<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '#pagination-container a', function () {
		var thisHref = $(this).attr('href');
		if (!thisHref) {
			return false;
		}
		$('#pagination-container').fadeTo(300, 0);

		$('#pagination-container').load(thisHref, function() {
			$(this).fadeTo(200, 1);
		});
		return false;
	});
});
</script>

<div class="page index">
<h2><?php echo __('Countries');?> and AJAX Pagination</h2>

<div id="pagination-container">
<?php echo $this->element('../AjaxExamples/pagination_container'); ?>
</div>

</div>



<h3>Key Goals for the AJAX Pagination</h3>
<ul>
	<li>Ajaxify all links in the "pagination-container" including pagination and sort links</li>
	<li>As easy as possible</li>
	<li>Fallback without AJAX (and JS) should be fully working</li>
</ul>
The fading is not necessary and only shows more clearly the beginning and end of the AJAX request.

Note: Instead of the jQuery.live plugin one could also just use on() event and bind the pagination
links to a click event.

<h3>How does it work</h3>
You only need
<ul>
	<li>A "pagination-container" div and a separate ctp file of the "common" content for both AJAX and normal view</li>
	<li>A few lines of custom (jQuery) JS on top</li>
</ul>
