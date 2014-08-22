<script type="text/javascript">
$(function() {
	$('.toggle-element').click(function() {
		var val = ($(this).data('value') + 1) % 2;
		var targeturl = $(this).data('rel') + '?status=' + val;
		var container = $(this);
		$.ajax({
			type: 'post',
			url: targeturl,
			success: function(response) {
				container.html(response.result);
				container.data('value', val);
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);
			}
		});
	});

});
</script>

<style>
.toggle img.icon {
	cursor: pointer;
}
#some-record {
	background-color: #eee;
	width: 40px;
}

</style>

<div class="page index">
<h2><?php echo __('Toggles');?> via AJAX</h2>

<p>
A simple AJAX toggle. Press F5 after you changed it to verify that the "simulated DB save" worked.
</p>

<div class="toggle">
	<div id="example-container">
		Status/Active: <span class="toggle-element" id="example" data-value="<?php echo $status; ?>" data-rel="<?php echo $this->Html->url(array('ext' => 'json')); ?>"><?php echo $this->Format->yesNo($status, 'Yeaah', 'Nooo'); ?></span>
	</div>
</div>

</div>
