<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class JqueryExamplesController extends SandboxAppController {

	public $helpers = array('Tools.Geshi');

	public $uses = array();

	public $jqueryPlugins = array('media');

	public function beforeFilter() {
		$this->Auth->allow();

		parent::beforeFilter();
	}

	public function beforeRender() {
		$this->set('jquery_plugins', $this->jqueryPlugins);

		parent::beforeRender();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	public function ajaxform() {
	}

	public function file_tree() {
	}

	/** ajax function for file_tree */

	/**
	 * JqueryExamplesController::file_tree_ajax()
	 *
	 * @return void
	 */
	public function file_tree_ajax() {
		$this->autoRender = false;

		if ($this->RequestHandler->isPost() && $this->request->is('ajax') && !empty($this->request->data['dir'])) {
			$dir = $this->request->data['dir'] . DS;
			$dir = urldecode($dir);

			$root = WWW_ROOT . 'files' . DS;

			//echo $root . $dir;

		if ( file_exists($root . $dir)) {
			$files = scandir($root . $dir);
			natcasesort($files);
			if ( count($files) > 2) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach ($files as $file) {
					if ( file_exists($root . $dir . $file) && $file !== '.' && $file !== '..' && is_dir($root . $dir . $file)) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($dir . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach ($files as $file) {
					if ( file_exists($root . $dir . $file) && $file !== '.' && $file !== '..' && !is_dir($root . $dir . $file)) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($dir . $file) . "\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";
			}
		}

		} else {
			echo '- Error -';
		}
	}

	public function autopreview() {
	}

	public function upload() {
	}

	public function media() {
	}

	public function formpost() {
	}

	public function sortable() {
	}

	public function clickevents() {
	}

	public function cascading_dropdowns() {
	}

	public function datepicker() {
	}

	public function maxlength() {
	}

	/**
	 * JqueryExamplesController::ajaxpost_ajax()
	 *
	 * @return void
	 */
	public function ajaxpost_ajax() {
		$this->autoRender = false;

		if ($this->RequestHandler->isPost() && $this->request->is('ajax')) {
			$ajax = 'Here it is...<br><br>';

			if (!empty($this->request->data['JqueryExample']['text'])) {
				$ajax .= '<b>Text:</b> ' . Sanitize::html($this->request->data['JqueryExample']['text']) . '<br>';
			}
			if (!empty($this->request->data['JqueryExample']['comment'])) {
				$ajax .= '<b>Comment:</b> ' . Sanitize::html($this->request->data['JqueryExample']['comment']) . '<br>';
			}

			$ajax .= 'Thats the time: ' . date('Y-m-d H:i:s') . '<br><br>- - - End of Ajax Request - - -';
			echo $ajax;
		}
	}

	/**
	 * JqueryExamplesController::formpost_ajax()
	 *
	 * @return void
	 */
	public function formpost_ajax() {
		$this->autoRender = false;

		if ($this->RequestHandler->isPost() && $this->request->is('ajax')) {
			$ajax = '';

			if (!empty($this->request->data['JqueryExample']['name'])) {
				$ajax .= '<b>Name:</b> ' . Sanitize::html($this->request->data['JqueryExample']['name']) . '<br>';
			}
			if (!empty($this->request->data['JqueryExample']['post'])) {
				$ajax .= '<b>Post:</b> ' . Sanitize::html($this->request->data['JqueryExample']['post']) . '<br>';
			}
			echo $ajax;
			echo '<br>NOW: <b>' . date('Y-m-d H:i:s') . '</b> - a random number: <b>' . mt_rand(5, 15) . '</b> - just for fun...';
		}
	}

	/**
	 * JqueryExamplesController::sortable_ajax()
	 *
	 * @return void
	 */
	public function sortable_ajax() {
		echo 'this is the "sortable_ajax()" function returning the following content:<br>';
		echo '<pre>'; print_r($this->request->query('table-3')); echo '</pre>';

		echo 'Could be saved in the DB now (would be better to transmit it as a POST, instead of GET)';
		$this->autoRender = false;
	}

}

