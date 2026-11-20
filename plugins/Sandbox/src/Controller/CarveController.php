<?php

namespace Sandbox\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Log\Log;
use Cake\Routing\Router;
use Closure;
use Composer\InstalledVersions;
use Dompdf\Dompdf;
use Dompdf\Options;
use HTMLPurifier;
use HTMLPurifier_AttrDef;
use HTMLPurifier_AttrDef_CSS_Color;
use HTMLPurifier_Config;
use MarkupCarve\Carve\Carve;
use MarkupCarve\Carve\Diagnostics\Diagnostic;
use MarkupCarve\Carve\Export\AnsiExporter;
use MarkupCarve\Carve\Export\MarkdownExporter;
use MarkupCarve\Carve\Export\PlainTextExporter;
use MarkupCarve\Carve\Extension\Bundle;
use MarkupCarve\Carve\Extension\Citations;
use MarkupCarve\Carve\Extension\CodeCallouts;
use MarkupCarve\Carve\Extension\CodeGroup;
use MarkupCarve\Carve\Extension\ColorSwatch;
use MarkupCarve\Carve\Extension\Details;
use MarkupCarve\Carve\Extension\FencedRender;
use MarkupCarve\Carve\Extension\Glossary;
use MarkupCarve\Carve\Extension\ImgFence;
use MarkupCarve\Carve\Extension\IndexTerms;
use MarkupCarve\Carve\Extension\ListTable;
use MarkupCarve\Carve\Extension\MathBlock;
use MarkupCarve\Carve\Extension\Navigation;
use MarkupCarve\Carve\Extension\SemanticSpan;
use MarkupCarve\Carve\Extension\SmartQuotes;
use MarkupCarve\Carve\Extension\Spoiler;
use MarkupCarve\Carve\Extension\Tabs;
use MarkupCarve\Carve\Extension\Transforms;
use MarkupCarve\Carve\Extension\Wikilinks;
use MarkupCarve\Carve\Node;
use MarkupCarve\Carve\RenderError;
use MarkupCarve\Carve\RenderResult;
use MarkupCarve\Chat\ChatPreviewRenderer;
use MarkupCarve\Chat\ChatRenderer;
use MarkupCarve\Chat\FlavorRegistry;
use MarkupCarve\Chat\OffsetUnit;
use MarkupCarve\Chat\OutputMode;
use MarkupCarve\MediaEmbed\MediaEmbedExtension;
use Sandbox\Carve\SnippetCatalogResolver;
use Sandbox\Carve\TreeExtension;
use Throwable;

class CarveController extends SandboxAppController {

