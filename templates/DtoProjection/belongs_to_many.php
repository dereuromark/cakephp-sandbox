<?php
/**
 * @var \App\View\AppView $this
 * @var array<\Sandbox\Model\Entity\SandboxPost> $entities
 * @var array<\App\Dto\PostDto> $dtos
 */
?>
<h1>DTO Projection Demo: BelongsToMany with _joinData</h1>

<p>
    This demo shows <code>projectAs()</code> with Posts having BelongsToMany Tags.
    The pivot table data (<code>_joinData</code>) is automatically hydrated into the DTO.
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData (this page)', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark', ['action' => 'benchmark']) ?></li>
</ul>

<h2>Traditional Entities</h2>
<pre><?php
foreach ($entities as $entity) {
    echo "Post #{$entity->id}: {$entity->title}\n";
    echo "  Tags: " . count($entity->tags) . "\n";
    foreach ($entity->tags as $tag) {
        echo "    - {$tag->label}";
        if ($tag->_joinData) {
            echo " (_joinData id: {$tag->_joinData->id}, type: " . get_class($tag->_joinData) . ")";
        }
        echo "\n";
    }
}
?></pre>

<h2>DTOs with _joinData</h2>
<pre><?php
foreach ($dtos as $dto) {
    echo "Post #{$dto->id}: {$dto->title}\n";
    echo "  Tags: " . count($dto->tags) . "\n";
    foreach ($dto->tags as $tag) {
        echo "    - {$tag->label}";
        if ($tag->_joinData) {
            echo " (_joinData id: {$tag->_joinData->id}, type: " . get_class($tag->_joinData) . ")";
        }
        echo "\n";
    }
}
?></pre>

<h2>DTO Definitions</h2>
<pre><code>// PostDto with tags collection
readonly class PostDto
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $content = null,
        #[CollectionOf(TagDto::class)]
        public array $tags = [],
    ) {}
}

// TagDto with _joinData for pivot table
readonly class TagDto
{
    public function __construct(
        public int $id,
        public string $label,
        public ?TaggedDto $_joinData = null,  // Pivot table data
    ) {}
}

// TaggedDto for the pivot/junction table
readonly class TaggedDto
{
    public function __construct(
        public int $id,
        public int $tag_id,
        public int $fk_id,
        public ?string $fk_model = null,
    ) {}
}</code></pre>
