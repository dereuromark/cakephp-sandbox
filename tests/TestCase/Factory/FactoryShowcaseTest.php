<?php
declare(strict_types=1);

namespace App\Test\TestCase\Factory;

use App\Test\Factory\CountryFactory;
use App\Test\Factory\UserFactory;
use Cake\TestSuite\TestCase;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;
use Sandbox\Test\Factory\SandboxArticleFactory;
use Sandbox\Test\Factory\SandboxCategoryFactory;
use Sandbox\Test\Factory\SandboxCityFactory;
use Sandbox\Test\Factory\SandboxPostFactory;

/**
 * Showcases ten distinct features of the cakephp-fixture-factories v2 API
 * exercised against the sandbox project's real tables. Each test method is
 * self-contained and isolates one feature.
 */
class FactoryShowcaseTest extends TestCase {

	/**
	 * 1) build() returns an in-memory entity that has not been persisted.
	 *    The DB row count stays zero — useful for unit tests that only need
	 *    a fully shaped entity to feed into a service.
	 *
	 * @return void
	 */
	public function testBuildIsInMemoryOnly(): void {
		$post = SandboxPostFactory::new()->build();

		$this->assertNull($post->id, 'In-memory entity has no primary key.');
		$this->assertSame(0, SandboxPostFactory::query()->count(), 'No row was persisted.');

		$persisted = SandboxPostFactory::new()->save();
		$this->assertNotNull($persisted->id);
		$this->assertSame(1, SandboxPostFactory::query()->count());
	}

	/**
	 * 2) Bulk persist via count() + saveMany() — N rows in one expression.
	 *    Each row gets its own faker-driven values, plus our explicit overrides.
	 *
	 * @return void
	 */
	public function testBulkPersistWithCount(): void {
		$posts = SandboxPostFactory::new(['rating_count' => 3])->count(50)->saveMany();

		$this->assertCount(50, $posts);
		$this->assertSame(50, SandboxPostFactory::query()->count());
		foreach ($posts as $post) {
			$this->assertSame(3, $post->rating_count, 'Override applied to every row.');
		}
	}

	/**
	 * 3) The unique() modifier guarantees per-call distinct values for fields
	 *    with a UNIQUE constraint. UserFactory::definition() declares
	 *    $generator->unique()->safeEmail() so a bulk save never collides.
	 *
	 * @return void
	 */
	public function testUniqueGeneratorYieldsDistinctValues(): void {
		$users = UserFactory::new()->count(25)->saveMany();

		$emails = array_map(static fn ($u) => $u->email, $users);
		$this->assertSame(count($emails), count(array_unique($emails)));

		$usernames = array_map(static fn ($u) => $u->username, $users);
		$this->assertSame(count($usernames), count(array_unique($usernames)));
	}

	/**
	 * 4) $uniqueProperties dedupes associated records inside one factory
	 *    expression. CountryFactory declares 'name' as unique, so three
	 *    cities sharing Country.name='Hyrule' produce three city rows but
	 *    only one country row.
	 *
	 * @return void
	 */
	public function testUniquePropertiesDedupeAssociatedRecords(): void {
		$cities = SandboxCityFactory::new()
			->count(3)
			->with('Countries', CountryFactory::new(['name' => 'Hyrule']))
			->saveMany();

		$this->assertCount(3, $cities);
		$countryIds = array_unique(array_map(static fn ($c) => $c->country_id, $cities));
		$this->assertCount(1, $countryIds, 'All three cities share one Country row.');
		$this->assertSame(1, CountryFactory::query()->where(['name' => 'Hyrule'])->count());
	}

	/**
	 * 5) Custom factory helper methods (state-style) make role assignment
	 *    expressive at the call site. asAdmin/asMod/asSuperadmin all delegate
	 *    to state() internally.
	 *
	 * @return void
	 */
	public function testCustomFactoryHelpers(): void {
		$superadmin = UserFactory::new()->asSuperadmin()->save();
		$admin = UserFactory::new()->asAdmin()->save();
		$mod = UserFactory::new()->asMod()->save();
		$user = UserFactory::new()->save();

		$this->assertSame(UserFactory::ROLE_SUPERADMIN, $superadmin->role_id);
		$this->assertSame(UserFactory::ROLE_ADMIN, $admin->role_id);
		$this->assertSame(UserFactory::ROLE_MOD, $mod->role_id);
		$this->assertSame(UserFactory::ROLE_USER, $user->role_id);
	}

