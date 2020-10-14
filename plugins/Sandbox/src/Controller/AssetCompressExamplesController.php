<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventInterface;
use Exception;
use MiniAsset\Filter\ScssFilter;
use RuntimeException;

class AssetCompressExamplesController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected $_cssDir;

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return void
	 */
	public function beforeFilter(EventInterface $event) {
		$this->_cssDir = Plugin::path('Sandbox') . 'files' . DS . 'AssetCompress' . DS;

		parent::beforeFilter($event);
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function sass() {
		if (!file_exists($this->_cssDir . 'test.scss')) {
			throw new Exception('Cannot find scss test file.');
		}

		$filter = new ScssFilter();
		$settings = (array)Configure::read('Sass');
		$filter->settings($settings);

		$source = file_get_contents($this->_cssDir . 'test.scss');
		if (!$source) {
			throw new RuntimeException('Cannot read test.scss file.');
		}

		try {
			$result = $filter->input($this->_cssDir . 'test.scss', $source);
		} catch (\RuntimeException $e) {
			$this->Flash->error('SASS Parsing error: ' . $e->getMessage());
			$result = [];
		}
		$expected = file_get_contents($this->_cssDir . 'compiled_scss.css') ?: '';
		if (!$expected) {
			throw new RuntimeException('Cannot read compiled_scss.scss file.');
		}
		if (!$result) {
			$result = $expected;
			$expected = '';
		}

		$result = trim(str_replace("\r\n", "\n", $result));
		$expected = trim(str_replace("\r\n", "\n", $expected));
		if ($expected && $expected !== $result) {
			$this->Flash->warning('Actual result is not quite the expected one.');
		}

		$this->set(compact('source', 'result', 'expected'));
	}

}
