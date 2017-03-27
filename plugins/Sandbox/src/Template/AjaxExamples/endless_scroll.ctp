<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php echo $this->Html->script('/assets/jquery-infinite-scroll/jquery.infinitescroll.js'); ?>
<script>
	$(function() {
		var $container = $('#pagination-container');

		$container.infinitescroll({
				navSelector: '.paging', // selector for the paged navigation
				nextSelector: '.next a', // selector for the NEXT link (to page 2)
				itemSelector: '.country-item', // selector for all items you'll retrieve
				debug: true,
				dataType: 'html',
				loading: {
					finishedMsg: 'No more posts to load!',
					img: 'http://miftyisbored.com/wp-tutorials/cakephp-infinite-scroll/img/spinner.gif'
				}
		});

		$('.paging-description').hide();
	});

</script>

<div class="page index">
<h2><?php echo __('Countries');?> and AJAX Pagination as Endless Scroll</h2>

	<p>
		The nice thing about this implementation is that it is SEO friendly, and fully BC if JavaScript is broken for some reason.
		<br>
		It will then just fall back to the normal pagination with links at the bottom (try it).
	</p>

<div id="pagination-container">
<?php echo $this->element('../AjaxExamples/endless_scroll_container'); ?>
</div>

</div>
