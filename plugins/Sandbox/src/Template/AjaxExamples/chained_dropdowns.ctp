<div class="form">
<h2>Chained Dropdowns using AJAX</h2>

<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo __('Countries and Country Provinces');?></legend>
	<?php
		$url = $this->Url->build(['plugin' => 'sandbox', 'controller' => 'ajax_examples', 'action' => 'country_provinces_ajax', '_ext' => 'json']);
		$empty = $countryProvinces->toArray() ? Configure::read('Select.defaultBefore') . __('pleaseSelect') . Configure::read('Select.defaultAfter') : ['0' => Configure::read('Select.naBefore') . __('noOptionAvailable') . Configure::read('Select.naAfter')];

		echo $this->Form->input('country_id', ['id' => 'countries', 'rel' => $url]);
		echo $this->Form->input('country_province_id', ['id' => 'provinces', 'empty' => $empty]);
	?>
	</fieldset>

	The province list is updated each time the country is switched. It also has a basic fallback for POST data (will auto-remember the previous selection).
	<br />
	Also note how "Please select" requires input, whereas "No option available" does not.
	<br /><br />
	Submit the form to see how validation kicks in and how it behaves with these two different options (required vs. no option available).
	<br /><br />

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>


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
					$('#provinces').html(response.content);
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
