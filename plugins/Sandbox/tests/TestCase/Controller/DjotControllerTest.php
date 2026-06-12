<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\DjotController Test Case
 *
 * @uses \Sandbox\Controller\DjotController
 */
class DjotControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvert(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => 'Hello *world*!',
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
	public function testConvertWithArticleProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "# Heading\n\n``` =html\n<script>alert(1)</script>\n```",
			'profile' => 'article',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<h1', $response['html']);
		$this->assertStringNotContainsString('<script>', $response['html']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertSanitizesXss(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => '[link](javascript:alert(1))',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringNotContainsString('javascript:', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithCommentProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "# Heading\n\nSome *bold* text.\n\n![image](/test.png)",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "*Bold* and `code` with [link](https://example.com)\n\n- list item",
			'profile' => 'minimal',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<strong>Bold</strong>', $response['html']);
		$this->assertStringContainsString('<code>code</code>', $response['html']);
		$this->assertStringContainsString('<li>', $response['html']);
		$this->assertStringNotContainsString('<a href', $response['html']);
		$this->assertNotEmpty($response['violations']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFullProfile(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "# Heading\n\n*Bold* text",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => '[undefined link][missing-ref]',
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "::: warning\nThis div is never closed.",
			'strict' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithSoftBreakAsBr(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "Line one\nLine two",
			'soft_break_br' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<br', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithBlocksInterruptParagraphs(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "Here:\n- one\n- two",
			'blocks_interrupt_paragraphs' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// The list interrupts the paragraph without a blank line.
		$this->assertStringContainsString('<p>Here:</p>', $response['html']);
		$this->assertStringContainsString('<ul>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithNestedListsWithoutBlankLine(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "- Item\n  - Sub one\n  - Sub two",
			'nested_lists_without_blank_line' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// The indented sublist nests without a blank line, producing two <ul>.
		$this->assertSame(2, substr_count($response['html'], '<ul>'));
		$this->assertStringContainsString('Sub one', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertBlocksInterruptParagraphsNestsMultiItemSublist(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "- Item\n  - Sub one\n  - Sub two",
			// A list is a block, so the broader option nests a real sublist on its own.
			'blocks_interrupt_paragraphs' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame(2, substr_count($response['html'], '<ul>'));
		$this->assertStringContainsString('Sub one', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithFilterModeStrip(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "# Heading\n\nSome text",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "# Heading\n\nSome text",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => '',
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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testComplexExamples(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'complexExamples']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testExtensions(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'extensions']);

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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "![Image](/test.png)\n\n| A | B |\n|---|---|\n| 1 | 2 |",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => 'Visit https://example.com for more.',
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => '# Über uns',
			'extensions' => ['ascii_heading_ids'],
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('id="Uber-uns"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTabNormalization(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "``` js\n\treturn 1;\n```",
			'extensions' => ['tab_normalization'],
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "``` js\n\treturn 1;\n```",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('    return 1;', $response['html']);
		$this->assertStringNotContainsString("\treturn 1;", $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsExternalLinks(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => '[Link](https://example.com)',
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => 'Thanks @johndoe!',
			'extensions' => ['mentions'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('href="/sandbox/djot?user=johndoe"', $response['html']);
		$this->assertStringContainsString('@johndoe', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsHeadingPermalinks(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => '# Hello World',
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "# Heading 1\n\n## Heading 2",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "# Hello\n\nContent here.",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "# Hello\n\nContent here.",
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
	public function testConvertWithExtensionsHeadingReference(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "# Intro\n\nSee [[Setup]].\n\n# Setup\n\nBody.",
			'extensions' => ['heading_reference'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="heading-ref"', $response['html']);
		$this->assertStringContainsString('href="#Setup"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsInlineFootnotes(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => 'Text[A note.]{.fn} more.',
			'extensions' => ['inline_footnotes'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('role="doc-noteref"', $response['html']);
		$this->assertStringContainsString('role="doc-endnotes"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsCitations(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => 'See [@knuth1984] for details.',
			'extensions' => ['citations'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="citation', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsLineBlockDiv(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "::: |\nRoses are red\n  Violets are blue\n:::",
			'extensions' => ['line_block_div'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="line-block"', $response['html']);
		$this->assertStringContainsString('<br', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * A line block nests inside a list item (indent it, blank line before the fence).
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsLineBlockDivNestedInListItem(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "- A short verse:\n\n  ::: |\n  Roses are red\n    Violets are blue\n  :::\n- Back to the list.",
			'extensions' => ['line_block_div'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<li>', $response['html']);
		$this->assertStringContainsString('class="line-block"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * Medial runs of two or more spaces inside a line block are held open with
	 * non-breaking spaces (verse caesura, aligned columns), and survive sanitizing.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsLineBlockDivPreservesMedialGap(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "::: |\nleft    right\n:::",
			'extensions' => ['line_block_div'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="line-block"', $response['html']);
		$this->assertStringContainsString("left\u{00A0}\u{00A0}\u{00A0}\u{00A0}right", $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * HeadingReference and Wikilinks both claim [[...]]; enabling both must drop
	 * HeadingReference so the converter does not throw, and Wikilinks wins.
	 *
	 * @return void
	 */
	public function testConvertWithExtensionsWikilinksHeadingReferenceCollision(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => 'See [[Getting Started]].',
			'extensions' => ['wikilinks', 'heading_reference'],
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('class="wikilink"', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsCombined(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "# Hello\n\nThanks @user! Visit https://example.com",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => '',
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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testMarkdownToDjot(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'markdownToDjot']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdown(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertMarkdown'], [
			'markdown' => 'Hello **world**!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('djot', $response);
		$this->assertStringContainsString('*world*', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdownEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertMarkdown'], [
			'markdown' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertMarkdownGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertMarkdown']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testHtmlToDjot(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'htmlToDjot']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertHtml(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertHtml'], [
			'html' => '<p>Hello <strong>world</strong>!</p>',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('djot', $response);
		$this->assertStringContainsString('*world*', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertHtml'], [
			'html' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertHtmlGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertHtml']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testBbcodeToDjot(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'bbcodeToDjot']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertBbcode(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertBbcode'], [
			'bbcode' => 'Hello [b]world[/b]!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('djot', $response);
		$this->assertStringContainsString('*world*', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertBbcodeEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertBbcode'], [
			'bbcode' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['djot']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertBbcodeGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertBbcode']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testWysiwyg(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'wysiwyg']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertWithExtensionsTabsAriaPreservesLabel(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => ":::: tabs\n\n::: tab\n### One\n\nAlpha\n:::\n\n::: tab\n### Two\n\nBeta\n:::\n\n::::",
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertWithExtensions'], [
			'djot' => "---yaml\ntitle: Demo\n---\n\n# Hi",
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
	public function testRoundtrip(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'roundtrip']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtrip(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertRoundtrip'], [
			'djot' => 'Hello *world*!',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertArrayHasKey('html1', $response);
		$this->assertArrayHasKey('djot2', $response);
		$this->assertArrayHasKey('html2', $response);
		$this->assertStringContainsString('<strong>world</strong>', $response['html1']);
		$this->assertStringContainsString('*world*', $response['djot2']);
		$this->assertTrue($response['htmlStable']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripNormalizesCrlf(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertRoundtrip'], [
			// Multipart form-data sends CRLF; the verdict must ignore line-ending differences.
			'djot' => "First *line*\r\n\r\nSecond line",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['djotStable']);
		$this->assertTrue($response['htmlStable']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertRoundtrip'], [
			'djot' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['html1']);
		$this->assertSame('', $response['djot2']);
		$this->assertFalse($response['htmlStable']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertRoundtripGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convertRoundtrip']);

		$this->assertResponseCode(405);
	}

	/**
	 * The strict-vs-interrupt comparison page renders and shows that interrupt
	 * diverges from the djot default on the curated prose cases.
	 *
	 * @return void
	 */
	public function testInterruption(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'interruption']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Strict vs Interrupt');
		$this->assertResponseContains('djot default preserves it - interrupt splits');
	}

}
