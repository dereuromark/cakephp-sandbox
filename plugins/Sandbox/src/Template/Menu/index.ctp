<?php
/**
 * @var \App\View\AppView $this
 */
use Menu\Link\Link;
use Menu\Menu;

/**
 * To test and work on it:
 *
 * git checkout 3.0-menu
 *
 * composer update --ignore-platform-reqs
 *
 * and go to
 *
 * http://sandbox.local/sandbox/menu
 */

?>
<h2>Menu plugin</h2>
<p>
	Showcasing the CakePHP <a href="https://github.com/dereuromark/cakephp-menu" target="_blank">[Menu Plugin]</a>
</p>

<h3>Simple menu</h3>
<?php
	$menu = Menu::create();
	$item = $menu->newItem();
	$item->setLink(Link::create()->setUrl('/x')->setAttribute('target', '_blank'));
	$item->setLabel('My label');

	$menu->add($item);


	$result = $this->Menu->render($menu);
	echo $result;
?>
