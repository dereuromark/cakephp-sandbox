<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * Simple readonly DTO for User using DtoMapper.
 */
readonly class SimpleUserDto {

	/**
	 * @param int $id User ID
	 * @param string $username Username
	 * @param string|null $email Email address
	 * @param \App\Dto\SimpleRoleDto|null $role Associated role
	 * @param \Cake\I18n\DateTime|null $created Created timestamp
	 */
	public function __construct(
		public int $id,
		public string $username,
		public ?string $email = null,
		public ?SimpleRoleDto $role = null,
		public ?DateTime $created = null,
	) {
	}

}
