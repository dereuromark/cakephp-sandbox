<div class="navbar-header">
	<a href="<?php echo $this->Url->build('/')?>" class="navbar-brand">CakePHP Sandbox App</a>
	<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
</div>
<div class="navbar-collapse collapse" id="navbar-main">
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Basics <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Conventions', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Conventions', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('Inflector', array('plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index'), array('tabindex' => '-1')); ?></li>

				<li class="divider"></li>
				<li><?php echo $this->Html->link('Best practice', array('plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'best-practices'), array('tabindex' => '-1')); ?></li>

				<li class="divider"></li>
				<li><?php echo $this->Html->link('Contribute', array('plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'contribute'), array('tabindex' => '-1')); ?></li>
			</ul>
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Sandbox <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Overview', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Sandbox', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('CakePHP Core', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'CakeExamples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('CakePHP Plugins', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'PluginExamples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('JS', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JsExamples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('Jquery', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JqueryExamples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('Tryouts', array('plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Tryouts', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
			</ul>
		</li>
		<li><?php echo $this->Html->link('(ISO) Data', array('plugin' => false, 'admin' => false, 'controller' => 'Export', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
		<li><a href="http://www.dereuromark.de">Blog</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<?php if ($this->AuthUser->id()) { ?>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('home') . ' ' . 'Account', array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'index'), array('escape' => false)); ?></li>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('signout') . ' ' . __('Logout'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'logout'), array('escape' => false)); ?></li>
		<?php } else { ?>
		<li><?php //echo $this->Html->link($this->Format->fontIcon('signin') . ' ' . __('Login'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'login'), array('escape' => false)); ?></li>
			<?php if (Configure::read('Config.allowRegister')) { ?>
			<li><?php echo $this->Html->link(__('Register'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'register')); ?></li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>
