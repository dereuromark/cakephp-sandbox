<div class="examples index">
<h1><?php echo __('Jquery Examples');?></h1>
For everybody that knows Jquery very well, this sure isn't anything new at all.<br />
It is supposed to show CakePHP/Jquery Beginners, that it is quite easy to switch from the default "Prototype" Ajax (Helper) to Jquery (with Helper or without).<br/>
In fact, it is even easier to use Jquery pure - you are more flexibel with it than using a helper for it.
<br /><br />
Additionally, this section shows how to integrate some of the really cool stuff of Jquery into CakePHP(1.1/1.2) Projects - respecting the MVC pattern.
<br /><br />

<table class="table list">
<tr>
	<th>About</th>
	<th>Author</th>
	<th>Published</th>
</tr>
<?php

//pr($examples);

$examples2 = [];
$examples2[] = [
	'title'=>'Auto Preview',
	'link'=>'autopreview',
	'author'=>'Mark',
	'user_id'=>'1',
	'published'=>'August 2008',
	'copyright'=>'s',
	'copyright_link'=>'xx'
];

foreach ($examples as $example):
?>
	<tr>
		<td>
			<?php echo $this->Html->link($example['JqueryExample']['title'], ['controller'=>'jquery_examples','action'=>$example['JqueryExample']['link']]); ?>
		</td>
		<td>
			<?php echo $this->Html->link($example['User']['username'], '/user/'.$example['User']['id']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($example['JqueryExample']['published']); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<br />
You may comment each example - or post your enhancements
