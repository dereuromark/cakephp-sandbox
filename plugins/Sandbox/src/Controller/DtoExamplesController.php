<?php

namespace Sandbox\Controller;

use App\Dto\PostDto;
use App\Dto\SimpleRoleDto;
use App\Dto\SimpleUserDto;
use App\Dto\UserProjectionDto;
use App\Dto\UserWithMatchingDto;
use App\Dto\UserWithMatchingTypedDto;
use Cake\Core\Plugin;
use Cake\ORM\Query\SelectQuery;
use Sandbox\Dto\Github\PullRequestDto;

/**
 * @property \Data\Controller\Component\CountryStateHelperComponent $CountryStateHelper
 * @property \Data\Model\Table\CountriesTable $Countries
 * @property \Data\Model\Table\StatesTable $States
 * @property \App\Model\Table\UsersTable $Users
 */
class DtoExamplesController extends SandboxAppController {

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Using a demo PR from GitHub to show case DTOs' power.
	 *
	 * @return void
	 */
	public function github() {
		$file = Plugin::path('Sandbox') . 'files' . DS . 'Github' . DS . 'demo_pr.json';
		$simulatedDataFromGitHubApi = json_decode(file_get_contents($file) ?: '', true);

		$pullRequestDto = PullRequestDto::create($simulatedDataFromGitHubApi, true, PullRequestDto::TYPE_UNDERSCORED);

		$this->set(compact('pullRequestDto', 'file'));
	}

	/**
	 * Live demo of generator.
	 *
	 * @return void
	 */
	public function generator() {
		$demoFiles = [
			'simple-product' => [
				'label' => 'Simple Product (Example Data)',
				'file' => 'Demo' . DS . 'simple_product.json',
				'namespace' => 'Shop',
				'type' => 'data',
			],
			'user-schema' => [
				'label' => 'User (JSON Schema)',
				'file' => 'Demo' . DS . 'user_schema.json',
				'namespace' => 'Account',
				'type' => 'schema',
			],
			'github-pr' => [
				'label' => 'GitHub Pull Request API (Complex)',
				'file' => 'Github' . DS . 'demo_pr.json',
				'namespace' => 'Github',
				'type' => 'data',
			],
		];

		$demos = [];
		foreach ($demoFiles as $key => $demo) {
			$file = Plugin::path('Sandbox') . 'files' . DS . $demo['file'];
			$data = file_get_contents($file) ?: '';
			$demos[$key] = [
				'label' => $demo['label'],
				'data' => base64_encode((string)gzcompress($data)),
				'namespace' => $demo['namespace'],
				'type' => $demo['type'],
			];
		}

		$this->set(compact('demos'));
	}

	/**
	 * DTO projection - Users with BelongsTo Role.
	 *
	 * @return void
	 */
	public function projection(): void {
		$usersTable = $this->fetchTable('Users');

		// Traditional Entity approach
		$entities = $usersTable->find()
			->contain(['Roles'])
			->limit(5)
			->toArray();

		// DTO projection using cakephp-dto plugin (createFromArray)
		$dtos = $usersTable->find()
			->contain(['Roles'])
			->limit(5)
			->projectAs(UserProjectionDto::class)
			->toArray();

		$this->set(compact('entities', 'dtos'));
	}

	/**
	 * HasMany association demo - Roles with Users.
	 *
	 * @return void
	 */
	public function projectionHasMany(): void {
		$rolesTable = $this->fetchTable('Roles');

		// Traditional Entities
		$entities = $rolesTable->find()
			->contain(['Users'])
			->limit(3)
			->toArray();

		// DTO projection with HasMany
		$dtos = $rolesTable->find()
			->contain(['Users'])
			->limit(3)
			->projectAs(SimpleRoleDto::class)
			->toArray();

		$this->set(compact('entities', 'dtos'));
	}

	/**
	 * BelongsToMany with _joinData demo - Posts with Tags.
	 *
	 * @return void
	 */
	public function projectionBelongsToMany(): void {
		$postsTable = $this->fetchTable('Sandbox.SandboxPosts');

		// Ensure demo data exists
		$postsTable->ensureDemoData();

		// Traditional Entities with Tags
		$entities = $postsTable->find()
			->contain(['Tags'])
			->limit(3)
			->toArray();

		// DTO projection with BelongsToMany
		$dtos = $postsTable->find()
			->contain(['Tags'])
			->limit(3)
			->projectAs(PostDto::class)
			->toArray();

		$this->set(compact('entities', 'dtos'));
	}

