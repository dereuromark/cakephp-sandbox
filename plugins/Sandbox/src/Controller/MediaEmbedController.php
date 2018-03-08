<?php
namespace Sandbox\Controller;

use MediaEmbed\MediaEmbed;

class MediaEmbedController extends SandboxAppController {

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

}
