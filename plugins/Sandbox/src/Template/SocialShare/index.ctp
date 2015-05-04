<h2>SocialShare Plugin Examples</h2>
<?php
$services = $this->SocialShare->services();
?>
The icons are part of "font awesome" and therefore available in all sizes thanks to vector graphics:

<ul class="list-unstyled">
<?php foreach ($services as $service) { ?>
	<li style="margin-bottom: 4px; margin-top: 4px;">
		<?php echo $this->SocialShare->fa($service, null, ['text' => 'Demo Share!', 'class' => 'btn btn-default btn-xs']) ;?> (<?php echo h($service); ?>)
	</li>
<?php } ?>
</ul>

<p>Note: Some services only work for mobile (whatsapp). For these you should use the built-in mobile detection to display them online in case of "mobile".</p>
