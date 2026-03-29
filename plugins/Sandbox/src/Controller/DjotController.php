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
use Djot\Extension\AdmonitionExtension;
use Djot\Extension\AutolinkExtension;
use Djot\Extension\CodeGroupExtension;
use Djot\Extension\DefaultAttributesExtension;
use Djot\Extension\ExternalLinksExtension;
use Djot\Extension\FrontmatterExtension;
use Djot\Extension\HeadingLevelShiftExtension;
use Djot\Extension\HeadingPermalinksExtension;
use Djot\Extension\MentionsExtension;
use Djot\Extension\MermaidExtension;
use Djot\Extension\SemanticSpanExtension;
use Djot\Extension\SmartQuotesExtension;
use Djot\Extension\TableOfContentsExtension;
use Djot\Extension\TabsExtension;
use Djot\Extension\WikilinksExtension;
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
		$reference = InstalledVersions::getReference('php-collective/djot');
		if ($djotVersion === 'dev-master' && $reference) {
			$djotVersion = 'dev-master@' . substr($reference, 0, 7);
		}

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
				}
				if ($softBreakAsBr) {
					$converter->getRenderer()->setSoftBreakMode(SoftBreakMode::Break);
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
			'rawHtml' => '',
			'toc' => '',
			'frontmatter' => null,
			'error' => null,
		];

		if ($djot) {
			try {
				$converter = new DjotConverter();
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

				$rawHtml = $converter->convert($djot);
				$result['html'] = $this->sanitizeHtml($rawHtml);
				if (Configure::read('debug')) {
					$result['rawHtml'] = $rawHtml;
				}
				if ($tocExtension !== null) {
					$result['toc'] = $tocExtension->getTocHtml();
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

`composer require php-collective/djot`
:::

::: tab
### Usage

Convert Djot to HTML:

`$html = $converter->convert($djot);`
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
composer require php-collective/djot
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
	 * WYSIWYG editor using Tiptap with Djot output.
	 *
	 * @return void
	 */
	public function wysiwyg(): void {
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
	 * Sanitize HTML output to prevent XSS attacks.
	 *
	 * @param string $html
	 * @return string
	 */
	protected function sanitizeHtml(string $html): string {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'djot-sandbox');
		$config->set('HTML.DefinitionRev', 8);
		$config->set('HTML.Allowed', 'p[class|id],br[class|id],strong[class|id],em[class|id],u[class|id],s[class|id],del[class|id],ins[class|id],mark[class|id],sub[class|id],sup[class|id],a[href|title|class|id|target|rel|data-username|aria-label],img[src|alt|title|loading|decoding|class|id],ul[class|id],ol[start|type|class|id],li[class|id],dl[class|id],dt[class|id],dd[class|id],blockquote[class|id],pre[class|id],code[class|id],h1[class|id],h2[class|id],h3[class|id],h4[class|id],h5[class|id],h6[class|id],table[class|id],caption[class|id],thead[class|id],tbody[class|id],tr[class|id],th[align|colspan|rowspan|style|class|id],td[align|colspan|rowspan|style|class|id],hr[class|id],div[class|id|role],span[class|id],section[class|id],nav[class|id],input[type|name|id|checked|disabled|class],label[for|class|id],button[role|id|class|tabindex|aria-selected|aria-controls],details[class|id|open],summary[class|id],figure[class|id],figcaption[class|id],kbd[class|id],dfn[class|id],abbr[title|class|id]');
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
