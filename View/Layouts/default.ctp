<?php
$description = 'CakePHP Sandbox App';
?>
<!DOCTYPE html>
<html>
<head>
	<?php

echo $this->Html->charset();

?>
	<title>
		<?php

echo $description

?>:
		<?php

echo $title_for_layout;

?>
	</title>
	<?php

echo $this->Html->meta('icon');

echo $this->Html->css('bootstrap');
echo $this->Html->css('app');
echo $this->Html->css('/sandbox/font-awesome/css/font-awesome');

echo $this->Html->script('jquery/jquery');
echo $this->Html->script('bootstrap');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

?>
</head>
<body>
 <div id="container">


	<div id="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="/" class="navbar-brand">CakePHP Sandbox App</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="sandbox">Sandbox <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="sandbox">
                <li><a tabindex="-1" href="./sandbox/cake_examples/">Core</a></li>

								<li class="divider"></li>

								<li><?php echo $this->Html->link('JS', array('plugin' => 'sandbox', 'admin' => false, 'controller'=>'js_examples', 'action'=>'index'), array('tabindex' => '-1')); ?></li>
								<li><?php echo $this->Html->link('Jquery', array('plugin' => 'sandbox', 'admin' => false, 'controller'=>'jquery_examples', 'action'=>'index'), array('tabindex' => '-1')); ?></li>

                <li class="divider"></li>

                <li><a tabindex="-1" href="/sandbox/tools_examples">Tools</a></li>

                <li class="divider"></li>

								<li><a tabindex="-1" href="/export">(ISO) Data - Download</a></li>
              </ul>
            </li>

            <li>
              <a href="http://www.dereuromark.de">Blog</a>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
          <?php if (Auth::id()) { ?>
          	<li><?php echo $this->Html->link($this->Format->fontIcon('home') . ' ' .'Account', array('plugin'=>false, 'admin'=>false, 'controller'=>'account', 'action'=>'index'), array('escape' => false)); ?></li>
          	<li><?php echo $this->Html->link($this->Format->fontIcon('signout') . ' ' . __('Logout'), array('plugin'=>false, 'admin'=>false, 'controller'=>'account', 'action'=>'logout'), array('escape' => false)); ?></li>
					<?php } else { ?>
						<li><?php echo $this->Html->link($this->Format->fontIcon('signin') . ' ' . __('Login'), array('plugin'=>false, 'admin'=>false, 'controller'=>'account', 'action'=>'login'), array('escape' => false)); ?></li>
						<?php if (Configure::read('Config.allow_register')) {
		echo '<li>' . $this->Html->link(__('Register'), array('plugin'=>false, 'admin'=>false, 'controller'=>'users', 'action'=>'register')) .'</li>';
	} ?>
					<?php } ?>
          </ul>

        </div>
      </div>
    </div>

		<div id="header">
			<h1><?php
echo $description;
?></h1>
		</div>
		<div id="content">

			<?php
echo $this->Session->flash();
echo $this->Common->flash();
?>

			<?php

echo $this->fetch('content');

?>
		</div>
		<div id="footer">
		<hr />
			Author: dereuromark | <a href="https://github.com/dereuromark/cakephp-sandbox">github.com/dereuromark/cakephp-sandbox</a> | <?php
echo $this->Html->link('Contact', array('plugin' => false, 'admin' => false, 'controller' => 'contact', 'action' => 'index'));

?>
		</div>
	</div>

<?php
if (CakePlugin::loaded('Setup')) {
	$debug = (int)Configure::read('debug');
	if ($debug > 0 && Configure::read('Debug.helper')) {
		$this->loadHelper('Setup.Debug', $debug);

		echo $this->Debug->show();
	}
} else {
	echo $this->element('sql_dump');
}
?>
</body>
</html>
