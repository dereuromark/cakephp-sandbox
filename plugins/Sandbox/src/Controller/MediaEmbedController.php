<?php

namespace Sandbox\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use MediaEmbed\Exception\EmbedCodeUnavailableException;
use MediaEmbed\Http\HttpClientInterface;
use MediaEmbed\MediaEmbed;

class MediaEmbedController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$privacy = $this->flag('privacy');
		$responsive = $this->flag('responsive');
		$customize = $this->flag('customize');
		$placeholder = $this->flag('placeholder');
		$oEmbed = $this->flag('oembed');

		$url = $this->request->getData('url') ?: $this->request->getQuery('url');
		$oEmbedResponse = null;
		$oEmbedHtml = null;
		$oEmbedError = null;
		$oEmbedOnly = false;
		$thumbnail = null;

		if ($url) {
			$mediaEmbed = $this->mediaEmbed();
			$mediaObject = $mediaEmbed->parseUrl($url, $privacy ? ['privacy' => true] : []);

			if (!$mediaObject) {
				$this->Flash->error('Could not parse URL');
			} else {
				$provider = $mediaEmbed->getProviderForUrl($url);
				// oEmbed-only providers (Tumblr, Bluesky, Flickr, Speaker Deck) have no static
				// iframe URL, so the iframe methods below would throw. Fetch their markup instead.
				$oEmbedOnly = $provider !== null && !$provider->hasIframeSupport() && $provider->hasOEmbedSupport();

				if ($customize) {
					// Immutable API: with*() returns a new instance, the original is untouched.
					$mediaObject = $mediaObject
						->withParam(['autoplay' => 1, 'loop' => 1])
						->withAttribute('class', 'demo-embed');
				}

				if ($oEmbed || $oEmbedOnly) {
					try {
						$oEmbedResponse = $mediaEmbed->oEmbed($mediaObject);
					} catch (EmbedCodeUnavailableException $e) {
						$oEmbedError = $e->getMessage();
					}

					if ($oEmbedResponse === null && $oEmbedError === null) {
						$oEmbedError = 'No oEmbed response - provider has no endpoint, or the request failed.';
					}

					if ($oEmbedResponse !== null) {
						// The convenience methods oEmbedHtml() and thumbnail() each perform their own
						// oEmbed() call. This page shows both values at once, so it derives them from
						// the single response above instead of fetching two more times.
						$oEmbedHtml = $oEmbedResponse->hasHtml() ? $oEmbedResponse->html : null;
						$thumbnail = $mediaObject->getImageSrc() ?: $oEmbedResponse->thumbnailUrl;
					}
				}

				$this->set(compact('mediaObject'));
			}
		}

		$this->set(compact(
			'privacy',
			'responsive',
			'customize',
			'placeholder',
			'oEmbed',
			'oEmbedOnly',
			'oEmbedResponse',
			'oEmbedHtml',
			'oEmbedError',
			'thumbnail',
		));
	}

	/**
	 * oEmbed showcase: providers that only expose provider-generated markup.
	 *
	 * @return void
	 */
	public function oembed() {
		$mediaEmbed = $this->mediaEmbed();

		$providers = $mediaEmbed->getProviders()->withOEmbedSupport();

		$oEmbedOnly = [];
		$oEmbedPlusIframe = [];
		foreach ($providers as $slug => $config) {
			if ($config->hasIframeSupport()) {
				$oEmbedPlusIframe[$slug] = $config;

				continue;
			}

			$oEmbedOnly[$slug] = $config;
		}

		// A custom oEmbed-only provider needs no iframe-player, only an oembed endpoint.
		// It can equally come from a PHP/JSON file via `providers_config` or a provider loader.
		$customProviderConfig = [
			'name' => 'Example Social',
			'website' => 'https://social.example.com',
			'url-match' => 'https://social\\.example\\.com/posts/([0-9]+)',
			'embed-width' => 540,
			'embed-height' => 600,
			'oembed' => 'https://social.example.com/oembed',
		];
		$customMediaEmbed = new MediaEmbed(['custom_providers' => [$customProviderConfig]]);
		$customProvider = $customMediaEmbed->getProviderForUrl('https://social.example.com/posts/123');

		// Iframe methods are unavailable for oEmbed-only providers - they throw instead of
		// silently returning unusable markup.
		$exceptionMessage = null;
		$customObject = $customMediaEmbed->parseUrl('https://social.example.com/posts/123');
		if ($customObject) {
			try {
				$customObject->getEmbedCode();
			} catch (EmbedCodeUnavailableException $e) {
				$exceptionMessage = $e->getMessage();
			}
		}

		$this->set(compact(
			'oEmbedOnly',
			'oEmbedPlusIframe',
			'customProviderConfig',
			'customProvider',
			'exceptionMessage',
		));
	}

	/**
	 * @return void
	 */
	public function bbcode() {
		if ($this->request->is('post')) {
			$bbcode = $this->request->getData('bbcode');

			$this->set(compact('bbcode'));
		}

		$bbcodeExample = '[video=youtube]dQw4w9WgXcQ[/video]';

		$this->set(compact('bbcodeExample'));
	}

	/**
	 * @return void
	 */
	public function hosts() {
		$mediaEmbed = $this->mediaEmbed();
		$hosts = $mediaEmbed->getHosts();
		$providers = $mediaEmbed->getProviders();

		$this->set(compact('hosts', 'providers'));
	}

	/**
	 * Read a demo toggle from the posted form, falling back to the query string so that
	 * the demo links above the form can preselect options.
	 *
	 * @param string $name
	 * @return bool
	 */
	protected function flag(string $name): bool {
		return (bool)($this->request->getData($name) ?? $this->request->getQuery($name));
	}

	/**
	 * oEmbed lookups perform HTTP requests, so a PSR-16 cache is used for them.
	 *
	 * The `MediaEmbed.httpClient` Configure key swaps the HTTP client out. It is unset in the
	 * app and is what the test case uses to exercise the oEmbed rendering without network access.
	 *
	 * @return \MediaEmbed\MediaEmbed
	 */
	protected function mediaEmbed(): MediaEmbed {
		$mediaEmbed = new MediaEmbed();

		$httpClient = Configure::read('MediaEmbed.httpClient');
		if ($httpClient instanceof HttpClientInterface) {
			$mediaEmbed->setHttpClient($httpClient);
		}

		$mediaEmbed->setCache(Cache::pool('default'), 3600);

		return $mediaEmbed;
	}

}
