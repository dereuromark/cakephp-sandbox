<?php
declare(strict_types=1);

namespace Sandbox\Model\Filter;

use Cake\ORM\Query\SelectQuery;
use Search\Model\Filter\FilterCollection;

class SandboxPostsCollection extends FilterCollection {

	/**
	 * @return void
	 */
	public function initialize(): void {
		$this
			->add('title', 'Search.Like', [
				'before' => true,
				'after' => true,
			])
			->add('tag', 'Search.Callback', [
				'callback' => function (SelectQuery $query, array $args, $filter) {
					if ($args['tag'] === '-1') {
						$query->find('untagged');
					} else {
						$query->find('tagged', ['slug' => $args['tag']]);
					}

					return true;
				},
			]);
	}

}
