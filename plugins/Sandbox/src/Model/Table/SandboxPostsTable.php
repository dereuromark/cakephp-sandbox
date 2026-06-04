<?php

namespace Sandbox\Model\Table;

use Cake\Validation\Validator;
use Sandbox\Model\Filter\SandboxPostsCollection;
use Tools\Model\Table\Table;

/**
 * @extends \Tools\Model\Table\Table<array{Search: \Search\Model\Behavior\SearchBehavior, Slugged: \Tools\Model\Behavior\SluggedBehavior, Tag: \Tags\Model\Behavior\TagBehavior}, \Sandbox\Model\Entity\SandboxPost>
 * @property \Tags\Model\Table\TaggedTable&\Cake\ORM\Association\HasMany $Tagged
 * @property \Tags\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @method \Sandbox\Model\Entity\SandboxPost newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxPost newEntity(array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> newEntities(array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxPost> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxPost findOrCreate(\Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxPost>|callable|array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost patchEntity(\Sandbox\Model\Entity\SandboxPost $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxPost> patchEntities(iterable<\Sandbox\Model\Entity\SandboxPost> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|false save(\Sandbox\Model\Entity\SandboxPost $entity, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost saveOrFail(\Sandbox\Model\Entity\SandboxPost $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxPost>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxPost> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxPost> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxPost> $entities, array<string, mixed> $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxPost $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxPost $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxPost>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxPost> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxPost> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxPost> $entities, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxPost|array<\Sandbox\Model\Entity\SandboxPost> loadInto(\Sandbox\Model\Entity\SandboxPost|array<\Sandbox\Model\Entity\SandboxPost> $entities, array<mixed> $contain)
 * @mixin \Ratings\Model\Behavior\RatableBehavior !
 * @mixin \Tags\Model\Behavior\TagBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @mixin \Tools\Model\Behavior\SluggedBehavior
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
		$this->addBehavior('Search.Search', [
			'collectionClass' => SandboxPostsCollection::class,
		]);
		$this->addBehavior('Tags.Tag', ['taggedCounter' => false]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->requirePresence('title', 'create')
			->notBlank('title', 'Mandatory');

		$validator
			->requirePresence('content', 'create')
			->notBlank('content', 'Mandatory');

		return $validator;
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
