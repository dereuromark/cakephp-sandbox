<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $result
 * @var array $options
 */

?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/qr_code'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Basic Usage</h3>
	<p>By default, we render a simple SVG image that can be scaled up/down easily.</p>

	<div class="col-md-6" style="margin-bottom: 16px;">
		<?php
		if ($result) {
			echo '<h4>Result</h4>';
			echo $this->QrCode->image($result, $options);
		}
		?>
	</div>

	<h4>Generate QR Code</h4>

	<?php echo $this->Form->create();?>
	<p>Enter some text (URL, ...)</p>

	<?php
	echo $this->Form->control('content', ['autocomplete' => 'off', 'type' => 'textarea']);
	?>
	<div class="col-md-offset-2 col-md-6">
		<?php echo $this->Form->button(__('Go'), ['class' => 'btn btn-success']);?>
	</div>
	<?php echo $this->Form->end(); ?>


</div>

<?php $this->append('script');?>
	<script type="text/javascript">
		$(document).ready(function() {
			// Character counter for all textareas
			// Wait a bit for the form to be fully rendered
			setTimeout(function() {
				// Add character counter to all textareas only
				$('textarea').each(function() {
					var $field = $(this);

					// Skip if it's a date field or other special inputs
					if ($field.hasClass('hasDatepicker') || $field.attr('readonly')) {
						return;
					}

					// Create a unique counter ID based on field name or ID
					var fieldId = $field.attr('id') || $field.attr('name') || 'field';
					var counterId = 'charCount_' + fieldId.replace(/[\[\]\.]/g, '_');

					// Add the counter div after the field's parent div (to handle CakePHP's form structure)
					var $counterDiv = $('<div class="char-counter" style="text-align: right; color: #666; font-size: 0.9em; margin-bottom: 10px;">' +
						'<span id="' + counterId + '">0</span> characters' +
						'</div>');

					// Insert counter after the form-group div
					var $formGroup = $field.closest('.form-group');
					if ($formGroup.length > 0) {
						$formGroup.after($counterDiv);
					} else {
						$field.after($counterDiv);
					}

					// Function to count Unicode characters properly (UTF-8 safe)
					function getUnicodeLength(str) {
						// Use the spread operator to split by grapheme clusters
						// This handles emojis, combining characters, etc. correctly
						return [...str].length;
					}

					// Bind input event
					$field.on('input keyup paste', function() {
						var charCount = getUnicodeLength($(this).val());
						$('#' + counterId).text(charCount);
					});

					// Initialize counter
					$('#' + counterId).text(getUnicodeLength($field.val()));
				});
			}, 100);
		});
	</script>
<?php $this->end();</div>
