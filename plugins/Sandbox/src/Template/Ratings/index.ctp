<h2>Ratings plugin</h2>


<?php
if (!$isRated) {
    echo $this->Rating->display(array(
		'item' => $post['id'],
		'url' => array($post['id'])
	));
} else {
	echo __('You have already rated.');
	echo $this->Rating->ratingImage($isRated['value']);
}


?>



<h3>Different settings
</h3>

<?php echo $this->Html->script('/assets/bootstrap-star-rating/js/star-rating.js'); ?>
<?php echo $this->Html->css('/assets/bootstrap-star-rating/css/star-rating.css'); ?>

<br>

<input id="input-5x" data-step="1" data-min="0" data-max="5" value="3" class="rating" data-symbol="&#xf005;" data-glyphicon="false" data-rating-class="rating-fa">

<br>

<input id="input-5a" data-step="1" data-min="0" data-max="5" value="2" class="rating" data-readonly="true">

<br>

<input id="input-5b" data-step="1" data-min="0" data-max="5" value="4" class="rating" data-disabled="true">

<br>

AJAX
<br>

<input id="input-27" class="rating">
<script>
	$("#input-27").on("rating.change", function(event, value, caption) {
		$("#input-27").rating("refresh", {disabled: true, showClear: false});
	});
</script>
