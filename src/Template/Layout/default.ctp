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
echo $this->fetch('meta');

echo $this->AssetCompress->css('css-combined');
//echo $this->Html->css('BootstrapUI.bootstrap-u-i');
echo $this->Html->css('/sandbox/font-awesome/css/font-awesome');
echo $this->fetch('css');

echo $this->AssetCompress->script('js-combined');
echo $this->fetch('script');

?>
</head>
<body>
 <div id="container">

	<?php
		$navigation = [
		];
	?>

	<div id="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <?php echo $this->element('navigation'); ?>
      </div>
    </div>

		<div id="header">
			<h1><?php
echo $description;
?> <b>v3</b></h1>
		</div>
		<div id="content">

			<?php

echo $this->Flash->render();
?>

			<?php

echo $this->fetch('content');

?>
		</div>
		<div id="footer">
		<hr />

		<div style="float: right;">Running on CakePHP <?php echo Configure::version(); ?> / PHP <?php echo substr(phpversion(), 0, 3);?></div>

			Author: dereuromark | <a href="https://github.com/dereuromark/cakephp-sandbox">github.com/dereuromark/cakephp-sandbox</a> | <?php
echo $this->Html->resetLink('Contact', ['controller' => 'contact', 'action' => 'index']);
?>
		</div>
	</div>

</body>
</html>
