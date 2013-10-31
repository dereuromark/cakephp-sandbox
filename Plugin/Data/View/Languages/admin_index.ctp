<div class="page index">
<h2><?php echo __('Languages');?></h2>

<table class="list"><tr>
	<th>&nbsp;</th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('locale');?></th>
	<th><?php echo $this->Paginator->sort('locale_fallback');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($languages as $language):
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

	if (!empty($language['Language']['code']) && in_array($language['Language']['code'].'.gif', $languageFlags)) {
		echo $this->Html->image('/tools/img/country_flags/'.$language['Language']['code'].'.gif');
	}
?>
		</td>
		<td>
			<?php echo h($language['Language']['name']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['ori_name']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['code']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['locale']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['locale_fallback']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($language['Language']['status'], __('Active'), __('Inactive')); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($language['Language']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $language['Language']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action'=>'edit', $language['Language']['id']), array('escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action'=>'delete', $language['Language']['id']), array('escape'=>false), __('Are you sure you want to delete # %s?', $language['Language']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

<div class="pagination-container">
<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?></div>

</div>

<br /><br />
Important Note:<br />
The language flags are actually country flags. Due to incompatabities between countries and languages they should not be used on public sites. They are only meant to be a help (eye catcher) for admin views.
<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Language')), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Compare %s', __('Languages')), array('action' => 'compare_to_iso_list')); ?></li>
		<li><?php echo $this->Html->link(__('Compare %s to core', __('Languages')), array('action' => 'compare_iso_list_to_core')); ?></li>
		<li><?php echo $this->Html->link(__('Import %s from Core', __('Language')), array('action' => 'import_from_core'), array(), __('Sure?')); ?></li>
		<li><?php echo $this->Html->link(__('Set primary languages active'), array('action' => 'set_primary_languages_active'), array(), __('Sure?')); ?></li>
	</ul>
</div>