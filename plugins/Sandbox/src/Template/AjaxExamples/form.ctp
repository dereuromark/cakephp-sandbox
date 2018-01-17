<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<div class="ajax-form">
<h2>AJAX Forms</h2>

<div class="form-container">
<?php echo $this->Form->create($user, ['novalidate' => true]);?>
	<fieldset>
 		<legend><?php echo __('Register fake action');?></legend>
	<?php
		echo $this->Form->input('username', []);
		echo $this->Form->input('email', []);
	?>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>

</div>

</div>

<script>
	$(function() {
		$(document).on('submit', '.ajax-form form', function(event) {
			var form = $(this);
			$.ajax({
				beforeSend: function(xhr) {
					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				},
				type: form.attr('method'),
				url: form.attr('action'),
				data: form.serialize()
			}).done(function(response) {
				// Flash message
				$('.flash-messages').remove();
				if (response._message) {
					var flashMessages = '';
					// Display the error
					response._message.forEach(function(message) {
						flashMessages += '<div class="flash-messages">';
						if (message.type == 'error') {
							flashMessages += '<div class="message error">' + message.message + '</div>';
						}
						if (message.type == 'success') {
							flashMessages += '<div class="message success">' + message.message + '</div>';
						}
						flashMessages += '</div>';
					});
					$('.ajax-form').prepend(flashMessages);
				}
				// Redirect if given
				if (response._redirect) {
					$('.ajax-form .form-container').html('Done - Save simulated. Redirect prevented to: ' + response._redirect.url + ' (' + response._redirect.status + ')');
					return;
				}
				$('.ajax-form .form-container').html(response.content);
			}).fail(function(response) {
				// Optionally alert the user of an error here...
				console.log(response.error);
				$('.ajax-form .form-container').html(response.content);
			});
			event.preventDefault(); // Prevent the form from submitting via the browser.
		});
	});

</script>
