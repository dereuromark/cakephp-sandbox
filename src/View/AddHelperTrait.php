<?php

namespace App\View;

use Cake\Core\Configure;
use Favorites\Utility\Config;

trait AddHelperTrait {

	/**
	 * @return void
	 */
	public function addHelpers(): void {
		$this->addHelper('Tools.Time', ['outputTimezone' => 'Europe/Berlin']);
		$this->addHelper('Tools.Text');

		$this->addHelper('CakeDecimal.Number');

		$this->addHelper('Data.Data');

		$this->addHelper('Form', (array)Configure::read('FormConfig'));
		$this->addHelper('Html');
		$this->addHelper('Tools.Url');

		$this->addHelper('Queue.Queue');
		$this->addHelper('Queue.QueueProgress');

		$this->addHelper('Search.Search');

		$this->addHelper('Markup.Highlighter', ['prefix' => '']);
		$this->addHelper('BootstrapUI.Paginator');

		$helpers = [
			'Tools.Common',
			'Flash.Flash',
			'Tools.Format',
			'Tools.Progress',
			'Tools.Meter',
			'Templating.Icon',
			'Templating.IconSnippet',
			'TinyAuth.AuthUser',
			'AssetCompress.AssetCompress',
			'Shim.Configure',
		];
		foreach ($helpers as $helper) {
			$this->addHelper($helper);
		}

		$this->addHelper('Favorites.Stars', ['strategy' => Config::STRATEGY_ACTION]);
		$this->addHelper('Favorites.Likes', ['strategy' => Config::STRATEGY_ACTION]);
		$this->addHelper('Favorites.Favorites', ['strategy' => Config::STRATEGY_ACTION]);
		$this->addHelper('Comments.Comments');
		$this->addHelper('QrCode.QrCode');
	}

}