	/**
	 * Performance benchmark comparing Entity vs DTO hydration.
	 *
	 * @return void
	 */
	public function benchmark(): void {
		$usersTable = $this->fetchTable('Users');
		$iterations = 100;

		// Warm up - ensure query is cached
		$usersTable->find()->contain(['Roles'])->limit(50)->toArray();

		// Benchmark Entity hydration
		$entityStart = microtime(true);
		$entityMemStart = memory_get_usage();
		for ($i = 0; $i < $iterations; $i++) {
			$entities = $usersTable->find()
				->contain(['Roles'])
				->limit(50)
				->toArray();
		}
		$entityTime = (microtime(true) - $entityStart) * 1000;
		$entityMem = memory_get_usage() - $entityMemStart;

		// Benchmark DTO projection
		$dtoStart = microtime(true);
		$dtoMemStart = memory_get_usage();
		for ($i = 0; $i < $iterations; $i++) {
			$dtos = $usersTable->find()
				->contain(['Roles'])
				->limit(50)
				->projectAs(UserProjectionDto::class)
				->toArray();
		}
		$dtoTime = (microtime(true) - $dtoStart) * 1000;
		$dtoMem = memory_get_usage() - $dtoMemStart;

		// Single iteration for detailed breakdown
		$singleEntityStart = microtime(true);
		$singleEntities = $usersTable->find()->contain(['Roles'])->limit(50)->toArray();
		$singleEntityTime = (microtime(true) - $singleEntityStart) * 1000;

		$singleDtoStart = microtime(true);
		$singleDtos = $usersTable->find()->contain(['Roles'])->limit(50)->projectAs(UserProjectionDto::class)->toArray();
		$singleDtoTime = (microtime(true) - $singleDtoStart) * 1000;

		$results = [
			'iterations' => $iterations,
			'recordCount' => count($entities ?? []),
			'entity' => [
				'totalMs' => round($entityTime, 2),
				'avgMs' => round($entityTime / $iterations, 4),
				'memoryKb' => round($entityMem / 1024, 2),
			],
			'dto' => [
				'totalMs' => round($dtoTime, 2),
				'avgMs' => round($dtoTime / $iterations, 4),
				'memoryKb' => round($dtoMem / 1024, 2),
			],
			'single' => [
				'entityMs' => round($singleEntityTime, 4),
				'dtoMs' => round($singleDtoTime, 4),
				'diffMs' => round($singleDtoTime - $singleEntityTime, 4),
			],
		];

		$results['comparison'] = [
			'dtoPct' => round(($dtoTime / $entityTime) * 100, 1),
			'overheadMs' => round(($dtoTime - $entityTime) / $iterations, 4),
		];

		$this->set(compact('results', 'entities', 'dtos'));
	}

	/**
	 * Matching query demo - Users matching specific Role.
	 *
	 * @return void
	 */
	public function projectionMatching(): void {
		$usersTable = $this->fetchTable('Users');

		// Traditional Entity with matching
		$entities = $usersTable->find()
			->matching('Roles', function (SelectQuery $q) {
				return $q->where(['Roles.id' => 1]);
			})
			->limit(5)
			->toArray();

		// DTO projection WITHOUT _matchingData property
		$dtosWithout = $usersTable->find()
			->matching('Roles', function (SelectQuery $q) {
				return $q->where(['Roles.id' => 1]);
			})
			->limit(5)
			->projectAs(SimpleUserDto::class)
			->toArray();

		// DTO projection WITH _matchingData as array
		$dtosWithArray = $usersTable->find()
			->matching('Roles', function (SelectQuery $q) {
				return $q->where(['Roles.id' => 1]);
			})
			->limit(5)
			->projectAs(UserWithMatchingDto::class)
			->toArray();

		// DTO projection WITH _matchingData as typed DTO
		$dtosWithTyped = $usersTable->find()
			->matching('Roles', function (SelectQuery $q) {
				return $q->where(['Roles.id' => 1]);
			})
			->limit(5)
			->projectAs(UserWithMatchingTypedDto::class)
			->toArray();

		$this->set(compact('entities', 'dtosWithout', 'dtosWithArray', 'dtosWithTyped'));
	}

}
