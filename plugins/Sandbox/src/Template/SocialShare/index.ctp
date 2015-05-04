<h2>SocialShare Plugin Examples</h2>
<?php
$services = $this->SocialShare->services();
?>

<ul>
<?php foreach ($services as $service) { ?>
	<li>
		<?php echo h($service); ?>: <?php echo $this->SocialShare->fa($service, ['text' => 'Demo Share!']) ;?>
	</li>
<?php } ?>
</ul>
