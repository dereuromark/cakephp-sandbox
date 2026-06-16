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
		$this->assertStringContainsString('<li>', $response['html']);
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
	public function testConvertInterruptsParagraphsByDefault(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'convert'], [
			'carve' => "Section\n# Heading",
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		// Carve interrupts paragraphs by default (§10): the heading starts
		// without a blank line in between.
		$this->assertStringContainsString('<p>Section</p>', $response['html']);
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
		$this->assertStringContainsString('<blockquote>', $response['html']);
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
	 * TipTap task-list HTML round-trips to Carve checkbox items.
	 *
	 * @return void
	 */
	public function testWysiwygPreviewConvertsTaskLists(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwygPreview'], [
			'html' => '<ul data-type="taskList"><li data-type="taskItem" data-checked="true"><label><input type="checkbox" checked></label><div><p>done</p></div></li><li data-type="taskItem" data-checked="false"><label><input type="checkbox"></label><div><p>todo</p></div></li></ul>',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('- [x] done', $response['carve']);
		$this->assertStringContainsString('- [ ] todo', $response['carve']);
	}

	/**
	 * The WYSIWYG preview also expands code tabs to spaces by default.
	 *
	 * @return void
	 */
	public function testWysiwygPreviewExpandsTabsByDefault(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwygPreview'], [
			'html' => "<pre><code class=\"language-js\">function f() {\n\treturn 1;\n}\n</code></pre>",
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
	public function testWysiwygPreview(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwygPreview'], [
			'html' => '<h1>Title</h1><p>A <strong>bold</strong> word and <mark>mark</mark>.</p>',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNull($response['error']);
		// HtmlToCarve produces the Carve source.
		$this->assertStringContainsString('# Title', $response['carve']);
		$this->assertStringContainsString('*bold*', $response['carve']);
		$this->assertStringContainsString('{=mark=}', $response['carve']);
		// CarveConverter renders the sanitized preview from that source.
		$this->assertStringContainsString('<h1>Title</h1>', $response['html']);
		$this->assertStringContainsString('<strong>bold</strong>', $response['html']);
	}

	/**
	 * @return void
	 */
	public function testWysiwygPreviewEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwygPreview'], [
			'html' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertSame('', $response['carve']);
		$this->assertSame('', $response['html']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testWysiwygPreviewGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'wysiwygPreview']);

		$this->assertResponseCode(405);
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

}
