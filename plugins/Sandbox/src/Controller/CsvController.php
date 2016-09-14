<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;

class CsvController extends SandboxAppController {

	public $components = [
		'RequestHandler' => [
			'viewClassMap' => ['csv' => 'CsvView.Csv']
		]
	];

	public $helpers = ['Data.Data'];

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Simple CSV
	 *
	 * @return void
	 */
	public function simple() {
		if (empty($this->request->params['_ext'])) {
			throw new NotFoundException('We only want access via .csv extension, there is no normal view for it.');
		}

		$data = [
			['a', 'b', 'c'],
			[1, 2, 3],
			['you', 'and', 'me'],
		];

		$_serialize = 'data';
		$_enclosure = '"';
		$_newline = '\r\n';

		$this->set(compact('data', '_serialize', '_enclosure', '_newline'));
	}

	/**
	 * Pagination example with CSV export.
	 *
	 * @return void
	 */
	public function pagination() {
		$this->loadModel('Data.Countries');

		$countries = $this->paginate('Countries');

		// Just to showcase how nullable date(time)s work we remove the dates from the first row
		foreach ($countries as $country) {
			$country->iso2 = null;
			$country->modified = null;
			break;
		}

		$this->set(compact('countries'));

		if (!empty($this->request->params['_ext'])) {
			Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');

			$_serialize = 'countries';
			$_null = '';
			$_header = ['Name', 'ISO2', 'ISO3', 'Modified'];
			$_extract = ['name', 'iso2', 'iso3', 'modified'];

			$this->set(compact('_serialize', '_header', '_extract', '_null'));
		}

		if ($this->request->query('download')) {
			$this->response->download('my-cool-country-list.csv');
		}
	}

}
