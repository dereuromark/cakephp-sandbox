<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Composer\InstalledVersions;
use Djot\Converter\BbcodeToDjot;
use Djot\Converter\HtmlToDjot;
use Djot\Converter\MarkdownToDjot;
use Djot\DjotConverter;
use Djot\Exception\ParseException;
use Djot\Exception\ProfileViolationException;
use Djot\Extension\AutolinkExtension;
use Djot\Extension\DefaultAttributesExtension;
use Djot\Extension\ExternalLinksExtension;
use Djot\Extension\HeadingPermalinksExtension;
use Djot\Extension\MentionsExtension;
use Djot\Extension\TableOfContentsExtension;
use Djot\Profile;
use Djot\Renderer\SoftBreakMode;
use Exception;
use HTMLPurifier;
use HTMLPurifier_Config;
use LengthException;

class DjotController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$djotVersion = InstalledVersions::getPrettyVersion('php-collective/djot');

		$this->set('debugMode', Configure::read('debug'));
		$this->set('djotVersion', $djotVersion);
	}

	/**
	 * AJAX endpoint for live conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convert(): Response {
		$this->request->allowMethod(['post']);

		$djot = (string)$this->request->getData('djot');
		$collectWarnings = (bool)$this->request->getData('warnings');
		$strict = (bool)$this->request->getData('strict');
		$raw = (bool)$this->request->getData('raw') && Configure::read('debug');
		$profileName = (string)$this->request->getData('profile');
		$filterMode = (string)$this->request->getData('filter_mode');
		$significantNewlines = (bool)$this->request->getData('significant_newlines');
		$softBreakAsBr = (bool)$this->request->getData('soft_break_br');

		$result = [
			'html' => '',
			'warnings' => [],
			'violations' => [],
			'error' => null,
		];

		if ($djot) {
			try {
				$profile = $this->getProfile($profileName, $filterMode);
				if ($significantNewlines) {
					$converter = DjotConverter::withSignificantNewlines(true, $collectWarnings, $strict, null, $profile);
				} else {
					$converter = new DjotConverter(true, $collectWarnings, $strict, null, $profile);
					// Soft break as <br> only applies when not using significantNewlines
					// (significantNewlines already renders soft breaks as <br>)
					if ($softBreakAsBr) {
						$converter->getRenderer()->setSoftBreakMode(SoftBreakMode::Break);
					}
				}
				$html = $converter->convert($djot);
				$result['html'] = $raw ? $html : $this->sanitizeHtml($html);
				if ($collectWarnings) {
					foreach ($converter->getWarnings() as $warning) {
						$result['warnings'][] = [
							'message' => $warning->getMessage(),
							'line' => $warning->getLine(),
							'column' => $warning->getColumn(),
							'category' => $warning->getCategory(),
							'suggestion' => $warning->getSuggestion(),
						];
					}
				}
				if ($profile) {
					foreach ($converter->getProfileViolations() as $violation) {
						$result['violations'][] = [
							'nodeType' => $violation->nodeType,
							'reason' => $violation->reason,
							'message' => $violation->getMessage(),
						];
					}
				}
			} catch (ParseException $e) {
				$result['error'] = $e->getMessage();
			} catch (LengthException $e) {
				$result['error'] = $e->getMessage();
			} catch (ProfileViolationException $e) {
				$result['error'] = 'Profile violation: ' . $e->getMessage();
				foreach ($e->violations as $violation) {
					$result['violations'][] = [
						'nodeType' => $violation->nodeType,
						'reason' => $violation->reason,
						'message' => $violation->getMessage(),
					];
				}
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Complex Djot examples showcase.
	 *
	 * @return void
	 */
	public function complexExamples(): void {
	}

	/**
	 * Extensions showcase.
	 *
	 * @return void
	 */
	public function extensions(): void {
		$examples = $this->getExtensionExamples();
		$this->set(compact('examples'));
	}

	/**
	 * AJAX endpoint for extension demo conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertWithExtensions(): Response {
		$this->request->allowMethod(['post']);

		$djot = (string)$this->request->getData('djot');
		$enabledExtensions = (array)$this->request->getData('extensions');

		$result = [
			'html' => '',
			'toc' => '',
			'error' => null,
		];

		if ($djot) {
			try {
				$converter = new DjotConverter();
				$tocExtension = null;

				foreach ($enabledExtensions as $ext) {
					switch ($ext) {
						case 'autolink':
							$converter->addExtension(new AutolinkExtension());

							break;
						case 'external_links':
							$converter->addExtension(new ExternalLinksExtension(
								internalHosts: ['sandbox.dereuromark.de', 'localhost'],
							));

							break;
						case 'heading_permalinks':
							$converter->addExtension(new HeadingPermalinksExtension());

							break;
						case 'mentions':
							$converter->addExtension(new MentionsExtension(
								urlTemplate: '/sandbox/djot?user={username}',
							));

							break;
						case 'toc':
							$tocExtension = new TableOfContentsExtension();
							$converter->addExtension($tocExtension);

							break;
						case 'toc_top':
							$converter->addExtension(new TableOfContentsExtension(position: 'top'));

							break;
						case 'toc_bottom':
							$converter->addExtension(new TableOfContentsExtension(position: 'bottom'));

							break;
						case 'default_attributes':
							$converter->addExtension(new DefaultAttributesExtension([
								'image' => ['loading' => 'lazy', 'decoding' => 'async'],
								'table' => ['class' => 'table table-striped'],
								'link' => ['class' => 'text-primary'],
								'code_block' => ['class' => 'bg-dark text-light p-2 rounded'],
							]));

							break;
					}
				}

				$result['html'] = $this->sanitizeExtensionHtml($converter->convert($djot));
				if ($tocExtension !== null) {
					$result['toc'] = $tocExtension->getTocHtml();
				}
			} catch (ParseException $e) {
				$result['error'] = $e->getMessage();
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Get extension example data.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	protected function getExtensionExamples(): array {
		return [
			'default_attributes' => [
				'name' => 'DefaultAttributesExtension',
				'description' => 'Adds default attributes to elements by type. This demo adds: images get lazy loading, tables get Bootstrap classes, links get text-primary class, and code blocks get dark styling.',
				'class' => DefaultAttributesExtension::class,
				'example_djot' => <<<'DJOT'
Check out this [link to Djot](https://djot.net).

![Sample image](/img/cake.icon.png)

| Feature | Support |
|---------|---------|
| Tables | Yes |
| Images | Yes |

``` php
echo "Hello World";
```
DJOT,
				'options' => [
					'image' => "['loading' => 'lazy', 'decoding' => 'async']",
					'table' => "['class' => 'table table-striped']",
					'link' => "['class' => 'text-primary']",
					'code_block' => "['class' => 'bg-dark text-light p-2 rounded']",
				],
			],
			'autolink' => [
				'name' => 'AutolinkExtension',
				'description' => 'Automatically converts bare URLs and email addresses into clickable links without requiring explicit link syntax.',
				'class' => AutolinkExtension::class,
				'example_djot' => <<<'DJOT'
Visit https://djot.net for the official documentation.

Contact us at info@example.com for support.

Also check out https://github.com/php-collective/djot-php for the PHP implementation.
DJOT,
				'options' => [
					'allowedSchemes' => "['https', 'http', 'mailto']",
				],
			],
			'external_links' => [
				'name' => 'ExternalLinksExtension',
				'description' => 'Adds target="_blank" and rel="noopener noreferrer" attributes to external links for security and UX.',
				'class' => ExternalLinksExtension::class,
				'example_djot' => <<<'DJOT'
Check out [Djot's homepage](https://djot.net) for more information.

This [internal link](/sandbox/djot) stays in the same tab.

Visit [GitHub](https://github.com) to see the source code.
DJOT,
				'options' => [
					'internalHosts' => "['example.com']",
					'target' => "'_blank'",
					'rel' => "'noopener noreferrer'",
					'nofollow' => 'false',
				],
			],
			'heading_permalinks' => [
				'name' => 'HeadingPermalinksExtension',
				'description' => 'Inserts clickable anchor links (¶ symbol) to headings for easy navigation and sharing.',
				'class' => HeadingPermalinksExtension::class,
				'example_djot' => <<<'DJOT'
# Introduction

Welcome to the documentation.

## Getting Started

First, install the package.

### Configuration

Configure the settings as needed.

## Advanced Usage

For power users.
DJOT,
				'options' => [
					'symbol' => "'¶'",
					'position' => "'after'",
					'cssClass' => "'permalink'",
					'ariaLabel' => "'Permalink'",
					'levels' => '[1, 2, 3, 4, 5, 6]',
				],
			],
			'mentions' => [
				'name' => 'MentionsExtension',
				'description' => 'Transforms @username patterns into profile links, perfect for social features.',
				'class' => MentionsExtension::class,
				'example_djot' => <<<'DJOT'
Thanks to @johndoe for the contribution!

The feature was implemented by @alice and reviewed by @bob.

If you have questions, reach out to @support-team.
DJOT,
				'options' => [
					'urlTemplate' => "'/users/view/{username}'",
					'cssClass' => "'mention'",
				],
			],
			'toc' => [
				'name' => 'TableOfContentsExtension',
				'description' => 'Automatically generates a table of contents from document headings. Can be retrieved manually or auto-inserted at top/bottom.',
				'class' => TableOfContentsExtension::class,
				'example_djot' => <<<'DJOT'
# Djot Documentation

An overview of the Djot markup language.

## Basic Syntax

### Paragraphs

Text separated by blank lines.

### Emphasis

Use _underscores_ for emphasis and *asterisks* for strong.

## Advanced Features

### Code Blocks

Fenced code blocks with syntax highlighting.

### Tables

Grid-based table syntax.

## Conclusion

Djot is a powerful markup language.
DJOT,
				'options' => [
					'minLevel' => '1',
					'maxLevel' => '6',
					'listType' => "'ul'",
					'cssClass' => "'toc'",
					'position' => "null, 'top', or 'bottom'",
				],
			],
		];
	}

	/**
	 * Markdown to Djot converter playground.
	 *
	 * @return void
	 */
	public function markdownToDjot(): void {
	}

	/**
	 * AJAX endpoint for Markdown to Djot conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertMarkdown(): Response {
		$this->request->allowMethod(['post']);

		$markdown = (string)$this->request->getData('markdown');

		$result = [
			'djot' => '',
			'error' => null,
		];

		if ($markdown) {
			try {
				$converter = new MarkdownToDjot();
				$result['djot'] = $converter->convert($markdown);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * HTML to Djot converter playground.
	 *
	 * @return void
	 */
	public function htmlToDjot(): void {
	}

	/**
	 * AJAX endpoint for HTML to Djot conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertHtml(): Response {
		$this->request->allowMethod(['post']);

		$html = (string)$this->request->getData('html');

		$result = [
			'djot' => '',
			'error' => null,
		];

		if ($html) {
			try {
				$converter = new HtmlToDjot();
				$result['djot'] = $converter->convert($html);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * BBCode to Djot converter playground.
	 *
	 * @return void
	 */
	public function bbcodeToDjot(): void {
	}

	/**
	 * AJAX endpoint for BBCode to Djot conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertBbcode(): Response {
		$this->request->allowMethod(['post']);

		$bbcode = (string)$this->request->getData('bbcode');

		$result = [
			'djot' => '',
			'error' => null,
		];

		if ($bbcode) {
			try {
				$converter = new BbcodeToDjot();
				$result['djot'] = $converter->convert($bbcode);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Get profile instance from name.
	 *
	 * @param string $name
	 * @param string $filterMode
	 * @return \Djot\Profile|null
	 */
	protected function getProfile(string $name, string $filterMode): ?Profile {
		$profile = match ($name) {
			'full' => Profile::full(),
			'article' => Profile::article(),
			'comment' => Profile::comment(),
			'minimal' => Profile::minimal(),
			default => null,
		};

		if ($profile !== null && $filterMode) {
			$action = match ($filterMode) {
				'strip' => Profile::ACTION_STRIP,
				'error' => Profile::ACTION_ERROR,
				default => Profile::ACTION_TO_TEXT,
			};
			$profile->onDisallowed($action);
		}

		return $profile;
	}

	/**
	 * Sanitize HTML output for extensions demo.
	 *
	 * @param string $html
	 * @return string
	 */
	protected function sanitizeExtensionHtml(string $html): string {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'djot-extensions');
		$config->set('HTML.DefinitionRev', 2);
		$config->set('HTML.Allowed', 'p,br,strong,em,u,s,del,ins,mark,sub[id],sup[id],a[href|title|class|id|target|rel|data-username|aria-label],img[src|alt|title|loading|decoding|class],ul[class],ol[start|type],li,dl,dt,dd,blockquote,pre[class],code[class],h1[id],h2[id],h3[id],h4[id],h5[id],h6[id],table[class|id],caption,thead,tbody,tr,th[align|colspan|rowspan|style],td[align|colspan|rowspan|style],hr,div[class|id],span[class|id],section[id],nav[class],input[type|checked|disabled],figure,figcaption');
		$config->set('CSS.AllowedProperties', 'text-align');
		$config->set('Attr.EnableID', true);
		$config->set('Attr.AllowedFrameTargets', ['_blank']);
		$config->set('HTML.TargetBlank', false);
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
		$config->set('AutoFormat.RemoveEmpty', false);

		$def = $config->maybeGetRawHTMLDefinition();
		if ($def !== null) {
			$def->addElement('mark', 'Inline', 'Inline', 'Common');
			$def->addElement('section', 'Block', 'Flow', 'Common');
			$def->addElement('figure', 'Block', 'Flow', 'Common');
			$def->addElement('figcaption', 'Block', 'Flow', 'Common');
			$def->addElement('nav', 'Block', 'Flow', 'Common');
			$def->addAttribute('a', 'data-username', 'Text');
			$def->addAttribute('a', 'aria-label', 'Text');
			$def->addAttribute('img', 'loading', 'Enum#lazy,eager,auto');
			$def->addAttribute('img', 'decoding', 'Enum#async,sync,auto');
			$def->addElement('input', 'Inline', 'Empty', 'Common', [
				'type' => 'Enum#checkbox',
				'checked' => 'Bool',
				'disabled' => 'Bool',
			]);
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

	/**
	 * Sanitize HTML output to prevent XSS attacks. Needed when input comes from outside.
	 *
	 * @param string $html
	 * @return string
	 */
	protected function sanitizeHtml(string $html): string {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'djot-sandbox');
		$config->set('HTML.DefinitionRev', 6);
		$config->set('HTML.Allowed', 'p,br,strong,em,u,s,del,ins,mark,sub[id],sup[id],a[href|title|class|id],img[src|alt|title],ul[class],ol[start|type],li,dl,dt,dd,blockquote,pre,code[class],h1[id],h2[id],h3[id],h4[id],h5[id],h6[id],table[class|id],caption,thead,tbody,tr,th[align|colspan|rowspan|style],td[align|colspan|rowspan|style],hr,div[class|id],span[class|id],section[id],input[type|checked|disabled],figure,figcaption');
		$config->set('CSS.AllowedProperties', 'text-align');
		$config->set('Attr.EnableID', true);
		$config->set('HTML.TargetBlank', true);
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
		$config->set('AutoFormat.RemoveEmpty', false);

		$def = $config->maybeGetRawHTMLDefinition();
		if ($def !== null) {
			$def->addElement('mark', 'Inline', 'Inline', 'Common');
			$def->addElement('section', 'Block', 'Flow', 'Common');
			$def->addElement('figure', 'Block', 'Flow', 'Common');
			$def->addElement('figcaption', 'Block', 'Flow', 'Common');
			$def->addElement('input', 'Inline', 'Empty', 'Common', [
				'type' => 'Enum#checkbox',
				'checked' => 'Bool',
				'disabled' => 'Bool',
			]);
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

}
