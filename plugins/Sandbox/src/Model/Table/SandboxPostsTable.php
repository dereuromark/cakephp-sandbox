<?php

namespace Sandbox\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Tools\Model\Table\Table;

/**
 * @mixin \Ratings\Model\Behavior\RatableBehavior !
 * @property \Tags\Model\Table\TaggedTable&\Cake\ORM\Association\HasMany $Tagged
 * @property \Tags\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @mixin \Tags\Model\Behavior\TagBehavior
 * @method \Sandbox\Model\Entity\SandboxPost get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxPost newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \Sandbox\Model\Entity\SandboxPost newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxPost> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Tools\Model\Behavior\SluggedBehavior
 * @extends \Tools\Model\Table\Table<array{Search: \Search\Model\Behavior\SearchBehavior, Slugged: \Tools\Model\Behavior\SluggedBehavior, Tag: \Tags\Model\Behavior\TagBehavior}>
 */
class SandboxPostsTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tools.Slugged');
		$this->addBehavior('Search.Search');
		$this->addBehavior('Tags.Tag', ['taggedCounter' => false]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(\Cake\Validation\Validator $validator): \Cake\Validation\Validator {
		$validator
			->requirePresence('title', 'create')
			->notBlank('title', 'Mandatory');

		$validator
			->requirePresence('content', 'create')
			->notBlank('content', 'Mandatory');

		return $validator;
	}

	/**
	 * @return \Search\Manager
	 */
	public function searchManager() {
		/** @var \Search\Manager $searchManager */
		$searchManager = $this->behaviors()->Search->searchManager();
		$searchManager
			->like('title', ['before' => true, 'after' => true])
			->callback('tag', [
				'callback' => function (SelectQuery $query, array $args, $manager) {
					if ($args['tag'] === '-1') {
						$query->find('untagged');
					} else {
						$query->find('tagged', ['slug' => $args['tag']]);
					}

					return true;
				},
			]);

		return $searchManager;
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function ensureDemoData(): void {
		$hasRecords = (bool)$this->find()->where(['title' => 'Awesome Post'])->first();
		if ($hasRecords) {
			return;
		}

		$posts = [
			[
				'title' => 'Awesome Post',
				'content' => '...',
				'tag_list' => 'Shiny, New, Interesting',
			],
			[
				'title' => 'Fun Story',
				'content' => '...',
				'tag_list' => 'Hip, Motivating',
			],
			[
				'title' => 'Older Post',
				'content' => '...',
				'tag_list' => 'Detailed, Legacy, Motivating, Long',
			],
			[
				'title' => 'Just a Post',
				'content' => '...',
			],
		];

		$postEntities = $this->newEntities($posts);

		$this->saveManyOrFail($postEntities);
	}

}
