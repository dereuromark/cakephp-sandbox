<h2>KnpMenu plugin</h2>
<p>
	<a href="https://github.com/gourmet/knp-menu" target="_blank">[KnpMenu Plugin]</a>
</p>

<h3>Simple menu</h3>
<?php
	echo $this->Menu->render('my_menu', ['currentClass' => 'active']);
?>



<style>
	#content li.active {
		font-weight: bold;
	}
</style>
