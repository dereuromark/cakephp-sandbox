<?php
/**
 * @var \App\View\AppView $this
 */

?>

<?php $this->Html->script('/assets/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js', ['block' => true]); ?>
<?php $this->Html->css('/assets/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css', ['block' => true]); ?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">
<h2>Edit In Place using AJAX</h2>

	<div class="alert alert-info" role="alert">
		<p>
			All you need for this is <a href="https://vitalets.github.io/x-editable/" target="_blank">x-editable</a> and a few lines of config JS.
			<br>
			Using the AJAX plugin you can simplify the PHP code to have more simple controller actions.
		</p>
	</div>


	<h3>Popup</h3>

	<p>
		<a href="#" id="username">superuser</a>
	</p>

	<p>Enter [A-Z]+ for valid input, and anything else (e.g. numbers or #;:$&/) to get en error.</p>

	<h3>Inline</h3>

	<p>
		<a href="#" id="email">demo@email.example</a>
	</p>


</div>

<?php $this->append('script'); ?>
<script>
$(function() {

	$('#username').editable({
		type: 'text',
		pk: 1,
		url: '<?php echo $this->Url->build(['action' => 'editInPlace', '_ext' => 'json']); ?>',
		title: '<?php echo __('Update username'); ?>',
		success: function(response, newValue) {
			if (response.error) {
				return response.error;  //msg will be shown in editable form
			}
		}
	});

    $('#email').editable({
		mode: 'inline',
        type: 'text',
        pk: 1,
        url: '<?php echo $this->Url->build(['action' => 'editInPlaceEmail', '_ext' => 'json']); ?>',
        title: '<?php echo __('Enter new email'); ?>',
        success: function(response, newValue) {
            if (response.error) {
                return response.error;  //msg will be shown in editable form
            }
        }
    });

});
</script>
<?php $this->end(); ?>

