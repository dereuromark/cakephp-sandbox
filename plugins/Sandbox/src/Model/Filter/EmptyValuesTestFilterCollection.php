<?php

namespace Sandbox\Model\Filter;

use Cake\ORM\Query\SelectQuery;
use Search\Model\Filter\FilterCollection;

class EmptyValuesTestFilterCollection extends FilterCollection {

	/**
	 * @return void
	 */
	public function initialize(): void {
		$this->callback('has_phone_code', [
				'callback' => function (SelectQuery $query, array $args, $manager) {
					$hasPhoneCode = (bool)$args['has_phone_code'];
					if ($hasPhoneCode) {
						$query->where(['phone_code IS NOT' => null]);
					} else {
						$query->where(['phone_code IS' => null]);
					}
				},
			])
			->like('phone_code');
	}

}
