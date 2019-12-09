<?php

namespace Sandbox\Controller;

use MediaEmbed\MediaEmbed;

class MediaEmbedController extends SandboxAppController {

	/**
	 * @var string|false
	 */
	public $modelClass = false;

	/**
	 * @var array
	 */
	public $helpers = ['Gourmet/KnpMenu.Menu'];

	/**
	 * @return void
	 */
	public function index() {
		if ($this->request->is('post')) {
			$url = $this->request->getData('url');
			if ($url) {
				$mediaEmbed = new MediaEmbed();
				$mediaObject = $mediaEmbed->parseUrl($url);

				if (!$mediaObject) {
					$this->Flash->error('Could not parse URL');
				}

				$this->set(compact('mediaObject'));
			}
		}
	}

	/**
	 * @return void
	 */
	public function bbcode() {
		if ($this->request->is('post')) {
			$bbcode = $this->request->getData('bbcode');

			$this->set(compact('bbcode'));
		}

		$bbcodeExample = '[video=youtube]Jh7oFiMVCZM[/video]';

		$this->set(compact('bbcodeExample'));
	}

	/**
	 * @return void
	 */
	public function hosts() {
		$mediaEmbed = new MediaEmbed();
		$hosts = $mediaEmbed->getHosts();

		$this->set(compact('hosts'));
	}

}
