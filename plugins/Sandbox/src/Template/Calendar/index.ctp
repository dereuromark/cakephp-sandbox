<div class="page index">

	<h2>Calendar Plugin examples</h2>
	<a href="https://github.com/dereuromark/cakephp-calendar" target="_blank">[Source]</a>

	<h3><?php echo __('Events'); ?></h3>


<?php
	$iconE = $this->Format->icon('calendar', ['title' => __('Event')]);
	foreach ($events as $event) {
		$content = $iconE . ' ' . $this->Html->link($event['title'], ['action' => 'view', $event['id'], \Cake\Utility\Inflector::slug($event['title'])]);
		$this->Calendar->addRow($event['beginning'], $content, ['class' => 'event']);
	}

	echo $this->Calendar->render();

	?>

	<br /><br />

	<?php if (!$this->Calendar->isCurrentMonth()) { ?>
		<?php echo $this->Html->link(__('Jump to the current month') . '...', ['action' => 'index'])?><br /><br />
	<?php } ?>



<h3>Implementation Details</h3>
<p>The texts are localizable, and the links should be AJAX-enhanceable if desired. Note how the backlink on the details page goes exactly back to the corrrect year and month again!</p>

<p>The layout is in the page source code following this note here - and can be freely adjusted to the markup.
</p>

</div>



<style>
	table.calendar {
		width: 100%;
	}

	table.calendar .cell-data {
		vertical-align: top;
		min-height: 40px;
	}

	table.calendar th {
		text-transform: none; padding: 4px; text-align: center;
	}

	table.calendar th.cell-prev {
		text-align: left;
	}
	table.calendar th.cell-next {
		text-align: right;
	}
	table.calendar th.cell-header {
		width: 70px;
		border-bottom: 1px solid #cccccc;
	}
	table.calendar td {
		background-color: #31313b;
		border: 1px solid #cccccc;
	}

	table.calendar td.cell-today {
		background-color: #fc5451;
	}
	table.calendar td.cell-disabled {
		background-color: inherit;
	}
	table.calendar td.cell-weekend {
		background-color: #333;
	}

	table.calendar td div.cell-number {
		text-align: right; font-size: 9px; color: #fff; display: block;
	}
	table.calendar td div {
		display: block; font-size: 12px; text-align: left;
	}
	table.calendar thead th {
	}


</style>
