<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/jquery'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1><?php echo __('Auto-complete');?></h1>

<p>Type into the following input e.g. "Ko" etc and wait for a selection to appear.</p>

<?php
echo $this->Form->create(null, [
	'id' => 'jquery-example-form',
	'url' => [
		'plugin' => 'sandbox',
		'controller' => 'jquery_examples',
		'action' => 'autocomplete',
	],
]);
echo $this->Form->control('term', ['id' => 'jquery-example-input', 'label' => __('Search for an animal')]);
echo $this->Form->submit(__('Save'));
echo $this->Form->end();
?>

<?php $this->append('css');?>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<?php $this->end();?>

<?php $this->append('script');?>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	<script>
	$(function () {
		$('#jquery-example-input').autocomplete({
			source: function (request, response) {
				$.ajax({
					url: $('#jquery-example-form').attr('action') + '.json',
					dataType: 'json',
					data: {
						'term': $('#jquery-example-input').val()
					},
					success: function (data) {
						response(data.items);
					},
					minLength: 1,
					select: function (event, ui) {
						// If you want to do something when a user clicks an item
					},
					open: function () {
						$(this).removeClass('ui-corner-all').addClass('ui-corner-top');
					},
					close: function () {
						$(this).removeClass('ui-corner-top').addClass('ui-corner-all');
					}
				});
			}
		});
	});
	</script>
<?php $this->end(); ?>

</div></div>
