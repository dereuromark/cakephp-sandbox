<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\ORM\Attribute\CollectionOf;

/**
 * Simple readonly DTO for Role using DtoMapper.
 */
readonly class SimpleRoleDto {

	/**
     * @param int $id
     * @param string $name
     * @param array<SimpleUserDto> $users HasMany Users
     */
	public function __construct(
		public int $id,
		public string $name,
		#[CollectionOf(SimpleUserDto::class)]
		public array $users = [],
	) {
	}

}
