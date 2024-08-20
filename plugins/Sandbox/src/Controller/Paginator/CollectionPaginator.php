<?php

namespace Sandbox\Controller\Paginator;
use Cake\Collection\CollectionInterface;
use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\Paging\PaginatedInterface;
use Cake\Datasource\Paging\PaginatedResultSet;
use Cake\Datasource\Paging\PaginatorInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Datasource\ResultSetInterface;

class CollectionPaginator implements PaginatorInterface
{
	use InstanceConfigTrait;

	protected array $query;

	/**
	 * Default pagination settings.
	 *
	 * When calling paginate() these settings will be merged with the configuration
	 * you provide.
	 *
	 * - `maxLimit` - The maximum limit users can choose to view. Defaults to 100
	 * - `limit` - The initial number of items per page. Defaults to 20.
	 * - `page` - The starting page, defaults to 1.
	 * - `allowedParameters` - A list of parameters users are allowed to set using request
	 *   parameters. Modifying this list will allow users to have more influence
	 *   over pagination, be careful with what you permit.
	 * - `sortableFields` - A list of fields which can be used for sorting. By
	 *   default all table columns can be used for sorting. You can use this option
	 *   to restrict sorting only by particular fields. If you want to allow
	 *   sorting on either associated columns or calculated fields then you will
	 *   have to explicity specify them (along with other fields). Using an empty
	 *   array will disable sorting alltogether.
	 * - `finder` - The table finder to use. Defaults to `all`.
	 * - `scope` - If specified this scope will be used to get the paging options
	 *   from the query params passed to paginate(). Scopes allow namespacing the
	 *   paging options and allows paginating multiple models in the same action.
	 *   Default `null`.
	 *
	 * @var array<string, mixed>
	 */
	protected array $_defaultConfig = [
		'page' => 1,
		'limit' => 20,
		'maxLimit' => 100,
		'allowedParameters' => ['limit', 'page'],
	];

	/**
	 * Calculated paging params.
	 *
	 * @var array
	 */
	protected array $pagingParams = [
		'limit' => null,
		'count' => null,
		'totalCount' => null,
		'perPage' => null,
		'pageCount' => null,
		'currentPage' => null,
		'requestedPage' => null,
		'start' => null,
		'end' => null,
		'hasPrevPage' => null,
		'hasNextPage' => null,
	];

	public function __construct($query) {
		$this->query = $query;
	}

	public function paginate(
		mixed $collection,
		array $params = [],
		array $settings = []
	): PaginatedInterface {
		$data = $this->extractData($collection, $params, $settings);
		$pagingParams = $this->buildParams($data);

		return $this->buildPaginated($collection, $pagingParams);
	}


	/**
	 * Extract pagination data needed
	 *
	 * @param \Cake\Datasource\RepositoryInterface $collection The repository object.
	 * @param array<string, mixed> $params Request params
	 * @param array<string, mixed> $settings The settings/configuration used for pagination.
	 *
	 * @return array
	 */
	protected function extractData(CollectionInterface $collection, array $params, array $settings): array
	{
		$defaults = $this->getDefaults($settings);

		$options = $defaults;
		$params = $this->query + $params;
		$options = $this->mergeOptions($params, $defaults);
		$options = $this->checkLimit($options);

		$options['page'] = max((int)$options['page'], 1);

		return compact('defaults', 'options');
	}

	/**
	 * Merges the various options that Paginator uses.
	 * Pulls settings together from the following places:
	 *
	 * - General pagination settings
	 * - Model specific settings.
	 * - Request parameters
	 *
	 * The result of this method is the aggregate of all the option sets
	 * combined together. You can change config value `allowedParameters` to modify
	 * which options/values can be set using request parameters.
	 *
	 * @param array<string, mixed> $params Request params.
	 * @param array $settings The settings to merge with the request data.
	 * @return array<string, mixed> Array of merged options.
	 */
	protected function mergeOptions(array $params, array $settings): array
	{
		$params = array_intersect_key($params, array_flip($this->getConfig('allowedParameters')));

		return array_merge($settings, $params);
	}

