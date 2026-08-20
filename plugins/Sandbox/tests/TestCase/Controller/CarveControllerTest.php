<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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
		$this->assertResponseContains('carve-js@60b74ac');
		$this->assertResponseContains('pandoc-carve@2b6e192');
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
			'carve' => "{header-rows=1 footer-rows=1}\n|=< Item |=> Qty |\n| Coffee | 2 |\n| Total | 2 |\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('<thead>', $response['html']);
		$this->assertStringContainsString('<tfoot><tr><td', $response['html']);
		$this->assertStringContainsString('Total', $response['html']);
	}

	/**
	 * The `?` prefix inherits the column's horizontal alignment so a cell can set
	 * only its vertical one, and the resulting `vertical-align` declaration has to
	 * survive the sanitizer's CSS allowlist.
	 *
	 * @return void
	 */
	public function testConvertKeepsInheritedCellAlignment(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "|=< Phase |=> Hours |\n|?v Design | 12 |\n| ^ | 8 |\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('vertical-align:bottom;', $response['html']);
		$this->assertStringContainsString('rowspan="2"', $response['html']);
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
		// The playground parses with source lines on, so a cell's single paragraph
		// keeps its `<p data-source-line>` wrapper instead of collapsing inline.
		$this->assertStringContainsString('<th scope="col"><p data-source-line="2">Region</p></th>', $response['html']);
		$this->assertStringContainsString('<th scope="row"><p data-source-line="7">2 regions</p></th>', $response['html']);
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
			'carve' => '[undefined link][missing-ref]',
			'warnings' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotEmpty($response['warnings']);
		$this->assertArrayHasKey('message', $response['warnings'][0]);
		$this->assertArrayHasKey('line', $response['warnings'][0]);
	}

	/**
	 * @return void
	 */
	public function testConvertWithStrictMode(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "``` php\nThis code fence is never closed.",
			'strict' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response['error']);
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
	public function testConvertInterruptsParagraphsByDefault(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "Section\n# Heading",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Carve interrupts paragraphs by default (§10): the heading starts
		// without a blank line in between. Blocks carry a data-source-line
		// scroll-sync anchor, so match tolerantly.
		$this->assertMatchesRegularExpression('#<p[^>]*>Section</p>#', $response['html']);
		$this->assertStringContainsString('<h1', $response['html']);
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
	public function testConvertInterruptsNestedBlockInsideListItem(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "- Item\n  > nested quote",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Interruption is unconditional, so the nested ">" becomes a real
		// blockquote inside the list item.
		$this->assertStringContainsString('<blockquote', $response['html']);
		$this->assertStringContainsString('nested quote', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFilterModeStrip(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\nSome text",
			'profile' => 'comment',
			'filter_mode' => 'strip',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('<h1', $response['html']);
		$this->assertStringNotContainsString('Heading', $response['html']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFilterModeError(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "# Heading\n\nSome text",
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
	}

	/**
	 * @return void
	 */
	public function testExtensions(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'extensions']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('DefaultAttributesExtension');
		$this->assertResponseContains('AutolinkExtension');
		$this->assertResponseContains('ExternalLinksExtension');
		$this->assertResponseContains('HeadingPermalinksExtension');
		$this->assertResponseContains('MentionsExtension');
		$this->assertResponseContains('TableOfContentsExtension');
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
	public function testConvertWithExtensionsPlusBullet(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "+ Apple\n+ Banana",
			'extensions' => ['plus_bullet'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<li>Apple</li>', $response['html']);
		$this->assertStringContainsString('<li>Banana</li>', $response['html']);
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
			'carve' => "::: tip\nHeads up.\n:::\n\nSee [[Getting Started]].",
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
			'carve' => "# Heading 1\n\n## Heading 2",
			'extensions' => ['toc'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('toc', $response);
		$this->assertStringContainsString('<nav class="toc">', $response['toc']);
		$this->assertStringContainsString('Heading 1', $response['toc']);
		$this->assertStringContainsString('Heading 2', $response['toc']);
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
			'carve' => "# Hello\n\nThanks @user! Visit https://example.com",
			'extensions' => ['autolink', 'mentions', 'toc'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('@user', $response['html']);
		$this->assertStringContainsString('href="https://example.com"', $response['html']);
		$this->assertNotEmpty($response['toc']);
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
	 * Contract canary: the bundled carve-js must exist and still expose the
	 * migration API the Migration Fix demo calls. A carve-js build that drops or
	 * renames applyMigrationFixes turns CI red here instead of silently breaking
	 * the page in the browser.
	 *
	 * @return void
	 */
	public function testCarveJsBundleExposesMigrationApi(): void {
		$bundle = WWW_ROOT . 'js' . DS . 'carve-js.min.js';
		$this->assertFileExists($bundle, 'carve-js bundle missing - run `composer assets` to build it.');

		$contents = (string)file_get_contents($bundle);
		$this->assertGreaterThan(1000, strlen($contents), 'carve-js bundle looks empty/truncated.');
		$this->assertStringContainsString(
			'applyMigrationFixes',
			$contents,
			'carve-js bundle no longer exposes applyMigrationFixes - the Migration Fix demo will break.',
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
	 * The word adapter binds Word's footnote-shaped anchors (reference fragment
	 * plus back-link) into real [^N] references and definitions; the generic
	 * adapter would keep them as the literal links the HTML spelled.
	 *
	 * @return void
	 */
	public function testConvertHtmlWordAdapterReadsFootnotes(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertHtml'], [
			'html' => '<p>Text<a href="#_ftn1" name="_ftnref1"><sup>[1]</sup></a> here.</p>'
				. '<hr><div><p><a href="#_ftnref1" name="_ftn1"><sup>[1]</sup></a> The note.</p></div>',
			'adapter' => 'word',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('Text[^1] here.', $response['carve']);
		$this->assertStringContainsString('[^1]: The note.', $response['carve']);
		$this->assertNull($response['error']);
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
	public function testConvertBbcode(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertBbcode'], [
			'bbcode' => 'Hello [b]world[/b]!',
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
	public function testConvertBbcodeEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertBbcode'], [
			'bbcode' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['carve']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertBbcodeGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertBbcode']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testWysiwyg(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwyg']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
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
			'carve' => ":::: tabs\n\n::: tab\n### One\n\nAlpha\n:::\n\n::: tab\n### Two\n\nBeta\n:::\n\n::::",
			'extensions' => ['tabs_aria'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// The ARIA tab/panel association must survive sanitization.
		$this->assertStringContainsString('aria-labelledby', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsFrontmatterAsComment(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "---yaml\ntitle: Demo\n---\n\n# Hi",
			'extensions' => ['frontmatter'],
			'frontmatter_as_comment' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Frontmatter rendered as an HTML comment must not be stripped by the sanitizer.
		$this->assertStringContainsString('<!--', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingReference(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "# Installation\n\nSee [[Configuration]].\n\n# Configuration\n\nDetails.",
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
			'carve' => 'Text with a note[Inline footnote content.]{.fn} here.',
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
	 * HeadingReference and Wikilinks share the [[...]] syntax; enabling both must
	 * not error, and Wikilinks wins so the reference renders as a wiki link.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingReferenceConflictsWithWikilinks(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "See [[Configuration]].\n\n# Configuration\n\nDetails.",
			'extensions' => ['wikilinks', 'heading_reference'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('class="wikilink"', $response['html']);
		$this->assertStringNotContainsString('class="heading-ref"', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testRoundtrip(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'roundtrip']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
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
	 * The interruption page renders Carve's §10 default plus the escape hatch:
	 * an as-typed marker interrupts, the backslash-escaped variant stays literal.
	 *
	 * @return void
	 */
	public function testInterruption(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'interruption']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Paragraph Interruption (§10)');
		// As-typed "# " interrupts into a heading.
		$this->assertResponseContains('<h1>H</h1>');
		// Lists are the documented exception to interruption.
		$this->assertResponseContains('One exception - lists.');
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
			'carve' => "# Title\n\nText.\n",
			'positions' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertGreaterThan(0, $response['placed']);

		$tree = json_decode($response['json'], true);
		$pos = $tree['children'][0]['pos'];
		$this->assertSame(
			['startLine', 'endLine', 'startColumn', 'endColumn', 'startOffset', 'endOffset'],
			array_keys($pos),
		);
		$this->assertSame(1, $pos['startLine']);
	}

	/**
	 * The field names are spec-pinned, so a tree written by hand (or by another
	 * engine) renders here without carve-php having produced it.
	 *
	 * @return void
	 */
	public function testConvertAstDecodeForeignTree(): void {
		$tree = [
			'type' => 'document',
			'srcByteLength' => 24,
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
		$this->assertStringContainsString('## From elsewhere', $response['carve']);
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
	 * @return void
	 */
	public function testConvertProseMirror(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertProseMirror'], [
			'carve' => "# Title\n\nText with *strong* and /emphasis/.\n\n- a\n- b\n",
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertTrue($response['stable']);
		$this->assertTrue($response['carveStable']);
		$this->assertSame([], $response['dropped']);

		$document = json_decode($response['pm'], true);
		$this->assertSame('doc', $document['type']);
		$this->assertSame('heading', $document['content'][0]['type']);
		// And all the way back, without a Node runtime anywhere.
		$this->assertStringContainsString('# Title', $response['carve']);
		$this->assertStringContainsString('*strong*', $response['carve']);
	}

	/**
	 * A typed div keeps its authored spelling across the ProseMirror bridge.
	 *
	 * It did not until carve-php#609: `carveDiv` carried only the class, so the
	 * div came back untyped and the writer fell back to an attribute block plus
	 * an anonymous fence. Both spellings render byte-identical HTML, so the HTML
	 * check passed either way - only comparing canonical Carve saw it. The
	 * bridge now records `carveTyped` alongside the authored attributes, and
	 * `carveStable` is what pins that here.
	 *
	 * @return void
	 */
	public function testConvertProseMirrorKeepsTypedDivSpelling(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertProseMirror'], [
			'carve' => "::: note\nHi.\n:::\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		// Same meaning...
		$this->assertTrue($response['stable']);
		// ...and now the same spelling.
		$this->assertTrue($response['carveStable']);
		$this->assertStringContainsString("::: note\n", $response['canonical']);
		$this->assertStringContainsString("::: note\n", $response['carve']);
		// Nothing was lost, so the fidelity report stays empty.
		$this->assertSame([], $response['dropped']);
		$this->assertSame([], $response['degraded']);

		$document = json_decode($response['pm'], true);
		$this->assertSame('carveDiv', $document['content'][0]['type']);
		$this->assertTrue($document['content'][0]['attrs']['carveTyped']);
	}

	/**
	 * A link with an empty label used to be a real loss: the editor model had no
	 * text to hang the mark on, so it came back gone and `degradedTypes()` named
	 * it. carve-php now carries such a mark as a `carveEmptyMark` node, for the
	 * five mark types the published schema gives a carrier (link, span,
	 * abbreviation, insert, delete), so the round trip is exact and the report is
	 * empty.
	 *
	 * The same direction the autolink (its #629) and the typed-div gap went - the
	 * losses shrink, and this suite is what keeps the demo's claim in step.
	 *
	 * @return void
	 */
	public function testConvertProseMirrorCarriesEmptyLinkMark(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertProseMirror'], [
			'carve' => "[](https://example.com)\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertTrue($response['carveStable']);
		$this->assertStringContainsString('[](https://example.com)', $response['canonical']);
		$this->assertStringContainsString('[](https://example.com)', $response['carve']);
		$this->assertSame([], $response['degraded']);

		$document = json_decode($response['pm'], true);
		$this->assertSame('carveEmptyMark', $document['content'][0]['content'][0]['type']);
	}

	/**
	 * What the bridge still cannot carry is NAMED rather than lost quietly.
	 *
	 * An unresolved reference has no editor counterpart, so it rides across as
	 * its literal source and comes back as escaped text. That is a real loss
	 * rather than a different spelling, which is why the demo's claim is the
	 * REPORT, not the round trip: `degradedTypes()` says what happened.
	 *
	 * @return void
	 */
	public function testConvertProseMirrorReportsDegradedUnresolvedReference(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertProseMirror'], [
			'carve' => "See [text][nope] here.\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertFalse($response['carveStable']);
		$this->assertStringContainsString('[text][nope]', $response['canonical']);
		$this->assertStringNotContainsString('[text][nope]', $response['carve']);
		// And the report names it.
		$this->assertArrayHasKey('link', $response['degraded']);
	}

	/**
	 * An autolink survives the bridge now (carve-php#629): it comes back as the
	 * `<url>` the author wrote, not as `[url](url)`.
	 *
	 * @return void
	 */
	public function testConvertProseMirrorKeepsAutolinkSpelling(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertProseMirror'], [
			'carve' => "See <https://example.com> now.\n",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertTrue($response['carveStable']);
		$this->assertStringContainsString('<https://example.com>', $response['carve']);
		$this->assertSame([], $response['degraded']);
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
		$this->assertSame('markdown-strong-asterisks', $response['lint'][0]['rule']);
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
			'carve' => 'This is *strong* and _underlined_ and ~struck~.',
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
	 * The accessible name and the styling hooks survive the sanitizer detour.
	 *
	 * The img fence derives the alt text from the SVG's `<title>` and puts an
	 * attribute line's `{#logo .wide}` on the tag, but the payload has to be
	 * stashed around HTMLPurifier (which drops percent-encoded `data:` SVGs) and
	 * the tag rebuilt afterwards. Rebuilding it from the src alone would strip
	 * both from exactly the images that carry them, and no other assertion here
	 * would notice.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsImgFenceKeepsAltAndAttributes(): void {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 20">'
			. '<title>Blue "badge" &amp; label</title>'
			. '<rect width="60" height="20" fill="#3b82f6"/>'
			. '</svg>';

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "{#logo .wide}\n``` img\n" . $svg . "\n```\n",
			'extensions' => ['img_fence'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('data:image/svg+xml,', $response['html']);
		// Quotes and ampersands stay escaped - the alt is authored text.
		$this->assertStringContainsString('alt="Blue &quot;badge&quot; &amp; label"', $response['html']);
		$this->assertStringContainsString('id="logo"', $response['html']);
		$this->assertStringContainsString('class="wide carve-svg"', $response['html']);
	}

	/**
	 * The three carried attributes bypass HTMLPurifier - the placeholder it sees
	 * has none of them - so an id it would have rejected is dropped here instead
	 * of riding back into the document.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsImgFenceDropsUnusableId(): void {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"><title>T</title></svg>';

		// An id starting with a digit is not a valid HTML id, and the purifier
		// strips it from an ordinary <img> - so it has to go here too.
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertWithExtensions'], [
			'carve' => "{id=\"1logo\"}\n``` img\n" . $svg . "\n```\n",
			'extensions' => ['img_fence'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('data:image/svg+xml,', $response['html']);
		$this->assertStringNotContainsString('id=', $response['html']);
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
		$this->assertResponseContains('ImgFenceExtension');
		$this->assertResponseContains('HeadingNumbersExtension');
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
	public function testConvertAstUpgradesLegacyStoredPayload(): void {
		$tree = '{"type":"document","srcByteLength":6,"children":[{"type":"paragraph","children":[{"type":"raw_text","content":"legacy"}]}]}';
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'decode',
			'tree' => $tree,
			'upgrade' => '1',
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('legacy', $response['html']);
		$this->assertStringContainsString('"type": "text"', $response['json']);
	}

	/**
	 * @return void
	 */
	public function testConvertAstPreservesThematicBreakMarker(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convertAst'], [
			'direction' => 'encode',
			'carve' => "***\n",
		]);

		$this->assertResponseCode(200);
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		$this->assertStringContainsString('"marker": "*"', $response['json']);
		$this->assertTrue($response['stable']);
	}

}
