<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Ajax Plugin'), ['controller' => 'AjaxExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Using CakePHP Core only') ?></li>
	<li><?php echo $this->Html->link('Simple JSON response', ['action' => 'simple'])?></li>
	<li><?php echo $this->Html->link('Pagination', ['action' => 'pagination'])?></li>
	<li><?php echo $this->Html->link('Endless scroll (vertical pagination)', ['action' => 'endlessScroll'])?></li>
	<li><?php echo $this->Html->link('Redirecting', ['action' => 'redirecting'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Using Ajax Plugin') ?></li>
	<li><?php echo $this->Html->link('Toggle', ['action' => 'toggle'])?></li>
	<li><?php echo $this->Html->link('Forms', ['action' => 'form'])?></li>
	<li><?php echo $this->Html->link('Chained dropdowns', ['action' => 'chained_dropdowns'])?></li>
	<li><?php echo $this->Html->link('Redirecting (prevented)', ['action' => 'redirecting_prevented'])?></li>
</ul>
