<?php

namespace Sandbox\Controller;

use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Shim\Datasource\LegacyModelAwareTrait;

/**
 * @property \Sandbox\Model\Table\CountryRecordsTable $CountryRecords
 * @property \Search\Controller\Component\SearchComponent $Search
 */
#[\AllowDynamicProperties]
class SearchExamplesController extends SandboxAppController {

	use ModelAwareTrait;
	use LegacyModelAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Sandbox.CountryRecords';

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		if (!$this->request->getParam('_ext')) {
			return [];
		}

		return [JsonView::class, XmlView::class];
	}

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$config = [
			'actions' => ['table', 'range'],
		];
		if ($this->request->getParam('action') === 'range') {
			$config['modelClass'] = 'Sandbox.Products';
		}
		$this->loadComponent('Search.Search', $config);

		$this->viewBuilder()->addHelpers(['Data.Data']);

		if ($this->request->getParam('action') === 'range') {
			/** @var \Sandbox\Model\Entity\Product|null $minPrice */
			$minPrice = $this->fetchTable('Sandbox.Products')->find()->orderByAsc('price')->first();
			/** @var \Sandbox\Model\Entity\Product|null $maxPrice */
			$maxPrice = $this->fetchTable('Sandbox.Products')->find()->orderByDesc('price')->first();

			$callable = function ($value, array $params) use ($minPrice, $maxPrice): bool {
				$minValue = $minPrice ? (int)$minPrice->price : 0;
				$maxValue = $maxPrice ? (int)ceil((float)$maxPrice->price) : 0;

				if (!$minPrice && !$maxPrice) {
					return true;
				}
				if (empty($params['price_min']) || empty($params['price_max'])) {
					return true;
				}

				if ((string)$minValue === $params['price_min'] && (string)$maxValue === $params['price_max']) {
					return true;
				}

				return false;
			};
			$this->Search->setConfig('emptyValues', [
				'price_min' => $callable,
				'price_max' => $callable,
			]);
		}
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function table() {
		// Make sure we can download all at once if we want to
		$this->paginate['maxLimit'] = 999;

		$query = $this->CountryRecords->find('search', search: $this->request->getQuery());
		$countries = $this->paginate($query);

		$this->set(compact('countries'));
		$serialize = 'countries';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return void
	 */
	public function range() {
		$productsTable = $this->fetchTable('Sandbox.Products');

		$this->paginate['maxLimit'] = 10;

		/** @var \Sandbox\Model\Entity\Product|null $min */
		$min = $this->fetchTable('Sandbox.Products')->find()->orderByAsc('price')->first();
		/** @var \Sandbox\Model\Entity\Product|null $max */
		$max = $this->fetchTable('Sandbox.Products')->find()->orderByDesc('price')->first();

		// Trick to avoid it being counted as isSearch for default range
		$queryParams = $this->request->getQuery();
		if ($min && (int)$this->request->getQuery('price_min') === (int)$min->price && $max && (int)$this->request->getQuery('price_max') === (int)ceil((float)$max->price)) {
			unset($queryParams['price_min']);
			unset($queryParams['price_max']);
		}

		$query = $productsTable->find('search', search: $queryParams);
		$products = $this->paginate($query);

		$this->set(compact('products', 'min', 'max'));
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return void
	 */
	public function afterFilter(EventInterface $event): void {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}
	}

}
