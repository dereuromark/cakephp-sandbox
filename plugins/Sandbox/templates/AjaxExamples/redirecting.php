<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php $this->append('script'); ?>
<script>
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
				// Will not run into this as it returns a 302 status code
				$('#example-target').html(res);
			},
			error: function(e, res) {
				// The 302 status code will make it run into this
				$('#example-target').html(res);
			}
		});
	});
});
</script>
<?php $this->end(); ?>

<?php $this->append('css'); ?>
<style>
.toggle img.icon {
	cursor: pointer;
}
#some-record {
	background-color: #eee;
	width: 40px;
}

</style>
<?php $this->end(); ?>


<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-12">
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

	<div class="alert alert-info" id="example-target">
	<small><i>The AJAX result (from the redirect) will go here</i></small>
	</div>
</div>

</div></div>
