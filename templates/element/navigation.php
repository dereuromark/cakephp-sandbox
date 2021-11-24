<?php
/**
 * @var \App\View\AppView $this
 */
?>
<header class="container navbar navbar-default navbar-expand navbar-light flex-column flex-md-row bd-navbar">
	<a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="Sandbox" style="padding-right: 10px">
		CakePHP Sandbox App v4
	</a>

	<div class="navbar-nav-scroll">
		<ul class="navbar-nav bd-navbar-nav flex-row">
			<li class="nav-item dropdown">
				<a class="nav-item nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
					<span class="badge badge-success">CakePHP 4.x</span> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="sandbox">
					<li class="nav-item"><a class="nav-link" href="https://sandbox3.dereuromark.de/"><span class="badge badge-warning">CakePHP 3.x</span></a></li>
					<li class="nav-item"><a class="nav-link" href="https://sandbox2.dereuromark.de/"><span class="badge badge-danger">CakePHP 2.x</span></a></li>
				</ul>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="basics">Basics <span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="sandbox">
					<li class="nav-item"><?php echo $this->Html->linkReset('Conventions', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Conventions', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Inflector', ['plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>

					<li class="dropdown-divider"></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Beginner tips', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'beginner-tips'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Best practice', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'best-practices'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>

					<li class="dropdown-divider"></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('<span class="fa fa-pencil"></span> Contribute', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'contribute'], ['class' => 'nav-link', 'tabindex' => '-1', 'escape' => false]); ?></li>
				</ul>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Sandbox <span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="sandbox">
					<li class="nav-item"><?php echo $this->Html->linkReset('Overview', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Sandbox', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="dropdown-divider"></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('CakePHP Core', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'CakeExamples', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('CakePHP Plugins', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'PluginExamples', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Auth Sandbox', ['plugin' => 'AuthSandbox', 'admin' => false, 'controller' => 'AuthSandbox', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Workflow Sandbox', ['plugin' => 'StateMachineSandbox', 'admin' => false, 'controller' => 'StateMachineSandbox', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="dropdown-divider"></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('MediaEmbed', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'MediaEmbed', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('JS', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JsExamples', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Jquery', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'JqueryExamples', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
					<li class="nav-item"><?php echo $this->Html->linkReset('Tryouts', ['plugin' => 'Sandbox', 'admin' => false, 'controller' => 'Tryouts', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
				</ul>
			</li>
			<li class="nav-item"><?php echo $this->Html->linkReset('(ISO) Data', ['plugin' => false, 'admin' => false, 'controller' => 'Export', 'action' => 'index'], ['class' => 'nav-link', 'tabindex' => '-1']); ?></li>
			<li class="nav-item"><a class="nav-link" href="http://www.dereuromark.de"><span class="fa fa-rss"></span> Blog</a></li>

		</ul>
	</div>
</header>

	<?php if (false) { ?>
	<ul class="nav navbar-nav navbar-right">
		<?php if ($this->AuthUser->id()) { ?>
	  	<li class="nav-item"><?php echo $this->Html->linkReset($this->Format->fontIcon('home') . ' ' . 'Account', ['plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'index'], ['escape' => false]); ?></li>
	  	<li class="nav-item"><?php echo $this->Html->linkReset($this->Format->fontIcon('signout') . ' ' . __('Logout'), ['plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'logout'], ['escape' => false]); ?></li>
		<?php } else { ?>
		<li class="nav-item"><?php //echo $this->Html->linkReset($this->Format->fontIcon('signin') . ' ' . __('Login'), array('plugin' => false, 'admin' => false, 'controller' => 'account', 'action' => 'login'), array('escape' => false)); ?></li>
			<?php if ($this->Configure->read('Config.allowRegister')) { ?>
			<li class="nav-item"><?php echo $this->Html->linkReset(__('Register'), ['plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'register']); ?></li>
			<?php } ?>
		<?php } ?>
	</ul>
	<?php } ?>
