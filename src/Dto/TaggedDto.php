<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * DTO for Tagged (_joinData pivot table).
 */
readonly class TaggedDto
{
    public function __construct(
        public int $id,
        public int $tag_id,
        public int $fk_id,
        public ?string $fk_model = null,
        public ?DateTime $created = null,
    ) {
    }
}
