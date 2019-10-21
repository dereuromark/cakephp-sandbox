<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php $this->append('script'); ?>
<script>
$(function() {
	$('.toggle-element').click(function() {
		var val = ($(this).data('value') + 1) % 2;
		var targeturl = $(this).data('rel') + '?status=' + val;
		var container = $(this);
		$.ajax({
			type: 'post',
			url: targeturl,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				container.html(response.content);
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
<?php $this->end(); ?>

<style>
.toggle i.icon {
	cursor: pointer;
	font-size: 18px;
}
#some-record {
	background-color: #eee;
	width: 40px;
}

</style>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">
<h2><?php echo __('Toggles');?> via AJAX</h2>

	<div class="alert alert-info" role="alert">
		<p>
			All you need for this is a <code>$.ajax()</code> call and the data-value content added to the span element.
			<br>
			Note how this is even tab safe as we are passing the "new" value along instead of just sending the "invert" command.
			If another tab already set it to active, it will stay this value instead of reverting it again.
		</p>
	</div>


	<h3>Yes/No</h3>

<p>
A simple AJAX toggle. Press F5 after you changed it to verify that the "simulated DB save" worked.
</p>

<div class="toggle">
	<div id="example-container">
		Status/Active: <span class="toggle-element" id="example" data-value="<?php echo $status; ?>" data-rel="<?php echo $this->Url->build(['_ext' => 'json']); ?>"><?php echo $this->Format->yesNo($status); ?></span>
	</div>
</div>

</div>
