<?php

namespace Sandbox\Controller;

use MediaEmbed\MediaEmbed;

class MediaEmbedController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$privacy = (bool)$this->request->getData('privacy');
		$responsive = (bool)$this->request->getData('responsive');
		$customize = (bool)$this->request->getData('customize');

		$url = $this->request->getData('url') ?: $this->request->getQuery('url');
		if ($url) {
			$mediaEmbed = new MediaEmbed();
			$mediaObject = $mediaEmbed->parseUrl($url, $privacy ? ['privacy' => true] : []);

			if (!$mediaObject) {
				$this->Flash->error('Could not parse URL');
			} elseif ($customize) {
				// Immutable API: with*() returns a new instance, the original is untouched.
				$mediaObject = $mediaObject
					->withParam(['autoplay' => 1, 'loop' => 1])
					->withAttribute('class', 'demo-embed');
			}

			$this->set(compact('mediaObject'));
		}

		$this->set(compact('privacy', 'responsive', 'customize'));
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
		$mediaEmbed = new MediaEmbed();
		$hosts = $mediaEmbed->getHosts();

		$this->set(compact('hosts'));
	}

}
