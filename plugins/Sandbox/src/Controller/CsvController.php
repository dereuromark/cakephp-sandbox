<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Time;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 */
class CsvController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->components()->unload('RequestHandler');
		$this->loadComponent('RequestHandler', ['viewClassMap' => ['csv' => 'CsvView.Csv']]);

		$this->viewBuilder()->setHelpers(['Data.Data']);
	}

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
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function simple() {
		if ($this->getRequest()->getParam('_ext') !== 'csv') {
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

		if ($this->getRequest()->getParam('_ext') === 'csv') {
			Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');

			$_serialize = 'countries';
			$_null = '';
			$_header = ['Name', 'ISO2', 'ISO3', 'Modified'];
			$_extract = ['name', 'iso2', 'iso3', 'modified'];

			$this->set(compact('_serialize', '_header', '_extract', '_null'));
		}

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload('my-cool-country-list.csv');
		}
	}

}
