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
use Carve\Extension\AsciiHeadingIdsExtension;
use Carve\Extension\AutolinkExtension;
use Carve\Extension\CodeGroupExtension;
use Carve\Extension\DefaultAttributesExtension;
use Carve\Extension\ExternalLinksExtension;
use Carve\Extension\FrontmatterExtension;
use Carve\Extension\HeadingLevelShiftExtension;
use Carve\Extension\HeadingPermalinksExtension;
use Carve\Extension\HeadingReferenceExtension;
use Carve\Extension\InlineFootnotesExtension;
use Carve\Extension\MentionsExtension;
use Carve\Extension\MermaidExtension;
use Carve\Extension\PlusBulletExtension;
use Carve\Extension\SemanticSpanExtension;
use Carve\Extension\SmartQuotesExtension;
use Carve\Extension\TableOfContentsExtension;
use Carve\Extension\TabNormalizeExtension;
use Carve\Extension\TabsExtension;
use Carve\Extension\WikilinksExtension;
use Carve\Profile;
use Carve\Renderer\SoftBreakMode;
use Composer\InstalledVersions;
use HTMLPurifier;
use HTMLPurifier_Config;
use LengthException;
use Throwable;

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
				// Carve interrupts paragraphs unconditionally (§10 default); there
				// is no strict toggle anymore.
				$converter = new CarveConverter(true, $collectWarnings, $strict, null, $profile);
				// Tabs in code render unevenly without a CSS tab-size; expand
				// them to spaces by default for consistent playground output.
				$converter->addExtension(new TabNormalizeExtension(width: 4));
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
			} catch (Throwable $e) {
				// Last-resort guard: any other error (e.g. a TypeError from an
				// extension closure) must surface as JSON, not an HTML error
				// page that would break the AJAX client's JSON.parse.
				$result['error'] = $e->getMessage();
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

		// HeadingReference and Wikilinks both claim the [[...]] inline syntax and
		// cannot share one converter instance. In the combined demo all toggles
		// default to on, so drop HeadingReference when Wikilinks is also enabled.
		if (in_array('wikilinks', $enabledExtensions, true) && in_array('heading_reference', $enabledExtensions, true)) {
			$enabledExtensions = array_values(array_filter(
				$enabledExtensions,
				fn (string $ext): bool => $ext !== 'heading_reference',
			));
		}

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
						case 'heading_reference':
							$converter->addExtension(new HeadingReferenceExtension());

							break;
						case 'inline_footnotes':
							$converter->addExtension(new InlineFootnotesExtension());

							break;
						case 'frontmatter':
							$renderAsComment = (bool)$this->request->getData('frontmatter_as_comment');
							$frontmatterExtension = new FrontmatterExtension(renderAsComment: $renderAsComment);
							$converter->addExtension($frontmatterExtension);

							break;
						case 'plus_bullet':
							$converter->addExtension(new PlusBulletExtension());

							break;
						case 'ascii_heading_ids':
							$converter->addExtension(new AsciiHeadingIdsExtension());

							break;
						case 'tab_normalize':
							$converter->addExtension(new TabNormalizeExtension(width: 4));

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
			} catch (Throwable $e) {
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

|= Feature |= Support |
| Tables   | Yes      |
| Images   | Yes      |

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

Use /slashes/ for emphasis and *asterisks* for strong.

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
npm install @example/carve
```

``` python [Pip]
pip install carve
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
			'heading_reference' => [
				'name' => 'HeadingReferenceExtension',
				'description' => 'Resolves [[Heading Text]] references to headings within the same document, producing anchor links. Supports custom display text via [[Heading Text|click here]]. Unresolvable references fall back to literal [[...]] text. Note: shares the [[...]] syntax with WikilinksExtension, so the two cannot be enabled on the same converter.',
				'class' => HeadingReferenceExtension::class,
				'example_djot' => <<<'DJOT'
# Installation

See [[Configuration]] for setup details, or jump straight to [[Usage|how to use it]].

# Configuration

Configure your settings here. A missing target like [[Nonexistent Section]] stays literal.

# Usage

Use the tool as described above.
DJOT,
				'options' => [
					'cssClass' => "'heading-ref'",
				],
			],
			'inline_footnotes' => [
				'name' => 'InlineFootnotesExtension',
				'description' => 'Converts spans marked with the .fn class into inline footnotes. Footnote content is written inline with the text instead of in a separate definition block, and is collected into a footnotes section at the end of the document. Content supports full inline formatting.',
				'class' => InlineFootnotesExtension::class,
				'example_djot' => <<<'DJOT'
Carve supports inline footnotes[This is the footnote content, written inline.]{.fn} right where you need them.

Footnote content can include _emphasis_ and `code`[Footnotes support full inline formatting.]{.fn} too.
DJOT,
				'options' => [
					'cssClass' => "'fn'",
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
  - carve
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
			'plus_bullet' => [
				'name' => 'PlusBulletExtension',
				'description' => 'Re-enables + as a bullet-list marker alongside - and *. A + is only a bullet when followed by a space and content; a bare + stays the list-continuation marker, so the two never collide. Task lists (+ [ ]) work too.',
				'class' => PlusBulletExtension::class,
				'example_djot' => <<<'DJOT'
+ Apple
+ Banana
+ Cherry

Mixed with the default markers:

- Dash bullet
+ Plus bullet
* Star bullet

Task lists work as well:

+ [ ] Pending task
+ [x] Completed task
DJOT,
				'options' => [
					'(none)' => 'Toggle-only; enable by adding the extension',
				],
			],
			'ascii_heading_ids' => [
				'name' => 'AsciiHeadingIdsExtension',
				'description' => 'Folds auto-generated heading ids to ASCII. By default Carve keeps non-ASCII characters in ids (# Über uns becomes über-uns); this extension transliterates them (über-uns becomes uber-uns) for share-safe URL fragments. Unmapped scripts (CJK, Arabic) pass through unchanged.',
				'class' => AsciiHeadingIdsExtension::class,
				'example_djot' => <<<'DJOT'
# Über uns

## Café résumé

### Größe & Maße

Compare the generated id attributes with and without the extension.
DJOT,
				'options' => [
					'transliterator' => 'AsciiTransliterator (custom map optional)',
				],
			],
			'tab_normalize' => [
				'name' => 'TabNormalizeExtension',
				'description' => 'Expands literal tabs in code blocks and inline code to a fixed number of spaces at render time. Carve preserves tabs by default (a CSS tab-size concern); this is useful for fixed-width output without CSS, e.g. email, RSS or plain HTML. This demo uses width 4.',
				'class' => TabNormalizeExtension::class,
				'example_djot' => <<<DJOT
``` js
function greet() {
\treturn "hi";
}
```
DJOT,
				'options' => [
					'width' => '4 (spaces per tab; default 2)',
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
	 * Migration fixer playground (carve-js `applyMigrationFixes` / `carve fix`).
	 *
	 * Runs fully client-side via the bundled carve-js library; there is no
	 * server endpoint - the JS rewrites Djot/Markdown delimiter collisions to
	 * their Carve equivalents in the browser and reports applied/skipped fixes.
	 *
	 * @return void
	 */
	public function migrationFix(): void {
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
			} catch (Throwable $e) {
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
			} catch (Throwable $e) {
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
	 * WYSIWYG editor.
	 *
	 * Carve has no published JS serializer yet, so this editor uses Tiptap for
	 * rich-text editing and round-trips its HTML through the PHP converters
	 * (HtmlToCarve, then CarveConverter) to produce both Carve source and a
	 * sanitized HTML preview via the wysiwygPreview endpoint.
	 *
	 * @return void
	 */
	public function wysiwyg(): void {
	}

	/**
	 * AJAX endpoint for the WYSIWYG editor.
	 *
	 * Serializes the editor's HTML to Carve (HtmlToCarve) and renders that Carve
	 * back to sanitized HTML (CarveConverter), returning both so the page can show
	 * the Carve source and a faithful server-rendered preview.
	 *
	 * @return \Cake\Http\Response
	 */
	public function wysiwygPreview(): Response {
		$this->request->allowMethod(['post']);

		$html = (string)$this->request->getData('html');

		$result = [
			'carve' => '',
			'html' => '',
			'error' => null,
		];

		if ($html) {
			try {
				$carve = (new HtmlToCarve())->convert($html);
				$result['carve'] = $carve;
				$converter = new CarveConverter();
				// Expand code tabs to spaces by default for consistent preview rendering.
				$converter->addExtension(new TabNormalizeExtension(width: 4));
				$result['html'] = $this->sanitizeHtml($converter->convert($carve));
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
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
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Roundtrip test playground.
	 *
	 * @return void
	 */
	public function roundtrip(): void {
		$this->set('debugMode', Configure::read('debug'));
	}

	/**
	 * Paragraph interruption (§10): a line that begins with a block marker is
	 * that block. Carve paragraphs are not greedy, so no blank line is needed.
	 *
	 * Each case is shown three ways: as typed (marker starts the block), with a
	 * blank line before the marker (identical result - the blank line is
	 * optional), and with the marker escaped (kept literal inside the paragraph).
	 *
	 * @return void
	 */
	public function interruption(): void {
		$converter = new CarveConverter();

		$rows = [];
		foreach ($this->getInterruptionCases() as $case) {
			$typedRaw = $converter->convert($case['carve']);
			$blankRaw = $converter->convert($case['blank']);
			$escapedRaw = $converter->convert($case['escaped']);
			$rows[] = [
				'title' => $case['title'],
				'note' => $case['note'],
				'carve' => $case['carve'],
				'blank' => $case['blank'],
				'escaped' => $case['escaped'],
				'typedRaw' => $typedRaw,
				'blankRaw' => $blankRaw,
				'escapedRaw' => $escapedRaw,
				'typedHtml' => $this->sanitizeHtml($typedRaw),
				'blankHtml' => $this->sanitizeHtml($blankRaw),
				'escapedHtml' => $this->sanitizeHtml($escapedRaw),
				// The whole point: no blank line and a blank line render the same.
				'equivalent' => $typedRaw === $blankRaw,
			];
		}

		$this->set('rows', $rows);
		$this->set('debugMode', Configure::read('debug'));
	}

	/**
	 * Curated cases. `carve` is as-typed (marker directly under the paragraph),
	 * `blank` adds a blank line before the marker (same result), `escaped` keeps
	 * the marker literal with a leading backslash.
	 *
	 * @return array<int, array{title: string, note: string, carve: string, blank: string, escaped: string}>
	 */
	protected function getInterruptionCases(): array {
		return [
			[
				'title' => 'Heading marker after text',
				'note' => 'A "# " line is a heading wherever it appears - the paragraph above does not absorb it.',
				'carve' => "text\n# H",
				'blank' => "text\n\n# H",
				'escaped' => "text\n\\# H",
			],
			[
				'title' => 'List after a label',
				'note' => 'A "- " line is a list item. The label above stays its own paragraph.',
				'carve' => "Cart:\n- 2x coffee\n- 1x tea",
				'blank' => "Cart:\n\n- 2x coffee\n- 1x tea",
				'escaped' => "Cart:\n\\- 2x coffee\n\\- 1x tea",
			],
			[
				'title' => 'Nested list (no blank line)',
				'note' => 'Indenting a sub-list nests it directly. Djot traditionally needed a blank line before the nested portion - a long-standing pain point - which Carve drops.',
				'carve' => "- Drinks\n  - Coffee\n  - Tea\n- Snacks",
				'blank' => "- Drinks\n\n  - Coffee\n  - Tea\n- Snacks",
				'escaped' => "- Drinks\n  \\- Coffee\n  \\- Tea\n- Snacks",
			],
			[
				'title' => 'Blockquote marker after text',
				'note' => 'A "> " line is a blockquote. Escape it when you mean a literal greater-than.',
				'carve' => "Make sure the result is\n> 5 so the check passes.",
				'blank' => "Make sure the result is\n\n> 5 so the check passes.",
				'escaped' => "Make sure the result is\n\\> 5 so the check passes.",
			],
			[
				'title' => 'Pipe line after text',
				'note' => 'A clean "| a | b |" row is a table. Escape the leading pipe to keep it as prose.',
				'carve' => "The CSV header is\n| id | name | email |",
				'blank' => "The CSV header is\n\n| id | name | email |",
				'escaped' => "The CSV header is\n\\| id | name | email |",
			],
			[
				'title' => 'Thematic break after text',
				'note' => 'A "---" line is a thematic break. Escape it to keep an em dash inside the paragraph.',
				'carve' => "Sign here:\n---\nJane Doe",
				'blank' => "Sign here:\n\n---\nJane Doe",
				'escaped' => "Sign here:\n\\---\nJane Doe",
			],
		];
	}

	/**
	 * AJAX endpoint for roundtrip conversion.
	 *
	 * Runs Carve -> HTML (pass 1) -> Carve -> HTML (pass 2) and reports whether
	 * the output is stable. HTML stability (pass 1 == pass 2) is the meaningful
	 * signal; the Carve text itself is normalized on the way back, so an exact
	 * text match is the stricter, less common outcome.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertRoundtrip(): Response {
		$this->request->allowMethod(['post']);

		// Multipart form-data normalizes field newlines to CRLF, while the
		// converter emits LF; normalize so the stability comparison is not
		// thrown off by line-ending differences alone.
		$carve = str_replace(["\r\n", "\r"], "\n", (string)$this->request->getData('carve'));

		$result = [
			'html1' => '',
			'carve2' => '',
			'html2' => '',
			'htmlStable' => false,
			'carveStable' => false,
			'error' => null,
		];

		if ($carve) {
			try {
				$toHtml = new CarveConverter(xhtml: true);
				$toCarve = new HtmlToCarve();

				$rawHtml1 = $toHtml->convert($carve);
				$carve2 = $toCarve->convert($rawHtml1);
				$rawHtml2 = (new CarveConverter(xhtml: true))->convert($carve2);

				$result['html1'] = $this->sanitizeHtml($rawHtml1);
				$result['carve2'] = $carve2;
				$result['html2'] = $this->sanitizeHtml($rawHtml2);
				// Compare raw (pre-sanitize) HTML so the verdict reflects converter
				// fidelity, not what the sanitizer happens to normalize away.
				$result['htmlStable'] = $rawHtml1 === $rawHtml2;
				$result['carveStable'] = trim($carve) === trim($carve2);
			} catch (ParseException $e) {
				$result['error'] = $e->getMessage();
			} catch (Throwable $e) {
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
			} catch (Throwable $e) {
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
		$config->set('HTML.DefinitionRev', 10);
		$config->set('HTML.Allowed', 'p[class|id],br[class|id],strong[class|id],em[class|id],u[class|id],s[class|id],del[class|id],ins[class|id],mark[class|id],sub[class|id],sup[class|id],a[href|title|class|id|target|rel|data-username|aria-label|role],img[src|alt|title|loading|decoding|class|id],ul[class|id],ol[start|type|class|id],li[class|id],dl[class|id],dt[class|id],dd[class|id],blockquote[class|id],pre[class|id],code[class|id],aside[class|id],h1[class|id],h2[class|id],h3[class|id],h4[class|id],h5[class|id],h6[class|id],table[class|id],caption[class|id],thead[class|id],tbody[class|id],tr[class|id],th[align|colspan|rowspan|style|class|id],td[align|colspan|rowspan|style|class|id],hr[class|id],div[class|id|role|aria-labelledby|hidden],span[class|id],section[class|id|role],nav[class|id],input[type|name|id|checked|disabled|class],label[for|class|id],button[role|id|class|tabindex|aria-selected|aria-controls],details[class|id|open],summary[class|id],figure[class|id],figcaption[class|id],kbd[class|id],dfn[class|id],samp[class|id],var[class|id],abbr[title|class|id]');
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
			$def->addElement('aside', 'Block', 'Flow', 'Common');
			$def->addElement('details', 'Block', 'Flow', 'Common', ['open' => 'Bool']);
			$def->addElement('summary', 'Block', 'Inline', 'Common');
			$def->addElement('button', 'Inline', 'Inline', 'Common', [
				'role' => 'Text',
				'tabindex' => 'Number',
				'aria-selected' => 'Enum#true,false',
				// Text, not ID: HTMLPurifier treats an ID-typed attr as an id
				// definition, so an ID-typed aria-controls would mark the panel's
				// real id as a duplicate and strip it, breaking the tab wiring.
				'aria-controls' => 'Text',
			]);
			$def->addAttribute('a', 'data-username', 'Text');
			$def->addAttribute('a', 'aria-label', 'Text');
			$def->addAttribute('a', 'role', 'Text');
			$def->addAttribute('img', 'loading', 'Enum#lazy,eager,auto');
			$def->addAttribute('img', 'decoding', 'Enum#async,sync,auto');
			$def->addAttribute('div', 'role', 'Text');
			$def->addAttribute('div', 'aria-labelledby', 'Text');
			$def->addAttribute('div', 'hidden', 'Bool');
			$def->addAttribute('section', 'role', 'Text');
			$def->addElement('samp', 'Inline', 'Inline', 'Common');
			$def->addElement('var', 'Inline', 'Inline', 'Common');
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
