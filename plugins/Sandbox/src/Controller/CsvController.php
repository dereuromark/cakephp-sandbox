<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Time;
use CsvView\View\CsvView;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 */
class CsvController extends SandboxAppController {

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		return [CsvView::class];
	}

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['Data.Data']);
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
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return void
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

		$serialize = 'data';
		$enclosure = '"';
		$newline = '\r\n';

		$this->set(compact('data'));
		$this->viewBuilder()->setOptions(compact('serialize', 'enclosure', 'newline'));
	}

	/**
	 * Pagination example with CSV export.
	 *
	 * @return void
	 */
	public function pagination() {
		$Countries = $this->fetchTable('Data.Countries');

		$countries = $this->paginate($Countries);

		// Just to showcase how nullable date(time)s work we remove the dates from the first row
		foreach ($countries as $country) {
			$country->iso2 = null;
			$country->modified = null;

			break;
		}

		$this->set(compact('countries'));

		if ($this->getRequest()->getParam('_ext') === 'csv') {
			Time::setToStringFormat('yyyy-MM-dd HH:mm:ss');

			$serialize = 'countries';
			$null = '';
			$header = ['Name', 'ISO2', 'ISO3', 'Modified'];
			$extract = ['name', 'iso2', 'iso3', 'modified'];

			$this->viewBuilder()->setOptions(compact('serialize', 'header', 'extract', 'null'));
		}

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload('my-cool-country-list.csv');
		}
	}

}
