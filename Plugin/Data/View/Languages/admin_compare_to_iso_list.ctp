<div class="page index">
<h2><?php echo __('Languages');?></h2>
ISO List contains <?php echo count($isoList['values']); ?> languages.
<br />
Local DB contains <?php echo count($languages); ?> locales.
<br /><br />

<table class="list"><tr>
	<th>&nbsp;</th>
	<th><?php echo $isoList['heading'][0];?></th>
	<th><?php echo $isoList['heading'][1];?></th>
	<th><?php echo $isoList['heading'][2];?></th>
	<th><?php echo __('Locales'); ?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($isoList['values'] as $language):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
<?php
	$languageFlags = Cache::read('language_flags');
	if (!$languageFlags) {
		App::uses('Folder', 'Utility');
		$handle = new Folder(App::pluginPath('Tools').'webroot'.DS.'img'.DS.'country_flags');
		$languageFlags = $handle->read(true, true);
		$languageFlags = $languageFlags[1];
		Cache::write('language_flags', $languageFlags);
	}

	if (!empty($language['iso2']) && in_array($language['iso2'].'.gif', $languageFlags)) {
		echo $this->Html->image('/tools/img/country_flags/'.$language['iso2'].'.gif');
	}
?>
		</td>
		<td>
			<?php
				echo h($language['iso3']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($language['iso2']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($language['ori_name']);
			?>&nbsp;
		</td>
		<td>
			<?php
				if (!empty($language['iso2'])) {
					foreach ($languages as $lang) {
					if (!empty($lang['Language']['code']) && $language['iso2'] == $lang['Language']['code']) {
						echo '<div>'.h($lang['Language']['name']).'</div>';
					}
					}
				}
			?>
			&nbsp;
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $language['Language']['id']), array('escape'=>false)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>


</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List %s', __('Languages')), array('action' => 'index')); ?></li>
	</ul>
</div>