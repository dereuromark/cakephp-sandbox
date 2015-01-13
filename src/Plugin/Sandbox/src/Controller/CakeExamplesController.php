<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\Utility\Hash;

class CakeExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * CakeExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * CakeExamplesController::query_strings()
	 *
	 * @return void
	 */
	public function query_strings() {
	}

	/**
	 * CakeExamplesController::merge()
	 *
	 * @return void
	 */
	public function merge() {
		$array = array(
			'root' => array(
				'deep1' => array('deeper1a' => 'value1a', 'deeper2b' => 'value2b'),
				'deep2' => array('deeper1', 'deeper2'),
				'deep3' => 'stringX',
			)
		);
		$mergeArray = array(
			'root' => array(
				'deep1' => array('deeper1a' => 'value1a', 'deeper3b' => 'value3b'),
				'deep2' => array('deeper1', 'deeper3'),
				'deep3' => 'stringY',
			)
		);

		if ($type = $this->request->query('type')) {
			switch ($type) {
				case 'hash':
					$result = Hash::merge($array, $mergeArray);
					break;
				case 'am':
					$result = am($array, $mergeArray);
					break;
				case 'array_merge':
					$result = array_merge($array, $mergeArray);
					break;
				case 'array_merge_recursive':
					$result = array_merge_recursive($array, $mergeArray);
					break;
				default:
					throw new NotFoundException('Invalid merge type');
			}
		}

		$this->set(compact('array', 'mergeArray', 'result'));
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _translate_behavior() {
	}

}
