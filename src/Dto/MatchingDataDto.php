<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * DTO for _matchingData structure.
 *
 * Property names must match association aliases used in matching().
 */
readonly class MatchingDataDto {

	/**
	 * @param \App\Dto\SimpleRoleDto|null $Roles Matching Roles data
	 */
	public function __construct(
		public ?SimpleRoleDto $Roles = null,
	) {
	}

}