	/**
	 * Heading id form of the playground: ASCII-folded and lowercased, for share-safe fragments.
	 *
	 * @var string
	 */
	protected const HEADING_IDS = 'ascii-lower';

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
		$this->set('carveSnippets', $this->snippetCatalog());
	}

	/**
	 * @return array<string, array{title: string, source: string}>
	 */
	protected function snippetCatalog(): array {
		/** @var array<string, array{title: string, source: string}> $snippets */
		$snippets = Configure::read('CarveSnippets', []);

		return $snippets;
	}

	/**
	 * The playground's default extension set.
	 *
	 * Each is a no-op until its syntax appears or a mild enrichment. Wikilinks point at the
	 * {@link self::wiki()} stub. Keep this list in sync with {@link self::defaultExtensionInfo()}.
	 *
	 * @return array<\MarkupCarve\Carve\Extension\Bundle|\MarkupCarve\Carve\Extension\ExtensionDefinition>
	 */
	protected function defaultExtensions(): array {
		return [
			Navigation::autolink(),
			Navigation::externalLinks(),
			SemanticSpan::bundle(),
			Wikilinks::bundle(urlGenerator: fn (string $page): string => Router::url([
				'plugin' => 'Sandbox',
				'controller' => 'Carve',
				'action' => 'wiki',
				$this->wikiSlug($page),
			])),
			Details::bundle(),
			ListTable::bundle(),
			MathBlock::bundle(),
			Citations::bundle(),
			Spoiler::bundle(),
			ColorSwatch::bundle(tint: true),
			Glossary::bundle(),
			IndexTerms::bundle(),
			CodeCallouts::bundle(),
			// Text mode so the Chart.js config rides in <pre class="chart"> as escaped text and
			// survives sanitizing; the page renders it client-side.
			FencedRender::bundle(language: 'chart', cssClass: 'chart', contentMode: 'text'),
			// Tabs in code render unevenly without a CSS tab-size.
			Transforms::tabNormalize(4),
		];
	}

	/**
	 * Renders with extensions, running the document transforms of every bundle.
	 *
	 * @param \MarkupCarve\Carve\Node|string $input
	 * @param array<\MarkupCarve\Carve\Extension\Bundle|\MarkupCarve\Carve\Extension\ExtensionDefinition|\MarkupCarve\Carve\Extension\ExtensionProvider> $extensions
	 * @param array<string, mixed> $options
	 * @return \MarkupCarve\Carve\RenderResult
	 */
	protected function renderCarve(Node|string $input, array $extensions = [], array $options = []): RenderResult {
		$transforms = [];
		foreach ($extensions as $extension) {
			if ($extension instanceof Bundle) {
				$transforms = array_merge($transforms, $extension->transforms());
			}
		}
		if ($extensions) {
			$options['extensions'] = $extensions;
		}

		return Carve::renderWithDocumentTransforms($input, $transforms, $options);
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
	 * The lint findings of a source (Markdown habits, semantic attributes, retired spellings, ...).
	 *
	 * @param string $source Carve source.
	 * @param bool $withExtensions Whether the caller renders with the default extension set.
	 * @return array<array<string, mixed>>
	 */
	protected function lintCarve(string $source, bool $withExtensions = true): array {
		$options = ['headingIds' => static::HEADING_IDS];
		if ($withExtensions) {
			$options['extensions'] = $this->defaultExtensions();
		}

		$warnings = [];
		try {
			foreach (Carve::lint($source, $options) as $finding) {
				$warnings[] = $this->diagnosticRow($source, $finding);
			}
		} catch (Throwable) {
			// The render path reports the error.
		}

		return $warnings;
	}

	/**
	 * A diagnostic as the JSON row the pages show, with a 1-based line and column.
	 *
	 * @param string $source
	 * @param \MarkupCarve\Carve\Diagnostics\Diagnostic $diagnostic
	 * @return array<string, mixed>
	 */
	protected function diagnosticRow(string $source, Diagnostic $diagnostic): array {
		$line = null;
		$column = null;
		if ($diagnostic->file === null) {
			try {
				['line' => $line, 'column' => $column] = Carve::positionOf($source, $diagnostic->startOffset);
			} catch (Throwable) {
			}
		}

		return [
			'line' => $line,
			'column' => $column,
			'rule' => $diagnostic->code,
			'severity' => $diagnostic->severity,
			'category' => $diagnostic->channel,
			'message' => $diagnostic->message,
			'file' => $diagnostic->file,
			'path' => $diagnostic->path,
		];
	}

	/**
	 * Demo stub target for the Wikilinks extension. There is no real wiki; any
	 * :wiki[Page] link from the playground lands here so the links resolve.
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
	 * footer. Keep in sync with {@link self::defaultExtensions()}.
	 *
	 * @return array<string, string>
	 */
	protected function defaultExtensionInfo(): array {
		return [
			'Navigation::autolink()' => 'Bare URLs and email addresses become links.',
			'Navigation::externalLinks()' => 'http(s) links get target="_blank" and rel="noopener noreferrer".',
			'SemanticSpan::bundle()' => '[text]{samp}, {var}, {cite} and {dfn="..."} become their semantic elements; kbd/abbr/time are core.',
			'headingIds: ascii-lower' => 'Heading ids are folded to ASCII and lowercased for share-safe fragments (a core option in 0.2).',
			'Wikilinks::bundle()' => ':wiki[Page] and :wiki[Page|label] link to the /sandbox/carve/wiki/... stub.',
			'Details::bundle()' => '::: details "Title" renders as a native <details>/<summary> disclosure widget.',
			'ListTable::bundle()' => '::: list-table blocks (nested lists) render as real HTML tables with block-level cells.',
			'MathBlock::bundle()' => '```math fenced blocks render as display math for KaTeX / MathJax.',
			'Citations::bundle()' => ':cite[key] citations resolved against a ::: references description list, collected as a numbered list.',
			'FencedRender::bundle(chart)' => '```chart fenced blocks (Chart.js JSON, text mode) render client-side via Chart.js.',
			'Spoiler::bundle()' => ':spoiler[text] becomes a click-to-reveal blurred inline span; ::: spoiler "Title" becomes a <details> disclosure.',
			'ColorSwatch::bundle()' => ':color[#3b82f6] renders a small color chip next to the value when it is a valid CSS color.',
			'Glossary::bundle()' => ':term[word] links a use to its definition in a ::: glossary description list.',
			'IndexTerms::bundle()' => ':index[term] drops an invisible index marker; ::: index lists every term with back-links.',
			'CodeCallouts::bundle()' => '<n> markers at the end of code lines become numbered bubbles; a following list of <n> text lines binds as the explanation.',
			'Transforms::tabNormalize(4)' => 'Tabs in code become four spaces.',
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
		$raw = (bool)$this->request->getData('raw') && Configure::read('debug');
		$profileName = (string)$this->request->getData('profile');
		$filterMode = (string)$this->request->getData('filter_mode');
		$disableExtensions = (bool)$this->request->getData('disable_ext');

		$result = [
			'html' => '',
			'warnings' => [],
			'dependencies' => [],
			'lint' => [],
			'violations' => [],
			'ms' => null,
			'bytes' => strlen($carve),
			'error' => null,
		];

		if ($carve) {
			$result['lint'] = $this->lintCarve($carve, !$disableExtensions);

			$includes = [
				'resolver' => new SnippetCatalogResolver($this->snippetCatalog()),
				'depth' => 8,
				'bytes' => 262_144,
				'maxDiagnostics' => 50,
			];
			$options = [
				'headingIds' => static::HEADING_IDS,
				'sourceLines' => true,
				'includes' => $includes,
			];
			if (in_array($profileName, ['full', 'article', 'comment', 'minimal'], true)) {
				$options['profile'] = $profileName;
				// 0.2 renders what a profile refuses as text and reports it; `error` makes that a hard failure.
				$options['strictLosses'] = $filterMode === 'error';
			}
			if ((string)$this->request->getData('soft_break_br') === '1') {
				$options['softBreak'] = 'br';
			}

			try {
				$start = microtime(true);
				$rendered = $this->renderCarve($carve, $disableExtensions ? [] : $this->defaultExtensions(), $options);
				$result['ms'] = round((microtime(true) - $start) * 1000, 2);
				$result['html'] = $raw ? $rendered->html : $this->sanitizeHtml($rendered->html);
				foreach ($rendered->diagnostics as $diagnostic) {
					if ($diagnostic->channel === 'render-loss') {
						$result['violations'][] = $this->violationRow($diagnostic);
					} elseif ($collectWarnings) {
						$result['warnings'][] = $this->diagnosticRow($carve, $diagnostic);
					}
				}
				foreach (Carve::includeDependencies($carve, ['includes' => $includes]) as $dependency) {
					$result['dependencies'][] = [
						'target' => $dependency['file'] ?? $dependency['path'],
						'resolved' => $dependency['read'],
					];
				}
			} catch (RenderError $e) {
				$result['error'] = 'Profile violation: ' . $e->getMessage();
				foreach ($e->diagnostics as $diagnostic) {
					$result['violations'][] = $this->violationRow($diagnostic);
				}
			} catch (Throwable $e) {
				// Any error (e.g. from an extension renderer) must surface as JSON, not an HTML error page.
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * @param \MarkupCarve\Carve\Diagnostics\Diagnostic $diagnostic
	 * @return array<string, string|null>
	 */
	protected function violationRow(Diagnostic $diagnostic): array {
		return [
			'nodeType' => $diagnostic->foreignType ?? $diagnostic->path,
			'reason' => $diagnostic->code,
			'message' => $diagnostic->message,
		];
	}

	/**
	 * AJAX endpoint that rewrites the editor source into canonical Carve.
	 *
	 * @return \Cake\Http\Response
	 */
	public function format(): Response {
		$this->request->allowMethod(['post']);

		// Multipart form-data normalizes field newlines to CRLF; the writer emits LF.
		$carve = str_replace(["\r\n", "\r"], "\n", (string)$this->request->getData('carve'));
		$alignTables = (bool)$this->request->getData('alignTables');

		$result = [
			'carve' => null,
			'error' => null,
		];

		if (trim($carve) === '') {
			$result['error'] = __('Nothing to format: the editor is empty.');
		} else {
			try {
				$result['carve'] = Carve::format($carve, ['alignTables' => $alignTables, 'extensions' => $this->defaultExtensions()]);
			} catch (Throwable $e) {
				$result['error'] = __('Could not format: {0}', $e->getMessage());
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

		$output = '';
		$error = null;
		try {
			$output = Carve::render($carve, ['extensions' => [new MediaEmbedExtension()]]);
		} catch (Throwable $e) {
			$error = $e->getMessage();
		}

		$this->set(compact('carve', 'output', 'error'));
	}

	/**
	 * Chat-platform export showcase: one Carve source rendered side by side into
	 * WhatsApp, Slack, Telegram and Discord markup, with the degradations each
	 * target forces listed underneath.
	 *
	 * Pandoc has no writer for any chat platform, so this is not reachable through
	 * the pandoc bridge - each platform is a JSON flavor table in
	 * `markup-carve/carve-php-chat`.
	 *
	 * @return void
	 */
	public function chatExport(): void {
		$defaultCarve = <<<'CARVE'
		= Release notes

		Shipped /today/: *bold*, {~struck~} and `inline code`.

		See the [changelog](https://example.com/changelog) for details.

		- First item
		- Second item

		> A quoted line.

		|= Feature |= State |
		| Export | done |
		| Split | open |

		A claim needing a source[^1].

		[^1]: The footnote body.
		CARVE;
		$defaultCarve = preg_replace('/^\t\t/m', '', $defaultCarve) ?? $defaultCarve;

		$carve = (string)($this->request->getData('carve') ?? '');
		if (!$this->request->is('post')) {
			$carve = $defaultCarve;
		}

		$registry = new FlavorRegistry();

		$results = [];
		$error = null;

		try {
			$document = Carve::parse($carve);
			foreach ($registry->ids() as $id) {
				$flavor = $registry->get($id);
				$result = (new ChatRenderer($flavor))->renderResult($document);
				$results[$id] = [
					'label' => $flavor->label(),
					'limit' => $flavor->messageLimit(),
					'length' => strlen($result->text),
					'text' => $result->text,
					'losses' => $result->losses,
					// Escaped by the preview renderer itself; nothing from the
					// document reaches the page as live markup.
					'preview' => (new ChatPreviewRenderer($flavor))->render($document),
					'ranges' => $result->ranges,
					'selections' => $this->sliceRanges($result->text, $result->ranges, $flavor->offsetUnit()),
					'offsetUnit' => $flavor->offsetUnit()->value,
					'isRangeBased' => $flavor->output() === OutputMode::Ranges,
				];
			}
		} catch (Throwable $e) {
			$error = $e->getMessage();
		}

		$this->set(compact('carve', 'results', 'error'));
	}

	/**
	 * Slices the text each style range selects, in the unit that range is
	 * counted in.
	 *
	 * Not interchangeable with mb_substr(): UTF-16 offsets and codepoint offsets
	 * disagree on any character outside the BMP, which is exactly where a naive
	 * preview would start showing the wrong span.
	 *
	 * @param string $text
	 * @param array<\MarkupCarve\Chat\StyleRange> $ranges
	 * @param \MarkupCarve\Chat\OffsetUnit $unit
	 * @return array<int, string>
	 */
	protected function sliceRanges(string $text, array $ranges, OffsetUnit $unit): array {
		$slices = [];
		foreach ($ranges as $range) {
			$slices[] = match ($unit) {
				OffsetUnit::Utf8 => substr($text, $range->start, $range->length),
				OffsetUnit::Codepoints => mb_substr($text, $range->start, $range->length, 'UTF-8'),
				OffsetUnit::Utf16 => (string)mb_convert_encoding(
					substr(
						(string)mb_convert_encoding($text, 'UTF-16LE', 'UTF-8'),
						$range->start * 2,
						$range->length * 2,
					),
					'UTF-8',
					'UTF-16LE',
				),
			};
		}

		return $slices;
	}

	/**
	 * Pandoc bridge showcase: Carve source converted to Pandoc's JSON AST, which
	 * unlocks every pandoc writer (LaTeX, Typst, DOCX, RST, EPUB, JATS, ...).
	 *
	 * Runs entirely in the browser. `pandoc-carve` is a TypeScript package, and
	 * emitting the JSON AST needs no pandoc binary at all - only converting that
	 * JSON onwards to a real format does. So the demo stays server-dependency
	 * free, matching the client-side path the WYSIWYG demo already uses.
	 *
	 * @return void
	 */
	public function pandoc(): void {
		$defaultCarve = <<<'CARVE'
		= Bridge demo

		Carve maps /node by node/, so *emphasis*, tables with spans,
		footnotes and math all arrive intact[^why].

		|= Format |= Reachable |
		| LaTeX | yes |
		| DOCX | yes |
		| Slack | no |

		[^why]: Target-routed raw spans fire too: `\alpha`{=latex} becomes a
		  Pandoc RawInline that only the LaTeX writer emits.
		CARVE;
		$defaultCarve = preg_replace('/^\t\t/m', '', $defaultCarve) ?? $defaultCarve;

		$this->set('carve', $defaultCarve);
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
		$examples = [];
		foreach ($this->getCodeBlockExamples() as $key => $example) {
			$example['html'] = Carve::render($example['carve']);
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
```php
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
{.line-numbers data-line-start=42}
```js
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
{.line-numbers data-highlight=2,4-5}
```php
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
{.line-numbers data-remove=2 data-add=3}
```php
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
{.line-numbers data-focus=3-4}
```php
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
```php "config/app.php"
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
{.line-numbers data-highlight=4 data-remove=5 data-add=6}
```php "src/Middleware/AuthMiddleware.php"
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
	 * Tree containers, from the bare zero-code form up to the custom extension.
	 *
	 * @return void
	 */
	public function trees(): void {
		$extensions = [
			'plain' => [],
			'details' => [Details::bundle()],
			'custom' => [new TreeExtension()],
		];

		$examples = [];
		foreach ($this->getTreeExamples() as $key => $example) {
			$example['html'] = Carve::render($example['carve'], ['extensions' => $extensions[$example['mode'] ?? 'plain']]);
			$examples[$key] = $example;
		}

		$extensionSource = file_get_contents(
			dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Carve' . DIRECTORY_SEPARATOR . 'TreeExtension.php',
		);

		$this->set(compact('examples', 'extensionSource'));
	}

	/**
	 * Source examples for the tree showcase, ordered from zero-code to custom
	 * extension. Each carries the Carve source; the rendered HTML is added in
	 * {@link self::trees()}. The `mode` key picks the converter: `plain` has no
	 * extensions at all, `details` enables the shipped
	 * {@link \MarkupCarve\Carve\Extension\Details}, and `custom` enables
	 * the sandbox's own {@link \Sandbox\Carve\TreeExtension}.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	protected function getTreeExamples(): array {
		return [
			'basics' => [
				'level' => 'Level 0 - nothing but CSS',
				'title' => 'A tree, with no extension at all',
				'description' => 'The `::: name` container syntax is core and always on. `tree` is not a recognized type, so it falls through to a generic `<div class="tree">` wrapping an ordinary nested list. That is already a correct tree: real list semantics, real nesting, no new node type. The connectors are CSS drawn on that markup - the HTML came out of the released package untouched.',
				'carve' => <<<'CARVE'
::: tree
- src/
  - parser/
    - blocks.crv
    - inline.crv
  - render/
    - html.crv
    - ansi.crv
- tests/
:::
CARVE,
			],
			'rich_nodes' => [
				'level' => 'Level 0 - nothing but CSS',
				'title' => 'Nodes are ordinary inline content',
				'description' => 'Because the body is a real list, every node is real Carve. Links, emphasis and code spans all work inside a node, and each one stays selectable, searchable and linkable. Pasted ASCII art in a code fence can do none of that.',
				'carve' => <<<'CARVE'
::: tree
- *src/*
  - [parser/](https://github.com/markup-carve/carve-php)
    - `BlockParser.php` - opens blocks
    - `InlineParser.php` - emphasis, links
  - *render/*
    - `HtmlRenderer.php`
- /tests/ - /mirrors/ the source layout
:::
CARVE,
			],
			'attributes' => [
				'level' => 'Level 0 - nothing but CSS',
				'title' => 'Attributes flow onto the container',
				'description' => 'An attribute line above the opener puts an id, extra classes and any `data-*` pair straight onto the `<div>`. That is the whole styling and scripting seam: a theme can vary a tree per instance without the markup language knowing anything about themes.',
				'carve' => <<<'CARVE'
{#project-layout .compact data-guides=dotted}
::: tree
- app/
  - Controller/
  - Model/
- config/
:::
CARVE,
			],
			'titled' => [
				'level' => 'Level 0 - nothing but CSS',
				'title' => 'A titled container',
				'description' => 'The quoted opener header works on any container type, so a tree can name itself without a separate heading.',
				'carve' => <<<'CARVE'
::: tree "Deployment targets"
- production/
  - eu-west/
  - us-east/
- staging/
:::
CARVE,
			],
			'taxonomy' => [
				'level' => 'Level 0 - nothing but CSS',
				'title' => 'Not only directories',
				'description' => 'Nothing here is filesystem-specific. Any hierarchy fits - a taxonomy, an org chart, a decision tree, a spec outline - and each node can link to the page that documents it.',
				'carve' => <<<'CARVE'
::: tree
- Markup languages
  - *Markdown family*
    - CommonMark
    - GitHub Flavored Markdown
  - *Djot family*
    - [Djot](https://djot.net)
    - [Carve](https://markup-carve.github.io/carve/)
  - *Other*
    - reStructuredText
    - AsciiDoc
:::
CARVE,
			],
			'details_nested' => [
				'level' => 'Level 1 - a shipped extension, still no custom code',
				'title' => 'Collapsible with the stock Details extension',
				'description' => 'A disclosure cannot be built from a `<ul>` by CSS alone - it needs an element that carries open/closed state. Carve already ships one: `::: details` is a standard extension, off by default, and a host turns it on by passing `Details::bundle()` in the `extensions` option. Nest one per branch and the tree collapses, with zero custom code and zero JavaScript. The cost is the source: every branch is now a container with its own `:::` fence and closer.',
				'mode' => 'details',
				'carve' => <<<'CARVE'
::::: tree
- :::: details "src/"
  - ::: details "Parser/"
    - BlockParser.php
    - InlineParser.php
    :::
  - ::: details "Renderer/"
    - HtmlRenderer.php
    - AnsiRenderer.php
    :::
  ::::
- tests/
:::::
CARVE,
			],
			'progressive' => [
				'level' => 'Level 2 - the bare markup plus page JavaScript',
				'title' => 'Collapsible with six lines of page script',
				'description' => 'If the noisier source is the problem but a PHP extension is more than you want, the bare Level 0 markup is enough: a small script on the page turns every branch of a `.js-collapsible` tree into a `<details>` after render. The Carve source stays exactly the plain one, nothing server-side changes, and a reader with JavaScript disabled still gets the full static tree. The script is at the bottom of this page.',
				'carve' => <<<'CARVE'
{.js-collapsible}
::: tree
- app/
  - Controller/
    - CarveController.php
    - DjotController.php
  - Model/
    - Table/
    - Entity/
- config/
  - app.php
:::
CARVE,
			],
			'collapsible' => [
				'level' => 'Level 3 - a host extension, ~60 lines',
				'title' => 'Collapsible with a clean source spelling',
				'description' => 'The cleanest authoring, and still no engine change. The sandbox registers its own `ExtensionDefinition` with a `div` matcher; it claims a tree marked `{.collapsible}` and emits nested `<details>`/`<summary>` itself. The author writes the same list as Level 0 plus one class, there is no JavaScript, and it survives a print or PDF render. This is a working prototype of the Tier-2 Tree extension being proposed for the spec.',
				'mode' => 'custom',
				'carve' => <<<'CARVE'
{.collapsible}
::: tree
- src/
  - Parser/
    - BlockParser.php
    - InlineParser.php
  - Renderer/
    - HtmlRenderer.php
    - AnsiRenderer.php
    - MarkdownRenderer.php
  - Extension/
    - DetailsExtension.php
    - SpoilerExtension.php
- tests/
  - TestCase/
:::
CARVE,
			],
			'collapsed' => [
				'level' => 'Level 3 - a host extension, ~60 lines',
				'title' => 'Collapsed by default',
				'description' => 'One more class starts every branch closed - the right default for a deep tree used as navigation rather than as documentation.',
				'mode' => 'custom',
				'carve' => <<<'CARVE'
{.collapsible .collapsed}
::: tree
- vendor/
  - markup-carve/
    - carve-php/
      - src/
      - tests/
  - cakephp/
    - cakephp/
:::
CARVE,
			],
			'mixed' => [
				'level' => 'Level 3 - a host extension, ~60 lines',
				'title' => 'Leaves stay leaves',
				'description' => 'Only a node that actually has children becomes a disclosure. A leaf renders as a plain list item, because a widget with nothing to disclose is noise for a screen reader.',
				'mode' => 'custom',
				'carve' => <<<'CARVE'
{.collapsible}
::: tree
- README.md
- composer.json
- src/
  - Carve/
    - TreeExtension.php
- LICENSE
:::
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
			'Headings & TOC' => ['heading_permalinks', 'ascii_heading_ids', 'lowercase_heading_ids', 'heading_level_shift', 'heading_numbers', 'toc', 'toc_placement'],
			'Inline & Text' => ['semantic_span', 'smart_quotes', 'tab_normalize', 'color_swatch'],
			'Blocks & Containers' => ['admonition', 'details', 'spoiler', 'tabs', 'code_group', 'code_callouts', 'list_table'],
			'Client-rendered & Math' => ['math_block', 'mermaid', 'plantuml', 'wavedrom', 'vega_lite', 'chart', 'img_fence'],
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

		$result = [
			'html' => '',
			'rawHtml' => '',
			'toc' => '',
			'frontmatter' => null,
			'error' => null,
		];

		if ($carve) {
			try {
				$extensions = [];
				$options = [];
				// Only the img fence produces the sanitized SVG data URI that HTMLPurifier would otherwise drop.
				$svgFence = false;

				foreach ($enabledExtensions as $ext) {
					switch ($ext) {
						case 'autolink':
							$extensions[] = Navigation::autolink();

							break;
						case 'external_links':
							$extensions[] = Navigation::externalLinks();

							break;
						case 'heading_permalinks':
							$extensions[] = Navigation::headingPermalinks();

							break;
						case 'mentions':
							// Core syntax in 0.2; the `social` option sets the link targets.
							$options['social'] = ['mentionUrl' => '/sandbox/carve?user={name}'];

							break;
						case 'toc':
						case 'toc_top':
							$extensions[] = Navigation::tableOfContents();

							break;
						case 'toc_bottom':
							$extensions[] = Navigation::tableOfContents(position: 'bottom');

							break;
						case 'toc_placement':
							$extensions[] = Navigation::tocPlacement();

							break;
						case 'default_attributes':
							$extensions[] = Transforms::defaultAttributes([
								'image' => ['loading' => 'lazy', 'decoding' => 'async'],
								'table' => ['class' => 'table table-striped'],
								'link' => ['class' => 'text-primary'],
								'code_block' => ['class' => 'bg-dark text-light p-2 rounded'],
							]);

							break;
						case 'semantic_span':
							$extensions[] = SemanticSpan::bundle();

							break;
						case 'smart_quotes':
							$locale = (string)$this->request->getData('smart_quotes_locale') ?: 'de';
							$extensions[] = SmartQuotes::bundle($locale);

							break;
						case 'heading_level_shift':
							$extensions[] = Navigation::headingLevelShift(1);

							break;
						case 'mermaid':
							$extensions[] = FencedRender::mermaid();

							break;
						case 'plantuml':
							$extensions[] = FencedRender::plantuml();

							break;
						case 'wavedrom':
							$extensions[] = FencedRender::wavedrom();

							break;
						case 'vega_lite':
							// Text mode (not the json-mode vegaLite() preset) so the spec rides in
							// <pre class="vega-lite"> as escaped text and survives HTML sanitizing.
							$extensions[] = FencedRender::bundle(language: 'vega-lite', cssClass: 'vega-lite', contentMode: 'text');

							break;
						case 'tabs':
							array_push($extensions, ...Tabs::extensions(true));

							break;
						case 'tabs_aria':
							array_push($extensions, ...Tabs::extensions(true, 'aria'));

							break;
						case 'code_group':
							$extensions[] = CodeGroup::bundle();

							break;
						case 'wikilinks':
							$extensions[] = Wikilinks::bundle(
								urlGenerator: fn (string $page): string => '/wiki/' . strtolower(str_replace(' ', '-', $page)),
							);

							break;
						case 'heading_reference':
							$extensions[] = Navigation::headingReference();

							break;
						case 'ascii_heading_ids':
							$options['headingIds'] = ($options['headingIds'] ?? '') === 'lower' ? 'ascii-lower' : 'ascii';

							break;
						case 'lowercase_heading_ids':
							$options['headingIds'] = ($options['headingIds'] ?? '') === 'ascii' ? 'ascii-lower' : 'lower';

							break;
						case 'tab_normalize':
							$extensions[] = Transforms::tabNormalize(4);

							break;
						case 'details':
							$extensions[] = Details::bundle();

							break;
						case 'list_table':
							$extensions[] = ListTable::bundle();

							break;
						case 'math_block':
							$extensions[] = MathBlock::bundle();

							break;
						case 'citations':
							$extensions[] = Citations::bundle();

							break;
						case 'spoiler':
							$extensions[] = Spoiler::bundle();

							break;
						case 'color_swatch':
							$extensions[] = ColorSwatch::bundle(tint: true);

							break;
						case 'glossary':
							$extensions[] = Glossary::bundle();

							break;
						case 'index':
							$extensions[] = IndexTerms::bundle();

							break;
						case 'code_callouts':
							$extensions[] = CodeCallouts::bundle();

							break;
						case 'chart':
							// Text mode (not the json-mode chart() preset) so the config survives sanitizing.
							$extensions[] = FencedRender::bundle(language: 'chart', cssClass: 'chart', contentMode: 'text');

							break;
						case 'img_fence':
							$extensions[] = ImgFence::definition('img');
							$svgFence = true;

							break;
						case 'heading_numbers':
							$extensions[] = Navigation::headingNumbers();

							break;
					}
				}
				$rawHtml = $this->renderCarve($carve, $extensions, $options)->html;
				$result['html'] = $this->sanitizeHtml($rawHtml, allowSanitizedSvg: $svgFence);
				if (Configure::read('debug')) {
					$result['rawHtml'] = $rawHtml;
				}
				if (in_array('frontmatter', $enabledExtensions, true)) {
					// Frontmatter is core in 0.2: the tree's first child, never rendered.
					$first = Carve::parse($carve)->children[0] ?? null;
					if ($first !== null && $first->type === 'frontmatter') {
						$result['frontmatter'] = [
							'format' => $first->f['format'] ?? null,
							'content' => $first->f['value'] ?? '',
						];
					}
				}
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
				'name' => 'Transforms::defaultAttributes()',
				'description' => 'Adds default attributes to elements by type. This demo adds: images get lazy loading, tables get Bootstrap classes, links get text-primary class, and code blocks get dark styling.',
				'example_carve' => <<<'CARVE'
Check out this [link to Carve](https://github.com/markup-carve/carve).

![Sample image](/img/cake.icon.png)

|= Feature |= Support |
| Tables | Yes |
| Images | Yes |

```php
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
				'name' => 'Navigation::autolink()',
				'description' => 'Automatically converts bare URLs and email addresses into clickable links without requiring explicit link syntax.',
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
				'name' => 'Navigation::externalLinks()',
				'description' => 'Adds `target="_blank"` and `rel="noopener noreferrer"` to every link and autolink to an http or https URL.',
				'example_carve' => <<<'CARVE'
Check out [Carve's homepage](https://github.com/markup-carve/carve) for more information.

This [internal link](/sandbox/carve) stays in the same tab.

Visit [GitHub](https://github.com) to see the source code.
CARVE,
				'options' => [
					'target' => '\'_blank\'',
					'rel' => '\'noopener noreferrer\'',
					'nofollow' => 'false',
				],
			],
			'heading_permalinks' => [
				'name' => 'Navigation::headingPermalinks()',
				'description' => 'Inserts clickable anchor links (¶ symbol) to headings for easy navigation and sharing.',
				'example_carve' => <<<'CARVE'
= Introduction

Welcome to the documentation.

== Getting Started

First, install the package.

=== Configuration

Configure the settings as needed.

== Advanced Usage

For power users.
CARVE,
				'options' => [
					'symbol' => '\'¶\'',
					'cssClass' => '\'permalink\'',
					'ariaLabel' => '\'Permalink\'',
					'levels' => '[1, 2, 3, 4, 5, 6]',
					'prepend' => 'false',
					'showOnHover' => 'false',
					'copyToClipboard' => 'false',
				],
			],
			'mentions' => [
				'name' => 'Mentions (core, option social)',
				'description' => 'Core syntax in 0.2: `@username` is a mention and `#tag` a tag without any extension. The `social` render option turns them into links (`mentionUrl`, `tagUrl` with a `{name}` placeholder); without it a mention renders as a styled span.',
				'example_carve' => <<<'CARVE'
Thanks to @johndoe for the contribution!

The feature was implemented by @alice and reviewed by @bob.

If you have questions, reach out to @support-team.
CARVE,
				'options' => [
					'social.mentionUrl' => '\'/users/{name}\'',
					'social.tagUrl' => '\'/tags/{name}\'',
				],
			],
			'toc' => [
				'name' => 'Navigation::tableOfContents()',
				'description' => 'Generates a table of contents from the top-level headings and inserts it at the top (default) or the bottom of the document, in a `<nav class="toc">`.',
				'example_carve' => <<<'CARVE'
= Carve Documentation

An overview of the Carve markup language.

== Basic Syntax

=== Paragraphs

Text separated by blank lines.

=== Emphasis

Use /slashes/ for emphasis and *asterisks* for strong.

== Advanced Features

=== Code Blocks

Fenced code blocks with syntax highlighting.

=== Tables

Grid-based table syntax.

== Conclusion

Carve is a powerful markup language.
CARVE,
				'options' => [
					'minLevel' => '1',
					'maxLevel' => '6',
					'listType' => '\'ul\' or \'ol\'',
					'cssClass' => '\'toc\'',
					'position' => '\'top\' (default) or \'bottom\'',
					'collapsible' => 'false (true wraps it in <details>)',
				],
			],
			'toc_placement' => [
				'name' => 'Navigation::tocPlacement()',
				'description' => 'In-document placement directives. `::: toc` renders a `<nav class="toc">` exactly where written (unlike Navigation::tableOfContents(), which injects one TOC at the document top or bottom), so a long document can place its contents after an intro. A `{depth=N}` or `{from=X to=Y}` attribute line before the opener sets an optional level window. `::: footnotes` (always-on core, no toggle needed) relocates the endnotes section to the marker. Both render byte-identical to carve-js.',
				'example_carve' => <<<'CARVE'
= Guide

Intro paragraph shown before the contents.

{depth=2}
::: toc

:::

== Setup

Install steps[^install].

=== Requirements

PHP 8.2+.

== Usage

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
				'name' => 'SemanticSpan::bundle()',
				'description' => 'Converts the four opt-in span attributes (`samp`, `var`, `cite`, `dfn`) into their semantic HTML5 elements. Core already reserves `kbd`, `abbr` and `time` - those need no extension.',
				'example_carve' => <<<'CARVE'
The command prints [Hello, World!]{samp} to the terminal.

Set the [timeout]{var} variable before the call.

A [variable]{dfn} is a named storage location in memory.

[To be, or not to be]{cite} opens the soliloquy.

[CSS]{dfn abbr="Cascading Style Sheets"} combines an opt-in name with a core one.

Core needs no extension for [Ctrl+C]{kbd} or [HTML]{abbr="HyperText Markup Language"}.
CARVE,
				'options' => [
					'(none)' => 'Uses span attributes: samp, var, cite, dfn (kbd/abbr/time are core)',
				],
			],
			'smart_quotes' => [
				'name' => 'SmartQuotes::bundle()',
				'description' => 'Configures locale-specific typographic quote characters. Transforms straight quotes into proper opening/closing quotes based on language conventions.',
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
				'name' => 'Navigation::headingLevelShift()',
				'description' => 'Shifts heading levels down (h1 → h2, h2 → h3, etc.). Useful when `h1` is reserved for the page title and document headings should start at `h2` for SEO and accessibility.',
				'example_carve' => <<<'CARVE'
= Main Title (becomes h2)

Introduction paragraph.

== Section (becomes h3)

Section content.

=== Subsection (becomes h4)

More details here.
CARVE,
				'options' => [
					'shift' => '1 (1-5, levels capped at h6)',
				],
			],
			'mermaid' => [
				'name' => 'FencedRender::mermaid()',
				'description' => 'Transforms code blocks with language `mermaid` into Mermaid.js-compatible markup for rendering diagrams (flowcharts, sequence, class diagrams, and more). Mermaid is a preset of the generic FencedRender; presets for d2, graphviz, wavedrom and abc also exist.',
				'example_carve' => <<<'CARVE'
```mermaid
graph TD;
    A[Start] --> B{Decision};
    B -->|Yes| C[Do Something];
    B -->|No| D[Do Nothing];
    C --> E[End];
    D --> E;
```

```mermaid
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
			'plantuml' => [
				'name' => 'FencedRender::plantuml()',
				'description' => 'Renders `plantuml` / `puml` fenced blocks as full UML and beyond - things Mermaid has no equivalent for, like GUI wireframes (Salt) and rich deployment/component diagrams. The block is emitted as <pre class="plantuml"> and drawn client-side via the Kroki service (kroki.io). Languages: plantuml, puml.',
				'example_carve' => <<<'CARVE'
A GUI wireframe (Salt) - Mermaid cannot draw UI mockups:

```plantuml
@startsalt
{
  Login
  {+
    Username | "         "
    Password | "****     "
    [ ] Remember me
    [Cancel] | [  OK  ]
  }
}
@endsalt
```

A deployment diagram with nested nodes:

```plantuml
@startuml
node "Web Server" {
  [CakePHP App] as app
  [Carve Renderer] as carve
}
database "MariaDB" as db
app --> carve
app --> db : SQL
@enduml
```
CARVE,
				'options' => [
					'language' => "['plantuml', 'puml']",
					'cssClass' => "'plantuml'",
				],
			],
			'wavedrom' => [
				'name' => 'FencedRender::wavedrom()',
				'description' => 'Renders `wavedrom` fenced blocks as digital timing / waveform diagrams - a domain Mermaid does not cover at all. The JSON spec is emitted as <pre class="wavedrom"> and drawn client-side by WaveDrom.',
				'example_carve' => <<<'CARVE'
```wavedrom
{ "signal": [
  { "name": "clk",  "wave": "p.....|..." },
  { "name": "data", "wave": "x.345x|=.x", "data": ["a", "b", "c", "d"] },
  { "name": "req",  "wave": "0.1..0|1.0" }
]}
```
CARVE,
				'options' => [
					'language' => "'wavedrom'",
					'cssClass' => "'wavedrom'",
				],
			],
			'vega_lite' => [
				'name' => "FencedRender::bundle('vega-lite')",
				'description' => 'Renders `vega-lite` fenced blocks as statistical data visualizations (bar/line/area/scatter, aggregations, faceting) - real analytical charts beyond Mermaid\'s scope. Text mode keeps the JSON spec in <pre class="vega-lite"> so it survives HTML sanitizing; Vega-Embed draws it client-side.',
				'example_carve' => <<<'CARVE'
```vega-lite
{
  "description": "Monthly page views",
  "data": { "values": [
    {"month": "Jan", "views": 120},
    {"month": "Feb", "views": 180},
    {"month": "Mar", "views": 90},
    {"month": "Apr", "views": 240},
    {"month": "May", "views": 200}
  ]},
  "mark": "bar",
  "encoding": {
    "x": {"field": "month", "type": "nominal", "sort": null},
    "y": {"field": "views", "type": "quantitative"},
    "color": {"field": "views", "type": "quantitative"}
  }
}
```
CARVE,
				'options' => [
					'language' => "'vega-lite'",
					'contentMode' => '\'text\' (survives sanitizing)',
					'cssClass' => "'vega-lite'",
				],
			],
			'admonition' => [
				'name' => 'Admonitions (core)',
				'description' => 'Core in 0.2: `::: note`, `::: tip`, `::: warning`, `::: danger`, `::: info` and the other admonition types render as `<aside class="admonition ...">` with an ARIA label, no extension needed. A `{title="..."}` attribute line sets the title. For a collapsible block use `::: details`.',
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
			],
			'tabs' => [
				'name' => 'Tabs::extensions()',
				'description' => 'Turns a `::: tabs` div holding `::: tab "Label"` divs into a tabbed interface. CSS mode uses radio inputs and sibling selectors (no JavaScript); aria mode writes a tablist with buttons and needs a script. The quoted title of each tab is its label.',
				'example_carve' => <<<'CARVE'
:::: tabs
::: tab "Installation"
Install the package with Composer:

`composer require markup-carve/carve-php`
:::

::: tab "Usage"
Convert Carve to HTML:

`$html = Carve::render($carve);`
:::

::: tab "Configuration"
Configure options as needed.
:::
::::
CARVE,
				'options' => [
					'mode' => '\'css\' (default) or \'aria\'',
				],
			],
			'code_group' => [
				'name' => 'CodeGroup::bundle()',
				'description' => 'Turns a `::: code-group` div of code blocks into a tabbed code view. The panel label is the bracket label, then the quoted title, then the language, then "Code N".',
				'example_carve' => <<<'CARVE'
::: code-group
```bash [Composer]
composer require markup-carve/carve-php
```

```bash [NPM]
npm install @example/carve
```

```bash [Pip]
pip install carve
```
:::
CARVE,
				'options' => [
					'mode' => '\'css\' (default) or \'aria\'',
					'wrapperClass' => '\'code-group\'',
					'panelClass' => '\'code-group-panel\'',
					'labelClass' => '\'code-group-label\'',
					'radioClass' => '\'code-group-radio\'',
					'highlighter' => 'Custom syntax highlighter callback',
				],
			],
			'wikilinks' => [
				'name' => 'Wikilinks::bundle()',
				'description' => 'The standard `:wiki` matcher: `:wiki[Page]` links a page, `:wiki[Page|display text]` sets the text and `:wiki[Page#section]` appends an anchor. Common in wiki systems and note-taking apps like Obsidian.',
				'example_carve' => <<<'CARVE'
Check out the :wiki[Getting Started] guide for beginners.

For advanced users, see :wiki[Advanced Topics|the advanced section].

The :wiki[API Reference#authentication] section covers auth.

Related: :wiki[Best Practices], :wiki[FAQ], :wiki[Troubleshooting]
CARVE,
				'options' => [
					'urlGenerator' => 'Custom URL generator closure',
					'cssClass' => "'wikilink'",
					'newWindow' => 'false',
				],
			],
			'heading_reference' => [
				'name' => 'Navigation::headingReference()',
				'description' => 'Adds a class to every reference link that a heading resolves: `[Heading Text][]`, or `[click here][Heading Text]` with custom text. Heading references are core in 0.2; the extension only marks them. (The 0.1 `[[Heading]]` spelling is gone.)',
				'example_carve' => <<<'CARVE'
= Installation

See [Configuration][] for setup details, or jump straight to [how to use it][Usage].

= Configuration

Configure your settings here.

= Usage

Use the tool as described above.
CARVE,
				'options' => [
					'cssClass' => "'heading-ref'",
				],
			],
			'inline_footnotes' => [
				'name' => 'Inline footnotes (core)',
				'description' => 'Core in 0.2: `^[note]` writes a footnote inline, right where it belongs. It is numbered and collected into the footnotes section with the other notes, and its content takes full inline formatting.',
				'example_carve' => <<<'CARVE'
Carve supports inline footnotes^[This is the footnote content, written inline.] right where you need them.

Footnote content can include /emphasis/ and `code`^[Footnotes support full inline formatting.] too.
CARVE,
			],
			'frontmatter' => [
				'name' => 'Frontmatter (core)',
				'description' => 'Core in 0.2: a `---` block at the start of a document is frontmatter (YAML by default, or a named format such as `---toml`). It is never rendered; the host reads it from the tree, which is what the panel below shows.',
				'example_carve' => <<<'CARVE'
---
title: My Article
author: John Doe
date: 2024-01-15
tags:
  - carve
  - documentation
---

= My Article

This is the main content after the frontmatter.
CARVE,
			],
			'ascii_heading_ids' => [
				'name' => "headingIds: 'ascii' (core option)",
				'description' => 'A core render option in 0.2. By default Carve keeps non-ASCII characters in ids (`= Über uns` becomes `Über-uns`); `headingIds: ascii` transliterates them (`Uber-uns`) for share-safe URL fragments.',
				'example_carve' => <<<'CARVE'
= Über uns

== Café résumé

=== Größe & Maße

Compare the generated id attributes with and without the extension.
CARVE,
				'options' => [
					'headingIds' => '\'off\', \'keep-case\', \'lower\', \'ascii\', \'ascii-lower\', \'ascii-strict\', \'ascii-strict-lower\'',
				],
			],
			'tab_normalize' => [
				'name' => 'Transforms::tabNormalize()',
				'description' => 'Expands literal tabs in code blocks and inline code to a fixed number of spaces at render time. Carve preserves tabs by default (a CSS tab-size concern); this is useful for fixed-width output without CSS, e.g. email, RSS or plain HTML. This demo uses width 4.',
				'example_carve' => <<<CARVE
```js
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
				'name' => 'Details::bundle()',
				'description' => 'Renders ::: details "Title" admonition blocks as the native HTML5 <details>/<summary> disclosure widget. The quoted title becomes the <summary>; the body stays collapsed until the reader expands it.',
				'example_carve' => <<<'CARVE'
::: details "What is Carve?"
Carve is a djot-flavored markup converter for PHP.

The body can hold *any* block content: lists, code, even tables.
:::
CARVE,
			],
			'list_table' => [
				'name' => 'ListTable::bundle()',
				'description' => 'Renders ::: list-table blocks as real HTML tables authored as nested lists, so cells can hold full block content (paragraphs, lists, code) that pipe-table syntax cannot. The preceding line carries optional {header-rows=N} / {header-cols=N} / {footer-rows=N} counts, or their boolean form ({header-rows} marks just the first row/column). A cell carries its own attributes glued to its bullet: -{header-row} makes the row a local header and opens a new <tbody> partition, -{header} promotes the single cell, and -{align=...}/-{valign=...} set that cell alignment.',
				'example_carve' => <<<'CARVE'
{footer-rows=1}
::: list-table "Quarterly results"
- -{header-row} Region
  - Notes
- - EMEA

  - Strong quarter.

    Drivers:

    - new logos
    - renewals
- -{header-row} Region
  - Notes
- - APAC
  -{align=right valign=bottom} Flat.
- - Total
  -{header} 2 regions
:::
CARVE,
			],
			'math_block' => [
				'name' => 'MathBlock::bundle()',
				'description' => 'Renders a fenced ```math ```block as block-level display math (<div class="math display">\[…\]</div>), matching how inline and display $…$ math is emitted so KaTeX / MathJax can pick it up.',
				'example_carve' => <<<'CARVE'
```math
\int_0^1 x^2 \, dx = \frac{1}{3}
```
CARVE,
				'options' => [
					'language' => "'math' (fence info string to match; default 'math')",
				],
			],
			'citations' => [
				'name' => 'Citations::bundle()',
				'description' => 'Citations with an in-document bibliography: `:cite[key]` resolves against a `::: references` (or `::: bibliography`) description list and becomes a numbered reference link; the list is written as an ordered reference list. The attributes `locator`, `prefix`, `suffix` and `mode` shape each citation.',
				'example_carve' => <<<'CARVE'
Carve follows the djot spec :cite[durusau2022]{locator="p. 12"} and borrows ideas from Markdown :cite[gruber2004]{prefix=see locator="ch. 3"}.

Author suppression reads naturally: Gruber :cite[gruber2004]{mode=suppress-author} introduced Markdown in 2004.

Group several sources: :cite[durusau2022; gruber2004].

::: references "References"
:: durusau2022
: Durusau, P. (2022). /The djot markup language/.
:: gruber2004
: Gruber, J. (2004). /Markdown: Syntax/.
:::
CARVE,
				'options' => [
					'mode' => '\'numbered\' (default) or \'author-date\'',
					'bibliography' => 'CSL-JSON array (optional)',
				],
			],
			'lowercase_heading_ids' => [
				'name' => "headingIds: 'lower' (core option)",
				'description' => 'A core render option in 0.2. Heading ids keep their case by default (`= Getting Started` becomes `Getting-Started`); `headingIds: lower` lowercases them for GitHub/SSG-style anchors (`getting-started`). Together with ASCII folding the value is `ascii-lower`.',
				'example_carve' => <<<'CARVE'
= Getting Started

== API Reference

See [API Reference][] for the lowercased anchor.
CARVE,
			],
			'spoiler' => [
				'name' => 'Spoiler::bundle()',
				'description' => 'Hidden / blurred spoiler content. Inline :spoiler[text] becomes <span class="spoiler"> (blurred until you click it); block ::: spoiler "Title" becomes a native <details class="spoiler"> disclosure (click the summary). The blur + click-to-reveal is host CSS + a tiny bit of JS.',
				'example_carve' => <<<'CARVE'
The killer was :spoiler[the butler] all along.

::: spoiler "Episode ending"
They defeat the villain and head home.
:::
CARVE,
			],
			'chart' => [
				'name' => "FencedRender::bundle('chart') (text mode)",
				'description' => 'Renders a ```chart fenced block (Chart.js JSON config) as a client-rendered chart. Configured in text mode so the JSON rides in <pre class="chart"> as escaped text and survives HTML sanitizing, instead of the json preset\'s <script type="application/json"> wrapper (which a sanitizer strips). Chart.js must be loaded on the page.',
				'example_carve' => <<<'CARVE'
```chart
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
					'contentMode' => '\'text\' (sanitizer-safe; avoids the json-mode <script> wrapper)',
				],
			],
			'color_swatch' => [
				'name' => 'ColorSwatch::bundle()',
				'description' => 'Inline :color[value] renders a small color chip next to the value when it flattens to a valid CSS color (hex, named, rgb()/hsl()); invalid values fall back to a plain <span class="ext-color">. Configurable chip position, shape and an optional faint tint behind the swatch. Add a {contrast} attribute to render the value inside a filled box with an auto-picked black or white label (brightness-based), instead of a chip. This demo uses tint: true.',
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
				'name' => 'Glossary::bundle()',
				'description' => 'Inline :term[word] marks a glossary use and links it to the matching entry of a `::: glossary` description list elsewhere in the document; an undefined term stays a plain span.',
				'example_carve' => <<<'CARVE'
Carve is built on the :term[djot] data model and adds a few :term[extension]s.

:: djot
: A light markup language with a clean, unambiguous grammar.
:: extension
: An opt-in feature that adds inline or block behavior.
CARVE,
			],
			'index' => [
				'name' => 'IndexTerms::bundle()',
				'description' => 'Inline :index[term] drops an invisible marker (an empty <span class="index-term" id="idx-...">) at each occurrence; a `::: index` directive lists every term with one back-link per use.',
				'example_carve' => <<<'CARVE'
Carve :index[Carve] converts markup :index[markup] to HTML, and markup :index[markup] is fun.

::: index

:::
CARVE,
			],
			'code_callouts' => [
				'name' => 'CodeCallouts::bundle()',
				'description' => 'Annotate code with numbered callouts. A `<n>` marker at the end of a fenced-code line becomes a numbered bubble (<b class="callout">), and an immediately-following paragraph of `<n> text` lines binds to it as a `<ol class="callouts">` explanation list. Markers in the code round-trip unchanged.',
				'example_carve' => <<<'CARVE'
```php
$bundle = CodeCallouts::bundle(); <1>
$options = ['extensions' => [$bundle]]; <2>

$html = Carve::renderWithDocumentTransforms($source, $bundle->transforms(), $options)->html; <3>
```

\<1> Create the bundle with its document transform.
\<2> Register the bundle so `<n>` markers are recognized.
\<3> Convert; callouts render as numbered bubbles.
CARVE,
			],
			'img_fence' => [
				'name' => "ImgFence::definition('img')",
				'description' => 'Renders a ```img fenced block as the SVG it contains instead of showing the source. The engine keeps only a small set of inert shape elements and presentational attributes (no script, no style, no links, no external images) and writes the result as a data: image.',
				'example_carve' => <<<'CARVE'
```img
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 64">
  <rect width="240" height="64" rx="8" fill="#3b82f6"/>
  <text x="16" y="40" fill="white" font-size="24" font-family="sans-serif">Carve</text>
  <circle cx="210" cy="20" r="8" fill="#fbbf24"/>
  <script>alert('this never runs')</script>
  <a href="javascript:alert('nor this')"><rect x="0" y="0" width="240" height="64"/></a>
</svg>
```

The `script` element and the `javascript:` link above are gone from the rendered
image - dropped with their subtrees, not escaped.
CARVE,
				'options' => [
					'language' => '\'img\' (fence info word to match)',
				],
			],
			'heading_numbers' => [
				'name' => 'Navigation::headingNumbers()',
				'description' => 'Auto-numbers sections at render time and rewrites auto-filled </#id> cross-references to "Section 1.2 - Title". No new syntax: it reads the heading tree and honors a {.unnumbered} class (written on the line ABOVE the heading, since Carve takes no trailing attribute block on a heading). Numbers render as <span class="section-number">.',
				'example_carve' => <<<'CARVE'
= Installation

== Requirements

See </#Configuration> for what to set afterwards.

== Configuration

Numbering follows the heading tree, so this is 1.2.

{.unnumbered}
= Appendix

An unnumbered heading is skipped by the counter.
CARVE,
				'options' => [
					'minLevel' => '1 (first heading level that gets a number)',
					'label' => "'Section' (word used in a rewritten cross-reference)",
					'crossref' => "'number-title' (or 'number' / 'title')",
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
			'lint' => [],
			'error' => null,
		];

		if ($markdown) {
			try {
				$result['carve'] = Carve::importDocument($markdown, ['from' => 'gfm'])->source;
				// Lint the OUTPUT: a habit surviving the conversion is a
				// converter gap, and it renders as literal text from here on.
				$result['lint'] = $this->lintCarve($result['carve'], false);
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
		// `semantic` drops raw HTML Carve has no spelling for; `raw` keeps it as a raw `{=html}` block.
		// Either way the diagnostics name what the import did.
		$mode = (string)$this->request->getData('mode') === 'raw' ? 'raw' : 'semantic';

		$result = [
			'carve' => '',
			'mode' => $mode,
			'diagnostics' => [],
			'error' => null,
		];

		if ($html) {
			try {
				$import = Carve::importHtml($html, ['rawHtml' => $mode === 'raw']);
				$result['carve'] = $import->source;
				foreach ($import->diagnostics as $diagnostic) {
					$result['diagnostics'][] = [
						'code' => $diagnostic->code,
						'severity' => $diagnostic->severity,
						'message' => $diagnostic->message,
						'path' => $diagnostic->path,
					];
				}
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
		$binary = getenv('CARVE_PDF_BIN');
		$this->set('pdfExportAvailable', Configure::read('debug') && $binary && is_file($binary) && is_executable($binary));
	}

	/**
	 * Export Carve serialized from the editor's JSON with carve-pdf.
	 *
	 * @return \Cake\Http\Response
	 */
	public function exportEditorPdf(): Response {
		$this->request->allowMethod(['post']);
		if (!Configure::read('debug')) {
			return $this->response->withStatus(403)->withType('text')->withStringBody('PDF export is available in the local sandbox only.');
		}
		if (!$this->request->is('ajax')) {
			return $this->response->withStatus(403)->withType('text')->withStringBody('PDF export requires a same-origin editor request.');
		}
		$source = $this->request->getData('carve');
		if (!is_string($source) || trim($source) === '' || strlen($source) > 1024 * 1024) {
			return $this->response->withStatus(400)->withType('text')->withStringBody('Carve source must contain 1 to 1048576 bytes.');
		}
		$binary = getenv('CARVE_PDF_BIN');
		if (!$binary || !is_file($binary) || !is_executable($binary)) {
			return $this->response->withStatus(503)->withType('text')->withStringBody('PDF export is unavailable. Set CARVE_PDF_BIN to an executable crv2pdf.sh.');
		}
		$lock = @fopen(CACHE . 'carve_pdf.lock', 'c');
		if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) {
			if ($lock) {
				fclose($lock);
			}

			return $this->response->withStatus(429)->withType('text')->withStringBody('A PDF export is already running. Try again shortly.');
		}

		$directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sandbox-carve-pdf-' . bin2hex(random_bytes(8));
		if (!mkdir($directory, 0700)) {
			fclose($lock);

			return $this->response->withStatus(500)->withType('text')->withStringBody('Could not prepare the PDF export.');
		}
		$input = $directory . DIRECTORY_SEPARATOR . 'document.crv';
		$output = $directory . DIRECTORY_SEPARATOR . 'document.pdf';
		$stderr = $directory . DIRECTORY_SEPARATOR . 'stderr.log';
		$stdout = $directory . DIRECTORY_SEPARATOR . 'stdout.log';
		try {
			if (file_put_contents($input, $source) === false) {
				return $this->response->withStatus(500)->withType('text')->withStringBody('Could not prepare the PDF export.');
			}
			$process = @proc_open(
				['timeout', '--signal=TERM', '--kill-after=5s', '90s', $binary, $input, $output, '--pdf', '--no-includes'],
				[0 => ['pipe', 'r'], 1 => ['file', $stdout, 'w'], 2 => ['file', $stderr, 'w']],
				$pipes,
			);
			if (!is_resource($process)) {
				return $this->response->withStatus(503)->withType('text')->withStringBody('carve-pdf could not start. Check the server log.');
			}
			fclose($pipes[0]);
			$exitCode = proc_close($process);
			if ($exitCode === 124 || $exitCode === 137) {
				return $this->response->withStatus(504)->withType('text')->withStringBody('PDF export timed out.');
			}
			$pdf = is_file($output) ? file_get_contents($output) : false;
			if ($exitCode !== 0 || !is_string($pdf) || !str_starts_with($pdf, '%PDF-')) {
				$error = is_file($stderr) ? file_get_contents($stderr) : false;
				Log::error('carve-pdf export failed: ' . json_encode(substr($error ?: 'No PDF output', 0, 4096)));

				return $this->response->withStatus(503)->withType('text')->withStringBody('PDF export failed. Check the server log.');
			}

			return $this->response
				->withType('pdf')
				->withHeader('Content-Disposition', 'attachment; filename="carve-editor.pdf"')
				->withStringBody($pdf);
		} finally {
			@unlink($input);
			@unlink($output);
			@unlink($stdout);
			@unlink($stderr);
			@rmdir($directory);
			flock($lock, LOCK_UN);
			fclose($lock);
		}
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
		$rows = [];
		foreach ($this->getInterruptionCases() as $case) {
			$typedRaw = Carve::render($case['carve']);
			$blankRaw = Carve::render($case['blank']);
			$escapedRaw = Carve::render($case['escaped']);
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
	 * `exports` repeats the trip through the chosen `format` twice, once plain
	 * and once with the roundtrip export option (HTML carriers, PART 10 §13;
	 * Markdown carrier markers, PART 11 §10s), so the page can show what the
	 * option keeps.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertRoundtrip(): Response {
		$this->request->allowMethod(['post']);

		// Multipart form-data normalizes field newlines to CRLF, while the
		// converter emits LF; normalize so the stability comparison is not
		// thrown off by line-ending differences alone.
		$carve = str_replace(["\r\n", "\r"], "\n", (string)$this->request->getData('carve'));
		$format = $this->request->getData('format') === 'markdown' ? 'markdown' : 'html';

		$result = [
			'format' => $format,
			'exports' => null,
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
				$t = microtime(true);
				$rawHtml1 = Carve::render($carve);
				$result['msToHtml'] = round((microtime(true) - $t) * 1000, 2);

				$t = microtime(true);
				$carve2 = Carve::importHtml($rawHtml1)->source;
				$result['msToCarve'] = round((microtime(true) - $t) * 1000, 2);

				$rawHtml2 = Carve::render($carve2);

				$result['html1'] = $this->sanitizeHtml($rawHtml1);
				$result['carve2'] = $carve2;
				$result['html2'] = $this->sanitizeHtml($rawHtml2);
				// Compare raw (pre-sanitize) HTML so the verdict reflects converter
				// fidelity, not what the sanitizer happens to normalize away.
				$result['htmlStable'] = $rawHtml1 === $rawHtml2;
				$result['carveStable'] = trim($carve) === trim($carve2);
				$result['exports'] = [
					'plain' => $this->roundtripExport($carve, $format, false),
					'roundtrip' => $format === 'html' ? $this->roundtripExport($carve, $format, true) : null,
				];
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * One Carve -> format -> Carve trip, with or without the roundtrip export option.
	 *
	 * @param string $carve
	 * @param string $format `html` or `markdown`
	 * @param bool $carry
	 * @return array{exported: string, carve: string, carveStable: bool}
	 */
	protected function roundtripExport(string $carve, string $format, bool $carry): array {
		// 0.2 has no Markdown carrier format; the `roundtrip` render option writes the HTML carriers.
		if ($format === 'markdown') {
			$exported = (new MarkdownExporter())->export(Carve::parse($carve))->output;
			$back = Carve::importDocument($exported, ['from' => 'gfm'])->source;
		} else {
			$exported = Carve::render($carve, ['roundtrip' => $carry]);
			$back = Carve::importHtml($exported)->source;
		}

		return [
			'exported' => $exported,
			'carve' => $back,
			'carveStable' => trim($carve) === trim($back),
		];
	}

	/**
	 * AST inspector: the parsed document as PART 12 JSON, in both directions.
	 *
	 * @return void
	 */
	public function ast(): void {
		$this->set('debugMode', Configure::read('debug'));
	}

	/**
	 * AJAX endpoint for the AST inspector.
	 *
	 * Two directions, selected by `direction`:
	 *
	 * - `encode`: Carve source -> PART 12 JSON tree. Source positions (§4) are
	 *   opt-in because tracking them costs work on every parse. The tree is
	 *   decoded again and re-rendered to prove the round trip is lossless -
	 *   which HTML round-tripping is not.
	 * - `decode`: a JSON tree (from ANY engine) -> rendered HTML plus the Carve
	 *   source it serializes back to. The field names are the ones the spec
	 *   pins, so a carve-js or carve-rs tree reads here; one this decoder would
	 *   lose fields from is rejected outright rather than silently mangled.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convertAst(): Response {
		$this->request->allowMethod(['post']);

		$direction = (string)$this->request->getData('direction') === 'decode' ? 'decode' : 'encode';
		$withPositions = (bool)$this->request->getData('positions');

		$result = [
			'json' => '',
			'html' => '',
			'carve' => '',
			'nodes' => 0,
			'placed' => 0,
			'stable' => false,
			'ms' => null,
			'error' => null,
		];

		$flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

		try {
			if ($direction === 'decode') {
				$tree = (string)$this->request->getData('tree');
				if (!trim($tree)) {
					return $this->astResponse($result);
				}

				$start = microtime(true);
				// A stored 1.x tree (0.1 engines) is migrated first; a 2.0 tree passes through.
				$document = Carve::decodeTree((string)json_encode(Carve::migrateTree($tree)));
				$result['ms'] = round((microtime(true) - $start) * 1000, 2);
				$result['html'] = $this->sanitizeHtml(Carve::render($document));
				$result['carve'] = Carve::write($document);
				$result['nodes'] = $this->countAstNodes((array)json_decode(Carve::encodeTree($document), true));

				return $this->astResponse($result);
			}

			$carve = (string)$this->request->getData('carve');
			if (!trim($carve)) {
				return $this->astResponse($result);
			}

			$start = microtime(true);
			$document = Carve::parse($carve);
			/** @var array<string, mixed> $encoded */
			$encoded = (array)json_decode(Carve::encodeTree($document), true);
			if (!$withPositions) {
				$encoded = $this->stripPositions($encoded);
			}
			$result['ms'] = round((microtime(true) - $start) * 1000, 2);
			$result['json'] = (string)json_encode($encoded, $flags);
			$result['nodes'] = $this->countAstNodes($encoded);
			$result['placed'] = $this->countAstNodes($encoded, 'pos');
			// The round trip is the claim worth checking: decode what was just
			// encoded and render both. Equal output means the tree carried
			// everything the renderer needs.
			$result['stable'] = Carve::render(Carve::decodeTree($result['json'])) === Carve::render($document);
		} catch (Throwable $e) {
			$result['error'] = $e->getMessage();
		}

		return $this->astResponse($result);
	}

	/**
	 * Drops the `pos` field of every node: 0.2 always records positions, the inspector shows them on request.
	 *
	 * @param array<mixed> $node
	 * @return array<mixed>
	 */
	protected function stripPositions(array $node): array {
		unset($node['pos']);
		foreach ($node as $key => $value) {
			if (is_array($value)) {
				$node[$key] = $this->stripPositions($value);
			}
		}

		return $node;
	}

	/**
	 * @param array<string, mixed> $result
	 * @return \Cake\Http\Response
	 */
	protected function astResponse(array $result): Response {
		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Counts encoded AST nodes, or those carrying a given field.
	 *
	 * @param array<string, mixed> $node
	 * @param string|null $field Count only nodes that carry this field.
	 * @return int
	 */
	protected function countAstNodes(array $node, ?string $field = null): int {
		$count = isset($node['type']) && ($field === null || isset($node[$field])) ? 1 : 0;

		foreach ($node as $value) {
			if (!is_array($value)) {
				continue;
			}
			foreach ($value as $child) {
				if (is_array($child) && isset($child['type'])) {
					$count += $this->countAstNodes($child, $field);
				}
			}
		}

		return $count;
	}

	/**
	 * ProseMirror / Tiptap bridge: the carve-php bridge is not part of 0.2, the page says so.
	 *
	 * @return void
	 */
	public function proseMirror(): void {
		$this->set('debugMode', Configure::read('debug'));
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
				$result['carve'] = Carve::importDocument($djot, ['from' => 'djot'])->source;
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Sanitize HTML output to prevent XSS attacks.
	 *
	 * @param string $html
	 * @param bool $allowSanitizedSvg Keep the img fence's sanitized SVG images.
	 * @return string
	 */
	protected function sanitizeHtml(string $html, bool $allowSanitizedSvg = false): string {
		$svgImages = [];
		if ($allowSanitizedSvg) {
			$html = $this->stashSvgImages($html, $svgImages);
		}

		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'carve-sandbox');
		$config->set('HTML.DefinitionRev', 18);
		$config->set('HTML.Allowed', 'p[class|id|lang|data-source-line],br[class|id],strong[class|id|title],em[class|id],u[class|id],s[class|id],del[class|id],ins[class|id],mark[class|id],sub[class|id],sup[class|id|data-carve-footnote-label],b[class|id],a[href|title|class|id|target|rel|data-username|aria-label|role|download],img[src|alt|title|loading|decoding|class|id|data-source-line],ul[class|id|data-source-line],ol[start|type|class|id|data-source-line|reversed|data-delim],li[class|id|value|title|data-source-line|data-task-state],dl[class|id|data-source-line],dt[class|id|data-source-line],dd[class|id|data-source-line],blockquote[class|id|lang|data-source-line],pre[class|id|title|data-source-line],code[class|id],aside[class|id|title|role|aria-label|aria-labelledby|data-source-line],h1[class|id|title|data-source-line],h2[class|id|title|data-source-line],h3[class|id|title|data-source-line],h4[class|id|title|data-source-line],h5[class|id|title|data-source-line],h6[class|id|title|data-source-line],table[class|id|data-source-line],caption[class|id],thead[class|id],tbody[class|id],tfoot[class|id],colgroup[class|id],col[span|style|class|id],tr[class|id],th[align|colspan|rowspan|scope|style|class|id],td[align|colspan|rowspan|scope|style|class|id],hr[class|id|data-source-line],div[class|id|role|aria-labelledby|hidden|data-source-line],span[class|id|style|lang|title|role|aria-label],section[class|id|role|aria-label|aria-labelledby|data-source-line],nav[class|id|data-source-line],input[type|name|id|checked|disabled|class|aria-label],label[for|class|id],button[role|id|class|tabindex|aria-selected|aria-controls],details[class|id|open|data-source-line],summary[class|id],figure[class|id|data-source-line],figcaption[class|id],kbd[class|id],dfn[class|id],samp[class|id],var[class|id],cite[class|id],abbr[title|class|id],time[datetime|class|id]');
		// background-color is needed for the ColorSwatch extension's chip; the
		// value is validated as a CSS color by HTMLPurifier, so it cannot inject.
		// background + color additionally cover the {contrast} label variant
		// (value inside a filled box, auto black/white text). Each is color-
		// validated by HTMLPurifier, so none can break out of the declaration.
		// vertical-align carries the per-cell valign markers (|?^ / |?v and the
		// list-table {valign=...} attribute); width carries the <col> widths a
		// list-table colgroup emits. Both are value-validated by HTMLPurifier.
		$config->set('CSS.AllowedProperties', 'text-align, vertical-align, width, background-color, background, color');
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
				'section', 'figure', 'details', 'nav', 'aside', 'img',
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
			// Engine-emitted state and accessibility attributes: task states drive
			// the carve-css task boxes, the rest name landmarks and checkboxes.
			$def->addAttribute('li', 'data-task-state', 'Enum#x,/,!,_,-,>,?');
			$def->addAttribute('ol', 'data-delim', 'Enum#),.');
			$def->addAttribute('sup', 'data-carve-footnote-label', 'Text');
			$def->addAttribute('span', 'role', 'Text');
			$def->addAttribute('span', 'aria-label', 'Text');
			foreach (['aside', 'section'] as $landmark) {
				$def->addAttribute($landmark, 'aria-label', 'Text');
				$def->addAttribute($landmark, 'aria-labelledby', 'Text');
			}
			$def->addAttribute('aside', 'role', 'Text');
			// A row fully covered by rowspans renders as an empty <tr>; the HTML4
			// content model requires a cell, so purification would drop the row
			// and shift every span below it.
			$def->addElement('tr', false, 'Optional: td | th', 'Common');
			$def->addElement('samp', 'Inline', 'Inline', 'Common');
			$def->addElement('var', 'Inline', 'Inline', 'Common');
			// Core semantic span: [now]{time="2026-01-01"} renders <time datetime>.
			$def->addElement('time', 'Inline', 'Inline', 'Common', [
				'datetime' => 'Text',
			]);
			$def->addElement('input', 'Inline', 'Empty', 'Common', [
				'type' => 'Enum#checkbox,radio',
				'name' => 'Text',
				'checked' => 'Bool',
				'disabled' => 'Bool',
				'aria-label' => 'Text',
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
		$clean = $purifier->purify($html);

		return $svgImages ? $this->restoreSvgImages($clean, $svgImages) : $clean;
	}

	/**
	 * Replaces the img fence's SVG images with an inert placeholder so they
	 * survive purification, re-checking each payload on the way out.
	 *
	 * HTMLPurifier's `data:` filter accepts only base64-encoded raster images
	 * (it validates them with getimagesize), so a percent-encoded
	 * `data:image/svg+xml` image is dropped outright and the fence renders as
	 * nothing. Rather than widening the purifier, each payload is decoded and
	 * run through the SAME img fence sanitizer again (a one-fence render). It is
	 * stashed only when that second pass returns the byte-identical string, so anything the sanitizer would still alter - a
	 * hand-written data: URI in a raw HTML block, say - keeps being dropped.
	 * What {@see self::restoreSvgImages()} puts back is markup built here from
	 * sanitizer output, never markup the request supplied.
	 *
	 * The authored `alt`, `id` and `class` travel with the payload. The img
	 * fence derives the alt from the SVG's `<title>` and puts an attribute
	 * line's `{#logo .wide}` on the tag, so rebuilding it from the src alone
	 * would strip the accessible name and the styling hooks from exactly the
	 * images that carry them. Nothing else is carried, and the three that are
	 * get validated here rather than trusted: these attributes bypass
	 * HTMLPurifier (the placeholder it sees has none of them), so `id` and
	 * `class` must match the shape the purifier would have allowed, and the alt
	 * is re-escaped as the authored text it is.
	 *
	 * @param string $html
	 * @param array<string, array{svg: string, alt: string, id: string, class: string}> $stash
	 * @return string
	 */
	protected function stashSvgImages(string $html, array &$stash): string {
		return (string)preg_replace_callback(
			'#<img\b[^>]*\bsrc="data:image/svg\+xml,([^"]*)"[^>]*>#i',
			function (array $match) use (&$stash): string {
				$svg = rawurldecode($match[1]);
				if (!$this->isEngineSanitizedSvg($svg)) {
					return '';
				}

				$token = 'carve-svg-' . count($stash);
				$stash[$token] = [
					'svg' => $svg,
					'alt' => $this->svgImageAttribute($match[0], 'alt'),
					'id' => $this->svgImageAttribute($match[0], 'id', '/^[A-Za-z][\w:.-]*$/'),
					'class' => $this->svgImageAttribute($match[0], 'class', '/^[\w-]+(?: [\w-]+)*$/'),
				];

				return '<span class="' . $token . '"></span>';
			},
			$html,
		);
	}

	/**
	 * Whether the img fence sanitizer of the engine returns this SVG unchanged.
	 *
	 * @param string $svg
	 * @return bool
	 */
	protected function isEngineSanitizedSvg(string $svg): bool {
		$fence = Carve::safeCodeFence($svg);
		try {
			$html = Carve::render($fence . "img\n" . $svg . "\n" . $fence . "\n", ['extensions' => [ImgFence::definition('img')]]);
		} catch (Throwable) {
			return false;
		}

		return preg_match('#src="data:image/svg\+xml,([^"]*)"#', $html, $match) === 1 && rawurldecode($match[1]) === $svg;
	}

	/**
	 * Reads one attribute off a stashed `<img>` tag, dropping anything that does
	 * not match the shape the purifier would have accepted.
	 *
	 * @param string $tag
	 * @param string $name
	 * @param string|null $shape Pattern the decoded value must match, if any.
	 * @return string
	 */
	protected function svgImageAttribute(string $tag, string $name, ?string $shape = null): string {
		if (preg_match('#\b' . preg_quote($name, '#') . '="([^"]*)"#i', $tag, $match) !== 1) {
			return '';
		}

		$value = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');

		return $shape === null || preg_match($shape, $value) === 1 ? $value : '';
	}

	/**
	 * Swaps the placeholders from {@see self::stashSvgImages()} back for images.
	 *
	 * @param string $html
	 * @param array<string, array{svg: string, alt: string, id: string, class: string}> $stash
	 * @return string
	 */
	protected function restoreSvgImages(string $html, array $stash): string {
		foreach ($stash as $token => $image) {
			$alt = htmlspecialchars($image['alt'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
			$classes = trim($image['class'] . ' carve-svg');
			$img = '<img src="data:image/svg+xml,' . rawurlencode($image['svg']) . '"'
				. ' alt="' . $alt . '"'
				. ($image['id'] !== '' ? ' id="' . $image['id'] . '"' : '')
				. ' class="' . $classes . '">';
			$html = (string)preg_replace_callback(
				'#<span class="' . preg_quote($token, '#') . '"></span>#',
				static fn (): string => $img,
				$html,
				1,
			);
		}

		return $html;
	}

	/**
	 * Graceful-degradation demo: render the same Carve source through every
	 * output target so the degradation of interactive constructs (tabs,
	 * code-group, details, spoiler, mermaid, math) is visible per target.
	 *
	 * Targets:
	 * - `interactive`: live HTML (`mode: interactive`).
	 * - `static`: HTML for a non-interactive medium (`mode: static`); tabs
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
					$output = $this->demoRender($carve, 'interactive');
					$rendered = $this->sanitizeHtml($output);
					$isHtml = true;

					break;
				case 'static':
					$output = $this->demoRender($carve, 'static', $useRenderers);
					$rendered = $this->sanitizeHtml($output);
					$isHtml = true;

					break;
				case 'markdown':
					$output = (new MarkdownExporter())->export(Carve::parse($carve))->output;

					break;
				case 'plain':
					$output = (new PlainTextExporter())->export(Carve::parse($carve))->output;

					break;
				case 'ansi':
					$ansi = (new AnsiExporter())->export(Carve::parse($carve))->output;
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
			$body = $this->sanitizeHtml($this->demoRender($carve, 'static', $useRenderers));
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
	 * Renders the demo source with the full interactive extension set (tabs, code-group, details,
	 * spoiler, mermaid, math, ...) in a render mode, optionally with build-time renderers.
	 *
	 * @param string $carve
	 * @param string $mode `interactive` or `static`.
	 * @param bool $useRenderers Whether static mode gets the build-time renderers.
	 * @return string
	 */
	protected function demoRender(string $carve, string $mode, bool $useRenderers = false): string {
		$renderers = $useRenderers ? $this->demoStaticRenderers() : [];
		$math = $renderers['math'] ?? null;
		$extensions = [
			Transforms::tabNormalize(4),
			...Tabs::extensions(true, 'aria'),
			CodeGroup::bundle(),
			Details::bundle(),
			Spoiler::bundle(),
			MathBlock::bundle(build: $math ? fn (string $tex, bool $display): string => $math($tex) : null),
			FencedRender::mermaid(build: $renderers['mermaid'] ?? null),
			FencedRender::graphviz(build: $renderers['graphviz'] ?? null),
		];

		return $this->renderCarve($carve, $extensions, ['mode' => $mode])->html;
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
= Graceful degradation demo

The same source below renders differently per target. Interactive constructs
flatten or reveal when the medium cannot run client scripts.

:::: tabs
::: tab "Install"
```bash
composer require markup-carve/carve-php
```
:::

::: tab "Usage"
```php
$html = MarkupCarve\Carve\Carve::render($carve);
```
:::
::::

::: code-group
```js [config.js]
export default { mode: 'static' };
```

```json [config.json]
{ "mode": "static" }
```
:::

::: details "Show the details"
Hidden content that a static target reveals inline.
:::

Inline secret: :spoiler[the answer is 42] and a block spoiler below.

::: spoiler "Spoiler block"
This stays blurred online but is revealed for print and text targets.
:::

```mermaid
graph TD
  A[Source] --> B{Target?}
  B -->|HTML| C[Interactive]
  B -->|PDF| D[Static]
```

Display math (a `math` fence, handled by the math renderer in static mode):

```math
\int_0^1 x^2 \, dx = \frac{1}{3}
```

And inline math $E = mc^2$ within a sentence.
CARVE;
	}

}
