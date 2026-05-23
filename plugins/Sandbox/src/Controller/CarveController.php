<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Carve\CarveConverter;
use Carve\Converter\BbcodeToCarve;
use Carve\Converter\DjotToCarve;
use Carve\Converter\HtmlToCarve;
use Carve\Converter\MarkdownToCarve;
use Carve\Exception\ParseException;
use Carve\Exception\ProfileViolationException;
use Carve\Extension\AdmonitionExtension;
use Carve\Extension\AutolinkExtension;
use Carve\Extension\CodeGroupExtension;
use Carve\Extension\DefaultAttributesExtension;
use Carve\Extension\ExternalLinksExtension;
use Carve\Extension\FrontmatterExtension;
use Carve\Extension\HeadingLevelShiftExtension;
use Carve\Extension\HeadingPermalinksExtension;
use Carve\Extension\MentionsExtension;
use Carve\Extension\MermaidExtension;
use Carve\Extension\SemanticSpanExtension;
use Carve\Extension\SmartQuotesExtension;
use Carve\Extension\TableOfContentsExtension;
use Carve\Extension\TabsExtension;
use Carve\Extension\WikilinksExtension;
use Carve\Profile;
use Carve\Renderer\SoftBreakMode;
use Composer\InstalledVersions;
use Exception;
use HTMLPurifier;
use HTMLPurifier_Config;
use LengthException;

