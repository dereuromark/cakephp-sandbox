<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MarkupCarve\Carve\Carve;
use MarkupCarve\Carve\Diagnostics\Diagnostic;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionMethod;
use Sandbox\Controller\CarveController;

/**
 * Sandbox\Controller\CarveController Test Case
 *
 * @uses \Sandbox\Controller\CarveController
 */
class CarveControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('window.carveRenderLanguageDiff');
		$this->assertResponseContains('const escape = function(text)');
		$this->assertResponseContains('pre.has-diff .line.diff.add');
		$this->assertResponseContains('display: inline-block');
		$this->assertResponseContains('{.diff}');
	}

	/**
	 * @return void
	 */
	public function testConvertKeepsARowCoveredByRowspans(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "|= a |= b |\n| x | y |\n| ^ | ^ |\n",
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('rowspan="2"', $response['html']);
		$this->assertSame(3, substr_count($response['html'], '<tr'));
	}

	/**
	 * @return void
	 */
	public function testConvertKeepsTaskStatesAndCheckboxLabels(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "- [x] Draft\n- [/] Review\n- [!] Approval pending\n- [_] Alias\n- [-] Dropped\n- [ ] Open\n",
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		foreach (['x', '/', '!', '_', '-'] as $state) {
			$this->assertStringContainsString('data-task-state="' . $state . '"', $response['html']);
		}
		$this->assertStringContainsString('aria-label="Review"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertPreservesLanguageDiffContract(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{.diff}\n```js\n  keep();\n- old();\n+ fresh();\n```\n",
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<pre class="diff"', $response['html']);
		$this->assertStringContainsString('<code class="language-js">', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testPandoc(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'pandoc']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Carve &rarr; Pandoc');
		$this->assertResponseContains('pandoc-carve');
	}

	/**
	 * @return void
	 */
	public function testChatExport(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'chatExport']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Carve &rarr; Chat Platforms');
		$this->assertResponseContains('discord-bot');
	}

	/**
	 * A link has no representation in WhatsApp markup, so it degrades to
	 * `text (url)` and the degradation is reported rather than hidden.
	 *
	 * @return void
	 */
	public function testChatExportReportsDegradations(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'chatExport'], [
			'carve' => 'See [docs](https://example.com).',
		]);

		$this->assertResponseCode(200);
		$this->assertResponseContains('docs (https://example.com)');
		$this->assertResponseContains('degradation');
	}

	/**
	 * @return void
	 */
	public function testConvert(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => 'Hello *world*!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('html', $response);
		$this->assertStringContainsString('<strong>world</strong>', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testFormatKeepsTablesUnaligned(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'format'], [
			'carve' => "| Name | Qty |\r\n|---|---|\r\n| Banana split | 12 |\r\n",
			'alignTables' => '0',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame("| Name | Qty |\n| --- | --- |\n| Banana split | 12 |\n", $response['carve']);
	}

	/**
	 * @return void
	 */
	public function testFormatAlignsTables(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'format'], [
			'carve' => "|= Name |= Qty |\n| Banana split | 12 |\n",
			'alignTables' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame("|= Name        |= Qty |\n| Banana split | 12   |\n", $response['carve']);
	}

	/**
	 * @return void
	 */
	public function testFormatReportsEmptySource(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'format'], [
			'carve' => " \n",
			'alignTables' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['carve']);
		$this->assertSame(__('Nothing to format: the editor is empty.'), $response['error']);
	}

	/**
	 * @return void
	 */
	public function testFormatRejectsGet(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'format']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testIndexListsConfigBackedIncludeLibrary(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Include Library');
		$this->assertResponseContains('library/intro.crv');
		$this->assertResponseContains('Try config includes');
		$this->assertResponseContains('id="include-library"');
		$this->assertResponseContains('https://markup-carve.github.io/carve/includes');
		$this->assertResponseContains('transclusion');
		$this->assertResponseContains('href="#violation-error-example"');
		$this->assertResponseContains('data-copy-anchor="enabled-extensions"');
	}

	/**
	 * @return void
	 */
	public function testConvertResolvesConfigBackedIncludes(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Includes\n\n{{ library/intro.crv }}\n\n{{ library/chapter.crv }}\n",
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('From the snippet library', $response['html']);
		$this->assertStringContainsString('Resolved relative to the including catalog snippet.', $response['html']);
		$this->assertSame([], $response['warnings']);
		$this->assertSame([
			['target' => 'library/intro.crv', 'resolved' => true],
			['target' => 'library/chapter.crv', 'resolved' => true],
			['target' => 'library/sign-off.crv', 'resolved' => true],
		], $response['dependencies']);
	}

	/**
	 * @return void
	 */
	public function testConvertSelectsRegionsCodeAndCsvFromTheLibrary(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{{ library/setup.crv @region:requirements }}\n\n{{ library/server.js @region:start @code:js }}\n\n{table}\n{{ library/plans.csv @code:csv }}\n",
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame([], $response['warnings']);
		$this->assertStringContainsString('PHP 8.2 or newer and Composer 2.', $response['html']);
		$this->assertStringNotContainsString('Text after the region is skipped.', $response['html']);
		$this->assertStringContainsString('<code class="language-js">const server', $response['html']);
		$this->assertStringNotContainsString('export default server', $response['html']);
		$this->assertStringContainsString('<td>Enterprise, annual</td>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertLeavesUnknownIncludeLiteral(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{{ library/missing.crv }}\n",
			'warnings' => '1',
		]);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('{{ library/missing.crv }}', $response['html']);
		$this->assertSame('parse', $response['warnings'][0]['category']);
		$this->assertSame('include-not-found', $response['warnings'][0]['rule']);
		$this->assertSame([
			['target' => 'library/missing.crv', 'resolved' => false],
		], $response['dependencies']);
	}

	/**
	 * @return void
	 */
	public function testConvertIncludeLibraryCannotEscapeItsNamespace(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{{ library/../../config/app.php }}\n",
			'warnings' => '1',
		]);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('{{ library/../../config/app.php }}', $response['html']);
		$this->assertStringStartsWith('include-', $response['warnings'][0]['rule']);
		$this->assertFalse($response['dependencies'][0]['resolved']);
	}

	/**
	 * @return void
	 */
	public function testConvertReportsIncludeCycle(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{{ library/cycle.crv }}\n",
			'warnings' => '1',
		]);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('{{ cycle.crv }}', $response['html']);
		$this->assertSame('include-cycle', $response['warnings'][0]['rule']);
	}

	/**
	 * Explicit row partitions survive the playground's sanitizer.
	 *
	 * `{header-rows=N footer-rows=N}` renders a `<tfoot>`, which HTMLPurifier
	 * drops unless the element is on the allowlist - and a dropped `tfoot` reads
	 * as an extra `tbody`, so the demo would show the feature as a no-op.
	 * HTMLPurifier reorders `tfoot` ahead of `tbody` (the HTML4 order); CSS
	 * places a footer group at the bottom either way.
	 *
	 * @return void
	 */
	public function testConvertKeepsExplicitTableRowPartitions(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "{header-rows=1 footer-rows=1}\n|={<} Item |={>} Qty |\n| Coffee | 2 |\n| Total | 2 |\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<thead>', $response['html']);
		// Since carve-php#1503 every table section writes one row per line, so the
		// footer row sits on its own line inside `<tfoot>` like a `<tbody>` row.
		$this->assertStringContainsString('<tfoot>', $response['html']);
		$this->assertStringContainsString('<tr><td style="text-align:left;">Total</td>', $response['html']);
		$this->assertStringContainsString('Total', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertKeepsInheritedCellAlignment(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "|={<} Phase |={>} Hours |\n| Design | 12 |\n| ^ | 8 |\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<td rowspan="2" style="text-align:left;">Design</td>', $response['html']);
		$this->assertStringContainsString('<td style="text-align:right;">8</td>', $response['html']);
	}

	/**
	 * A list-table's local `{header-row}` cells open a fresh `<tbody>` partition,
	 * `{header}` promotes a single cell, and per-cell `{align=}` / `{valign=}` land
	 * as inline styles. All of it has to clear the sanitizer.
	 *
	 * @return void
	 */
	public function testConvertKeepsListTableLocalHeaders(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "::: list-table\n- -{header-row} Region\n  - Notes\n- - EMEA\n  -{align=right valign=bottom} Flat.\n- - Total\n  -{header} 2 regions\n:::\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<th scope="col">Region</th>', $response['html']);
		$this->assertStringContainsString('<th scope="row">2 regions</th>', $response['html']);
		$this->assertStringContainsString('text-align:right;vertical-align:bottom;', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithArticleProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\n``` =html\n<script>alert(1)</script>\n```",
			'profile' => 'article',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Article profile renders the heading; the fenced block is treated as code
		// (info string "=html"), so its contents are escaped rather than executed.
		$this->assertStringContainsString('<h1', $response['html']);
		$this->assertStringNotContainsString('<script>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertSanitizesXss(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => '[link](javascript:alert(1))',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('javascript:', $response['html']);
	}

	/**
	 * Core semantic spans emit <time datetime> and (via the extension) <cite>;
	 * both must survive sanitization.
	 *
	 * @return void
	 */
	public function testConvertKeepsSemanticTimeAndCite(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => 'At [noon]{time="2026-01-01"} read [Hamlet]{cite}.',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<time datetime="2026-01-01">noon</time>', $response['html']);
		$this->assertStringContainsString('<cite>Hamlet</cite>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithCommentProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\nSome *bold* text.\n\n![image](/test.png)",
			'profile' => 'comment',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('<h1', $response['html']);
		$this->assertStringNotContainsString('<img', $response['html']);
		$this->assertStringContainsString('<strong>bold</strong>', $response['html']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithMinimalProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "*Bold* and `code` with [link](https://example.com)\n\n- list item",
			'profile' => 'minimal',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<strong>Bold</strong>', $response['html']);
		$this->assertStringContainsString('<code>code</code>', $response['html']);
		$this->assertStringContainsString('<li', $response['html']);
		$this->assertStringNotContainsString('<a href', $response['html']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFullProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\n*Bold* text",
			'profile' => 'full',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<h1', $response['html']);
		$this->assertStringContainsString('<strong>Bold</strong>', $response['html']);
		$this->assertEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithWarnings(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "``` php\nThis code fence is never closed.",
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotEmpty($response['warnings']);
		$this->assertSame('unclosed-code-fence', $response['warnings'][0]['rule']);
		$this->assertSame(1, $response['warnings'][0]['line']);
	}

	/**
	 * Strict follows `carve render --strict` (C2-T-051): an entry fails the render, the HTML stays.
	 *
	 * @return void
	 */
	public function testConvertStrictFailsOnParseEntry(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "``` php\nThis code fence is never closed.",
			'strict' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringStartsWith('Strict: 1 entry', $response['error']);
		$this->assertStringContainsString('fence', $response['error']);
		$this->assertStringContainsString('<pre', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertStrictPassesCleanSource(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "= Heading\n\nSome *bold* text.",
			'strict' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsWritesFrontmatterAsComment(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "---\ntitle: A -- B\n---\n\nBody text.",
			'extensions' => ['frontmatter'],
			'frontmatter_as_comment' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringStartsWith("<!-- frontmatter (yaml)\ntitle: A - - B\n-->\n", $response['rawHtml']);
		$this->assertStringNotContainsString('<!--', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertLintsUnresolvedReference(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => '[undefined link][missing-ref]',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame('unresolved-reference-link', $response['lint'][0]['rule']);
		$this->assertArrayHasKey('message', $response['lint'][0]);
	}

	/**
	 * @return void
	 */
	public function testConvertStampsSourceLineAnchors(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\nPara one.",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<h1 data-source-line="1"', $response['html']);
		$this->assertStringContainsString('<p data-source-line="3"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertKeepsHeadingLineUnderTextInTheParagraph(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "Section\n= Heading",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// 0.2 paragraphs take every non-blank line (C2-B-012); lint points at the heading-shaped line.
		$this->assertStringNotContainsString('<h1', $response['html']);
		$this->assertSame('block-opener-without-blank-line', $response['lint'][0]['rule']);
	}

	/**
	 * Lists are the one exception to §10: a list following a paragraph needs a
	 * blank line, so a hard-wrapped "- " mid-prose is not turned into a list.
	 *
	 * @return void
	 */
	public function testConvertDoesNotInterruptParagraphWithList(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "Shopping:\n- milk\n- bread",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('<ul>', $response['html']);
		$this->assertStringContainsString('- milk', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertNestsBlockAfterBlankLineInsideListItem(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "- Item\n\n  > nested quote",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<blockquote', $response['html']);
		$this->assertStringContainsString('nested quote', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertProfileRendersRefusedConstructAsText(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "= Heading\n\nSome text",
			'profile' => 'comment',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringNotContainsString('<h1', $response['html']);
		$this->assertStringContainsString('Heading', $response['html']);
		$this->assertSame('profile-construct-degraded', $response['violations'][0]['reason']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFilterModeError(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "= Heading\n\nSome text",
			'profile' => 'comment',
			'filter_mode' => 'error',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response['error']);
		$this->assertStringContainsString('Profile violation', $response['error']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertEmptyInput(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testComplexExamples(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'complexExamples']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('CSV Table');
		$this->assertResponseContains('TSV Table without Header');
		$this->assertResponseContains('Task States');
		$this->assertResponseContains('Blocks inside List Items');
	}

	/**
	 * @return void
	 */
	public function testExtensions(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'extensions']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Transforms::defaultAttributes()');
		$this->assertResponseContains('Navigation::autolink()');
		$this->assertResponseContains('Navigation::externalLinks()');
		$this->assertResponseContains('Navigation::headingPermalinks()');
		$this->assertResponseContains('Mentions (core, option social)');
		$this->assertResponseContains('Navigation::tableOfContents()');
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsDefaultAttributes(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "![Image](/test.png)\n\n| A | B |\n|---|---|\n| 1 | 2 |",
			'extensions' => ['default_attributes'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('loading="lazy"', $response['html']);
		$this->assertStringContainsString('decoding="async"', $response['html']);
		$this->assertStringContainsString('class="table table-striped"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsAutolink(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => 'Visit https://example.com for more.',
			'extensions' => ['autolink'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('html', $response);
		$this->assertStringContainsString('<a href="https://example.com"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsAsciiHeadingIds(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => '# Über uns',
			'extensions' => ['ascii_heading_ids'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		// Heading ids are case-preserving; the extension only folds diacritics.
		$this->assertStringContainsString('id="Uber-uns"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTabNormalize(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "``` js\n\treturn 1;\n```",
			'extensions' => ['tab_normalize'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('    return 1;', $response['html']);
		$this->assertStringNotContainsString("\treturn 1;", $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * Tabs in code are expanded to spaces by default on the main playground.
	 *
	 * @return void
	 */
	public function testConvertExpandsTabsByDefault(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "``` js\n\treturn 1;\n```",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('    return 1;', $response['html']);
		$this->assertStringNotContainsString("\treturn 1;", $response['html']);
	}

	/**
	 * The playground enables a curated extension set by default, so admonitions
	 * and wikilinks render without any explicit toggle.
	 *
	 * @return void
	 */
	public function testConvertEnablesExtensionsByDefault(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "::: tip\nHeads up.\n:::\n\nSee :wiki[Getting Started].",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="wikilink"', $response['html']);
		$this->assertStringContainsString('tip', $response['html']);
		$this->assertStringNotContainsString('::: tip', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * With disable_ext the same input renders as plain spec Carve: the
	 * admonition stays a literal fence and the wikilink is not linkified.
	 *
	 * @return void
	 */
	public function testConvertDisableExtensions(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "::: tip\nHeads up.\n:::\n\nSee [[Getting Started]].",
			'disable_ext' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('class="wikilink"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsExternalLinks(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => '[Link](https://example.com)',
			'extensions' => ['external_links'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('target="_blank"', $response['html']);
		$this->assertStringContainsString('noopener', $response['html']);
		$this->assertStringContainsString('noreferrer', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsMentions(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => 'Thanks @johndoe!',
			'extensions' => ['mentions'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('href="/sandbox/carve?user=johndoe"', $response['html']);
		$this->assertStringContainsString('@johndoe', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingPermalinks(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => '# Hello World',
			'extensions' => ['heading_permalinks'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="permalink"', $response['html']);
		$this->assertStringContainsString('aria-label="Permalink"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsToc(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "= Heading 1\n\n== Heading 2",
			'extensions' => ['toc'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringStartsWith('<nav class="toc"', $response['toc']);
		$this->assertStringContainsString('href="#Heading-1"', $response['toc']);
		$this->assertStringContainsString('href="#Heading-2"', $response['toc']);
		$this->assertStringNotContainsString('<nav', $response['html']);
		$this->assertStringStartsWith('<section id="Heading-1">', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTocTop(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "# Hello\n\nContent here.",
			'extensions' => ['toc_top'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<nav class="toc">', $response['html']);
		$tocPos = strpos($response['html'], '<nav class="toc">');
		$contentPos = strpos($response['html'], 'Content here');
		$this->assertLessThan($contentPos, $tocPos, 'TOC should appear before content');
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTocBottom(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "# Hello\n\nContent here.",
			'extensions' => ['toc_bottom'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<nav class="toc">', $response['html']);
		$tocPos = strpos($response['html'], '<nav class="toc">');
		$contentPos = strpos($response['html'], 'Content here');
		$this->assertGreaterThan($contentPos, $tocPos, 'TOC should appear after content');
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsCombined(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "= Hello\n\nThanks @user! Visit https://example.com",
			'extensions' => ['autolink', 'mentions', 'toc'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('@user', $response['html']);
		$this->assertStringContainsString('href="https://example.com"', $response['html']);
		$this->assertStringContainsString('<nav class="toc"', $response['toc']);
		$this->assertStringContainsString('href="/sandbox/carve?user=user"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => '',
			'extensions' => ['autolink'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testMarkdownToCarve(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'markdownToCarve']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMigrationFix(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'migrationFix']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('carve-js.min.js');
	}

	/**
	 * @return void
	 */
	public function testCarveJsBundleExposesMigrationApi(): void {
		$bundle = WWW_ROOT . 'js' . DS . 'carve-js.min.js';
		$this->assertFileExists($bundle, 'carve-js bundle missing - run `composer assets` to build it.');

		$contents = (string)file_get_contents($bundle);
		$this->assertGreaterThan(1000, strlen($contents), 'carve-js bundle looks empty/truncated.');
		$this->assertStringContainsString(
			'fixableRules',
			$contents,
			'carve-js bundle no longer exposes fix()/fixableRules - the Migration Fix demo will break.',
		);
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdown(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertMarkdown'], [
			'markdown' => 'Hello **world**!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('carve', $response);
		$this->assertStringContainsString('*world*', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdownEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertMarkdown'], [
			'markdown' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdownGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertMarkdown']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testHtmlToCarve(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'htmlToCarve']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertHtml(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '<p>Hello <strong>world</strong>!</p>',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('carve', $response);
		$this->assertStringContainsString('*world*', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlSemanticModeReportsDroppedElement(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '<p>Keep me.</p><iframe src="https://example.com/x"></iframe>',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame('semantic', $response['mode']);
		$this->assertSame("Keep me.\n", $response['carve']);
		$this->assertContains('import-element-dropped', array_column($response['diagnostics'], 'code'));
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlRawModePreservesRawElement(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '<p>Keep me.</p><iframe src="https://example.com/x"></iframe>',
			'mode' => 'raw',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame('raw', $response['mode']);
		$this->assertStringContainsString("```=html\n<iframe src=\"https://example.com/x\"></iframe>\n```", $response['carve']);
		$this->assertSame([], $response['diagnostics']);
	}

	/**
	 * @return void
	 */
	public function testConvertRendersFencedQuoteAndLooseList(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "::: >\nQuoted.\n:::\n\n- one\n\n- two\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<blockquote', $response['html']);
		$this->assertStringContainsString('Quoted.', $response['html']);
		$this->assertMatchesRegularExpression('#<li[^>]*>\s*<p[^>]*>one</p>#', $response['html']);
	}

	/**
	 * An unknown adapter name falls back to generic instead of erroring.
	 *
	 * @return void
	 */
	public function testConvertHtmlUnknownAdapterFallsBackToGeneric(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '<p>Hello <strong>world</strong>!</p>',
			'adapter' => 'nonsense',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('*world*', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testBbcodeToCarve(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'bbcodeToCarve']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testWysiwyg(): void {
		Configure::write('plugins.Sandbox', dirname(__DIR__, 3) . DIRECTORY_SEPARATOR);
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwyg']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Export PDF');
		$this->assertResponseContains('serializeToCarve');
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfRejectsEmptySource(): void {
		$this->postEditorPdf(['carve' => '']);

		$this->assertResponseCode(400);
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfRejectsFormPost(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'exportEditorPdf'], ['carve' => '# Export']);

		$this->assertResponseCode(403);
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfIsDisabledOutsideLocalSandbox(): void {
		$previous = Configure::read('debug');
		Configure::write('debug', false);
		try {
			$this->postEditorPdf(['carve' => '# Export']);
			$this->assertResponseCode(403);
		} finally {
			Configure::write('debug', $previous);
		}
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfRequiresConfiguredBinary(): void {
		$previous = getenv('CARVE_PDF_BIN');
		putenv('CARVE_PDF_BIN=/missing/crv2pdf.sh');
		try {
			$this->postEditorPdf(['carve' => '# Export']);
			$this->assertResponseCode(503);
			$this->assertResponseContains('CARVE_PDF_BIN');
		} finally {
			$previous === false ? putenv('CARVE_PDF_BIN') : putenv('CARVE_PDF_BIN=' . $previous);
		}
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfLimitsConcurrentRuns(): void {
		$previous = getenv('CARVE_PDF_BIN');
		putenv('CARVE_PDF_BIN=' . PHP_BINARY);
		$lock = fopen(CACHE . 'carve_pdf.lock', 'c');
		$this->assertIsResource($lock);
		flock($lock, LOCK_EX);
		try {
			$this->postEditorPdf(['carve' => '# Export']);
			$this->assertResponseCode(429);
			$this->assertContentType('text/plain');
		} finally {
			flock($lock, LOCK_UN);
			fclose($lock);
			$previous === false ? putenv('CARVE_PDF_BIN') : putenv('CARVE_PDF_BIN=' . $previous);
		}
	}

	/**
	 * @return void
	 */
	public function testExportEditorPdfWithInstalledCarvePdf(): void {
		$binary = getenv('CARVE_PDF_BIN');
		if (!$binary || !is_executable($binary)) {
			$this->markTestSkipped('Set CARVE_PDF_BIN to run the PDF integration test.');
		}

		$this->postEditorPdf([
			'carve' => "= Tiptap JSON export\n\nA *strong* result.",
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/pdf');
		$this->assertStringStartsWith('%PDF-', (string)$this->_response->getBody());
	}

	/**
	 * @param array<string, string> $data
	 * @return void
	 */
	protected function postEditorPdf(array $data): void {
		$this->configRequest(['headers' => ['X-Requested-With' => 'XMLHttpRequest']]);
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'exportEditorPdf'], $data);
	}

	/**
	 * @return void
	 */
	public function testDjotToCarve(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'djotToCarve']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * The wikilinks stub target renders for any slug.
	 *
	 * @return void
	 */
	public function testWiki(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wiki', 'getting-started']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Getting Started');
	}

	/**
	 * @return void
	 */
	public function testConvertDjot(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertDjot'], [
			'djot' => '_text_ and {=mark=}',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('carve', $response);
		$this->assertStringContainsString('/text/', $response['carve']);
		$this->assertStringContainsString('{=mark=}', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertDjotEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertDjot'], [
			'djot' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertDjotGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertDjot']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTabsAriaPreservesLabel(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => ":::: tabs\n::: tab \"One\"\nAlpha\n:::\n::: tab \"Two\"\nBeta\n:::\n::::\n",
			'extensions' => ['tabs_aria'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// The ARIA tab/panel association must survive sanitization.
		$this->assertStringContainsString('aria-labelledby', $response['html']);
		$this->assertStringContainsString('>One</button>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingReference(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "= Installation\n\nSee [Configuration][].\n\n= Configuration\n\nDetails.",
			'extensions' => ['heading_reference'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Heading ids are case-preserving, so the anchor keeps the original case.
		$this->assertStringContainsString('href="#Configuration"', $response['html']);
		$this->assertStringContainsString('class="heading-ref"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsInlineFootnotes(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => 'Text with a note^[Inline footnote content.] here.',
			'extensions' => ['inline_footnotes'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Footnote reference and the generated endnotes section must survive sanitizing.
		$this->assertStringContainsString('role="doc-noteref"', $response['html']);
		$this->assertStringContainsString('role="doc-endnotes"', $response['html']);
		$this->assertStringContainsString('Inline footnote content.', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testRoundtrip(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'roundtrip']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('id="format-html" value="html" checked');
	}

	/**
	 * A shared link with `?format=markdown` opens on the Markdown export.
	 *
	 * @return void
	 */
	public function testRoundtripFormatFromQuery(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'roundtrip', '?' => ['format' => 'markdown']]);

		$this->assertResponseCode(200);
		$this->assertResponseContains('id="format-markdown" value="markdown" checked');
		$this->assertResponseNotContains('id="format-html" value="html" checked');
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtrip(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip'], [
			'carve' => 'Hello *world*!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('html1', $response);
		$this->assertArrayHasKey('carve2', $response);
		$this->assertArrayHasKey('html2', $response);
		$this->assertStringContainsString('<strong>world</strong>', $response['html1']);
		$this->assertStringContainsString('*world*', $response['carve2']);
		$this->assertTrue($response['htmlStable']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripNormalizesCrlf(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip'], [
			// Multipart form-data sends CRLF; the verdict must ignore line-ending differences.
			'carve' => "First *line*\r\n\r\nSecond line",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['carveStable']);
		$this->assertTrue($response['htmlStable']);
	}

	/**
	 * The HTML roundtrip export keeps a thematic-break character and a reference
	 * link that the plain export normalizes away.
	 *
	 * @return void
	 */
	public function testConvertRoundtripHtmlExportCarriers(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip'], [
			'carve' => "See [docs][d].\n\n***\n\n[d]: https://example.org",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('html', $response['format']);
		$plain = $response['exports']['plain'];
		$roundtrip = $response['exports']['roundtrip'];
		$this->assertStringNotContainsString('data-carve-ref', $plain['exported']);
		$this->assertStringContainsString('data-carve-ref="d"', $roundtrip['exported']);
		$this->assertFalse($plain['carveStable']);
		$this->assertTrue($roundtrip['carveStable']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripMarkdownHasNoCarrierFormat(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip'], [
			'carve' => "::: aside\nBoxed.\n:::",
			'format' => 'markdown',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame('markdown', $response['format']);
		$this->assertSame("Boxed.\n", $response['exports']['plain']['exported']);
		$this->assertFalse($response['exports']['plain']['carveStable']);
		$this->assertNull($response['exports']['roundtrip']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip'], [
			'carve' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['html1']);
		$this->assertSame('', $response['carve2']);
		$this->assertFalse($response['htmlStable']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertRoundtrip']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testInterruption(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'interruption']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Paragraph Interruption');
		// A heading line under text is a lazy line; with a blank line it is a heading.
		$this->assertResponseContains('block-opener-without-blank-line');
		$this->assertResponseContains('<h1>H</h1>');
		$this->assertResponseContains('interrupts: no blank line needed');
	}

	/**
	 * @return void
	 */
	public function testAst(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'ast']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('AST Inspector');
	}

	/**
	 * Encoding publishes the PART 12 shape, and decoding it again renders the
	 * same document - which is the claim the page makes.
	 *
	 * @return void
	 */
	public function testConvertAstEncode(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'encode',
			'carve' => "# Title\n\nText with *strong*.\n",
			'positions' => '0',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertTrue($response['stable']);
		$this->assertGreaterThan(0, $response['nodes']);

		$tree = json_decode($response['json'], true);
		$this->assertSame('document', $tree['type']);
		$this->assertArrayHasKey('srcByteLength', $tree);
		$this->assertSame('heading', $tree['children'][0]['type']);
		// A heading always publishes its level, default or not.
		$this->assertSame(1, $tree['children'][0]['level']);
		// Positions were not asked for, so §4 forbids inventing them.
		$this->assertArrayNotHasKey('pos', $tree['children'][0]);
		$this->assertSame(0, $response['placed']);
	}

	/**
	 * Source positions are opt-in because tracking them costs work on every
	 * parse; asking for them puts a complete six-field span on the nodes.
	 *
	 * @return void
	 */
	public function testConvertAstEncodeWithPositions(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'encode',
			'carve' => "= Title\n\nText.\n",
			'positions' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertGreaterThan(0, $response['placed']);

		$tree = json_decode($response['json'], true);
		$pos = $tree['children'][0]['pos'];
		$this->assertEqualsCanonicalizing(
			['startLine', 'endLine', 'startColumn', 'endColumn', 'startOffset', 'endOffset'],
			array_keys($pos),
		);
		$this->assertSame(1, $pos['startLine']);
	}

	/**
	 * @return void
	 */
	public function testConvertAstDecodeForeignTree(): void {
		$tree = [
			'astVersion' => '1.0',
			'type' => 'document',
			'children' => [
				[
					'type' => 'heading',
					'level' => 2,
					'children' => [['type' => 'text', 'value' => 'From elsewhere']],
				],
			],
		];

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'decode',
			'tree' => json_encode($tree),
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('From elsewhere', $response['html']);
		$this->assertSame("== From elsewhere\n", $response['carve']);
	}

	/**
	 * A tree carrying a field this decoder does not read is refused outright,
	 * rather than silently decoded into a different document.
	 *
	 * @return void
	 */
	public function testConvertAstDecodeRejectsLossyTree(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'decode',
			'tree' => '{"type":"document","srcByteLength":2,"children":[{"type":"paragraph","bogus":1,"children":[]}]}',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response['error']);
		$this->assertStringContainsString('bogus', $response['error']);
		$this->assertSame('', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testProseMirror(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'proseMirror']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('ProseMirror Bridge');
	}

	/**
	 * A Markdown habit parses as a valid document, so no parse warning fires -
	 * it just renders as literal asterisks. That is what the separate lint pass
	 * is for.
	 *
	 * @return void
	 */
	public function testConvertReportsMarkdownHabits(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => 'This is **not bold** in Carve.',
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame([], $response['warnings']);
		$this->assertCount(1, $response['lint']);
		$this->assertSame('markdown-strong-double-star', $response['lint'][0]['rule']);
		$this->assertSame(1, $response['lint'][0]['line']);
	}

	/**
	 * The lint pass also runs the AST-walking linters: a value on a semantic
	 * span name that only selects its wrapper reaches no output, so the
	 * document is valid but the value is silently discarded.
	 *
	 * @return void
	 */
	public function testConvertReportsSemanticAttributeLint(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => '[text]{kbd=value}',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertCount(1, $response['lint']);
		$this->assertSame('semantic-attribute-value-ignored', $response['lint'][0]['rule']);
	}

	/**
	 * The semantic linter reads element names off the renderer the playground's
	 * default extensions configure: `samp` is SemanticSpanExtension tier, not
	 * core, so this only fires because the lint pass gets the same set.
	 *
	 * @return void
	 */
	public function testConvertReportsExtensionTierSemanticAttributeLint(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => '[text]{samp=value}',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertCount(1, $response['lint']);
		$this->assertSame('semantic-attribute-value-ignored', $response['lint'][0]['rule']);
		$this->assertStringContainsString('samp', $response['lint'][0]['message']);
	}

	/**
	 * Correct Carve stays silent: `*x*` is strong and `_x_` is underline, so
	 * warning on them would punish authors writing the language properly.
	 *
	 * @return void
	 */
	public function testConvertDoesNotReportCorrectCarve(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => 'This is *strong* and {_underlined_} and {~struck~}.',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame([], $response['lint']);
	}

	/**
	 * A habit surviving the Markdown conversion would be a converter gap.
	 *
	 * @return void
	 */
	public function testConvertMarkdownLeavesNoHabits(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertMarkdown'], [
			'markdown' => "**bold** and *italic* and ~~struck~~\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertSame([], $response['lint']);
		$this->assertStringContainsString('*bold*', $response['carve']);
	}

	/**
	 * The img fence renders the SVG body, sanitized: the script element and the
	 * javascript: link are dropped with their subtrees, and what survives comes
	 * back through the page sanitizer as a data: image.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsImgFence(): void {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 20">'
			. '<rect width="60" height="20" fill="#3b82f6"/>'
			. '<script>alert(1)</script>'
			. '<a href="javascript:alert(2)"><circle cx="50" cy="10" r="4"/></a>'
			. '</svg>';

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "``` img\n" . $svg . "\n```\n",
			'extensions' => ['img_fence'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('data:image/svg+xml,', $response['html']);
		$this->assertStringContainsString('rect', rawurldecode($response['html']));
		$this->assertStringNotContainsString('alert', rawurldecode($response['html']));
		$this->assertStringNotContainsString('javascript:', rawurldecode($response['html']));
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsImgFenceDropsTitle(): void {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 20">'
			. '<title>Blue badge</title>'
			. '<rect width="60" height="20" fill="#3b82f6"/>'
			. '</svg>';

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "``` img\n" . $svg . "\n```\n",
			'extensions' => ['img_fence'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('data:image/svg+xml,', $response['html']);
		$this->assertStringContainsString('class="carve-svg"', $response['html']);
		$this->assertStringNotContainsString('Blue badge', rawurldecode($response['html']));
	}

	/**
	 * Without the extension the same fence stays verbatim source, so the
	 * sanitized-SVG allowance is not on for every render.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsWithoutImgFence(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "``` img\n<svg xmlns=\"http://www.w3.org/2000/svg\"></svg>\n```\n",
			'extensions' => [],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringNotContainsString('data:image/svg+xml', $response['html']);
		$this->assertStringContainsString('<pre', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingNumbers(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "# One\n\n## Sub\n\n## Sub two\n",
			'extensions' => ['heading_numbers'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<span class="section-number">1</span>', $response['html']);
		$this->assertStringContainsString('<span class="section-number">1.2</span>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testExtensionsShowcaseListsTheNewExtensions(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'extensions']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('ImgFence::definition(&#039;img&#039;)');
		$this->assertResponseContains('Navigation::headingNumbers()');
	}

	/**
	 * @return void
	 */
	public function testCodeBlocks(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'codeBlocks']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Code Blocks');
		$this->assertResponseContains('language-php');
	}

	/**
	 * @return void
	 */
	public function testMediaEmbed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'mediaEmbed']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Carve &rarr; Media Embeds');
		$this->assertResponseContains('data-carve-source');
	}

	/**
	 * @return void
	 */
	public function testGracefulDegradation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'demo']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Graceful Degradation');
		$this->assertResponseContains('Static HTML');
	}

	/**
	 * @return void
	 */
	public function testGracefulDegradationMarkdownTarget(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'demo'], [
			'target' => 'markdown',
			'carve' => '# Export',
		]);

		$this->assertResponseCode(200);
		$this->assertResponseContains('# Export');
	}

	/**
	 * @return void
	 */
	public function testConvertAstRoundTripsThematicBreak(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'encode',
			'carve' => "***\n",
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('"type": "thematic_break"', $response['json']);
		$this->assertStringContainsString('"astVersion": "2.0"', $response['json']);
		$this->assertTrue($response['stable']);
	}

	/**
	 * @return void
	 */
	public function testTrees(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'trees']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		// Level 0 is core; Level 3 is the host extension rendering nested disclosures.
		$this->assertResponseContains('<div class="tree">');
		$this->assertResponseContains('<details open><summary>');
		$this->assertResponseNotContains('Error:');
	}

	/**
	 * @return array<string, array{string}>
	 */
	public static function snippetProvider(): array {
		/** @var array<string, array{title: string, source: string}> $snippets */
		$snippets = (require CONFIG . 'carve_snippets.php')['CarveSnippets'];
		$cases = [];
		foreach ($snippets as $path => $snippet) {
			$cases[$path] = [$path];
		}

		return $cases;
	}

	/**
	 * Every snippet of the include library is valid 0.2 Carve and expands through the playground.
	 *
	 * @param string $path
	 * @return void
	 */
	#[DataProvider('snippetProvider')]
	public function testSnippetLibraryIncludesRender(string $path): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => str_ends_with($path, '.crv') && $path !== 'library/cycle.crv'
				? '{{ ' . $path . " }}\n"
				: '{{ ' . $path . " @code }}\n",
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertNotSame('', $response['html']);
		$this->assertStringNotContainsString('{{ ' . $path, $response['html']);
		$this->assertTrue($response['dependencies'][0]['resolved'], $path);
	}

	/**
	 * @return array<string, array{string, string}>
	 */
	public static function extensionExampleProvider(): array {
		$controller = new CarveController(new ServerRequest());
		/** @var array<string, array<string, mixed>> $examples */
		$examples = (new ReflectionMethod($controller, 'getExtensionExamples'))->invoke($controller);
		$cases = [];
		foreach ($examples as $key => $example) {
			if (isset($example['example_carve'])) {
				$cases[$key] = [$key, (string)$example['example_carve']];
			}
		}

		return $cases;
	}

	/**
	 * Every example of the extension showcase renders with its extension and is lint clean.
	 *
	 * @param string $key
	 * @param string $carve
	 * @return void
	 */
	#[DataProvider('extensionExampleProvider')]
	public function testExtensionExampleRenders(string $key, string $carve): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => $carve,
			'extensions' => [$key],
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error'], $key);
		$this->assertNotSame('', trim($response['html']), $key);
	}

	/**
	 * @return array<string, array{string, string}>
	 */
	public static function sourceExampleProvider(): array {
		$controller = new CarveController(new ServerRequest());
		$cases = [];
		foreach (['getCodeBlockExamples', 'getTreeExamples', 'getExtensionExamples'] as $method) {
			/** @var array<string, array<string, mixed>> $examples */
			$examples = (new ReflectionMethod($controller, $method))->invoke($controller);
			foreach ($examples as $key => $example) {
				$source = $example['carve'] ?? $example['example_carve'] ?? null;
				if (is_string($source)) {
					$cases[$method . ':' . $key] = [$method . ':' . $key, $source];
				}
			}
		}
		$cases['demoSampleCarve'] = ['demoSampleCarve', (string)(new ReflectionMethod($controller, 'demoSampleCarve'))->invoke($controller)];

		return $cases;
	}

	/**
	 * Every example source in the controller is canonical 0.2 Carve without lint errors.
	 *
	 * @param string $name
	 * @param string $source
	 * @return void
	 */
	#[DataProvider('sourceExampleProvider')]
	public function testExampleSourceIsValidCarve(string $name, string $source): void {
		$errors = array_filter(
			Carve::lint($source),
			fn (Diagnostic $finding): bool => $finding->severity === 'error',
		);
		$this->assertSame([], array_map(fn (Diagnostic $finding): string => $finding->code . ': ' . $finding->message, array_values($errors)), $name);
		$this->assertSame(rtrim($source, "\n") . "\n", Carve::format($source), $name . ' is not canonical');
	}

}
