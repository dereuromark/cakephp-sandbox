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
	public function testConvertWithSignificantNewlines(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Djot', 'action' => 'convert'], [
			'djot' => "Line one\nLine two",
			'significant_newlines' => '1',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertStringContainsString('<br', $response['html']);
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

}
