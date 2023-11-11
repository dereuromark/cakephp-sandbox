<?php
/**
 * @var \App\View\AppView $this
 * @var array $array
 * @var array $mergeArray
 * @var array $result
 */
?>
<div class="source-link" style="float: right;">
<?php //echo $this->SourceCode->link(null, array('class' => 'btn btn-info')); ?>
</div>

<h2>Merge em all</h2>
<p>
There are quite a few functions and methods available:
</p>
<p>
 <?php echo $this->Html->link('Cake\'s Hash::merge() (former Set::merge)', ['action' => 'merge', '?' => ['type' => 'hash']]); ?> |
 <?php echo $this->Html->link('array_merge() (pretty much the same than Cake\'s am() function)', ['action' => 'merge', '?' => ['type' => 'array_merge']]); ?> |
 <?php echo $this->Html->link('array_merge_recursive()', ['action' => 'merge', '?' => ['type' => 'array_merge_recursive']]); ?>
</p>
<p>
They produce different results. So it's good to know when which of those merging methods should be best used.
See for yourself.
</p>

The two arrays we want to merge:
<table><td>
<?php
echo pre(h($array));

?></td><td>
<?php
echo pre(h($mergeArray));

?>
</td></table>



<?php if (!empty($result)) {
	echo '<b>Result:</b>';
	echo pre(h($result));
}?>


<br />
<h3>Notes</h3>
<ul>
<li>
array_merge_recursive() is value oriented. It ignores keys and merge-adds values regardless if they already exist.
</li>
<li>
array_merge() is more key oriented. If the same key exists, it will be overwritten.
</li>
<li>
Hash::merge() is somewhere in the middle and behaves a little bit more key oriented while trying to keep values as well.
</li>
</ul>
