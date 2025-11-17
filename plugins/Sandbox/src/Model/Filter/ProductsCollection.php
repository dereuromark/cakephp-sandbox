<?php
declare(strict_types=1);

namespace Sandbox\Model\Filter;

use Cake\ORM\Query\SelectQuery;
use Search\Model\Filter\FilterCollection;

class ProductsCollection extends FilterCollection {

	/**
	 * @return void
	 */
	public function initialize(): void {
		$this
			->add('title', 'Search.Like', [
				'before' => true,
				'after' => true,
			])
			->add('price_max', 'Search.Callback', [
				'callback' => function (SelectQuery $query, array $args, $filter) {
					$min = isset($args['price_min']) ? (int)$args['price_min'] : 0;
					$max = isset($args['price_max']) ? (int)ceil((float)$args['price_max']) : 0;

					if (!$min && !$max || $max < $min) {
						return false;
					}

					return true;
				},
			])
			->add('price_min', 'Search.Callback', [
				'callback' => function (SelectQuery $query, array $args, $filter) {
					$min = isset($args['price_min']) ? (int)$args['price_min'] : 0;
					$max = isset($args['price_max']) ? (int)ceil((float)$args['price_max']) : 0;
					if (!$min && !$max || $max < $min) {
						return false;
					}

					$query->where(['price >=' => $min, 'price <=' => $max]);

					return true;
				},
			]);
	}

}
