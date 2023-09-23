<?php

namespace Sandbox\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Tools\Model\Table\Table;

/**
 * @mixin \Ratings\Model\Behavior\RatableBehavior
 * @property \Tags\Model\Table\TaggedTable&\Cake\ORM\Association\HasMany $Tagged
 * @property \Tags\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @mixin \Tags\Model\Behavior\TagBehavior
 * @method \Sandbox\Model\Entity\SandboxPost get($primaryKey, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Sandbox\Model\Entity\SandboxPost newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost> deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 */
class SandboxPostsTable extends Table {

	/**
	 * @var array<mixed>
	 */
	public $actsAs = [
		'Tools.Slugged',
		'Search.Search',
		'Tags.Tag' => ['taggedCounter' => false],
	];

	/**
	 * @var array<mixed>
	 */
	public $validate = [
		'title' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true,
			],
		],
		'content' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true,
			],
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
				'callback' => function (SelectQuery $query, array $args, $manager) {
					if ($args['tag'] === '-1') {
						$query->find('untagged');
					} else {
						$query->find('tagged', slug: $args['tag']);
					}

					return true;
				},
			]);

		return $searchManager;
	}

}
