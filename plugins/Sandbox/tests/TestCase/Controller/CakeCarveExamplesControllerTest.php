<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DOMDocument;
use DOMXPath;

class CakeCarveExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'index']);
		$this->assertCarvePage();
		$xpath = $this->xpath();
		$default = $xpath->query('//div[@data-preset="default"]/div[contains(@class, "carve-output")]')->item(0);
		$this->assertNotNull($default);
		$this->assertSame('Preset comparison', $xpath->query('.//h1', $default)->item(0)?->textContent);
		$this->assertSame('emphasis', $xpath->query('.//em', $default)->item(0)?->textContent);
		$this->assertStringContainsString('Raw HTML', (string)$xpath->query('.//pre/code', $default)->item(0)?->textContent);
		foreach (['comment', 'minimal'] as $preset) {
			$output = $xpath->query('//div[@data-preset="' . $preset . '"]/div[contains(@class, "carve-output")]')->item(0);
			$this->assertNotNull($output);
			$this->assertCount(0, $xpath->query('.//h1', $output));
		}
		foreach (['default', 'comment', 'article', 'minimal'] as $preset) {
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
		$this->assertResponseRegExp('#<h1>First heading</h1>#');
		$this->assertResponseContains('&quot;title&quot;: &quot;Document metadata&quot;');
	}

	public function testValidation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation']);
		$this->assertCarvePage();
		$this->assertResponseContains('= Comment');
	}

	public function testValidationFailure(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation'], ['body' => '= Disallowed heading', 'preset' => 'comment', 'maxLength' => 200]);
		$this->assertCarvePage();
		$this->assertResponseContains('Carve content contains markup disallowed by its profile.');
	}

	public function testValidationStrictRejectsParseWarnings(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation'], ['body' => "```carve\nunclosed", 'preset' => 'default', 'maxLength' => 200, 'strict' => '1']);
		$this->assertCarvePage();
		$this->assertResponseContains('Carve content has parse warnings');
	}

	public function testValidationSuccess(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'validation'], ['body' => 'Valid /comment/ with *strong* text', 'preset' => 'comment', 'maxLength' => 200]);
		$this->assertCarvePage();
		$this->assertResponseContains('Valid, rendered');
		$this->assertResponseContains('<em>comment</em>');
		$this->assertResponseContains('<strong>strong</strong>');
	}

	public function testBehavior(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'behavior']);
		$this->assertCarvePage();
		$this->assertResponseContains('= Saved post');
		$this->assertResponseNotContains('Saved row');
	}

	public function testBehaviorSave(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'behavior'], ['body' => "= Saved post\n\nSome *bold* text.\n\n== Details\n\nMore text."]);
		$this->assertCarvePage();
		$this->assertResponseContains('Saved row');
		$this->assertResponseContains('body_html');
		$this->assertResponseContains('&lt;h1');
		$this->assertResponseContains('body_text');
		$this->assertResponseContains('body_toc');
		$this->assertResponseContains('Details');
	}

	public function testView(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'view']);
		$this->assertCarvePage();
		$this->assertResponseContains('= {{carve.meta.title}}');
		$this->assertResponseContains('src="/sandbox/cake-carve-examples/document"');
	}

	public function testDocument(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeCarveExamples', 'action' => 'document']);
		$this->assertCarvePage();
		$this->assertResponseContains('CakePHP sandbox');
		$this->assertResponseRegExp('#<h1[^>]*>A CarveView page</h1>#');
		$this->assertResponseContains('come from the Carve layout');
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

	protected function assertCarvePage(): void {
		$this->assertResponseCode(200);
		$this->assertResponseNotContains('Unknown Carve');
		$this->assertResponseNotContains('not available yet');
		$this->assertResponseNotContains('Invalid Carve content');
	}

	protected function xpath(): DOMXPath {
		$document = new DOMDocument();
		$previous = libxml_use_internal_errors(true);
		$document->loadHTML((string)$this->_response->getBody());
		libxml_clear_errors();
		libxml_use_internal_errors($previous);

		return new DOMXPath($document);
	}

}
