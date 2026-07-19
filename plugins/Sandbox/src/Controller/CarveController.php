<?php

namespace Sandbox\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Routing\Router;
use Closure;
use Composer\InstalledVersions;
use Dompdf\Dompdf;
use Dompdf\Options;
use HTMLPurifier;
use HTMLPurifier_AttrDef;
use HTMLPurifier_AttrDef_CSS_Color;
use HTMLPurifier_Config;
use LengthException;
use MarkupCarve\Carve\CarveConverter;
use MarkupCarve\Carve\Converter\BbcodeToCarve;
use MarkupCarve\Carve\Converter\DjotToCarve;
use MarkupCarve\Carve\Converter\HtmlToCarve;
use MarkupCarve\Carve\Converter\MarkdownToCarve;
use MarkupCarve\Carve\Exception\ParseException;
use MarkupCarve\Carve\Exception\ProfileViolationException;
use MarkupCarve\Carve\Extension\AdmonitionExtension;
use MarkupCarve\Carve\Extension\AsciiHeadingIdsExtension;
use MarkupCarve\Carve\Extension\AutolinkExtension;
use MarkupCarve\Carve\Extension\CitationsExtension;
use MarkupCarve\Carve\Extension\CodeCalloutsExtension;
use MarkupCarve\Carve\Extension\CodeGroupExtension;
use MarkupCarve\Carve\Extension\ColorSwatchExtension;
use MarkupCarve\Carve\Extension\DefaultAttributesExtension;
use MarkupCarve\Carve\Extension\DetailsExtension;
use MarkupCarve\Carve\Extension\ExternalLinksExtension;
use MarkupCarve\Carve\Extension\FencedRenderExtension;
use MarkupCarve\Carve\Extension\FrontmatterExtension;
use MarkupCarve\Carve\Extension\GlossaryExtension;
use MarkupCarve\Carve\Extension\HeadingLevelShiftExtension;
use MarkupCarve\Carve\Extension\HeadingPermalinksExtension;
use MarkupCarve\Carve\Extension\HeadingReferenceExtension;
use MarkupCarve\Carve\Extension\IndexExtension;
use MarkupCarve\Carve\Extension\InlineFootnotesExtension;
use MarkupCarve\Carve\Extension\ListTableExtension;
use MarkupCarve\Carve\Extension\LowercaseHeadingIdsExtension;
use MarkupCarve\Carve\Extension\MathBlockExtension;
use MarkupCarve\Carve\Extension\MentionsExtension;
use MarkupCarve\Carve\Extension\PlusBulletExtension;
use MarkupCarve\Carve\Extension\SemanticSpanExtension;
use MarkupCarve\Carve\Extension\SmartQuotesExtension;
use MarkupCarve\Carve\Extension\SpoilerExtension;
use MarkupCarve\Carve\Extension\TableOfContentsExtension;
use MarkupCarve\Carve\Extension\TabNormalizeExtension;
use MarkupCarve\Carve\Extension\TabsExtension;
use MarkupCarve\Carve\Extension\TocPlacementExtension;
use MarkupCarve\Carve\Extension\WikilinksExtension;
use MarkupCarve\Carve\Profile;
use MarkupCarve\Carve\Renderer\RenderMode;
use MarkupCarve\Carve\Renderer\SoftBreakMode;
use MarkupCarve\MediaEmbed\MediaEmbedExtension;
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
		$this->set('enabledExtensions', $this->defaultExtensionInfo());
	}

	/**
	 * Adds the playground's default extension set to a converter.
	 *
	 * Curated to be safe-by-default: each is either a no-op until its syntax
	 * appears or a mild enrichment, with no colliding pair and nothing that needs
	 * page-specific JS. Wikilinks point at the {@link self::wiki()} stub so they
	 * resolve instead of 404ing; Mentions stay out (no user pages). Keep this list
	 * in sync with {@link self::defaultExtensionInfo()}.
	 *
	 * @param \MarkupCarve\Carve\CarveConverter $converter
	 * @return void
	 */
	protected function addDefaultExtensions(CarveConverter $converter): void {
		$converter->addExtension(new AutolinkExtension());
		$converter->addExtension(new ExternalLinksExtension(
			internalHosts: ['sandbox.dereuromark.de', 'localhost'],
		));
		$converter->addExtension(new AdmonitionExtension(icons: true));
		$converter->addExtension(new SemanticSpanExtension());
		$converter->addExtension(new AsciiHeadingIdsExtension());
		$converter->addExtension(new PlusBulletExtension());
		$converter->addExtension(new InlineFootnotesExtension());
		$converter->addExtension(new WikilinksExtension(
			urlGenerator: fn (string $page): string => Router::url([
				'plugin' => 'Sandbox',
				'controller' => 'Carve',
				'action' => 'wiki',
				$this->wikiSlug($page),
			]),
		));
		$converter->addExtension(new DetailsExtension());
		$converter->addExtension(new ListTableExtension());
		$converter->addExtension(new MathBlockExtension());
		$converter->addExtension(new CitationsExtension());
		$converter->addExtension(new LowercaseHeadingIdsExtension());
		$converter->addExtension(new SpoilerExtension());
		$converter->addExtension(new ColorSwatchExtension(tint: true));
		$converter->addExtension(new GlossaryExtension());
		$converter->addExtension(new IndexExtension());
		$converter->addExtension(new CodeCalloutsExtension());
		// Text mode so the Chart.js config rides in <pre class="chart"> as escaped
		// text and survives sanitizing (the json preset's <script> wrapper would
		// be stripped). The playground renders it client-side via Chart.js.
		$converter->addExtension(new FencedRenderExtension(
			language: 'chart',
			contentMode: FencedRenderExtension::MODE_TEXT,
			cssClass: 'chart',
		));
	}

	/**
	 * Slugify a wikilink page name for the wiki stub URL.
	 *
	 * @param string $page
	 * @return string
	 */
	protected function wikiSlug(string $page): string {
		return strtolower(str_replace(' ', '-', trim($page)));
	}

	/**
	 * Demo stub target for the Wikilinks extension. There is no real wiki; any
	 * [[Page]] link from the playground lands here so the links resolve.
	 *
	 * @param string $page
	 * @return void
	 */
	public function wiki(string $page = ''): void {
		$this->set('page', $page);
		$this->set('title', $page !== '' ? ucwords(str_replace('-', ' ', $page)) : 'Wiki');
	}

	/**
	 * Human-readable description of the default extension set, for the page
	 * footer. Keep in sync with {@link self::addDefaultExtensions()}.
	 *
	 * @return array<string, string>
	 */
	protected function defaultExtensionInfo(): array {
		return [
			'AutolinkExtension' => 'Bare URLs and email addresses become links.',
			'ExternalLinksExtension' => 'External links get target="_blank" and rel="noopener noreferrer".',
			'AdmonitionExtension' => '::: note / tip / warning / ... blocks render as styled callouts with icons.',
			'SemanticSpanExtension' => '[text]{kbd}, {dfn} and {abbr="..."} become <kbd>, <dfn> and <abbr>.',
			'AsciiHeadingIdsExtension' => 'Heading ids are folded to ASCII for share-safe fragments.',
			'PlusBulletExtension' => '+ works as a bullet-list marker alongside - and *.',
			'InlineFootnotesExtension' => '[note]{.fn} produces an inline footnote collected at the end.',
			'WikilinksExtension' => '[[Page]] and [[Page|label]] link to the /sandbox/carve/wiki/... stub.',
			'DetailsExtension' => '::: details "Title" renders as a native <details>/<summary> disclosure widget.',
			'ListTableExtension' => '::: list-table blocks (nested lists) render as real HTML tables with block-level cells.',
			'MathBlockExtension' => '``` math fenced blocks render as display math for KaTeX / MathJax.',
			'CitationsExtension' => '[@key] citations with an in-document bibliography ([@key]: ...) collected as a numbered reference list.',
			'LowercaseHeadingIdsExtension' => 'Heading ids are lowercased for GitHub/SSG-style anchors.',
			'FencedRenderExtension (chart)' => '``` chart fenced blocks (Chart.js JSON, text mode) render client-side via Chart.js.',
			'SpoilerExtension' => ':spoiler[text] becomes a click-to-reveal blurred inline span; ::: spoiler "Title" becomes a <details> disclosure.',
			'ColorSwatchExtension' => ':color[#3b82f6] renders a small color chip next to the value when it is a valid CSS color.',
			'GlossaryExtension' => ':term[word] links a use to its definition in a glossary definition list.',
			'IndexExtension' => ':index[term] drops an invisible index marker, collected per occurrence for a back-of-book index.',
			'CodeCalloutsExtension' => '<n> markers at the end of code lines become numbered bubbles; a following list of <n> text lines binds as the explanation.',
		];
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
		$disableExtensions = (bool)$this->request->getData('disable_ext');
		// Markdown-compatibility option: render soft breaks (single newlines) as
		// <br>. Null keeps the Carve default (newline / collapse onto one line).
		$softBreakMode = (string)$this->request->getData('soft_break_br') === '1' ? SoftBreakMode::Break : null;

		$result = [
			'html' => '',
			'warnings' => [],
			'violations' => [],
			'ms' => null,
			'bytes' => strlen($carve),
			'error' => null,
		];

		if ($carve) {
			try {
				$profile = $this->getProfile($profileName, $filterMode);
				// Carve interrupts paragraphs unconditionally (§10 default); there
				// is no strict toggle anymore.
				$converter = new CarveConverter(true, $collectWarnings, $strict, null, $profile, softBreakMode: $softBreakMode, sourceLines: true);
				// Tabs in code render unevenly without a CSS tab-size; expand
				// them to spaces by default for consistent playground output.
				$converter->addExtension(new TabNormalizeExtension(width: 4));
				// The playground enables a curated, safe set of extensions by
				// default (mostly no-ops unless their syntax is used); the UI can
				// turn them off to show plain spec output.
				if (!$disableExtensions) {
					$this->addDefaultExtensions($converter);
				}
				$start = microtime(true);
				$html = $converter->convert($carve);
				$result['ms'] = round((microtime(true) - $start) * 1000, 2);
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
	 * Media embeds via the carve-php-media-embed extension (dereuromark/media-embed).
	 *
	 * @return void
	 */
	public function mediaEmbed(): void {
		$defaultCarve = <<<'CARVE'
		Embed audio/video from 35+ providers with concise inline syntax.

		Per-provider (bare id or full url):

		:youtube[dQw4w9WgXcQ]

		:vimeo[https://vimeo.com/channels/staffpicks/99585787]

		:ted[https://www.ted.com/talks/sir_ken_robinson_do_schools_kill_creativity]

		Catchall with auto-detection:

		:media[https://open.spotify.com/track/4iV5W9uYEdYUVa79Axb7Rh]

		:media[https://sketchfab.com/3d-models/the-great-drawing-room-2QpgjMeXKHq6L8KIBAJjRrFV3jg]
		CARVE;
		$defaultCarve = preg_replace('/^\t\t/m', '', $defaultCarve) ?? $defaultCarve;

		$carve = (string)($this->request->getData('carve') ?? '');
		if (!$this->request->is('post')) {
			$carve = $defaultCarve;
		}

		$converter = new CarveConverter();
		$converter->addExtension(new MediaEmbedExtension());

		$output = '';
		$error = null;
		try {
			$output = $converter->convert($carve);
		} catch (Throwable $e) {
			$error = $e->getMessage();
		}

		$this->set(compact('carve', 'output', 'error'));
	}

	/**
	 * Code-block showcase: syntax highlighting, line numbers, line highlight /
	 * diff / focus, title bar and copy button. Carve emits the attributes from a
	 * preceding `{...}` line onto the `<pre>`; highlight.js plus a little JS on
	 * the page turn them into the gutter, highlighted lines and chrome.
	 *
	 * @return void
	 */
	public function codeBlocks(): void {
		$converter = new CarveConverter();
		$examples = [];
		foreach ($this->getCodeBlockExamples() as $key => $example) {
			$example['html'] = $converter->convert($example['carve']);
			$examples[$key] = $example;
		}
		$this->set(compact('examples'));
	}

	/**
	 * Source examples for the code-block showcase. Each carries the Carve source;
	 * the rendered HTML is added in {@link self::codeBlocks()}.
	 *
	 * @return array<string, array<string, string>>
	 */
	protected function getCodeBlockExamples(): array {
		return [
			'highlighting' => [
				'title' => 'Syntax highlighting',
				'description' => 'A fenced block with a language info string renders as <pre><code class="language-X">; highlight.js colors it on the page. Carve highlights nothing itself, so any highlighter works.',
				'carve' => <<<'CARVE'
``` php
function greet(string $name): string
{
    return "Hello, {$name}!";
}
```
CARVE,
			],
			'line_numbers' => [
				'title' => 'Line numbers',
				'description' => 'Add the .line-numbers class on the preceding attribute line to get a gutter. Use data-line-start to offset the first number (handy for excerpts).',
				'carve' => <<<'CARVE'
{.line-numbers data-line-start="42"}
``` js
const items = await fetch('/api/items').then(r => r.json());
for (const item of items) {
  render(item);
}
```
CARVE,
			],
			'line_highlight' => [
				'title' => 'Highlighted lines',
				'description' => 'data-highlight takes a comma list of line numbers and ranges (e.g. "2,4-6"). Those lines get a marker background. Works with or without the gutter.',
				'carve' => <<<'CARVE'
{.line-numbers data-highlight="2,4-5"}
``` php
$user = $this->Users->get($id);
$user->verified = true;          // changed
$user->verified_at = new DateTime();
$this->Users->save($user);       // and
$this->log("verified {$id}");    // these
```
CARVE,
			],
			'diff' => [
				'title' => 'Diff (add / remove)',
				'description' => 'data-add and data-remove mark inserted and deleted lines with +/- gutters and green/red backgrounds, like a code review diff.',
				'carve' => <<<'CARVE'
{.line-numbers data-remove="2" data-add="3"}
``` php
$query = $table->find();
$query->where(['active' => 1]);
$query->where(['active' => true]);
return $query->all();
```
CARVE,
			],
			'focus' => [
				'title' => 'Focus',
				'description' => 'data-focus dims every line except the listed ones, so the eye jumps to what matters; hovering the block restores full contrast.',
				'carve' => <<<'CARVE'
{.line-numbers data-focus="3-4"}
``` php
class PaymentService
{
    public function charge(Money $amount): Receipt
    {
        return $this->gateway->process($amount);
    }
}
```
CARVE,
			],
			'title_bar' => [
				'title' => 'Title bar and language badge',
				'description' => 'A quoted "header" right on the fence opener (the spec-native form from carve#201) renders a filename header above the block; the language shows as a badge. A {title="..."} attribute line does the same and wins if both are present. A copy-to-clipboard button is added to every block.',
				'carve' => <<<'CARVE'
{.line-numbers}
``` php "config/app.php"
return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
];
```
CARVE,
			],
			'combined' => [
				'title' => 'Everything together',
				'description' => 'Fence-opener header, line numbers, a highlighted line and a diff in one block.',
				'carve' => <<<'CARVE'
{.line-numbers data-highlight="4" data-remove="5" data-add="6"}
``` php "src/Middleware/AuthMiddleware.php"
public function process($request, $handler)
{
    $identity = $this->authenticate($request);
    $request = $request->withAttribute('identity', $identity);
    return $handler->handle($request);
    return $handler->handle($request->withAttribute('identity', $identity));
}
```
CARVE,
			],
		];
	}

	/**
	 * Extensions showcase.
	 *
	 * @return void
	 */
	public function extensions(): void {
		$examples = $this->getExtensionExamples();
		$groupedExamples = $this->groupExamples($examples);
		$this->set(compact('examples', 'groupedExamples'));
	}

	/**
	 * Ordered category map for the extension showcase. Keys are category labels,
	 * values are the extension keys (from {@link self::getExtensionExamples()})
	 * in display order.
	 *
	 * @return array<string, array<string>>
	 */
	protected function extensionGroups(): array {
		return [
			'Links & References' => ['autolink', 'external_links', 'wikilinks', 'mentions', 'inline_footnotes', 'citations', 'heading_reference', 'glossary', 'index'],
			'Headings & TOC' => ['heading_permalinks', 'ascii_heading_ids', 'lowercase_heading_ids', 'heading_level_shift', 'toc', 'toc_placement'],
			'Inline & Text' => ['semantic_span', 'smart_quotes', 'plus_bullet', 'tab_normalize', 'color_swatch'],
			'Blocks & Containers' => ['admonition', 'details', 'spoiler', 'tabs', 'code_group', 'code_callouts', 'list_table'],
			'Client-rendered & Math' => ['math_block', 'mermaid', 'chart'],
			'Document & Attributes' => ['frontmatter', 'default_attributes'],
		];
	}

	/**
	 * Groups the flat example list by category for the showcase. Any example not
	 * listed in {@link self::extensionGroups()} falls into a trailing "Other"
	 * group so nothing is silently dropped.
	 *
	 * @param array<string, array<string, mixed>> $examples
	 * @return array<string, array<string, array<string, mixed>>>
	 */
	protected function groupExamples(array $examples): array {
		$grouped = [];
		$remaining = $examples;
		foreach ($this->extensionGroups() as $category => $keys) {
			foreach ($keys as $key) {
				if (isset($remaining[$key])) {
					$grouped[$category][$key] = $remaining[$key];
					unset($remaining[$key]);
				}
			}
		}
		if ($remaining) {
			$grouped['Other'] = $remaining;
		}

		return $grouped;
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
				fn (mixed $ext): bool => $ext !== 'heading_reference',
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
						case 'toc_placement':
							$converter->addExtension(new TocPlacementExtension());

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
							$converter->addExtension(FencedRenderExtension::mermaid());

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
						case 'details':
							$converter->addExtension(new DetailsExtension());

							break;
						case 'list_table':
							$converter->addExtension(new ListTableExtension());

							break;
						case 'math_block':
							$converter->addExtension(new MathBlockExtension());

							break;
						case 'citations':
							$converter->addExtension(new CitationsExtension());

							break;
						case 'lowercase_heading_ids':
							$converter->addExtension(new LowercaseHeadingIdsExtension());

							break;
						case 'spoiler':
							$converter->addExtension(new SpoilerExtension());

							break;
						case 'color_swatch':
							$converter->addExtension(new ColorSwatchExtension(tint: true));

							break;
						case 'glossary':
							$converter->addExtension(new GlossaryExtension());

							break;
						case 'index':
							$converter->addExtension(new IndexExtension());

							break;
						case 'code_callouts':
							$converter->addExtension(new CodeCalloutsExtension());

							break;
						case 'chart':
							// Text mode (not the json-mode chart() preset) so the
							// config rides in <pre class="chart"> as escaped text and
							// survives HTML sanitizing; the json preset's inert
							// <script type="application/json"> wrapper would be stripped.
							$converter->addExtension(new FencedRenderExtension(
								language: 'chart',
								contentMode: FencedRenderExtension::MODE_TEXT,
								cssClass: 'chart',
							));

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
				'example_carve' => <<<'CARVE'
Check out this [link to Carve](https://github.com/markup-carve/carve).

![Sample image](/img/cake.icon.png)

|= Feature |= Support |
| Tables   | Yes      |
| Images   | Yes      |

``` php
echo "Hello World";
```
CARVE,
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
				'example_carve' => <<<'CARVE'
Visit https://github.com/markup-carve/carve for the official documentation.

Contact us at info@example.com for support.

Also check out https://github.com/markup-carve/carve-php for the PHP implementation.
CARVE,
				'options' => [
					'allowedSchemes' => "['https', 'http', 'mailto']",
				],
			],
			'external_links' => [
				'name' => 'ExternalLinksExtension',
				'description' => 'Adds `target="_blank"` and `rel="noopener noreferrer"` attributes to external links for security and UX.',
				'class' => ExternalLinksExtension::class,
				'example_carve' => <<<'CARVE'
Check out [Carve's homepage](https://github.com/markup-carve/carve) for more information.

This [internal link](/sandbox/carve) stays in the same tab.

Visit [GitHub](https://github.com) to see the source code.
CARVE,
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
				'example_carve' => <<<'CARVE'
# Introduction

Welcome to the documentation.

## Getting Started

First, install the package.

### Configuration

Configure the settings as needed.

## Advanced Usage

For power users.
CARVE,
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
				'description' => 'Transforms `@username` patterns into profile links, perfect for social features.',
				'class' => MentionsExtension::class,
				'example_carve' => <<<'CARVE'
Thanks to @johndoe for the contribution!

The feature was implemented by @alice and reviewed by @bob.

If you have questions, reach out to @support-team.
CARVE,
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
				'example_carve' => <<<'CARVE'
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
CARVE,
				'options' => [
					'minLevel' => '1',
					'maxLevel' => '6',
					'listType' => "'ul'",
					'cssClass' => "'toc'",
					'position' => "null, 'top', or 'bottom'",
				],
			],
			'toc_placement' => [
				'name' => 'TocPlacementExtension',
				'description' => 'In-document placement directives. `::: toc` renders a `<nav class="toc">` exactly where written (unlike TableOfContentsExtension, which injects one TOC at the document top or bottom), so a long document can place its contents after an intro. A `{depth=N}` or `{from=X to=Y}` attribute line before the opener sets an optional level window. `::: footnotes` (always-on core, no toggle needed) relocates the endnotes section to the marker. Both render byte-identical to carve-js.',
				'class' => TocPlacementExtension::class,
				'example_carve' => <<<'CARVE'
# Guide

Intro paragraph shown before the contents.

{depth=2}
::: toc
:::

## Setup

Install steps[^install].

### Requirements

PHP 8.2+.

## Usage

Run it[^run].

[^install]: Install via Composer.
[^run]: See the CLI docs.

::: footnotes
:::
CARVE,
				'options' => [
					'depth' => 'N - include levels 1-N',
					'from' => 'X - window start level',
					'to' => 'Y - window end level',
				],
			],
			'semantic_span' => [
				'name' => 'SemanticSpanExtension',
				'description' => 'Converts span attributes into semantic HTML5 elements like `<kbd>`, `<dfn>`, and `<abbr>` for keyboard input, definitions, and abbreviations.',
				'class' => SemanticSpanExtension::class,
				'example_carve' => <<<'CARVE'
Press [Ctrl+C]{kbd} to copy the selection.

A [variable]{dfn} is a named storage location in memory.

The [HTML]{abbr="HyperText Markup Language"} standard defines web page structure.

[CSS]{dfn abbr="Cascading Style Sheets"} is used for styling web pages.

Use [Enter]{kbd} to submit and [Esc]{kbd} to cancel.
CARVE,
				'options' => [
					'(none)' => 'Uses span attributes: kbd, dfn, abbr',
				],
			],
			'smart_quotes' => [
				'name' => 'SmartQuotesExtension',
				'description' => 'Configures locale-specific typographic quote characters. Transforms straight quotes into proper opening/closing quotes based on language conventions.',
				'class' => SmartQuotesExtension::class,
				'example_carve' => <<<'CARVE'
She said, "Hello, world!"

It's a 'simple' example.

"Nested 'quotes' work too," he replied.

The "German style" uses „low-high" quotes.
CARVE,
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
				'description' => 'Shifts heading levels down (h1 → h2, h2 → h3, etc.). Useful when `h1` is reserved for the page title and document headings should start at `h2` for SEO and accessibility.',
				'class' => HeadingLevelShiftExtension::class,
				'example_carve' => <<<'CARVE'
# Main Title (becomes h2)

Introduction paragraph.

## Section (becomes h3)

Section content.

### Subsection (becomes h4)

More details here.
CARVE,
				'options' => [
					'shift' => '1 (1-5, levels capped at h6)',
				],
			],
			'mermaid' => [
				'name' => 'FencedRenderExtension::mermaid()',
				'description' => 'Transforms code blocks with language `mermaid` into Mermaid.js-compatible markup for rendering diagrams (flowcharts, sequence, class diagrams, and more). Mermaid is a preset of the generic FencedRenderExtension; presets for d2, graphviz, wavedrom and abc also exist.',
				'class' => FencedRenderExtension::class,
				'example_carve' => <<<'CARVE'
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
CARVE,
				'options' => [
					'tag' => "'pre' or 'div'",
					'cssClass' => "'mermaid'",
					'wrapInFigure' => 'false',
					'figureClass' => "'mermaid-figure'",
				],
			],
			'admonition' => [
				'name' => 'AdmonitionExtension',
				'description' => 'Transforms divs with admonition type classes (note, tip, warning, danger, info, success) into semantic HTML with ARIA roles, emoji icons, and auto-generated titles. For a collapsible block use the Details extension (::: details "Title").',
				'class' => AdmonitionExtension::class,
				'example_carve' => <<<'CARVE'
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
CARVE,
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
				'description' => 'Transforms nested divs into accessible tabbed interfaces. CSS-only mode uses radio inputs and sibling selectors (no JavaScript required). The tab name comes from the opener [Label] (canonical, carve#201), falling back to a leading content heading. Use more colons (`::::`) for the outer tabs container to nest the inner tab divs.',
				'class' => TabsExtension::class,
				'example_carve' => <<<'CARVE'
:::: tabs

::: tab [Installation]
Install the package with Composer:

`composer require markup-carve/carve-php`
:::

::: tab [Usage]
Convert Carve to HTML:

`$html = $converter->convert($carve);`
:::

::: tab [Configuration]
Configure options as needed.
:::

::::
CARVE,
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
				'example_carve' => <<<'CARVE'
::: code-group

``` bash [Composer]
composer require markup-carve/carve-php
```

``` bash [NPM]
npm install @example/carve
```

``` bash [Pip]
pip install carve
```

:::
CARVE,
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
				'description' => 'Parses `[[wikilinks]]` into navigational links. Supports `[[page|display text]]` syntax and anchors like `[[page#section]]`. Common in wiki systems and note-taking apps like Obsidian.',
				'class' => WikilinksExtension::class,
				'example_carve' => <<<'CARVE'
Check out the [[Getting Started]] guide for beginners.

For advanced users, see [[Advanced Topics|the advanced section]].

The [[API Reference#authentication]] section covers auth.

Related: [[Best Practices]], [[FAQ]], [[Troubleshooting]]
CARVE,
				'options' => [
					'urlGenerator' => 'Custom URL generator closure',
					'cssClass' => "'wikilink'",
					'newWindow' => 'false',
				],
			],
			'heading_reference' => [
				'name' => 'HeadingReferenceExtension',
				'description' => 'Resolves `[[Heading Text]]` references to headings within the same document, producing anchor links. Supports custom display text via `[[Heading Text|click here]]`. Unresolvable references fall back to literal `[[...]]` text. Note: shares the `[[...]]` syntax with WikilinksExtension, so the two cannot be enabled on the same converter.',
				'class' => HeadingReferenceExtension::class,
				'example_carve' => <<<'CARVE'
# Installation

See [[Configuration]] for setup details, or jump straight to [[Usage|how to use it]].

# Configuration

Configure your settings here. A missing target like [[Nonexistent Section]] stays literal.

# Usage

Use the tool as described above.
CARVE,
				'options' => [
					'cssClass' => "'heading-ref'",
				],
			],
			'inline_footnotes' => [
				'name' => 'InlineFootnotesExtension',
				'description' => 'Converts spans marked with the `.fn` class into inline footnotes. Footnote content is written inline with the text instead of in a separate definition block, and is collected into a footnotes section at the end of the document. Content supports full inline formatting.',
				'class' => InlineFootnotesExtension::class,
				'example_carve' => <<<'CARVE'
Carve supports inline footnotes[This is the footnote content, written inline.]{.fn} right where you need them.

Footnote content can include _emphasis_ and `code`[Footnotes support full inline formatting.]{.fn} too.
CARVE,
				'options' => [
					'cssClass' => "'fn'",
				],
			],
			'frontmatter' => [
				'name' => 'FrontmatterExtension',
				'description' => 'Parses YAML/NEON/TOML/... frontmatter blocks at the start of documents. The format identifier (`yaml`, `neon`, `toml`, ...) is optional.',
				'class' => FrontmatterExtension::class,
				'example_carve' => <<<'CARVE'
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
CARVE,
				'options' => [
					'defaultFormat' => "'yaml'",
					'renderAsComment' => 'false (true renders as HTML comment)',
					'renderCallback' => 'Custom render function',
				],
			],
			'plus_bullet' => [
				'name' => 'PlusBulletExtension',
				'description' => 'Re-enables `+` as a bullet-list marker alongside `-` and `*`. A `+` is only a bullet when followed by a space and content; a bare `+` stays the list-continuation marker, so the two never collide. Task lists (`+ [ ]`) work too.',
				'class' => PlusBulletExtension::class,
				'example_carve' => <<<'CARVE'
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
CARVE,
				'options' => [
					'(none)' => 'Toggle-only; enable by adding the extension',
				],
			],
			'ascii_heading_ids' => [
				'name' => 'AsciiHeadingIdsExtension',
				'description' => 'Folds auto-generated heading ids to ASCII. By default Carve keeps non-ASCII characters in ids (`# Über uns` becomes `Über-uns`); this extension transliterates them (`Über-uns` becomes `Uber-uns`) for share-safe URL fragments. Unmapped scripts (CJK, Arabic) pass through unchanged.',
				'class' => AsciiHeadingIdsExtension::class,
				'example_carve' => <<<'CARVE'
# Über uns

## Café résumé

### Größe & Maße

Compare the generated id attributes with and without the extension.
CARVE,
				'options' => [
					'transliterator' => 'AsciiTransliterator (custom map optional)',
				],
			],
			'tab_normalize' => [
				'name' => 'TabNormalizeExtension',
				'description' => 'Expands literal tabs in code blocks and inline code to a fixed number of spaces at render time. Carve preserves tabs by default (a CSS tab-size concern); this is useful for fixed-width output without CSS, e.g. email, RSS or plain HTML. This demo uses width 4.',
				'class' => TabNormalizeExtension::class,
				'example_carve' => <<<CARVE
``` js
function greet() {
\treturn "hi";
}
```
CARVE,
				'options' => [
					'width' => '4 (spaces per tab; default 2)',
				],
			],
			'details' => [
				'name' => 'DetailsExtension',
				'description' => 'Renders ::: details "Title" admonition blocks as the native HTML5 <details>/<summary> disclosure widget. The quoted title becomes the <summary>; the body stays collapsed until the reader expands it.',
				'class' => DetailsExtension::class,
				'example_carve' => <<<'CARVE'
::: details "What is Carve?"
Carve is a djot-flavored markup converter for PHP.

The body can hold *any* block content: lists, code, even tables.
:::
CARVE,
			],
			'list_table' => [
				'name' => 'ListTableExtension',
				'description' => 'Renders ::: list-table blocks as real HTML tables authored as nested lists, so cells can hold full block content (paragraphs, lists, code) that pipe-table syntax cannot. The preceding line carries optional {header-rows=N} / {header-cols=N} counts, or their boolean form ({header-rows} marks just the first row/column).',
				'class' => ListTableExtension::class,
				'example_carve' => <<<'CARVE'
{header-rows=1}
::: list-table "Quarterly results"
- - Region
  - Notes
- - EMEA
  - Strong quarter.

    Drivers:

    - new logos
    - renewals
:::
CARVE,
			],
			'math_block' => [
				'name' => 'MathBlockExtension',
				'description' => 'Renders a fenced ``` math ``` block as block-level display math (<div class="math display">\[…\]</div>), matching how inline and display $…$ math is emitted so KaTeX / MathJax can pick it up.',
				'class' => MathBlockExtension::class,
				'example_carve' => <<<'CARVE'
``` math
\int_0^1 x^2 \, dx = \frac{1}{3}
```
CARVE,
				'options' => [
					'language' => "'math' (fence info string to match; default 'math')",
				],
			],
			'citations' => [
				'name' => 'CitationsExtension',
				'description' => 'Bracketed [@key] citations with an in-document bibliography. Each [@key] becomes a numbered reference link, and [@key]: ... definition lines are collected into an ordered reference list at the end. Supports a prefix ([see @key]), author suppression ([-@key]), typed locators after a comma ([@key, p. 12] / ch. / §, the full citeproc vocabulary, §22), multiple semicolon-separated sources, and a group-level integral marker ([+@key]).',
				'class' => CitationsExtension::class,
				'example_carve' => <<<'CARVE'
Carve follows the djot spec [@durusau2022, p. 12] and borrows ideas from Markdown [see @gruber2004, ch. 3].

Author suppression reads naturally: Gruber [-@gruber2004] introduced Markdown in 2004.

Group several sources, with locators: [@durusau2022, pp. 12-14; @gruber2004, §2]. Force an integral (textual) group with a leading +: [+@durusau2022, p. 1].

[@durusau2022]: Durusau, P. (2022). *The djot markup language*.
[@gruber2004]: Gruber, J. (2004). *Markdown: Syntax*.
CARVE,
				'options' => [
					'mode' => "'numbered' (reference label style; default 'numbered')",
				],
			],
			'lowercase_heading_ids' => [
				'name' => 'LowercaseHeadingIdsExtension',
				'description' => 'Carve heading ids are case-preserving by default (# Getting Started -> "Getting-Started"). This opt-in extension lowercases them for GitHub/SSG-style anchors (-> "getting-started"). Combine with AsciiHeadingIds for fully lowercase ASCII slugs.',
				'class' => LowercaseHeadingIdsExtension::class,
				'example_carve' => <<<'CARVE'
# Getting Started

## API Reference

See [API Reference][] for the lowercased anchor.
CARVE,
			],
			'spoiler' => [
				'name' => 'SpoilerExtension',
				'description' => 'Hidden / blurred spoiler content. Inline :spoiler[text] becomes <span class="spoiler"> (blurred until you click it); block ::: spoiler "Title" becomes a native <details class="spoiler"> disclosure (click the summary). The blur + click-to-reveal is host CSS + a tiny bit of JS.',
				'class' => SpoilerExtension::class,
				'example_carve' => <<<'CARVE'
The killer was :spoiler[the butler] all along.

::: spoiler "Episode ending"
They defeat the villain and head home.
:::
CARVE,
			],
			'chart' => [
				'name' => 'FencedRenderExtension::chart() (text mode)',
				'description' => 'Renders a ``` chart fenced block (Chart.js JSON config) as a client-rendered chart. Configured in text mode so the JSON rides in <pre class="chart"> as escaped text and survives HTML sanitizing, instead of the json preset\'s <script type="application/json"> wrapper (which a sanitizer strips). Chart.js must be loaded on the page.',
				'class' => FencedRenderExtension::class,
				'example_carve' => <<<'CARVE'
``` chart
{
  "type": "bar",
  "data": {
    "labels": ["Q1", "Q2", "Q3", "Q4"],
    "datasets": [{ "label": "Revenue", "data": [12, 19, 14, 23] }]
  }
}
```
CARVE,
				'options' => [
					'language' => "'chart' (fence info string to match)",
					'contentMode' => 'MODE_TEXT (sanitizer-safe; avoids the json-mode <script> wrapper)',
				],
			],
			'color_swatch' => [
				'name' => 'ColorSwatchExtension',
				'description' => 'Inline :color[value] renders a small color chip next to the value when it flattens to a valid CSS color (hex, named, rgb()/hsl()); invalid values fall back to a plain <span class="ext-color">. Configurable chip position, shape and an optional faint tint behind the swatch. Add a {contrast} attribute to render the value inside a filled box with an auto-picked black or white label (brightness-based), instead of a chip. This demo uses tint: true.',
				'class' => ColorSwatchExtension::class,
				'options' => [
					'position' => "'before' (default) | 'after' | 'none' (chip only, value as title)",
					'shape' => "'square' (default) | 'round' | 'ring'",
					'tint' => 'false (default) | true (faint color-mix tint behind the swatch)',
					'reveal' => 'false (default) | true (collapse value, reveal on hover/focus)',
					'{contrast} attr' => 'per-use: filled label box with auto black/white text',
				],
				'example_carve' => <<<'CARVE'
Brand palette: :color[#3b82f6], :color[rebeccapurple] and :color[hsl(150 60% 45%)].

Auto-contrast labels (text flips black/white to stay readable): :color[#3b82f6]{contrast} :color[#facc15]{contrast} :color[#111827]{contrast}.

Not a color: :color[banana].
CARVE,
			],
			'glossary' => [
				'name' => 'GlossaryExtension',
				'description' => 'Inline :term[word] marks a glossary use and links it to the matching definition-list term (<dt>) defined elsewhere in the document. Reuses the definition-list syntax; no new block syntax.',
				'class' => GlossaryExtension::class,
				'example_carve' => <<<'CARVE'
Carve is built on the :term[djot] data model and adds a few :term[extension]s.

:: djot
:  A light markup language with a clean, unambiguous grammar.

:: extension
:  An opt-in feature that adds inline or block behavior.
CARVE,
			],
			'index' => [
				'name' => 'IndexExtension',
				'description' => 'Inline :index[term] drops an invisible marker (an empty <span class="index-term" id="idx-...">) at each occurrence, collected for a back-of-book index. It renders nothing visible; it is an anchor an index page can link back to.',
				'class' => IndexExtension::class,
				'example_carve' => <<<'CARVE'
Carve:index[Carve] converts markup:index[markup] to HTML, and markup:index[markup] is fun.
CARVE,
			],
			'code_callouts' => [
				'name' => 'CodeCalloutsExtension',
				'description' => 'Annotate code with numbered callouts. A `<n>` marker at the end of a fenced-code line becomes a numbered bubble (<b class="callout">), and an immediately-following paragraph of `<n> text` lines binds to it as a `<ol class="callouts">` explanation list. Markers in the code round-trip unchanged.',
				'class' => CodeCalloutsExtension::class,
				'example_carve' => <<<'CARVE'
``` php
$converter = new CarveConverter(); <1>
$converter->addExtension(new CodeCalloutsExtension()); <2>

$html = $converter->convert($source); <3>
```

<1> Create the converter with default options.
<2> Register the extension so `<n>` markers are recognized.
<3> Convert; callouts render as numbered bubbles.
CARVE,
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
	 * Uses Tiptap with the CarveKit extensions from carve-grammars. The document
	 * is serialized to Carve markup client-side (serializeToCarve); the page then
	 * renders that Carve to sanitized HTML through the standard convert endpoint.
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
	 * that block. Carve paragraphs are not greedy, so no blank line is needed -
	 * with one exception: a list (bullet or ordered) following a paragraph needs
	 * a blank line, so a hard-wrapped "- " mid-prose is not turned into a list.
	 * Nested sub-lists still need no blank line.
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
			'msToHtml' => null,
			'msToCarve' => null,
			'error' => null,
		];

		if ($carve) {
			try {
				$toHtml = new CarveConverter(xhtml: true);
				$toCarve = new HtmlToCarve();

				$t = microtime(true);
				$rawHtml1 = $toHtml->convert($carve);
				$result['msToHtml'] = round((microtime(true) - $t) * 1000, 2);

				$t = microtime(true);
				$carve2 = $toCarve->convert($rawHtml1);
				$result['msToCarve'] = round((microtime(true) - $t) * 1000, 2);

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
	 * @return \MarkupCarve\Carve\Profile|null
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
		$config->set('HTML.DefinitionRev', 13);
		$config->set('HTML.Allowed', 'p[class|id|data-source-line],br[class|id],strong[class|id],em[class|id],u[class|id],s[class|id],del[class|id],ins[class|id],mark[class|id],sub[class|id],sup[class|id],b[class|id],a[href|title|class|id|target|rel|data-username|aria-label|role|download],img[src|alt|title|loading|decoding|class|id],ul[class|id|data-source-line],ol[start|type|class|id|data-source-line|reversed],li[class|id|value|data-source-line],dl[class|id|data-source-line],dt[class|id|data-source-line],dd[class|id|data-source-line],blockquote[class|id|data-source-line],pre[class|id|data-source-line],code[class|id],aside[class|id|data-source-line],h1[class|id|data-source-line],h2[class|id|data-source-line],h3[class|id|data-source-line],h4[class|id|data-source-line],h5[class|id|data-source-line],h6[class|id|data-source-line],table[class|id|data-source-line],caption[class|id],thead[class|id],tbody[class|id],tr[class|id],th[align|colspan|rowspan|style|class|id],td[align|colspan|rowspan|style|class|id],hr[class|id|data-source-line],div[class|id|role|aria-labelledby|hidden|data-source-line],span[class|id|style],section[class|id|role|data-source-line],nav[class|id|data-source-line],input[type|name|id|checked|disabled|class],label[for|class|id],button[role|id|class|tabindex|aria-selected|aria-controls],details[class|id|open|data-source-line],summary[class|id],figure[class|id|data-source-line],figcaption[class|id],kbd[class|id],dfn[class|id],samp[class|id],var[class|id],abbr[title|class|id]');
		// background-color is needed for the ColorSwatch extension's chip; the
		// value is validated as a CSS color by HTMLPurifier, so it cannot inject.
		// background + color additionally cover the {contrast} label variant
		// (value inside a filled box, auto black/white text). Each is color-
		// validated by HTMLPurifier, so none can break out of the declaration.
		$config->set('CSS.AllowedProperties', 'text-align, background-color, background, color');
		$config->set('Attr.EnableID', true);
		$config->set('Attr.AllowedFrameTargets', ['_blank']);
		$config->set('HTML.TargetBlank', false);
		// `data` is needed so self-contained build-time diagram images
		// (data:image/png;base64 from the static renderers) survive sanitization;
		// HTMLPurifier's data scheme only permits image MIME types, so it is safe.
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'data' => true]);
		$config->set('AutoFormat.RemoveEmpty', false);
		// Preserve HTML comments (e.g. frontmatter rendered as a comment) while blocking IE conditional comments.
		$config->set('HTML.AllowedCommentsRegexp', '#^(?!\s*\[if)#i');

		// Allow the ColorSwatch tint's color-mix() background value (the embedded
		// color is already validated, so it cannot break out of the declaration);
		// anything else falls back to HTMLPurifier's standard color validation.
		$cssDef = $config->getCSSDefinition();
		if ($cssDef !== null) {
			$cssDef->info['background-color'] = new class extends HTMLPurifier_AttrDef {
				/**
				 * @param string $string
				 * @param \HTMLPurifier_Config $config
				 * @param \HTMLPurifier_Context $context
				 * @return string|bool
				 */
				public function validate($string, $config, $context): string|bool {
					$string = trim($string);
					if (preg_match('/^color-mix\(in srgb, [#a-zA-Z0-9(),.%\s\/]+ \d{1,3}%, transparent\)$/', $string) === 1) {
						return $string;
					}

					return (new HTMLPurifier_AttrDef_CSS_Color())->validate($string, $config, $context);
				}
			};
		}

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
			// Boolean attrs carried through from bare-word carve attributes;
			// HTMLPurifier's HTML4 base does not define these HTML5 booleans.
			$def->addAttribute('a', 'download', 'Bool');
			$def->addAttribute('ol', 'reversed', 'Bool');
			// Scroll-sync anchors: the converter stamps blocks with
			// data-source-line (sourceLines: true); keep it through purification.
			$sourceLineElements = [
				'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li',
				'dl', 'dt', 'dd', 'blockquote', 'pre', 'div', 'table', 'hr',
				'section', 'figure', 'details', 'nav', 'aside',
			];
			foreach ($sourceLineElements as $element) {
				$def->addAttribute($element, 'data-source-line', 'Number');
			}
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
			// CodeCallouts: the bound explanation list is an <ol class="callouts">
			// of <li value="N">; the per-item value drives the CSS number bubble.
			$def->addAttribute('li', 'value', 'Number');
			// CodeCallouts: in-code <n> bubbles render as <b class="callout">N</b>.
			$def->addAttribute('b', 'data-callout', 'Text');
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

	/**
	 * Graceful-degradation demo: render the same Carve source through every
	 * output target so the degradation of interactive constructs (tabs,
	 * code-group, details, spoiler, mermaid, math) is visible per target.
	 *
	 * Targets:
	 * - `interactive`: live HTML (RenderMode::INTERACTIVE).
	 * - `static`: HTML for a non-interactive medium (RenderMode::STATIC); tabs
	 *   and code-group flatten to labeled sections, details/spoiler reveal,
	 *   mermaid/math use the build-time `renderers` closures or fall back to
	 *   source.
	 * - `markdown` / `plain` / `ansi`: the inherently static text renderers.
	 * - `pdf`: the static HTML run through dompdf, returned inline as a real PDF.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function demo(): ?Response {
		$target = (string)($this->request->getData('target') ?: 'static');
		$carve = (string)($this->request->getData('carve') ?? '');
		// On the first GET load, prefill with the showcase sample.
		if (!$this->request->is('post')) {
			$carve = $this->demoSampleCarve();
		}
		// Static "with build-time renderers" toggle: on by default so the
		// renderers-supplied path is what a visitor sees first. Off shows the
		// source fallback (no renderer registered for mermaid/math).
		$useRenderers = !$this->request->is('post') || $this->request->getData('use_renderers') !== null;

		// PDF is a separate response (binary), handled before the view renders.
		if ($this->request->is('post') && $target === 'pdf') {
			return $this->demoPdf($carve, $useRenderers);
		}

		$output = '';
		$rendered = '';
		$isHtml = false;
		$error = null;
		try {
			switch ($target) {
				case 'interactive':
					$rendered = $this->sanitizeHtml($this->demoHtmlConverter(RenderMode::INTERACTIVE)->convert($carve));
					$output = $this->demoHtmlConverter(RenderMode::INTERACTIVE)->convert($carve);
					$isHtml = true;

					break;
				case 'static':
					$converter = $this->demoHtmlConverter(
						RenderMode::STATIC,
						$useRenderers ? $this->demoStaticRenderers() : [],
					);
					$output = $converter->convert($carve);
					$rendered = $this->sanitizeHtml($output);
					$isHtml = true;

					break;
				case 'markdown':
					$output = CarveConverter::markdown()->convert($carve);

					break;
				case 'plain':
					$output = CarveConverter::plainText()->convert($carve);

					break;
				case 'ansi':
					$ansi = CarveConverter::ansi()->convert($carve);
					$output = $ansi;
					$rendered = $this->ansiToHtml($ansi);
					$isHtml = true;

					break;
				default:
					$error = sprintf('Unknown target "%s".', $target);
			}
		} catch (Throwable $e) {
			$error = $e->getMessage();
		}

		$this->set('carve', $carve);
		$this->set('target', $target);
		$this->set('useRenderers', $useRenderers);
		$this->set('output', $output);
		$this->set('rendered', $rendered);
		$this->set('isHtml', $isHtml);
		$this->set('error', $error);
		$this->set('targets', $this->demoTargets());

		return null;
	}

	/**
	 * Render the static HTML through dompdf and return it inline as a real PDF.
	 *
	 * @param string $carve
	 * @param bool $useRenderers Whether to pass the build-time static renderers.
	 * @return \Cake\Http\Response
	 */
	protected function demoPdf(string $carve, bool $useRenderers = true): Response {
		// Cache the rendered PDF (keyed on source + renderer toggle) so repeated
		// or shared requests skip dompdf and the kroki/dot renders entirely.
		$this->ensureDemoCache();
		$key = 'carve_demo_pdf_' . md5($carve . ($useRenderers ? '1' : '0'));
		$pdf = Cache::read($key, 'carve_demo');
		if (!is_string($pdf)) {
			$converter = $this->demoHtmlConverter(
				RenderMode::STATIC,
				$useRenderers ? $this->demoStaticRenderers() : [],
			);
			$body = $this->sanitizeHtml($converter->convert($carve));
			$html = $this->demoPrintDocument($body);

			$options = new Options();
			$options->set('isRemoteEnabled', false);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4');
			$dompdf->render();
			$pdf = (string)$dompdf->output();
			Cache::write($key, $pdf, 'carve_demo');
		}

		return $this->response
			->withType('pdf')
			->withHeader('Content-Disposition', 'inline; filename="carve-degradation-demo.pdf"')
			->withStringBody($pdf);
	}

	/**
	 * Register the demo cache config once (idempotent). A dedicated File cache
	 * with a 1-day TTL keeps the kroki/dot renders and PDFs out of the app's
	 * default cache and bounds external load.
	 */
	protected function ensureDemoCache(): void {
		if (in_array('carve_demo', Cache::configured(), true)) {
			return;
		}
		Cache::setConfig('carve_demo', [
			'className' => 'File',
			'duration' => '+1 day',
			'path' => CACHE . 'carve_demo' . DS,
			'prefix' => 'carve_demo_',
		]);
	}

	/**
	 * Wrap the static HTML body in a minimal print document/stylesheet so the
	 * flattened tabs and revealed sections read cleanly in the PDF.
	 *
	 * @param string $body
	 * @return string
	 */
	protected function demoPrintDocument(string $body): string {
		return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
	@page { margin: 24mm 18mm; }
	body { font-family: "DejaVu Sans", sans-serif; font-size: 11pt; color: #1f2430; line-height: 1.55; }
	.pdf-header { position: fixed; top: -14mm; left: 0; right: 0; height: 10mm;
		font-size: 8pt; letter-spacing: 0.08em; text-transform: uppercase; color: #9aa3b5; }
	.pdf-footer { position: fixed; bottom: -16mm; left: 0; right: 0; height: 10mm;
		font-size: 8pt; color: #9aa3b5; border-top: 0.5pt solid #e3e7f0; padding-top: 4pt; text-align: right; }
	.pdf-footer .pg:after { content: "Page " counter(page); }
	h1 { font-size: 21pt; color: #0f1729; margin: 0 0 7pt; padding-bottom: 5pt; border-bottom: 2pt solid #2f7d7a; }
	h2 { font-size: 15pt; color: #16323f; margin: 16pt 0 5pt; }
	h3 { font-size: 12.5pt; color: #16323f; margin: 12pt 0 4pt; }
	p { margin: 0 0 7pt; }
	a { color: #2f6f9f; text-decoration: none; }
	pre { background: #f6f8fa; border: 0.5pt solid #dde3ec; border-radius: 4pt; padding: 8pt 10pt;
		font-family: "DejaVu Sans Mono", monospace; font-size: 9.5pt; line-height: 1.45; color: #243140;
		white-space: pre-wrap; word-wrap: break-word; page-break-inside: avoid; }
	code { background: #eef1f6; border-radius: 3pt; padding: 0.5pt 3pt; font-family: "DejaVu Sans Mono", monospace; font-size: 9.5pt; }
	pre code { background: transparent; padding: 0; }
	.tabs, .code-group { margin: 10pt 0; }
	.tabs-panel, .code-group-panel { margin: 0 0 8pt; page-break-inside: avoid; }
	.tabs-label, .code-group-label { display: block; color: #2f7d7a; font-weight: bold;
		font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 3pt; }
	.details, details { border: 0.5pt solid #d5dbe6; border-left: 3pt solid #2f7d7a; border-radius: 4pt;
		background: #fafcfc; padding: 7pt 11pt; margin: 9pt 0; page-break-inside: avoid; }
	.details-title, details summary { margin: 0 0 5pt; font-weight: bold; font-size: 11pt; color: #1d5b58; }
	.spoiler, .spoiler-revealed { background: #f1eef7; border-radius: 3pt; padding: 0.5pt 3pt; }
	section.spoiler { padding: 7pt 11pt; }
	.diagram-figure, figure { margin: 11pt 0; text-align: center; page-break-inside: avoid; }
	img.diagram { max-width: 100%; border: 0.5pt solid #e1e5ee; border-radius: 4pt; padding: 5pt; background: #fff; }
	figcaption { font-size: 8.5pt; font-style: italic; color: #7a8398; margin-top: 4pt; }
	.math.display, .math-static { display: block; text-align: center; margin: 9pt 0;
		font-family: "DejaVu Sans Mono", monospace; color: #243140; }
	.math-image { text-align: center; margin: 10pt 0; }
	.math-img { max-width: 100%; }
	.div-label { font-weight: bold; color: #1d5b58; font-size: 10pt; margin: 0 0 4pt; }
	table { border-collapse: collapse; width: 100%; margin: 9pt 0; font-size: 10pt; page-break-inside: avoid; }
	th, td { border: 0.5pt solid #d5dbe6; padding: 4pt 7pt; text-align: left; }
	th { background: #eef5f4; color: #1d5b58; }
	blockquote { border-left: 3pt solid #cfd6e2; color: #4a5366; margin: 9pt 0; padding: 2pt 12pt; }
	ul, ol { margin: 0 0 7pt 16pt; }
</style>
</head>
<body>
<div class="pdf-header">Carve - static render (print fallback)</div>
<div class="pdf-footer"><span class="pg"></span></div>
{$body}
</body>
</html>
HTML;
	}

	/**
	 * Build an HTML CarveConverter for the demo with the full interactive
	 * extension set (tabs, code-group, details, spoiler, mermaid, math, ...),
	 * a render mode, and optional build-time static renderers.
	 *
	 * @param string $mode RenderMode::INTERACTIVE or RenderMode::STATIC.
	 * @param array<string, \Closure(string): string> $renderers
	 * @return \MarkupCarve\Carve\CarveConverter
	 */
	protected function demoHtmlConverter(string $mode, array $renderers = []): CarveConverter {
		$converter = new CarveConverter(xhtml: true, mode: $mode, renderers: $renderers);
		$converter->addExtension(new TabNormalizeExtension(width: 4));
		$converter->addExtension(new TabsExtension(mode: TabsExtension::MODE_ARIA));
		$converter->addExtension(new CodeGroupExtension());
		$converter->addExtension(new DetailsExtension());
		$converter->addExtension(new SpoilerExtension());
		$converter->addExtension(new MathBlockExtension());
		$converter->addExtension(FencedRenderExtension::mermaid());

		return $converter;
	}

	/**
	 * Build-time static renderers for the demo. Each maps the extension's source
	 * string to sanitizer-safe HTML so the "with renderers" static path is
	 * visible. Without these the static renderer falls back to the source.
	 *
	 * @return array<string, \Closure(string): string>
	 */
	protected function demoStaticRenderers(): array {
		// Each renderer produces a real image (mermaid via kroki, graphviz via
		// the local `dot`, math via CodeCogs) and falls back to readable source.
		// All share demoCachedImage(), which caches successful renders so an
		// external service is hit at most once per unique source.
		return [
			'mermaid' => fn (string $s): string => $this->demoCachedImage(
				'mermaid_' . md5($s),
				fn (): ?string => $this->demoFigure($this->demoKrokiPng('mermaid', $s), 'Mermaid diagram'),
				fn (): string => $this->demoDiagramSource($s, 'Mermaid diagram (source - renderer unavailable)'),
			),
			'graphviz' => fn (string $s): string => $this->demoCachedImage(
				'graphviz_' . md5($s),
				fn (): ?string => $this->demoFigure($this->demoDotPng($s), 'Graphviz diagram'),
				fn (): string => $this->demoDiagramSource($s, 'Graphviz diagram (source - dot unavailable)'),
			),
			'math' => fn (string $s): string => $this->demoCachedImage(
				'math_' . md5(trim($s)),
				fn (): ?string => $this->demoMathFigure(trim($s)),
				fn (): string => '<div class="math-static">' . htmlspecialchars($s, ENT_QUOTES) . '</div>',
			),
			'chart' => fn (string $s): string => $this->demoDiagramSource($s, 'Chart config (no build-time renderer)'),
		];
	}

	/**
	 * Cache-on-success image wrapper: returns the cached figure, else the
	 * producer's figure (cached), else the fallback (not cached, so it retries).
	 */
	protected function demoCachedImage(string $key, Closure $produce, Closure $fallback): string {
		$this->ensureDemoCache();
		$full = 'carve_demo_diag_' . $key;
		$cached = Cache::read($full, 'carve_demo');
		if (is_string($cached)) {
			return $cached;
		}
		try {
			$figure = $produce();
			if (is_string($figure)) {
				Cache::write($full, $figure, 'carve_demo');

				return $figure;
			}
		} catch (Throwable $e) {
			// fall through to the fallback (uncached, so it retries next time)
		}

		return $fallback();
	}

	protected function demoKrokiPng(string $type, string $source): ?string {
		$response = (new Client(['timeout' => 8]))->post('https://kroki.io/' . $type . '/png', $source, ['type' => 'text/plain']);
		$png = $response->isOk() ? $response->getStringBody() : '';

		return $this->isPng($png) ? $png : null;
	}

	protected function demoDotPng(string $source): ?string {
		$process = @proc_open('dot -Tpng', [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
		if (!is_resource($process)) {
			return null;
		}
		fwrite($pipes[0], $source);
		fclose($pipes[0]);
		$png = stream_get_contents($pipes[1]);
		fclose($pipes[1]);
		fclose($pipes[2]);
		proc_close($process);

		return ($png !== false && $this->isPng($png)) ? $png : null;
	}

	protected function demoMathFigure(string $latex): ?string {
		$response = (new Client(['timeout' => 8]))->get('https://latex.codecogs.com/png.image?' . rawurlencode('\dpi{150} ' . $latex));
		$png = $response->isOk() ? $response->getStringBody() : '';
		if (!$this->isPng($png)) {
			return null;
		}

		return '<div class="math-image"><img class="math-img" src="data:image/png;base64,'
			. base64_encode($png) . '" alt="' . htmlspecialchars($latex, ENT_QUOTES) . '"></div>';
	}

	protected function isPng(string $bytes): bool {
		return substr($bytes, 0, 8) === "\x89PNG\r\n\x1a\n";
	}

	protected function demoFigure(?string $png, string $caption): ?string {
		return $png === null ? null : $this->demoImageFigure($png, $caption);
	}

	protected function demoImageFigure(string $png, string $caption): string {
		$src = 'data:image/png;base64,' . base64_encode($png);

		return '<figure class="diagram-figure">'
			. '<img class="diagram" src="' . $src . '" alt="' . htmlspecialchars($caption, ENT_QUOTES) . '">'
			. '<figcaption>' . htmlspecialchars($caption, ENT_QUOTES) . '</figcaption>'
			. '</figure>';
	}

	protected function demoDiagramSource(string $source, string $caption): string {
		return '<figure class="diagram-figure">'
			. '<pre><code>' . htmlspecialchars($source, ENT_QUOTES) . '</code></pre>'
			. '<figcaption>' . htmlspecialchars($caption, ENT_QUOTES) . '</figcaption>'
			. '</figure>';
	}

	/**
	 * The output targets offered by the demo (value => label).
	 *
	 * @return array<string, string>
	 */
	protected function demoTargets(): array {
		return [
			'interactive' => 'Interactive HTML',
			'static' => 'Static HTML',
			'markdown' => 'Markdown',
			'plain' => 'Plain text',
			'ansi' => 'ANSI (terminal colors)',
			'pdf' => 'PDF',
		];
	}

	/**
	 * Convert ANSI SGR escape sequences to HTML spans so terminal colors show
	 * in the browser. Handles the SGR codes the AnsiRenderer emits: reset (0),
	 * bold (1), dim (2), italic (3), underline (4), strikethrough (9), and the
	 * 16 foreground colors (30-37, 90-97).
	 *
	 * @param string $ansi
	 * @return string
	 */
	protected function ansiToHtml(string $ansi): string {
		$colors = [
			30 => '#000000',
			31 => '#cc0000',
			32 => '#4e9a06',
			33 => '#c4a000',
			34 => '#3465a4',
			35 => '#75507b',
			36 => '#06989a',
			37 => '#d3d7cf',
			90 => '#555753',
			91 => '#ef2929',
			92 => '#8ae234',
			93 => '#fce94f',
			94 => '#729fcf',
			95 => '#ad7fa8',
			96 => '#34e2e2',
			97 => '#eeeeec',
		];

		$open = 0;
		$result = '';
		$offset = 0;
		$length = strlen($ansi);
		while ($offset < $length) {
			$escPos = strpos($ansi, "\033[", $offset);
			if ($escPos === false) {
				$result .= htmlspecialchars(substr($ansi, $offset), ENT_QUOTES);

				break;
			}

			$result .= htmlspecialchars(substr($ansi, $offset, $escPos - $offset), ENT_QUOTES);

			$mPos = strpos($ansi, 'm', $escPos);
			if ($mPos === false) {
				$result .= htmlspecialchars(substr($ansi, $escPos), ENT_QUOTES);

				break;
			}

			$codes = substr($ansi, $escPos + 2, $mPos - ($escPos + 2));
			$offset = $mPos + 1;

			$styles = [];
			foreach (explode(';', $codes) as $codePart) {
				$code = (int)$codePart;
				if ($code === 0) {
					// Reset: close any open span.
					while ($open > 0) {
						$result .= '</span>';
						$open--;
					}

					continue;
				}
				$style = match (true) {
					$code === 1 => 'font-weight:bold',
					$code === 2 => 'opacity:0.7',
					$code === 3 => 'font-style:italic',
					$code === 4 => 'text-decoration:underline',
					$code === 9 => 'text-decoration:line-through',
					isset($colors[$code]) => 'color:' . $colors[$code],
					default => null,
				};
				if ($style !== null) {
					$styles[] = $style;
				}
			}

			if ($styles !== []) {
				$result .= '<span style="' . implode(';', $styles) . '">';
				$open++;
			}
		}

		while ($open > 0) {
			$result .= '</span>';
			$open--;
		}

		return $result;
	}

	/**
	 * Sample Carve source exercising every degradation class: tabs, code-group,
	 * details, inline + block spoiler, a mermaid fence, and display + inline math.
	 *
	 * @return string
	 */
	protected function demoSampleCarve(): string {
		return <<<'CARVE'
# Graceful degradation demo

The same source below renders differently per target. Interactive constructs
flatten or reveal when the medium cannot run client scripts.

:::: tabs
::: tab [Install]
``` bash
composer require markup-carve/carve-php
```
:::
::: tab [Usage]
``` php
$html = (new MarkupCarve\Carve\CarveConverter())->convert($carve);
```
:::
::::

:::: code-group
``` js [config.js]
export default { mode: 'static' };
```
``` json [config.json]
{ "mode": "static" }
```
::::

::: details "Show the details"
Hidden content that a static target reveals inline.
:::

Inline secret: :spoiler[the answer is 42] and a block spoiler below.

::: spoiler "Spoiler block"
This stays blurred online but is revealed for print and text targets.
:::

``` mermaid
graph TD
  A[Source] --> B{Target?}
  B -->|HTML| C[Interactive]
  B -->|PDF| D[Static]
```

Display math (a ``` math fence, handled by the math renderer in static mode):

``` math
\int_0^1 x^2 \, dx = \frac{1}{3}
```

And inline math $E = mc^2$ within a sentence.
CARVE;
	}

}
