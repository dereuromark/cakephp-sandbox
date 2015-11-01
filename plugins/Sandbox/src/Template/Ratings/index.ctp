<h2>Ratings plugin</h2>


<?php
if (!$isRated) {
    echo $this->Rating->display([
		'item' => $post['id'],
		'url' => [$post['id']]
	]);
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

<div style="font-size: 20px">
<div class="rating-container rating-fa" data-content="&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;" title="x of y stars">
	<div class="rating-stars" data-content="&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;" style="width: 20%;"></div>
</div>

<br>
<?php

echo $this->Rating->image(2.75,
	['title' => 'x of y stars !!!']);

?>

<br>
<?php
echo $this->Rating->image(2.25,
	['steps' => 2, 'label' => false, 'title' => 'x of y stars !!!', 'class'=> 'rating', 'data-symbol' => '&#xf005;', 'data-glyphicon' => 'false', 'data-rating-class' => 'rating-fa', 'escape' => false,
		'data-readonly' => 'true', 'data-show-clear' => 'false', 'data-show-caption' => 'false']);
?>

</div>

<br>

<?php
echo $this->Rating->input('input-5',
	['value' => 2.75, 'label' => false, 'title' => 'x of y stars', 'class'=> 'rating', 'data-symbol' => '&#xf005;', 'data-glyphicon' => 'false', 'data-rating-class' => 'rating-fa', 'escape' => false,
		'data-readonly' => 'true', 'data-show-clear' => 'false', 'data-show-caption' => 'false']);
?>
<script>
	$("#input-5").rating({
		starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"}
	});
	$(".rating-container").mouseover(function() {
		$(this).attr('title', $(this).find('input').attr('title'));
	});
</script>

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
