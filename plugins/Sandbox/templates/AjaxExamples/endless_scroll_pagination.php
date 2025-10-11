<?php
/**
 * @var \App\View\AppView $this
 * @var bool $addArrows
 * @var bool $reverse
 */
if (!isset($separator)) {
	if (defined('PAGINATOR_SEPARATOR')) {
		$separator = PAGINATOR_SEPARATOR;
	} else {
		$separator = '';
	}
}

if (empty($first)) {
	$first = __d('tools', 'first');
}
if (empty($last)) {
	$last = __d('tools', 'last');
}
if (empty($prev)) {
	$prev = __d('tools', 'previous');
}
if (empty($next)) {
	$next = __d('tools', 'next');
}
if (!isset($format)) {
	$format = __d('tools', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total');
}
if (!empty($reverse)) {
	$tmp = $first;
	$first = $last;
	$last = $tmp;

	$tmp = $prev;
	$prev = $next;
	$next = $tmp;
}
if (!empty($addArrows)) {
	$prev = '« ' . $prev;
	$next .= ' »';
}
$escape = isset($escape) ? $escape : true;

$this->Paginator->setConfig('templates.nextActive', '<li class="page-item next">' .
	'<a class="page-link" rel="next" aria-label="Next" href="{{url}}">' .
	'<span aria-hidden="true">{{text}}</span></a></li>');
?>

<div class="paginator paging row">
	<div class="col-lg-6">

		<ul class="pagination">
			<?php echo $this->Paginator->first($first, ['escape' => $escape]);?>
			<?php echo $separator; ?>
			<?php echo $this->Paginator->prev($prev, ['escape' => $escape, 'disabledTitle' => false]);?>
			<?php echo $separator; ?>
			<?php echo $this->Paginator->numbers(['escape' => $escape, 'separator' => $separator]);?>
			<?php echo $separator; ?>
			<?php echo $this->Paginator->next($next, ['escape' => $escape, 'disabledTitle' => false]);?>
			<?php echo $separator; ?>
			<?php echo $this->Paginator->last($last, ['escape' => $escape]);?>
		</ul>

	</div>
	<div class="col-lg-6">
		<p class="paging-description">
			<?php echo $this->Paginator->counter($format); ?>
		</p>
	</div>
</div>
