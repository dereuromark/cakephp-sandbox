<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/search'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h2>CakePHP and Search functionality</h2>

	<h3>Search Form posting to another action</h3>

	<div class="search-box">
		<?php
		echo $this->Form->create(null, ['valueSources' => 'query', 'url' => ['action' => 'table']]);

		echo $this->Form->control('search', ['placeholder' => 'Wildcards: * and ?']);
		echo $this->Form->control('status', ['options' => ['' => '- does not matter -', '0' => 'Inactive', '1' => 'Active']]);

		echo $this->Form->button(__('Search'), ['class' => 'btn btn-primary']);

		echo $this->Form->end();
		?>
	</div>

</div>
