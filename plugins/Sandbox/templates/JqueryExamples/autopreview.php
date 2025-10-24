<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/jquery'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<?php $this->append('script'); ?>
<script type="text/javascript">

	$(document).ready(function() {

		$("textarea").keyup(function () {
 			var value = $(this).val();
 			$("p").text(value);
		}).keyup();

	});


/** more testing */

function escape( value ) {
	return value
		.replace(/&/g, '&amp;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;')
		.replace(/\"/g, '&quot;')
		.replace(/\'/g, '&#39;')
	;
}
function go() {
	jQuery( '#output' ).val( escape( jQuery( '#input' ).val() ) );
}
jQuery( function() {
	jQuery( 'textarea' ).val('');
} );

</script>
<?php $this->end(); ?>


<h1><?php echo __('Auto Preview');?></h1>
Preview the result while typing. Works on any input (text,textarea):<br />
<?php
$dataPrint = '$(document).ready(function() {

	$("textarea").keyup(function () {
		var value = $(this).val();
		$("p").text(value);
	}).keyup();

});';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'javascript']);
?>
Notice: Due to security issues I did not allow HTML content. that would be so if you change the following line:
<?php
$dataPrint = '		$("p").text(value);
	/* into */
		$("p").html(value);';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'javascript']);
?>

<br />
With more advanced jquery you can use BB-Code or even real html code (only some elements allowed) in the textarea. So the preview would be more realistic as this is
a common way of submitting comments etc.


<h2>Example</h2>

<textarea cols="53" rows="6">enter some text</textarea>
<br /><br />
Preview:<br />
<p class="" style="color:blue;font-weight:bold"></p>

</div></div>
