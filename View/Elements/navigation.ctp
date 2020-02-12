<div class="navbar-header">
	<a href="<?php echo $this->Html->url('/')?>" class="navbar-brand">CakePHP Sandbox App</a>
	<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
</div>
<div class="navbar-collapse collapse" id="navbar-main">
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox"><span class="label label-danger">CakePHP 2.x</span> <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><a href="https://sandbox3.dereuromark.de/"><span class="label label-warning">CakePHP 3.x</span></a></li>
                <li><a href="https://sandbox4.dereuromark.de/"><span class="label label-success">CakePHP 4.x</span></a></li>
			</ul>
		</li>

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Basics <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Conventions', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'conventions', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('Best practice', array('plugin' => false, 'admin' => false, 'controller' => 'pages', 'action' => 'display', 'best-practices'), array('tabindex' => '-1')); ?></li>
			</ul>
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Sandbox <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="sandbox">
				<li><?php echo $this->Html->link('Overview', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'sandbox', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('CakePHP Core', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'cake_examples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('Tools Plugin', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'tools_examples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('JS', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'js_examples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li><?php echo $this->Html->link('Jquery', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'jquery_examples', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
				<li class="divider"></li>
				<li><?php echo $this->Html->link('Tryouts', array('plugin' => 'sandbox', 'admin' => false, 'controller' => 'tryouts', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
			</ul>
		</li>
		<li><?php echo $this->Html->link('(ISO) Data', array('plugin' => false, 'admin' => false, 'controller' => 'export', 'action' => 'index'), array('tabindex' => '-1')); ?></li>
		<li><a href="http://www.dereuromark.de">Blog</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<?php if (Auth::id()) { ?>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('home') . ' ' . 'Account', array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'index'), array('escape' => false)); ?></li>
	  	<li><?php echo $this->Html->link($this->Format->fontIcon('signout') . ' ' . __('Logout'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'logout'), array('escape' => false)); ?></li>
		<?php } else { ?>
		<li><?php echo $this->Html->link($this->Format->fontIcon('signin') . ' ' . __('Login'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'login'), array('escape' => false)); ?></li>
			<?php if (Configure::read('Config.allowRegister')) { ?>
			<li><?php echo $this->Html->link(__('Register'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'register')); ?></li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>
