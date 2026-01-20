<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * User DTO with typed _matchingData as a DTO (not array).
 */
readonly class UserWithMatchingDtoTyped {

	/**
	 * @param int $id User ID
	 * @param string $username Username
	 * @param string|null $email Email address
	 * @param \Cake\I18n\DateTime|null $created Created timestamp
	 * @param \App\Dto\MatchingDataDto|null $_matchingData Matching data from query
	 */
	public function __construct(
		public int $id,
		public string $username,
		public ?string $email = null,
		public ?DateTime $created = null,
		public ?MatchingDataDto $_matchingData = null,
	) {
	}

}
