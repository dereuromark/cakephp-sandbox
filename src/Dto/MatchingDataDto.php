<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * DTO for _matchingData structure.
 *
 * Property names must match association aliases used in matching().
 */
readonly class MatchingDataDto
{
    public function __construct(
        public ?SimpleRoleDto $Roles = null,
    ) {
    }
}
