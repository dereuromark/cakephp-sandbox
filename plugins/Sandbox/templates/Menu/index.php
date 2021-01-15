<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;

?>
<h2>Menu plugin</h2>
<p>
	<a href="https://github.com/icings/menu" target="_blank">[Icings/Menu Plugin]</a>
</p>

<h3>Simple menu</h3>
<?php
$menu = $this->Menu->create('my_menu');

$menu->addChild('Dashboard',
	['uri' => ['plugin' => false, 'controller' => 'Overview', 'action' => 'index']]);
$menu->addChild('Sandbox');
$menu->addChild('Coming soon');

$menu['Sandbox']->setUri(Router::url(['plugin' => 'Sandbox', 'controller' => 'Sandbox', 'action' => 'index']));
$menu['Sandbox']->addChild('Bootstrap', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Bootstrap', 'action' => 'index']]);
$menu['Sandbox']->addChild('Menu Index', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']]);
$menu['Sandbox']->addChild('Menu Index with Passed Param', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', 'foo']]);
$menu['Sandbox']->addChild('Menu Index with Query String', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', '?' => ['foo' => 'bar']]]);

echo $this->Menu->render('my_menu', ['currentClass' => 'active']);
?>

<p>Notes:
It seems that the "active" part does only work with the exact URL (here <code><?php echo h($this->Url->build(['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']));?></code>),
	not with the same action and just other passed params. Query strings are fine, though.</p>

<?php $this->append('css'); ?>
<style>
	#content li.active {
		font-weight: bold;
	}
</style>
<?php $this->end(); ?>

