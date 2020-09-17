<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>SocialShare Plugin Examples</h2>
<a href="https://github.com/drmonkeyninja/cakephp-social-share" target="_blank">[SocialShare Plugin]</a>

<br><br>

<?php
$services = $this->SocialShare->services();
?>
<p>
The icons are part of "font awesome" and therefore available in all sizes thanks to vector graphics:
</p>

<ul class="list-unstyled">
<?php foreach ($services as $service) { ?>
	<li style="margin-bottom: 4px; margin-top: 4px;">
		<?php echo $this->SocialShare->fa($service, null, ['text' => 'Demo Share!', 'class' => 'btn btn-secondary']);?> (<?php echo h($service); ?>)
	</li>
<?php } ?>
</ul>

<p>Note: Some services only work for mobile (whatsapp). For these you should use the built-in mobile detection to only display them in case of "mobile".</p>
