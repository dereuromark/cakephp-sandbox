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
		<?php echo $description; ?>:
		<?php echo $this->fetch('title'); ?>
	</title>

<?php
echo $this->Html->meta('icon');

echo $this->Html->css('bootstrap');
echo $this->Html->css('app');
echo $this->Html->css('flash_messages');
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

	<?php
		$navigation = array(
		);
	?>

	<div id="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <?php echo $this->element('navigation'); ?>
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
echo $this->Flash->flash();
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
