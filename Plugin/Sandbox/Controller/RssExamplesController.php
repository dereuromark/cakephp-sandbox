<?php
use Sandbox\Controller\SandboxAppController;

class RssExamplesController extends SandboxAppController {

	public $components = array(
		'RequestHandler' => array(
			'viewClassMap' => array(
				'rss' => 'Tools.Rss')));

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Main RSS example.
	 *
	 * @return void
	 */
	public function feed() {
		if (empty($this->request->params['ext']) || $this->request->params['ext'] !== 'rss') {
			throw new NotFoundException();
		}
		// This is only needed without the viewClassMap setting for RequestHandler
		//$this->viewClass = 'Tools.Rss';

		$this->News = ClassRegistry::init('Sandbox.NewsRecord');
		$news = $this->News->feed();

		$items = array();
		foreach ($news as $key => $val) {
			$content = nl2br(h($val['News']['content']));
			$link = array('action' => 'feedview', $val['News']['id']);
			$guidLink = array('action' => 'view', $val['News']['id']);;

			$items[] = array(
				'title' => $val['News']['title'],
				'link' => $link,
				'guid' => array('url' => $guidLink, '@isPermaLink' => 'true'),
				'description' => String::truncate($val['News']['content']),
				'dc:creator' => $val['User']['username'],
				'pubDate' => $val['News']['published'],
				'content:encoded' => $content
			);
		}

		$atomLink = array('action' => 'feed', 'ext' => 'rss');

		$channel = array(
			'title' => __('News/Updates') . '',
			'link' => '/',
			'atom:link' => array('@href' => $atomLink),
			'description' => __('Most recent news articles'),
			'language' => 'en-en',
			'image' => array(
				'url' => '/img/statics/logo_rss.png',
				'link' => '/'
			)
		);

		$data = array(
			'document' => array(
			),
			'channel' => $channel,
			'items' => $items
		);
		$this->set(array('channel' => $data, '_serialize' => 'channel'));
	}

	/**
	 * RssExamplesController::feedview()
	 *
	 * @param string $id
	 * @return void
	 */
	public function feedview($id = null) {
		if (!$id) {
			throw new NotFoundException();
		}
		$this->response->body('Example of web frontend for ' . $id);
		$this->autoRender = false;
	}

}

