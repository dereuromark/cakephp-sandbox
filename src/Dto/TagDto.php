<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * DTO for Tags with _joinData from BelongsToMany pivot.
 */
readonly class TagDto
{
    /**
     * @param int $id
     * @param string $label The tag label
     * @param string|null $slug
     * @param int|null $counter Usage counter
     * @param TaggedDto|null $_joinData Pivot table data from BelongsToMany
     */
    public function __construct(
        public int $id,
        public string $label,
        public ?string $slug = null,
        public ?int $counter = null,
        public ?TaggedDto $_joinData = null,
    ) {
    }
}
