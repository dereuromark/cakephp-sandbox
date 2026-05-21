<?php

namespace App\Test\TestCase\Controller;

use App\Controller\MiscController;
use Cake\Http\ServerRequest;
use ReflectionMethod;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\MiscController
 */
class MiscControllerTest extends IntegrationTestCase {

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Misc', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testConvertText() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['controller' => 'Misc', 'action' => 'convertText']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Posting a valid type runs the conversion and reports success.
	 *
	 * @return void
	 */
	public function testConvertTextPost() {
		$this->enableRetainFlashMessages();

		$this->post(['controller' => 'Misc', 'action' => 'convertText'], [
			'Form' => ['text' => '<b>', 'type' => '1'],
		]);

		$this->assertResponseCode(200);
		$this->assertFlashMessage('html encode done');
	}

	/**
	 * @return void
	 */
	public function testProcessHtmlEncode() {
		$input = '<b> & "quote"';
		$this->assertSame(h($input), $this->invokeProcess($input, '1'));
	}

	/**
	 * @return void
	 */
	public function testProcessHtmlDecode() {
		$input = '&lt;b&gt; &amp; &quot;quote&quot;';
		$this->assertSame(hDec($input), $this->invokeProcess($input, '2'));
	}

	/**
	 * @return void
	 */
	public function testProcessEntityEncode() {
		$input = '<ä> & ü';
		$this->assertSame(ent($input), $this->invokeProcess($input, '3'));
	}

	/**
	 * @return void
	 */
	public function testProcessEntityDecode() {
		$input = '&lt;&auml;&gt; &amp; &uuml;';
		$this->assertSame(entDec($input), $this->invokeProcess($input, '4'));
	}

	/**
	 * @return void
	 */
	public function testProcessIndent() {
		$input = 'line1' . PHP_EOL . 'line2';
		$expected = "\t" . 'line1' . PHP_EOL . "\t" . 'line2';
		$this->assertSame($expected, $this->invokeProcess($input, '5'));
	}

	/**
	 * @return void
	 */
	public function testProcessOutdent() {
		$input = "\t" . 'line1' . PHP_EOL . 'line2';
		$expected = 'line1' . PHP_EOL . 'line2';
		$this->assertSame($expected, $this->invokeProcess($input, '6'));
	}

	/**
	 * An unknown type is returned unchanged (no switch case matches).
	 *
	 * @return void
	 */
	public function testProcessUnknownTypeReturnsInput() {
		$input = '<b>';
		$this->assertSame($input, $this->invokeProcess($input, '99'));
	}

	/**
	 * No type + plain text auto-detects as "encode" (type 1).
	 *
	 * @return void
	 */
	public function testProcessAutoDetectEncodes() {
		$input = '<b>';
		$this->assertSame(h($input), $this->invokeProcess($input, null));
	}

	/**
	 * No type + already-encoded text auto-detects as "decode" (type 2).
	 *
	 * @return void
	 */
	public function testProcessAutoDetectDecodes() {
		$input = '&lt;b&gt;';
		$this->assertSame(hDec($input), $this->invokeProcess($input, null));
	}

	/**
	 * @return void
	 */
	public function testAutoDetectPlainText() {
		$this->assertSame(1, $this->invokeAutoDetect('just plain text'));
	}

	/**
	 * @return void
	 */
	public function testAutoDetectEncodedText() {
		$this->assertSame(2, $this->invokeAutoDetect('a &gt; b'));
	}

	/**
	 * @param string $text
	 * @param string|int|null $type
	 * @return string
	 */
	protected function invokeProcess(string $text, $type): string {
		$controller = new MiscController(new ServerRequest());
		$method = new ReflectionMethod($controller, '_process');

		return $method->invoke($controller, $text, $type);
	}

	/**
	 * @param string $text
	 * @return int
	 */
	protected function invokeAutoDetect(string $text): int {
		$controller = new MiscController(new ServerRequest());
		$method = new ReflectionMethod($controller, '_autoDetect');

		return $method->invoke($controller, $text);
	}

}
