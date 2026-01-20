<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * User DTO that includes _matchingData from matching() queries.
 *
 * This demonstrates that _matchingData CAN be included in DTOs
 * if you explicitly add it as a property.
 */
readonly class UserWithMatchingDto {

	/**
     * @param int $id
     * @param string $username
     * @param string|null $email
     * @param \Cake\I18n\DateTime|null $created
     * @param array<string, \App\Dto\SimpleRoleDto>|null $_matchingData Matched association data
     */
	public function __construct(
		public int $id,
		public string $username,
		public ?string $email = null,
		public ?DateTime $created = null,
		public ?array $_matchingData = null,
	) {
	}

}
