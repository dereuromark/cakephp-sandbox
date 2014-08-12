<h2>Export</h2>
This is the export interface where you can get the current version of the tables.<br />
Please help to keep it up to date. You can submit changes via Email.<br />
An interface to directly modify the data is planned, though.

<div class="row">
	<div class="col-md-4">

<h3><?php echo __('Continents'); ?></h3>
<div>Key information: lat/lng</div>
<?php //echo $this->Html->link(__('View online'), array('plugin'=>'tools', 'controller'=>'continents', 'action'=>'index')); ?>
<ul>
<li><?php echo $this->Html->link('JSON', array('action' => 'continents', 'ext' => 'json')); ?></li>
<li><?php echo $this->Html->link('XML', array('action' => 'continents', 'ext' => 'xml')); ?></li>
</ul>

<h3>Countries</h3>
<div>Key information: lat/lng, iso codes, zip code length/regexp, eu member, address_format, country_code, timezone</div>
<?php echo $this->Html->link(__('View online'), array('plugin' => 'data', 'controller' => 'countries', 'action' => 'index')); ?>
<ul>
<li><?php echo $this->Html->link('JSON', array('action' => 'countries', 'ext' => 'json')); ?></li>
<li><?php echo $this->Html->link('XML', array('action' => 'countries', 'ext' => 'xml')); ?></li>
</ul>

<h3>Country Provinces</h3>
<div>Key information: lat/lng, iso codes, timezone</div>
<?php echo $this->Html->link(__('View online'), array('plugin' => 'data', 'controller' => 'country_provinces', 'action' => 'index')); ?>
<ul>
<li><?php echo $this->Html->link('JSON', array('action' => 'country_provinces', 'ext' => 'json')); ?></li>
<li><?php echo $this->Html->link('XML', array('action' => 'country_provinces', 'ext' => 'xml')); ?></li>
</ul>

<h3>States / Cities / Districts / Postal Codes</h3>
TODO
	</div>

	<div class="col-md-4">

<h3><?php echo __('Currencies'); ?></h3>
<div>Key information: iso codes, current value, base currency, symbol</div>
<?php //echo $this->Html->link(__('View online'), array('plugin'=>'data', 'controller'=>'currencies', 'action'=>'index')); ?>
<ul>
<li><?php echo $this->Html->link('JSON', array('action' => 'currencies', 'ext' => 'json')); ?></li>
<li><?php echo $this->Html->link('XML', array('action' => 'currencies', 'ext' => 'xml')); ?></li>
</ul>

<h3><?php echo __('Languages'); ?></h3>
<?php //echo $this->Html->link(__('View online'), array('plugin'=>'data', 'controller'=>'languages', 'action'=>'index')); ?>
<ul>
<li><?php echo $this->Html->link('JSON', array('action' => 'languages', 'ext' => 'json')); ?></li>
<li><?php echo $this->Html->link('XML', array('action' => 'languages', 'ext' => 'xml')); ?></li>
</ul>

<h3><?php echo __('Smileys'); ?></h3>
TODO

<h3><?php echo __('Mime Types'); ?></h3>
TODO

	</div>
</div>




<br />
Note: If you want to force downloading, append `?download=1` after the extension.