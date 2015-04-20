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
				$('#example-target').html('...');
			},
			success: function(res) {
				$('#example-target').text('Redirect to: ' + res._redirect.url + ' (status code ' + res._redirect.status + ')');
				$('#example-target').append('<br/>Message: ' + res._message.success);
				$('#example-target').append("<br/><br/>Raw data:<br/>" + JSON.stringify(res));
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
<h2><?php echo __('Redirecting');?> and AJAX - Using Ajax Plugin</h2>

<p>
A simple AJAX POST with a normal redirect is usually resolved in the RequestHandler to avoid actual redirecting when serving AJAX.
It instead returns the redirected content as part of the response. Using the AjaxComponent you can disable that and instead return
the redirect URL and its status code to manually use it in your JS/jQuery code.
</p>

<div class="toggle">
	<div style="margin-bottom: 10px;"><?php echo $this->Form->postLink(__('A normal POST link'), []); ?></div>

	<div style="margin-bottom: 10px;" id="example-container">
		<?php echo $this->Form->postLink(__('Click me (I am AJAXified).'), []); ?>
	</div>

	<div class="alert alert-info" id="example-target">
	<small><i>The AJAX result (from the redirect) will go here</i></small>
	</div>
</div>

</div>
