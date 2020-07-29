<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost[] $posts
 * @var array $tags
 * @var bool $_isSearch
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tags'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

	<div class="search-box pull-right" style="margin-bottom: 10px;">
		<?php
		echo $this->Form->create(null, ['valueSources' => 'query']);

		echo $this->Form->control('title', ['placeholder' => 'Wildcards: * and ?']);
		echo $this->Form->control('tag', ['options' => ['' => '- does not matter -', '-1' => '- all without any tag -'] + $tags]);

		echo $this->Form->button(__('Search'), ['class' => 'btn btn-primary']);
		if (!empty($_isSearch)) {
			echo ' ';
			echo $this->Html->link(__('Reset'), ['action' => 'search', '?' => array_intersect_key($this->request->getQuery(), array_flip(['sort', 'direction']))], ['class' => 'btn btn-default']);
		}

		echo $this->Form->end();
		?>
	</div>

	<h2><?php echo __('Tags');?> and filter functionality</h2>

	<p>This example uses Search plugin for filtering.</p>

<table class="table list">
<tr>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo __('Tags');?></th>
</tr>
<?php
foreach ($posts as $post):
?>
	<tr>
		<td>
			<?php echo h($post->title); ?>
		</td>
		<td>
			<?php
				echo h($post->tag_list);
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>

	<p>Note the "- all without any tag -" filter using the <code>find('untagged')</code> finder.</p>
	<p>
		You can also try or/and tag filtering:
		<?php echo $this->Html->link('Motivating or Detailed', ['?' => ['tag'=> 'motivating,detailed'] + $this->request->getQuery()]); ?>,
		<?php echo $this->Html->link('Motivating and Detailed', ['?' => ['tag'=> 'motivating+detailed'] + $this->request->getQuery()]); ?>
	</p>

</div>
