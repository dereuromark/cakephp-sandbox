<?php

$list=array();

$list[]=$this->Html->link(__('Home'), '/', array('title'=>''));

//$list[]=$this->Html->link('Code-Base','/codebase', array('title'=>'Overview - Codesnippets and CO'));

$list[]=$this->Html->link('Code-Snippet Categories', '/codesnippet_cats', array('title'=>''));
//$list[]=$this->Html->link('Code-Snippets','/codesnippets', array('title'=>''));
$list[]=$this->Html->link('Working Examples','/examples', array('title'=>''));
$list[]=$this->Html->link('Little Projects / Fun Apps', '/page/projects', array('title'=>'Show Project List'));

//$list[]=$this->Html->link('Questions/Problems','/todos', array('title'=>''));
//$list[]=$this->Html->link('ToDo\'s/Suggestions/Ideas','/todos', array('title'=>''));

$list[]=$this->Html->link('Useful tools','/misc', array('title'=>'Tools', 'escape'=>false));
$list[]=$this->Html->link('Tests','/testing/tests', array('title'=>'Tests', 'escape'=>false));

echo $this->Html->nestedList($list, array('class'=>'navigation'));

?>

<br /><br />

<b>Introducing Plugins</b>
Live CakePHP Plugins in Action

<ul>
<li><?php echo $this->Html->defaultLink('Translate', array('plugin'=>'translate', 'controller'=>'translate', 'action'=>'index'), array('title'=>''));?></li>
<li><?php echo $this->Html->defaultLink('Math', array('plugin'=>'math', 'controller'=>'math', 'action'=>'index'), array('title'=>''));?></li>
</ul>


<br /><br /><br />

<?php
if ($this->Session->check('Auth.User.id')) {
?>
Eingeloggt als '<b><?php echo h($this->Session->read('Auth.User.username'));?></b>'<br />
UID: <b><?php echo $this->Session->read('Auth.User.id')?></b><br />
Roles: <b><?php foreach ((array)$this->Session->read('Auth.User.Role') as $role) {echo $role.', ';}?></b>
<br />-- <?php echo $this->Html->link('Logout', array('plugin'=>false, 'admin'=>false, 'controller'=>'users', 'action'=>'logout'));?>--

<br /><br />
Admin-Navi
<br /><br />

<?php
$list = array();

$list[]=$this->Html->link('Admin', array('admin'=>true, 'controller'=>'overview', 'action'=>'index'), array('title'=>'Admin-Menü'));
$list[]=$this->Html->link('Translate Languages','/translate/translate_languages', array('title'=>'Translate Languages'));
$list[]=$this->Html->link('Translate Terms','/translate/translate_terms', array('title'=>'Translate Terms'));
//$list[]=$this->Html->link('Translate Dump','/admin/translate_terms', array('title'=>'Translate Dump'));

$list[]=$this->Html->link('Comments','/admin/codesnippetComments', array('title'=>''));
$list[]=$this->Html->link('Code-Snippet Cats','/admin/codesnippetCats', array('title'=>''));
$list[]=$this->Html->link('Code-Snippets','/admin/codesnippets', array('title'=>''));
$list[]=$this->Html->link('Examples','/admin/examples', array('title'=>''));
$list[]=$this->Html->link('ToDo\'s','/admin/todos', array('title'=>''));

echo $this->Html->nestedList($list, array('class'=>'navigation'));


if (Auth::hasRole(ROLE_SUPERADMIN)) {
	$list=array();

	$list[]=$this->Html->link(__('Users'), array('admin'=>false, 'controller'=>'users'), array('title'=>'Mitglieder'));



	//$list[]=$this->Html->link('ACL\'s update','/roles/acl_search', array('title'=>''));
	//$list[]=$this->Html->link('ACL edit','/roles/acl2', array('title'=>''));



	$list[]=$this->Html->link('Configurations','/admin/configurations', array('title'=>'All Configs and stuff'));
	$list[]=$this->Html->link('Clear Cache!','/admin/configurations/clearcache', array('title'=>'Delete Cache Files and Show Result'));
	$list[]=$this->Html->link('Clear Cache Silently!','/admin/configurations/clearcache/silent', array('title'=>'Delete Cache Files (silently)'));


	echo $this->Html->nestedList($list, array('class'=>'navigation'));
}

}
