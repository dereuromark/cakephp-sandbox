<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Sandbox\Model\Entity\SandboxPost> $entities
 * @var array<\App\Dto\PostDto> $dtos
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>DTO Projection: BelongsToMany with _joinData</h1>

<p>
	This demo shows <code>projectAs()</code> with Posts having BelongsToMany Tags.
	The pivot table data (<code>_joinData</code>) is automatically hydrated into the DTO.
</p>

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
	echo "Post #{$dto->getId()}: {$dto->getTitle()}\n";
	$tags = $dto->getTags();
	echo "  Tags: " . count($tags) . "\n";
	foreach ($tags as $tag) {
		echo "    - {$tag->getLabel()}";
		if ($tag->getJoinData()) {
			echo " (_joinData id: {$tag->getJoinData()->getId()}, type: " . get_class($tag->getJoinData()) . ")";
		}
		echo "\n";
	}
}
?></pre>

<h2>Code Example</h2>
<pre><code>// BelongsToMany with pivot table data
$posts = $postsTable->find()
    ->contain(['Tags'])
    ->projectAs(PostDto::class)
    ->toArray();

// _joinData is automatically included
foreach ($posts as $post) {
    foreach ($post->getTags() as $tag) {
        echo $tag->getLabel();
        echo $tag->getJoinData()?->getId();
    }
}</code></pre>

</div></div>
