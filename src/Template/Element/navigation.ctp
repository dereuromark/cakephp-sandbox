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
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="label label-success">CakePHP 3.x</span> <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><a href="http://sandbox.dereuromark.de/"><span class="label label-warning">CakePHP 2.x</span></a></li>

			</ul>
		</li>

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="basics">Basics <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Conventions', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Conventions', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li><?php echo $this->Html->link('Inflector', ['plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index'], ['tabindex' => '-1']); ?></li>

				<li class="divider"></li>
				<li><?php echo $this->Html->link('Beginner tips', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'beginner-tips'], ['tabindex' => '-1']); ?></li>
				<li><?php echo $this->Html->link('Best practice', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'best-practices'], ['tabindex' => '-1']); ?></li>

				<li class="divider"></li>
				<li><?php echo $this->Html->link('Contribute', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'contribute'], ['tabindex' => '-1']); ?></li>
			</ul>
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Sandbox <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Overview', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Sandbox', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('CakePHP Core', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'CakeExamples', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li><?php echo $this->Html->link('CakePHP Plugins', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'PluginExamples', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li><?php echo $this->Html->link('JS', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JsExamples', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li><?php echo $this->Html->link('Jquery', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JqueryExamples', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('Tryouts', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Tryouts', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
			</ul>
		</li>
		<li><?php echo $this->Html->link('(ISO) Data', ['plugin' => false, 'admin' => false, 'controller' => 'Export', 'action' => 'index'], ['tabindex' => '-1']); ?></li>
		<li><a href="http://www.dereuromark.de">Blog</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<?php if ($this->AuthUser->id()) { ?>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('home') . ' ' . 'Account', ['plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'index'], ['escape' => false]); ?></li>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('signout') . ' ' . __('Logout'), ['plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'logout'], ['escape' => false]); ?></li>
		<?php } else { ?>
		<li><?php //echo $this->Html->link($this->Format->fontIcon('signin') . ' ' . __('Login'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'login'), array('escape' => false)); ?></li>
			<?php if (Configure::read('Config.allowRegister')) { ?>
			<li><?php echo $this->Html->link(__('Register'), ['plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'register']); ?></li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>
