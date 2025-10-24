<?php
/**
 * @var \App\View\AppView $this
 * @var \Tools\Model\Entity\Entity $event
 * @var \Tools\Model\Entity\Entity[] $attendees
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Timeline</h2>

	<?php echo $this->Html->script('timeline/timeline', ['block' => true]); ?>
	<?php echo $this->Html->css('/js/timeline/timeline', ['block' => true]); ?>

	<div id="mytimeline">
		<noscript><p>JavaScript is required to view the attendance timeline.</p></noscript>
	</div>

	<?php
	$settings = [
		'min' => $event['from']->sub(new \DateInterval('P10D')),
		'max' => $event['to']->add(new \DateInterval('P10D')),
	];
	$this->loadHelper('Tools.Timeline', $settings);

	foreach ($attendees as $attendee) {
		$content = '';
		if ($attendee->role == 'speaker') {
			$content .= '<div style="float: right"><small>' . __('Speaker') . '</small></div>';
		}
		$content .= $this->Html->link($attendee->name, '#');

		$this->Timeline->addItem(['start' => $attendee['from'], 'end' => $attendee['to'], 'content' => $content]);
	}
	$this->Timeline->finalize();
	?>

</div></div>
