<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\PostDto;
use App\Dto\SimpleRoleDto;
use App\Dto\SimpleUserDto;
use App\Dto\UserProjectionDto;
use App\Dto\UserWithMatchingDto;
use App\Dto\UserWithMatchingDtoTyped;

/**
 * DtoProjectionController
 *
 * Demonstrates the projectAs() feature for projecting ORM results into DTOs.
 */
class DtoProjectionController extends AppController {

    /**
     * Basic DTO projection - Users with BelongsTo Role.
     *
     * Shows:
     * - Simple projectAs() usage
     * - BelongsTo association hydrated into nested DTO
     *
     * @return void
     */
    public function index(): void {
        $usersTable = $this->fetchTable('Users');

        // Traditional Entity approach
        $entities = $usersTable->find()
            ->contain(['Roles'])
            ->limit(5)
            ->toArray();

        // DTO projection using DtoMapper (reflection-based)
        $dtosSimple = $usersTable->find()
            ->contain(['Roles'])
            ->limit(5)
            ->projectAs(SimpleUserDto::class)
            ->toArray();

        // DTO projection using cakephp-dto plugin (createFromArray)
        $dtosPlugin = $usersTable->find()
            ->contain(['Roles'])
            ->limit(5)
            ->projectAs(UserProjectionDto::class)
            ->toArray();

        $this->set(compact('entities', 'dtosSimple', 'dtosPlugin'));
    }

    /**
     * HasMany association demo - Roles with Users.
     *
     * Shows:
     * - HasMany collection hydrated using #[CollectionOf] attribute
     *
     * @return void
     */
    public function hasMany(): void {
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
     * Shows:
     * - BelongsToMany association
     * - _joinData (pivot table data) hydrated into nested DTO
     *
     * @return void
     */
    public function belongsToMany(): void {
        $postsTable = $this->fetchTable('Sandbox.SandboxPosts');

        // Ensure demo data exists
        $postsTable->ensureDemoData();

        // Traditional Entities with Tags
        $entities = $postsTable->find()
            ->contain(['Tags'])
            ->limit(3)
            ->toArray();

        // DTO projection with BelongsToMany
        // Note: _joinData is automatically hydrated into TagDto->_joinData
        $dtos = $postsTable->find()
            ->contain(['Tags'])
            ->limit(3)
            ->projectAs(PostDto::class)
            ->toArray();

        $this->set(compact('entities', 'dtos'));
    }

    /**
     * Matching query demo - Users matching specific Role.
     *
     * Shows:
     * - matching() finder with _matchingData
     * - How matched association data appears in DTOs
     * - DTO without _matchingData vs DTO with _matchingData
     *
     * @return void
     */
    public function matching(): void {
        $usersTable = $this->fetchTable('Users');

        // Traditional Entity with matching
        $entities = $usersTable->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.id' => 1]);
            })
            ->limit(5)
            ->toArray();

        // DTO projection WITHOUT _matchingData property
        // The _matchingData from the query is ignored (not in DTO constructor)
        $dtosWithout = $usersTable->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.id' => 1]);
            })
            ->limit(5)
            ->projectAs(SimpleUserDto::class)
            ->toArray();

        // DTO projection WITH _matchingData as array
        // The _matchingData is included because UserWithMatchingDto has the property
        $dtosWithArray = $usersTable->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.id' => 1]);
            })
            ->limit(5)
            ->projectAs(UserWithMatchingDto::class)
            ->toArray();

        // DTO projection WITH _matchingData as typed DTO
        // The _matchingData is recursively mapped to MatchingDataDto->SimpleRoleDto
        $dtosWithTyped = $usersTable->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.id' => 1]);
            })
            ->limit(5)
            ->projectAs(UserWithMatchingDtoTyped::class)
            ->toArray();

        // Get raw array to show _matchingData structure
        $rawArrays = $usersTable->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.id' => 1]);
            })
            ->limit(5)
            ->disableHydration()
            ->toArray();

        $this->set(compact('entities', 'dtosWithout', 'dtosWithArray', 'dtosWithTyped', 'rawArrays'));
    }

    /**
     * Performance comparison demo.
     *
     * Shows memory and time comparison between:
     * - Entities
     * - DTOs via DtoMapper
     * - DTOs via cakephp-dto plugin
     * - Plain arrays
     *
     * @return void
     */
    public function benchmark(): void {
        $usersTable = $this->fetchTable('Users');

        $iterations = 100;
        $results = [];

        // Entities
        gc_collect_cycles();
        $start = hrtime(true);
        $memBefore = memory_get_usage();
        for ($i = 0; $i < $iterations; $i++) {
            $usersTable->find()->contain(['Roles'])->limit(50)->toArray();
        }
        $results['Entity'] = [
            'time' => (hrtime(true) - $start) / 1_000_000,
            'memory' => memory_get_usage() - $memBefore,
        ];

        // SimpleUserDto (DtoMapper)
        gc_collect_cycles();
        $start = hrtime(true);
        $memBefore = memory_get_usage();
        for ($i = 0; $i < $iterations; $i++) {
            $usersTable->find()->contain(['Roles'])->limit(50)->projectAs(SimpleUserDto::class)->toArray();
        }
        $results['DtoMapper'] = [
            'time' => (hrtime(true) - $start) / 1_000_000,
            'memory' => memory_get_usage() - $memBefore,
        ];

        // UserProjectionDto (cakephp-dto plugin)
        gc_collect_cycles();
        $start = hrtime(true);
        $memBefore = memory_get_usage();
        for ($i = 0; $i < $iterations; $i++) {
            $usersTable->find()->contain(['Roles'])->limit(50)->projectAs(UserProjectionDto::class)->toArray();
        }
        $results['cakephp-dto'] = [
            'time' => (hrtime(true) - $start) / 1_000_000,
            'memory' => memory_get_usage() - $memBefore,
        ];

        // Plain arrays
        gc_collect_cycles();
        $start = hrtime(true);
        $memBefore = memory_get_usage();
        for ($i = 0; $i < $iterations; $i++) {
            $usersTable->find()->contain(['Roles'])->limit(50)->enableHydration(false)->toArray();
        }
        $results['Array'] = [
            'time' => (hrtime(true) - $start) / 1_000_000,
            'memory' => memory_get_usage() - $memBefore,
        ];

        $this->set(compact('results', 'iterations'));
    }

}
