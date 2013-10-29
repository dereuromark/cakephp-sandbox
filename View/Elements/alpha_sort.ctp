<?php
# Needs: $active_c = active char
# Needs: $chars = all chars availible

if (empty($active_c)) {
	$active_c = '';
}

?>
<div class="alphaSort"><?php
if ($active_c=='all') {
	$class='active';
} else {
	$class='';
}
echo $this->Html->link(__('Custom'), array('custom'), array('title'=>'Custom Controllers','class'=>$class));

?><span class="divider">|</span><?php
if ($active_c=='custom') {
	$class='active';
} else {

}
echo $this->Html->link(__('All'), array('all'), array('title'=>'Show All Controllers and their actions','class'=>$class));
?><span class="divider">|</span><?php

foreach ($chars as $c) {
	$char=strtoupper($c);

	if (!empty($assigned[$c])) {
		if ($active_c == $c) {
			$class='active';
		} else {
			$class='';
		}

		// $active_c='active';
		echo $this->Html->link($char, array($char), array('title'=>'Starting with "'.$char.'"','class'=>$class));

	} else {
		echo '<span>'.$char.'</span>';
	}

}

?></div>
<br class="clear"/>
