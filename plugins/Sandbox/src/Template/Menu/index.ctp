<h2>KnpMenu plugin</h2>
<p>
	<a href="https://github.com/gourmet/knp-menu" target="_blank">[KnpMenu Plugin]</a>
</p>

<h3>Simple menu</h3>
<?php
	echo $this->Menu->render('my_menu', ['currentClass' => 'active']);
?>

<p>Notes:
It seems that the "active" part does only work with the exact URL (here <code><?php echo h($this->Url->build(['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']));?></code>), not with the same action and just other passed params or query strings.</p>

<style>
	#content li.active {
		font-weight: bold;
	}
</style>
