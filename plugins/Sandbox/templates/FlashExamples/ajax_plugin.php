<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Flash messages and AJAX</h2>


<div class="ajax-form">
<p>
Let's simulate an action as button icon:
</p>

	<div class="form-container">
		<?php echo $this->Form->postLink($this->Format->icon('save'), ['action' => 'ajax'], ['escapeTitle' => false]); ?>
	</div>

	<div class="debug-container">

	</div>
</div>


<?php $this->append('script'); ?>
	<script>
		$(function() {
			// For demo purposes we replace the original form post handler.
			$('.ajax-form a').attr('onclick', '')
				.click(function(event) {
				var form = $(this);
				$.ajax({
					beforeSend: function(xhr) {
						xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					},
					type: 'post',
					url: $('.ajax-form').attr('action'),
				}).done(function(response, textStatus, xhr) {
					var flash = xhr.getResponseHeader("X-Flash");
					var messages = JSON.parse(flash);

					// Flash message
					$('.ajax-flash-messages').remove();
					if (messages) {
						var flashMessages = '';
						// Display the error
						$.each(messages, function(index, message) {
							flashMessages += '<div class="ajax-flash-messages">';
							if (message.type === 'error') {
								flashMessages += '<div class="alert alert-danger">' + message.message + '</div>';
							}
							if (message.type === 'success') {
								flashMessages += '<div class="alert alert-success">' + message.message + '</div>';
							}
							flashMessages += '</div>';
						});
						$('.ajax-form').prepend(flashMessages);
					}
					// Redirect if given
					if (response._redirect) {
						$('.ajax-form .debug-container').html('Done - Save simulated. Redirect prevented to: ' + response._redirect.url + ' (' + response._redirect.status + ')');
						return;
					}
					$('.ajax-form .debug-container').html(response.content);
				}).fail(function(response) {
					// Optionally alert the user of an error here...
					console.log(response.error);
					$('.ajax-form .debug-container').html(response.content);
				});
				event.preventDefault(); // Prevent the form from submitting via the browser.
			});
		});

	</script>
<?php $this->end();