	/**
	 * Check the limit parameter and ensure it's within the maxLimit bounds.
	 *
	 * @param array<string, mixed> $options An array of options with a limit key to be checked.
	 * @return array<string, mixed> An array of options for pagination.
	 */
	protected function checkLimit(array $options): array
	{
		$options['limit'] = (int)$options['limit'];
		if ($options['limit'] < 1) {
			$options['limit'] = 1;
		}
		$options['limit'] = max(min($options['limit'], $options['maxLimit']), 1);

		return $options;
	}

	/**
	 * Get the settings for a $model. If there are no settings for a specific
	 * repository, the general settings will be used.
	 *
	 * @param string $alias Model name to get settings for.
	 * @param array<string, mixed> $settings The settings which is used for combining.
	 * @return array<string, mixed> An array of pagination settings for a model,
	 *   or the general settings.
	 */
	protected function getDefaults(array $settings): array
	{
		$defaults = $this->getConfig();

		$maxLimit = $settings['maxLimit'] ?? $defaults['maxLimit'];
		$limit = $settings['limit'] ?? $defaults['limit'];

		if ($limit > $maxLimit) {
			$limit = $maxLimit;
		}

		$settings['maxLimit'] = $maxLimit;
		$settings['limit'] = $limit;

		return $settings + $defaults;
	}

	/**
	 * Build pagination params.
	 *
	 * @param array<string, mixed> $data Paginator data containing keys 'options',
	 *  'defaults', 'alias'.
	 * @return array<string, mixed> Paging params.
	 */
	protected function buildParams(array $data): array
	{
		$this->pagingParams = [
				'perPage' => $data['options']['limit'],
				'requestedPage' => $data['options']['page'],
			] + $this->pagingParams;

		$this->addPageCountParams($data);
		$this->addStartEndParams($data);
		$this->addPrevNextParams($data);

		$this->pagingParams['limit'] = $data['defaults']['limit'] != $data['options']['limit']
			? $data['options']['limit']
			: null;

		return $this->pagingParams;
	}

	/**
	 * Add "currentPage" and "pageCount" params.
	 *
	 * @param array $data Paginator data.
	 * @return void
	 */
	protected function addPageCountParams(array $data): void
	{
		$page = $data['options']['page'];
		$pageCount = null;

		if ($this->pagingParams['totalCount'] !== null) {
			$pageCount = max((int)ceil($this->pagingParams['totalCount'] / $this->pagingParams['perPage']), 1);
			$page = min($page, $pageCount);
		} elseif ($this->pagingParams['count'] === 0 && $this->pagingParams['requestedPage'] > 1) {
			$page = 1;
		}

		$this->pagingParams['currentPage'] = $page;
		$this->pagingParams['pageCount'] = $pageCount;
	}

	/**
	 * Add "start" and "end" params.
	 *
	 * @param array $data Paginator data.
	 * @return void
	 */
	protected function addStartEndParams(array $data): void
	{
		$start = $end = 0;

		if ($this->pagingParams['count'] > 0) {
			$start = (($this->pagingParams['currentPage'] - 1) * $this->pagingParams['perPage']) + 1;
			$end = $start + $this->pagingParams['count'] - 1;
		}

		$this->pagingParams['start'] = $start;
		$this->pagingParams['end'] = $end;
	}

	/**
	 * Add "prevPage" and "nextPage" params.
	 *
	 * @param array $data Paging data.
	 * @return void
	 */
	protected function addPrevNextParams(array $data): void
	{
		$this->pagingParams['hasPrevPage'] = $this->pagingParams['currentPage'] > 1;
		if ($this->pagingParams['totalCount'] === null) {
			$this->pagingParams['hasNextPage'] = true;
		} else {
			$this->pagingParams['hasNextPage'] = $this->pagingParams['totalCount']
				> $this->pagingParams['currentPage'] * $this->pagingParams['perPage'];
		}
	}

	/**
	 * Build paginated resultset.
	 *
	 * Since the query fetches an extra record, drop the last record if records
	 * fetched exceeds the limit/per page.
	 *
	 * @param \Cake\Datasource\ResultSetInterface $items
	 * @param array $pagingParams
	 * @return \Cake\Datasource\Paging\PaginatedInterface
	 */
	protected function buildPaginated(CollectionInterface $items, array $pagingParams): PaginatedInterface
	{
		if (count($items) > $this->pagingParams['perPage']) {
			$items = $items->take($this->pagingParams['perPage']);
		}

		return new PaginatedResultSet($items, $pagingParams);
	}
}
