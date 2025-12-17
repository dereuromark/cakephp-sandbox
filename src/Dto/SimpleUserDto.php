<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * Simple readonly DTO for User using DtoMapper.
 */
readonly class SimpleUserDto
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $email = null,
        public ?SimpleRoleDto $role = null,
        public ?DateTime $created = null,
    ) {
    }
}