class CarveController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$carveVersion = InstalledVersions::getPrettyVersion('markup-carve/carve-php');
		$reference = InstalledVersions::getReference('markup-carve/carve-php');
		if ($carveVersion !== null && str_starts_with($carveVersion, 'dev-') && $reference) {
			$carveVersion .= '@' . substr($reference, 0, 7);
		}

		$this->set('debugMode', Configure::read('debug'));
		$this->set('carveVersion', $carveVersion);
	}

	/**
	 * AJAX endpoint for live conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convert(): Response {
		$this->request->allowMethod(['post']);

		$carve = (string)$this->request->getData('carve');
		$collectWarnings = (bool)$this->request->getData('warnings');
		$strict = (bool)$this->request->getData('strict');
		$raw = (bool)$this->request->getData('raw') && Configure::read('debug');
		$profileName = (string)$this->request->getData('profile');
		$filterMode = (string)$this->request->getData('filter_mode');
		$blocksInterruptParagraphs = (bool)$this->request->getData('blocks_interrupt_paragraphs');
		$softBreakAsBr = (bool)$this->request->getData('soft_break_br');

		$result = [
			'html' => '',
			'warnings' => [],
			'violations' => [],
			'error' => null,
		];

		if ($carve) {
			try {
				$profile = $this->getProfile($profileName, $filterMode);
				if ($blocksInterruptParagraphs) {
					$converter = CarveConverter::withBlocksInterruptParagraphs(true, $collectWarnings, $strict, null, $profile);
				} else {
					$converter = new CarveConverter(true, $collectWarnings, $strict, null, $profile);
				}
				if ($softBreakAsBr) {
					$converter->getHtmlRenderer()->setSoftBreakMode(SoftBreakMode::Break);
				}
				$html = $converter->convert($carve);
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
	 * Complex Carve examples showcase.
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

		$carve = (string)$this->request->getData('carve');
		$enabledExtensions = (array)$this->request->getData('extensions');

		$result = [
			'html' => '',
			'rawHtml' => '',
			'toc' => '',
			'frontmatter' => null,
			'error' => null,
		];

		if ($carve) {
			try {
				$converter = new CarveConverter();
				$tocExtension = null;
				$frontmatterExtension = null;

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
								mentionUrl: '/sandbox/carve?user={name}',
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
						case 'semantic_span':
							$converter->addExtension(new SemanticSpanExtension());

							break;
						case 'smart_quotes':
							$locale = (string)$this->request->getData('smart_quotes_locale') ?: 'de';
							$converter->addExtension(new SmartQuotesExtension(locale: $locale));

							break;
						case 'heading_level_shift':
							$converter->addExtension(new HeadingLevelShiftExtension(shift: 1));

							break;
						case 'mermaid':
							$converter->addExtension(new MermaidExtension());

							break;
						case 'admonition':
							$converter->addExtension(new AdmonitionExtension(icons: true));

							break;
						case 'tabs':
							$converter->addExtension(new TabsExtension(mode: TabsExtension::MODE_CSS));

							break;
						case 'tabs_aria':
							$converter->addExtension(new TabsExtension(mode: TabsExtension::MODE_ARIA));

							break;
						case 'code_group':
							$converter->addExtension(new CodeGroupExtension());

							break;
						case 'wikilinks':
							$converter->addExtension(new WikilinksExtension(
								urlGenerator: fn (string $page) => '/wiki/' . strtolower(str_replace(' ', '-', $page)),
							));

							break;
						case 'frontmatter':
							$renderAsComment = (bool)$this->request->getData('frontmatter_as_comment');
							$frontmatterExtension = new FrontmatterExtension(renderAsComment: $renderAsComment);
							$converter->addExtension($frontmatterExtension);

							break;
					}
				}

				$rawHtml = $converter->convert($carve);
				$result['html'] = $this->sanitizeHtml($rawHtml);
				if (Configure::read('debug')) {
					$result['rawHtml'] = $rawHtml;
				}
				if ($tocExtension !== null) {
					$result['toc'] = $this->sanitizeHtml($tocExtension->getTocHtml());
				}
				if ($frontmatterExtension !== null) {
					$fm = $frontmatterExtension->getFrontmatter();
					if ($fm !== null) {
						$result['frontmatter'] = [
							'format' => $fm->getFormat(),
							'content' => $fm->getContent(),
						];
					}
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
Check out this [link to Carve](https://github.com/markup-carve/carve).

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
Visit https://github.com/markup-carve/carve for the official documentation.

Contact us at info@example.com for support.

Also check out https://github.com/markup-carve/carve-php for the PHP implementation.
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
Check out [Carve's homepage](https://github.com/markup-carve/carve) for more information.

This [internal link](/sandbox/carve) stays in the same tab.

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
					'mentionUrl' => "'/users/{name}'",
					'tagUrl' => "'/tags/{name}'",
					'mentionClass' => "'mention'",
					'tagClass' => "'tag'",
				],
			],
			'toc' => [
				'name' => 'TableOfContentsExtension',
				'description' => 'Automatically generates a table of contents from document headings. Can be retrieved manually or auto-inserted at top/bottom.',
				'class' => TableOfContentsExtension::class,
				'example_djot' => <<<'DJOT'
# Carve Documentation

An overview of the Carve markup language.

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

Carve is a powerful markup language.
DJOT,
				'options' => [
					'minLevel' => '1',
					'maxLevel' => '6',
					'listType' => "'ul'",
					'cssClass' => "'toc'",
					'position' => "null, 'top', or 'bottom'",
				],
			],
			'semantic_span' => [
				'name' => 'SemanticSpanExtension',
				'description' => 'Converts span attributes into semantic HTML5 elements like <kbd>, <dfn>, and <abbr> for keyboard input, definitions, and abbreviations.',
				'class' => SemanticSpanExtension::class,
				'example_djot' => <<<'DJOT'
Press [Ctrl+C]{kbd} to copy the selection.

A [variable]{dfn} is a named storage location in memory.

The [HTML]{abbr="HyperText Markup Language"} standard defines web page structure.

[CSS]{dfn abbr="Cascading Style Sheets"} is used for styling web pages.

Use [Enter]{kbd} to submit and [Esc]{kbd} to cancel.
DJOT,
				'options' => [
					'(none)' => 'Uses span attributes: kbd, dfn, abbr',
				],
			],
			'smart_quotes' => [
				'name' => 'SmartQuotesExtension',
				'description' => 'Configures locale-specific typographic quote characters. Transforms straight quotes into proper opening/closing quotes based on language conventions.',
				'class' => SmartQuotesExtension::class,
				'example_djot' => <<<'DJOT'
She said, "Hello, world!"

It's a 'simple' example.

"Nested 'quotes' work too," he replied.

The "German style" uses „low-high" quotes.
DJOT,
				'options' => [
					'locale' => "'en', 'de', 'de-CH', 'fr', 'pl', 'ru', etc.",
					'openDoubleQuote' => 'Custom opening double quote',
					'closeDoubleQuote' => 'Custom closing double quote',
					'openSingleQuote' => 'Custom opening single quote',
					'closeSingleQuote' => 'Custom closing single quote',
				],
			],
			'heading_level_shift' => [
				'name' => 'HeadingLevelShiftExtension',
				'description' => 'Shifts heading levels down (h1 → h2, h2 → h3, etc.). Useful when h1 is reserved for the page title and document headings should start at h2 for SEO and accessibility.',
				'class' => HeadingLevelShiftExtension::class,
				'example_djot' => <<<'DJOT'
# Main Title (becomes h2)

Introduction paragraph.

## Section (becomes h3)

Section content.

### Subsection (becomes h4)

More details here.
DJOT,
				'options' => [
					'shift' => '1 (1-5, levels capped at h6)',
				],
			],
			'mermaid' => [
				'name' => 'MermaidExtension',
				'description' => 'Transforms code blocks with language "mermaid" into Mermaid.js-compatible markup for rendering diagrams. Supports flowcharts, sequence diagrams, class diagrams, and more.',
				'class' => MermaidExtension::class,
				'example_djot' => <<<'DJOT'
``` mermaid
graph TD;
    A[Start] --> B{Decision};
    B -->|Yes| C[Do Something];
    B -->|No| D[Do Nothing];
    C --> E[End];
    D --> E;
```

``` mermaid
sequenceDiagram
    Alice->>Bob: Hello Bob!
    Bob->>Alice: Hi Alice!
```
DJOT,
				'options' => [
					'tag' => "'pre' or 'div'",
					'cssClass' => "'mermaid'",
					'wrapInFigure' => 'false',
					'figureClass' => "'mermaid-figure'",
				],
			],
			'admonition' => [
				'name' => 'AdmonitionExtension',
				'description' => 'Transforms divs with admonition type classes (note, tip, warning, danger, info, success) into semantic HTML with ARIA roles, emoji icons, and auto-generated titles. Supports collapsible blocks.',
				'class' => AdmonitionExtension::class,
				'example_djot' => <<<'DJOT'
::: note
This is a simple note with 📝 icon.
:::

::: info
Here's some informational content with ℹ️ icon.
:::

::: tip
Here's a helpful tip with 💡 icon.
:::

{title="Watch Out!"}
::: warning
Be careful with this operation! (⚠️ icon)
:::

::: danger
This action cannot be undone! (🚨 icon)
:::

::: success
Operation completed successfully! (✅ icon)
:::

{collapsible}
::: tip
Click to expand this collapsible tip block.
:::
DJOT,
				'options' => [
					'types' => "['note', 'tip', 'warning', 'danger', 'info', 'success']",
					'icons' => 'true',
					'defaultTitle' => 'true',
					'titleTag' => "'p'",
					'titleClass' => "'admonition-title'",
					'containerClass' => "'admonition'",
				],
			],
			'tabs' => [
				'name' => 'TabsExtension',
				'description' => 'Transforms nested divs into accessible tabbed interfaces. CSS-only mode uses radio inputs and sibling selectors (no JavaScript required). Note: Use more colons (::::) for the outer tabs container to properly nest inner tab divs.',
				'class' => TabsExtension::class,
				'example_djot' => <<<'DJOT'
:::: tabs

::: tab
### Installation

Install the package with Composer:

`composer require markup-carve/carve-php`
:::

::: tab
### Usage

Convert Carve to HTML:

`$html = $converter->convert($carve);`
:::

::: tab
### Configuration

Configure options as needed.
:::

::::
DJOT,
				'options' => [
					'mode' => "'css' (default) or 'aria'",
					'wrapperClass' => "'tabs'",
					'tabClass' => "'tabs-panel'",
					'labelClass' => "'tabs-label'",
					'radioClass' => "'tabs-radio'",
				],
			],
			'code_group' => [
				'name' => 'CodeGroupExtension',
				'description' => 'Transforms code-group divs into tabbed code block interfaces. Labels are extracted from language hints using `[Label]` suffix syntax (e.g., `php [Installation]`), falling back to the language name or "Code N".',
				'class' => CodeGroupExtension::class,
				'example_djot' => <<<'DJOT'
::: code-group

``` php [Composer]
composer require markup-carve/carve-php
```

``` bash [NPM]
npm install @example/djot
```

``` python [Pip]
pip install djot
```

:::
DJOT,
				'options' => [
					'wrapperClass' => "'code-group'",
					'panelClass' => "'code-group-panel'",
					'labelClass' => "'code-group-label'",
					'radioClass' => "'code-group-radio'",
					'highlighter' => 'Custom syntax highlighter callback',
				],
			],
			'wikilinks' => [
				'name' => 'WikilinksExtension',
				'description' => 'Parses [[wikilinks]] into navigational links. Supports [[page|display text]] syntax and anchors like [[page#section]]. Common in wiki systems and note-taking apps like Obsidian.',
				'class' => WikilinksExtension::class,
				'example_djot' => <<<'DJOT'
Check out the [[Getting Started]] guide for beginners.

For advanced users, see [[Advanced Topics|the advanced section]].

The [[API Reference#authentication]] section covers auth.

Related: [[Best Practices]], [[FAQ]], [[Troubleshooting]]
DJOT,
				'options' => [
					'urlGenerator' => 'Custom URL generator closure',
					'cssClass' => "'wikilink'",
					'newWindow' => 'false',
				],
			],
			'frontmatter' => [
				'name' => 'FrontmatterExtension',
				'description' => 'Parses YAML/NEON/TOML/... frontmatter blocks at the start of documents. The format identifier (yaml, neon, toml, ...) is optional.',
				'class' => FrontmatterExtension::class,
				'example_djot' => <<<'DJOT'
---yaml
title: My Article
author: John Doe
date: 2024-01-15
tags:
  - djot
  - documentation
---

# My Article

This is the main content after the frontmatter.
DJOT,
				'options' => [
					'defaultFormat' => "'yaml'",
					'renderAsComment' => 'false (true renders as HTML comment)',
					'renderCallback' => 'Custom render function',
				],
			],
		];
	}

	/**
	 * Markdown to Carve converter playground.
	 *
	 * @return void
	 */
	public function markdownToCarve(): void {
	}

	/**
	 * AJAX endpoint for Markdown to Carve conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertMarkdown(): Response {
		$this->request->allowMethod(['post']);

		$markdown = (string)$this->request->getData('markdown');

		$result = [
			'carve' => '',
			'error' => null,
		];

		if ($markdown) {
			try {
				$converter = new MarkdownToCarve();
				$result['carve'] = $converter->convert($markdown);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * HTML to Carve converter playground.
	 *
	 * @return void
	 */
	public function htmlToCarve(): void {
	}

	/**
	 * AJAX endpoint for HTML to Carve conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertHtml(): Response {
		$this->request->allowMethod(['post']);

		$html = (string)$this->request->getData('html');

		$result = [
			'carve' => '',
			'error' => null,
		];

		if ($html) {
			try {
				$converter = new HtmlToCarve();
				$result['carve'] = $converter->convert($html);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * BBCode to Carve converter playground.
	 *
	 * @return void
	 */
	public function bbcodeToCarve(): void {
	}

	/**
	 * WYSIWYG editor placeholder.
	 *
	 * Carve has no published JS editor tooling (Tiptap kit/serializer) yet, so this
	 * page shows a notice plus a server-side HTML preview via the convert endpoint.
	 *
	 * @return void
	 */
	public function wysiwyg(): void {
	}

	/**
	 * AJAX endpoint for BBCode to Carve conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertBbcode(): Response {
		$this->request->allowMethod(['post']);

		$bbcode = (string)$this->request->getData('bbcode');

		$result = [
			'carve' => '',
			'error' => null,
		];

		if ($bbcode) {
			try {
				$converter = new BbcodeToCarve();
				$result['carve'] = $converter->convert($bbcode);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Djot to Carve converter playground.
	 *
	 * @return void
	 */
	public function djotToCarve(): void {
	}

	/**
	 * AJAX endpoint for Djot to Carve conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertDjot(): Response {
		$this->request->allowMethod(['post']);

		$djot = (string)$this->request->getData('djot');

		$result = [
			'carve' => '',
			'error' => null,
		];

		if ($djot) {
			try {
				$converter = new DjotToCarve();
				$result['carve'] = $converter->convert($djot);
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
	 * @return \Carve\Profile|null
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
	 * Sanitize HTML output to prevent XSS attacks.
	 *
	 * @param string $html
	 * @return string
	 */
	protected function sanitizeHtml(string $html): string {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'carve-sandbox');
		$config->set('HTML.DefinitionRev', 8);
		$config->set('HTML.Allowed', 'p[class|id],br[class|id],strong[class|id],em[class|id],u[class|id],s[class|id],del[class|id],ins[class|id],mark[class|id],sub[class|id],sup[class|id],a[href|title|class|id|target|rel|data-username|aria-label],img[src|alt|title|loading|decoding|class|id],ul[class|id],ol[start|type|class|id],li[class|id],dl[class|id],dt[class|id],dd[class|id],blockquote[class|id],pre[class|id],code[class|id],h1[class|id],h2[class|id],h3[class|id],h4[class|id],h5[class|id],h6[class|id],table[class|id],caption[class|id],thead[class|id],tbody[class|id],tr[class|id],th[align|colspan|rowspan|style|class|id],td[align|colspan|rowspan|style|class|id],hr[class|id],div[class|id|role|aria-labelledby],span[class|id],section[class|id],nav[class|id],input[type|name|id|checked|disabled|class],label[for|class|id],button[role|id|class|tabindex|aria-selected|aria-controls],details[class|id|open],summary[class|id],figure[class|id],figcaption[class|id],kbd[class|id],dfn[class|id],abbr[title|class|id]');
		$config->set('CSS.AllowedProperties', 'text-align');
		$config->set('Attr.EnableID', true);
		$config->set('Attr.AllowedFrameTargets', ['_blank']);
		$config->set('HTML.TargetBlank', false);
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
		$config->set('AutoFormat.RemoveEmpty', false);
		// Preserve HTML comments (e.g. frontmatter rendered as a comment) while blocking IE conditional comments.
		$config->set('HTML.AllowedCommentsRegexp', '#^(?!\s*\[if)#i');

		$def = $config->maybeGetRawHTMLDefinition();
		if ($def !== null) {
			$def->addElement('mark', 'Inline', 'Inline', 'Common');
			$def->addElement('section', 'Block', 'Flow', 'Common');
			$def->addElement('figure', 'Block', 'Flow', 'Common');
			$def->addElement('figcaption', 'Block', 'Flow', 'Common');
			$def->addElement('nav', 'Block', 'Flow', 'Common');
			$def->addElement('details', 'Block', 'Flow', 'Common', ['open' => 'Bool']);
			$def->addElement('summary', 'Block', 'Inline', 'Common');
			$def->addElement('button', 'Inline', 'Inline', 'Common', [
				'role' => 'Text',
				'tabindex' => 'Number',
				'aria-selected' => 'Enum#true,false',
				'aria-controls' => 'ID',
			]);
			$def->addAttribute('a', 'data-username', 'Text');
			$def->addAttribute('a', 'aria-label', 'Text');
			$def->addAttribute('img', 'loading', 'Enum#lazy,eager,auto');
			$def->addAttribute('img', 'decoding', 'Enum#async,sync,auto');
			$def->addAttribute('div', 'role', 'Text');
			$def->addAttribute('div', 'aria-labelledby', 'Text');
			$def->addElement('input', 'Inline', 'Empty', 'Common', [
				'type' => 'Enum#checkbox,radio',
				'name' => 'Text',
				'checked' => 'Bool',
				'disabled' => 'Bool',
			]);
			$def->addElement('label', 'Inline', 'Inline', 'Common', [
				'for' => 'CDATA',
			]);
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

}
