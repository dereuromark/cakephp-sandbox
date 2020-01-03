<?php
/**
 * @var \App\View\AppView $this
 * @var array $states
 * @var \App\Model\Entity\Entity $user
 */

use Cake\Core\Configure;

?>
<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">
<h2>Chained Dropdowns using AJAX</h2>

<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo __('Countries and States');?></legend>
	<?php
		$url = $this->Url->build(['plugin' => 'sandbox', 'controller' => 'ajax_examples', 'action' => 'countryStates', '_ext' => 'json']);
		$empty = $states ? Configure::read('Select.defaultBefore') . __('pleaseSelect') . Configure::read('Select.defaultAfter') : ['0' => Configure::read('Select.naBefore') . __('noOptionAvailable') . Configure::read('Select.naAfter')];

		echo $this->Form->control('country_id', ['id' => 'countries', 'rel' => $url]);
		echo $this->Form->control('state_id', ['id' => 'states', 'empty' => $empty]);
	?>
	</fieldset>

	The states list is updated each time the country is switched. It also has a basic fallback for POST data (will auto-remember the previous selection).
	<br />
	Also note how "Please select" requires input, whereas "No option available" does not.
	<br /><br />
	Submit the form to see how validation kicks in and how it behaves with these two different options (required vs. no option available).
	<br /><br />

<?php echo $this->Form->submit(__('Submit'));
echo $this->Form->end();?>
</div>

<?php $this->append('script'); ?>
<script>
$(function() {

	$('#countries').change(function() {
		var selectedValue = $(this).val();

		var targeturl = $(this).attr('rel') + '?id=' + selectedValue;
		$.ajax({
			type: 'get',
			url: targeturl,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				if (response.content) {
					$('#states').html(response.content);
				}
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});

});
</script>
<?php $this->end();
