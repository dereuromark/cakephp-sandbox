<h2>Admin-Backend - <?php echo __('Overview')?></h2>


<h3><?php echo __('Public Lists')?></h3>
<ul>
<li><?php echo $this->Html->link(__('Countries'), ['plugin' => 'tools', 'controller' => 'countries', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Country Provinces'), ['plugin' => 'tools', 'controller' => 'country_provinces', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Postal Codes'), ['plugin' => 'tools', 'controller' => 'postal_codes', 'action' => 'index'])?></li>

<li><?php echo $this->Html->link(__('Currencies'), ['plugin' => 'tools', 'controller' => 'currencies', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Languages'), ['plugin' => 'tools', 'controller' => 'languages', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Smileys'), ['plugin' => 'tools', 'controller' => 'smileys', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Mime Types'), ['plugin' => 'tools', 'controller' => 'mime_types', 'action' => 'index'])?></li>
</ul>


<h3><?php echo __('Content')?></h3>
<ul>

<li><?php echo $this->Html->link(__('Code Snippets'), ['controller' => 'code_snippets', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Examples'), ['plugin' => 'Sandbox', 'controller' => 'examples', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Jquery Examples'), ['plugin' => 'Sandbox', 'controller' => 'examples', 'action' => 'index'])?></li>


</ul>


<h3><?php echo __('System')?></h3>

<ul>
<li><?php echo $this->Html->link(__('Translations'), ['admin' => false, 'plugin' => 'translate', 'controller' => 'translate', 'action' => 'index'])?></li>


<?php if ($this->AuthUser->hasRole('admin')) { ?>

<li><?php echo $this->Html->link(__('Cronjobs'), ['plugin' => 'queue', 'controller' => 'cron_tasks', 'action' => 'index'])?></li>
<li><?php echo $this->Html->link(__('Setup'), ['plugin' => 'setup', 'controller' => 'setup', 'action' => 'index'])?></li>

<?php } ?>

</ul>