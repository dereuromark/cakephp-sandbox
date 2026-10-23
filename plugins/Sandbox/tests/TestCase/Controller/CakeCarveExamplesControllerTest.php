<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\Attributes\DataProvider;

class CakeCarveExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	public static function pages(): array {
		return [['index'], ['validation'], ['behavior'], ['view'], ['document']];
	}

	#[DataProvider('pages')]
	public function testPages(string $action): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => $action]);
		$this->assertResponseCode(200);
		if ($action === 'view') {
			$this->assertResponseContains('{{carve.meta.title}}');
			$this->assertResponseContains('src="/sandbox/cake-carve-examples/document"');
		}
		if ($action === 'document') {
			$this->assertResponseContains('CakePHP sandbox');
			$this->assertResponseRegExp('#<h1[^>]*>A CarveView page</h1>#');
			$this->assertResponseContains('come from the Carve layout');
		}
	}

	public function testPresets(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'index']);
		$this->assertResponseCode(200);
		$document = new DOMDocument();
		$previous = libxml_use_internal_errors(true);
		$document->loadHTML((string)$this->_response->getBody());
		libxml_clear_errors();
		libxml_use_internal_errors($previous);
		$xpath = new DOMXPath($document);
		foreach (['default', 'comment', 'strict'] as $preset) {
			$output = $xpath->query('//div[@data-preset="' . $preset . '"]/div[contains(@class, "carve-output")]')->item(0);
			$this->assertNotNull($output);
			$this->assertCount(0, $xpath->query('.//div[contains(text(), "Raw HTML")]', $output));
		}
		// Trusted keeps the raw HTML, so it is shown as escaped source only.
		$this->assertCount(0, $xpath->query('//div[@data-preset="trusted"]/div[contains(@class, "carve-output")]'));
		$trustedSource = $xpath->query('//div[@data-preset="trusted"]/div[contains(@class, "carve-source")]')->item(0);
		$this->assertNotNull($trustedSource);
		$this->assertStringContainsString('onclick="alert(1)"', $trustedSource->textContent);
		$this->assertCount(0, $xpath->query('//*[@onclick or starts-with(@href, "javascript:")]'));
		$this->assertCount(0, $xpath->query('//div[@data-preset="comment"]//h1'));
	}

	public function testValidationFailure(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation'], ['body' => '# Disallowed heading', 'preset' => 'comment', 'maxLength' => 200]);
		$this->assertResponseCode(200);
		$this->assertResponseContains('Carve content contains markup disallowed by its profile.');
	}

	public function testValidationSuccess(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation'], ['body' => 'Valid /comment/', 'preset' => 'comment', 'maxLength' => 200]);
		$this->assertResponseCode(200);
		$this->assertResponseContains('<em>comment</em>');
	}

	public function testBehavior(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'behavior'], ['body' => "# Saved post\n\nSome *bold* text.\n\n## Details\n\nMore text."]);
		$this->assertResponseCode(200);
		$this->assertResponseContains('body_html');
		$this->assertResponseContains('&lt;h1');
		$this->assertResponseContains('body_text');
		$this->assertResponseContains('body_toc');
		$this->assertResponseContains('Details');
	}

	public function testPluginNavigationAndCrossLinks(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'index']);
		$this->assertResponseCode(200);
		foreach (['', '/validation', '/behavior', '/view'] as $suffix) {
			$this->assertResponseContains('href="/sandbox/cake-carve-examples' . $suffix . '"');
		}
		$this->assertResponseContains('href="/sandbox/carve"');
	}

	public function testCarveAreaLinksThePluginExamples(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Carve', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertResponseContains('href="/sandbox/cake-carve-examples"');
	}

	public function testPluginHubLinksThePluginExamples(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'PluginExamples', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertResponseContains('href="/sandbox/cake-carve-examples"');
	}

}
