<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Ajax Plugin'), ['controller' => 'AjaxExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Using CakePHP Core only') ?></li>
	<li><?php echo $this->Navigation->link('Simple JSON response', ['action' => 'simple'])?></li>
	<li><?php echo $this->Navigation->link('Pagination', ['action' => 'pagination'])?></li>
	<li><?php echo $this->Navigation->link('Endless scroll (vertical pagination)', ['action' => 'endlessScroll'])?></li>
	<li><?php echo $this->Navigation->link('Redirecting', ['action' => 'redirecting'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Using Ajax Plugin') ?></li>
	<li><?php echo $this->Navigation->link('Toggle', ['action' => 'toggle'])?></li>
	<li><?php echo $this->Navigation->link('Forms', ['action' => 'form'])?></li>
	<li><?php echo $this->Navigation->link('Chained dropdowns', ['action' => 'chainedDropdowns'])?></li>
	<li><?php echo $this->Navigation->link('Redirecting (prevented)', ['action' => 'redirectingPrevented'])?></li>
</ul>
