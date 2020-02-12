<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php echo $this->Html->script('/assets/jquery-infinite-scroll/dist/infinite-scroll.pkgd.js', ['block' => true]); ?>

<?php $this->append('script'); ?>
<script>
	$(function() {
		var $container = $('#pagination-container');

		$container.infiniteScroll({
            path: '.next a',
            append: '.country-item',
            status: '.scroller-status',
            hideNav: '.paging',
				navSelector: '.paging', // selector for the paged navigation
				nextSelector: '.next a', // selector for the NEXT link (to page 2)
				itemSelector: '.country-item', // selector for all items you'll retrieve
				debug: true,
				dataType: 'html',
				loading: {
					finishedMsg: 'No more posts to load!',
					img: 'https://miftyisbored.com/wp-tutorials/cakephp-infinite-scroll/img/spinner.gif'
				}
		});

		$('.paging-description').hide();
	});

</script>
<?php $this->end(); ?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">
<h2><?php echo __('Countries');?> and AJAX Pagination as Endless Scroll</h2>

	<p>
		The nice thing about this implementation is that it is SEO friendly, and fully BC if JavaScript is broken for some reason.
		<br>
		It will then just fall back to the normal pagination with links at the bottom (try it).
	</p>

	<!-- status elements -->
	<div class="scroller-status">
		<div class="infinite-scroll-request loader-ellips">
			...
		</div>
		<p class="infinite-scroll-last">End of content</p>
		<p class="infinite-scroll-error">No more pages to load</p>
	</div>

<div id="pagination-container">
<?php echo $this->element('../AjaxExamples/endless_scroll_container'); ?>
</div>

</div>
