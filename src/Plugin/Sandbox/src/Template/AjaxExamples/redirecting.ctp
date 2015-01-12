<script type="text/javascript">
$(function() {
	$('#example-container a').removeAttr('onclick');
	$('#example-container a').click(function(e) {
	  e.preventDefault();
	  var form = $(this).prev();
		var url = $(form).attr("action");
		var tr = $(this).closest('tr');

		$.ajax({
			type: 'post',
			url: url,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(res) {
				if (res.error) {
					alert(res.error);
				}
			},
			error: function(e) {
				alert("Error");
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
<h2><?php echo __('Redirecting');?> and AJAX</h2>

<p>
A simple AJAX POST with a normal redirect resolved in the RequestHandler to avoid redirecting when serving AJAX, but instead returning it as part
of the response.
</p>

<div class="toggle">
	<p><?php echo $this->Form->postLink(__('A normal POST link'), array()); ?></p>

	<div id="example-container">
		<?php echo $this->Form->postLink(__('Click me (I am AJAXified).'), array()); ?>
	</div>
</div>

</div>
