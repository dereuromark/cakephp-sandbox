<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Bootstrap UI Examples</h2>
<p>
	<a href="https://github.com/FriendsOfCake/bootstrap-ui" target="_blank">[BootstrapUI Plugin]</a>
</p>

<h3>Helpers</h3>
<p>Using Bootstrap v5 components with CakePHP.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('FormHelper') ?></li>
	<li><?php echo $this->Navigation->link('Basic Form', ['action' => 'form'])?></li>
	<li><?php echo $this->Navigation->link('Form Post & Defaults', ['action' => 'formPost'])?></li>
	<li><?php echo $this->Navigation->link('Localized Inputs', ['action' => 'localized'])?></li>
	<li><?php echo $this->Navigation->link('Time Inputs', ['action' => 'time'])?></li>

	<li class="heading"><?= __('Other Helpers') ?></li>
	<li><?php echo $this->Navigation->link('Flash Messages', ['action' => 'flash'])?></li>
	<li><?php echo $this->Navigation->link('Post Links', ['action' => 'postLink'])?></li>
	<li><?php echo $this->Navigation->link('Badges & Icons (Html)', ['action' => 'html'])?></li>
	<li><?php echo $this->Navigation->link('Pagination', ['action' => 'pagination'])?></li>
	<li><?php echo $this->Navigation->link('Breadcrumbs', ['action' => 'breadcrumbs'])?></li>
</ul>
