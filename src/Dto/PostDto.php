<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\ORM\Attribute\CollectionOf;

/**
 * DTO for SandboxPosts with BelongsToMany Tags.
 */
readonly class PostDto
{
    /**
     * @param int $id
     * @param string $title
     * @param string|null $content
     * @param string|null $slug
     * @param array<TagDto> $tags BelongsToMany Tags (each has _joinData)
     */
    public function __construct(
        public int $id,
        public string $title,
        public ?string $content = null,
        public ?string $slug = null,
        #[CollectionOf(TagDto::class)]
        public array $tags = [],
    ) {
    }
}
