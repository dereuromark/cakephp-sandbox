<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php
echo $this->Html->css('Sandbox.highlighting/github.css');
?>
<script src="https://highlightjs.org/static/highlight.site.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

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
