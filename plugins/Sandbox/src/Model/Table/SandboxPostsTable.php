<?php
namespace Sandbox\Model\Table;

use Cake\ORM\Query;
use Tools\Model\Table\Table;

/**
 * @mixin \Ratings\Model\Behavior\RatableBehavior
 * @property \Tags\Model\Table\TaggedTable|\Cake\ORM\Association\HasMany $Tagged
 * @property \Tags\Model\Table\TagsTable|\Cake\ORM\Association\BelongsToMany $Tags
 * @mixin \Tags\Model\Behavior\TagBehavior
 * @method \Sandbox\Model\Entity\SandboxPost get($primaryKey, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost newEntity($data = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost[] newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost[] patchEntities($entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class SandboxPostsTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = [
		'Search.Search',
		'Tags.Tag' => ['taggedCounter' => false]
	];

	/**
	 * @var array
	 */
	public $validate = [
		'title' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
		'content' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
	];

	/**
	 * @return \Search\Manager
	 */
	public function searchManager() {
		$searchManager = $this->behaviors()->Search->searchManager();
		$searchManager
			->like('title', ['before' => true, 'after' => true])
			->callback('tag', [
				'callback' => function (Query $query, array $args, $manager) {
					if ($args['tag'] === '-1') {
						$query->find('untagged');
					} else {
						$query->find('tagged', $args);
					}

					return true;
				}
			]);

		return $searchManager;
	}

}
