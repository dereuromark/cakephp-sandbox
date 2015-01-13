<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Text;

class FeedExamplesController extends SandboxAppController {

	public $components = array(
		'RequestHandler' => array(
			'viewClassMap' => array(
				'rss' => 'Feed.Rss')));

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

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
		if (empty($this->request->params['_ext']) || $this->request->params['_ext'] !== 'rss') {
			throw new NotFoundException();
		}
		// This is only needed without the viewClassMap setting for RequestHandler
		//$this->viewClass = 'Tools.Rss';

		$news = $this->_feedData();

		$items = array();
		foreach ($news as $key => $val) {
			$content = nl2br(h($val['content']));
			$link = array('action' => 'feedview', $val['id']);
			$guidLink = array('action' => 'view', $val['id']);

			$items[] = array(
				'title' => $val['title'],
				'link' => $link,
				'guid' => array('url' => $guidLink, '@isPermaLink' => 'true'),
				'description' => Text::truncate($val['content']),
				'dc:creator' => $val['User']['username'],
				'pubDate' => $val['published'],
				'content:encoded' => $content
			);
		}

		$atomLink = array('action' => 'feed', 'ext' => 'rss');

		$channel = array(
			'title' => __('News/Updates') . '', 'link' => '/',
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

	protected function _feedData() {
		$records = array(
			array(
				'id' => 1,
				'title' => 'Foo',
				'content' => '<b>Bold text</b>',
				'published' => '2012-01-04 11:12:13',
			),
			array(
				'id' => 2,
				'title' => 'Bar',
				'content' => '<i>Italic text</b>',
				'published' => '2012-07-04 11:12:13',
			),
		);
		$res = array();
		foreach ($records as $k => $v) {
			$v['User'] = array(
				'username' => 'Some user'
			);
			$res[] = $v;
		}
		return $res;
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