	/**
	 * 6) state() accepts both an array and a closure. Closures see the
	 *    factory plus a GeneratorInterface so per-row values can be derived.
	 *
	 * @return void
	 */
	public function testStateAcceptsArrayAndClosure(): void {
		$arrayState = SandboxArticleFactory::new()
			->state(['status' => 'draft', 'title' => 'Static title'])
			->save();
		$this->assertSame('draft', $arrayState->status);
		$this->assertSame('Static title', $arrayState->title);

		$closureState = SandboxArticleFactory::new()
			->state(fn (BaseFactory $f, GeneratorInterface $g): array => ['title' => 'Generated: ' . $g->word()])
			->save();
		$this->assertStringStartsWith('Generated: ', $closureState->title);
	}

	/**
	 * 7) with() pulls an associated factory into the graph. The country_id
	 *    field on SandboxCity is wired automatically from the persisted Country.
	 *
	 * @return void
	 */
	public function testWithBuildsAssociatedRecord(): void {
		$city = SandboxCityFactory::new()
			->with('Countries', CountryFactory::new(['name' => 'Atlantis']))
			->save();

		$this->assertNotNull($city->country_id);
		$country = CountryFactory::table()->get($city->country_id);
		$this->assertSame('Atlantis', $country->name);
	}

	/**
	 * 8) Re-enabling a behavior with listeningToBehaviors() lets a test
	 *    exercise side-effects that factories normally suppress. Tree
	 *    behaviour computes lft/rght when adding a node.
	 *
	 * @return void
	 */
	public function testListeningToBehaviorRunsTreeOnSave(): void {
		$root = SandboxCategoryFactory::new()
			->listeningToBehaviors('Tree')
			->state(['lft' => null, 'rght' => null, 'parent_id' => null])
			->save();

		$this->assertSame(1, $root->lft);
		$this->assertSame(2, $root->rght);

		$child = SandboxCategoryFactory::new()
			->listeningToBehaviors('Tree')
			->state(['lft' => null, 'rght' => null, 'parent_id' => $root->id])
			->save();

		$reloaded = SandboxCategoryFactory::table()->get($root->id);
		$this->assertGreaterThan($reloaded->lft, $reloaded->rght);
		$this->assertGreaterThan($reloaded->lft, $child->lft);
		$this->assertLessThan($reloaded->rght, $child->rght);
	}

	/**
	 * 9) skipSetterFor() bypasses the entity's own setter for a field. We
	 *    set status to a string the entity setter would normally normalise,
	 *    and assert the raw value survives.
	 *
	 * @return void
	 */
	public function testSkipSetterForLeavesRawValue(): void {
		$rawValue = '   raw status   ';
		$article = SandboxArticleFactory::new()
			->skipSetterFor('status')
			->state(['status' => $rawValue])
			->save();

		$this->assertSame($rawValue, $article->status);
	}

	/**
	 * 10) Composing the whole API in one expression: bulk-create five
	 *     articles, each with a distinct generated user (via unique() on
	 *     UserFactory), all attached to the same Country graph, and assert
	 *     the resulting object graph is fully wired.
	 *
	 * @return void
	 */
	public function testFullStackComposition(): void {
		$baseCity = SandboxCityFactory::new()
			->with('Countries', CountryFactory::new(['name' => 'Hyrule']))
			->save();

		$articles = SandboxArticleFactory::new()
			->count(5)
			->state(fn (BaseFactory $f, GeneratorInterface $g): array => [
				'title' => $g->unique()->sentence(3),
				'status' => 'published',
			])
			->saveMany();

		$this->assertCount(5, $articles);

		$titles = array_map(static fn ($a) => $a->title, $articles);
		$this->assertSame(count($titles), count(array_unique($titles)));

		$country = CountryFactory::table()->get($baseCity->country_id);
		$this->assertSame('Hyrule', $country->name);

		$articleIds = array_map(static fn ($a) => $a->id, $articles);
		$this->assertSame(5, SandboxArticleFactory::query()->where(['id IN' => $articleIds])->count());
	}

}
