<script type="text/javascript">
$(function() {
	$('#example-container a').removeAttr('onclick');
	$('#example-container a').click(function(e) {
	  e.preventDefault();
	  var form = $(this).prev();
		var url = $(form).attr("action");

		$.ajax({
			type: 'post',
			url: url,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				$('#example-target').html('');
			},
			success: function(res) {
				$('#example-target').html(res);
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
	<div style="margin-bottom: 10px;"><?php echo $this->Form->postLink(__('A normal POST link'), []); ?></div>

	<div style="margin-bottom: 10px;" id="example-container">
		<?php echo $this->Form->postLink(__('Click me (I am AJAXified).'), []); ?>
	</div>

	<p id="example-target">
	<small><i>The AJAX result (from the redirect) will go here</i></small>
	</p>
</div>

</div>
