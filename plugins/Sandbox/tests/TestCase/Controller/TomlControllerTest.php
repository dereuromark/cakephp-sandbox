<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\TomlController Test Case
 *
 * @uses \Sandbox\Controller\TomlController
 */
class TomlControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testExamples(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'examples']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testValidation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConvert(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert'], [
			'toml' => 'title = "Hello World"',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['success']);
		$this->assertArrayHasKey('data', $response);
		$this->assertSame('Hello World', $response['data']['title']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithTable(): void {
		$toml = <<<'TOML'
[database]
host = "localhost"
port = 5432
TOML;

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert'], [
			'toml' => $toml,
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['success']);
		$this->assertSame('localhost', $response['data']['database']['host']);
		$this->assertSame(5432, $response['data']['database']['port']);
	}

	/**
	 * @return void
	 */
	public function testConvertWithArray(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert'], [
			'toml' => 'ports = [8000, 8001, 8002]',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['success']);
		$this->assertSame([8000, 8001, 8002], $response['data']['ports']);
	}

	/**
	 * @return void
	 */
	public function testConvertEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert'], [
			'toml' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['success']);
		$this->assertNull($response['data']);
	}

	/**
	 * @return void
	 */
	public function testConvertInvalidToml(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert'], [
			'toml' => 'invalid = "unclosed string',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['success']);
		$this->assertNotNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testConvertGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'convert']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testEncode(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'encode'], [
			'json' => '{"title": "Hello World"}',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['success']);
		$this->assertStringContainsString('title = "Hello World"', $response['data']);
		$this->assertNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testEncodeWithNestedData(): void {
		$json = json_encode([
			'database' => [
				'host' => 'localhost',
				'port' => 5432,
			],
		]);

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'encode'], [
			'json' => $json,
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['success']);
		$this->assertStringContainsString('[database]', $response['data']);
		$this->assertStringContainsString('host = "localhost"', $response['data']);
	}

	/**
	 * @return void
	 */
	public function testEncodeEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'encode'], [
			'json' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['success']);
		$this->assertNull($response['data']);
	}

	/**
	 * @return void
	 */
	public function testEncodeInvalidJson(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'encode'], [
			'json' => '{invalid json}',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['success']);
		$this->assertNotNull($response['error']);
	}

	/**
	 * @return void
	 */
	public function testEncodeGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'encode']);

		$this->assertResponseCode(405);
	}

	/**
	 * @return void
	 */
	public function testValidateValid(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'validate'], [
			'toml' => 'name = "test"',
		]);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertTrue($response['valid']);
		$this->assertEmpty($response['errors']);
		$this->assertArrayHasKey('data', $response);
		$this->assertSame('test', $response['data']['name']);
	}

	/**
	 * @return void
	 */
	public function testValidateWithErrors(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'validate'], [
			'toml' => 'name = "unclosed',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['valid']);
		$this->assertNotEmpty($response['errors']);
		$this->assertArrayHasKey('message', $response['errors'][0]);
	}

	/**
	 * @return void
	 */
	public function testValidateEmpty(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'validate'], [
			'toml' => '',
		]);

		$this->assertResponseCode(200);

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertFalse($response['valid']);
	}

	/**
	 * @return void
	 */
	public function testValidateGetMethodNotAllowed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Toml', 'action' => 'validate']);

		$this->assertResponseCode(405);
	}

}
