<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Text;
use Feed\View\RssView;

class FeedExamplesController extends SandboxAppController {

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		return [RssView::class];
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
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return void
	 */
	public function feed() {
		if ($this->getRequest()->getParam('_ext') !== 'rss') {
			throw new NotFoundException('The URL requires .rss extension.');
		}
		// This is only needed without the viewClassMap setting for RequestHandler
		//$this->viewBuilder()->setClassName('Feed.Rss');

		$news = $this->_feedData();

		$items = [];
		foreach ($news as $key => $val) {
			$description = h($val['content']);
			// We render the content as mini-template to use helpers etc.
			$this->viewBuilder()->setVar('text', $description)->disableAutoLayout();
			// This is now HTML
			$content = $this->createView()->render('/element/feed/element');

			$link = ['action' => 'feedview', $val['id']];
			$guidLink = ['action' => 'view', $val['id']];

			$items[] = [
				'title' => $val['title'],
				'link' => $link,
				'guid' => ['url' => $guidLink, '@isPermaLink' => 'true'],
				'dc:creator' => $val['User']['username'],
				'pubDate' => $val['published'],
				'description' => Text::truncate($description, 200),
				'content:encoded' => $content,
			];
		}

		$atomLink = ['action' => 'feed', '_ext' => 'rss'];

		$channel = [
			'title' => __('News/Updates') . '',
			'link' => '/',
			'atom:link' => ['@href' => $atomLink],
			'description' => __('Most recent news articles'),
			'language' => 'en-en',
			'image' => [
				'url' => '/img/statics/logo_rss.png',
				'link' => '/',
			],
		];

		$data = [
			'document' => [],
			'channel' => $channel,
			'items' => $items,
		];
		$this->set(['channel' => $data]);
		$serialize = 'channel';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return array<mixed>
	 */
	protected function _feedData() {
		$content = <<<TXT
<u>Paragraph example text</u>

Another paragraph.
Two lines of it.
TXT;

		$records = [
			[
				'id' => 1,
				'title' => 'Foo',
				'content' => '<b>Bold text</b>',
				'published' => '2012-01-04 11:12:13',
			],
			[
				'id' => 2,
				'title' => 'Bar',
				'content' => '<i>Italic text X</b>',
				'published' => '2012-07-04 11:12:13',
			],
			[
				'id' => 3,
				'title' => 'Xxx',
				'content' => $content,
				'published' => '2012-07-08 11:12:13',
			],
		];

		$res = [];
		foreach ($records as $k => $v) {
			$v['User'] = [
				'username' => 'Some user',
			];
			$res[] = $v;
		}

		return $res;
	}

	/**
	 * @param string|null $id
	 *
	 * @throws \Cake\Http\Exception\NotFoundException
	 *
	 * @return \Cake\Http\Response
	 */
	public function feedview($id = null) {
		if (!$id) {
			throw new NotFoundException();
		}

		// Use a real template instead if needed
		return $this->response->withStringBody('Example of web page for feed element ' . $id);
	}

}
