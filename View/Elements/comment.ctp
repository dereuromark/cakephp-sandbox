<?php
/*
	$commentposts[]=array(
		'id'=>
		'name'=>
		'comment'=>
		'title'=>
		'created'=>
		'email'=>
	);
*/

//debug ($commentposts);

foreach ($commentposts as $comment)
{
	echo '<li class="comment " id="comment-'.$comment['id'].'">';
		echo '<p class="title">'.$comment['title'].'</p>';		
		echo '<p class="meta">
				<strong>'.$comment['name'].'</strong> 
				<span class="time">// <a href="#comment-'.$comment['id'].'" title="Permalink to this comment">'.$comment['created'].'</a></span>
			 </p>
	 			<div class="entry">
				<p>'.$comment['comment'].'</p>
				</div>';		
	echo '</li>';
}
 
?>