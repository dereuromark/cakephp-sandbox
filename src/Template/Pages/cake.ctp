<h2>CakePHP - Rapid Development Framework</h2>

<p><?php echo __('My Version') ?>: <?php echo Configure::read('Cake.version');?></p>

<h2>What is CakePHP?</h2>
It is one of the most powerful Frameworks for PHP.
<br />
Framework means you don't have to write functions for every little task. The framework provides you with basic functionality which you can extend.<br />
<?php echo $this->Html->link('CakePHP', 'http://www.cakephp.org'); ?> is easier to learn than many other frameworks - and comes with very handy features.

<p>
<h2><?php echo __('Advantages') ?></h2>
Using commonly known design patterns like MVC and ORM within the convention over configuration paradigm, CakePHP reduces development costs and helps developers write less code.
<br /><br />
What speaks for CakePHP:
<?php
$list = [];

$list[] = 'Very clean code (all css/js etc together with the scaffolds in "view" - all models with their validation rules and most of the database access routines in "model" - all the action itself in the "controller"). Makes it easy to find errors, to add new features etc.';
$list[] = 'Reusable code - you can use your module files in other projects by just copying and pasting them';
$list[] = 'Helps to stick to the "Never repeat yourself" principle';
$list[] = 'Standard platform for developing - several coders can share parts of their work - all kinds of components/helpers/plugins from others will easily be usable in your site';
$list[] = 'It saves a lot of time once you\'re used to it. All the little things are done by the framework - so that you can concentrate on the implementation of your site content.';

echo $this->Html->nestedList($list, ['class' => 'features']);

?>

<ul class="features">
<li><strong>No Configuration</strong> - Set-up the database and let the magic begin</li>
<li><strong>Flexible License</strong> - Distributed under the MIT License</li>
<li><strong>Best Practices</strong> - covering security, authentication, and session handling, among the many other features.</li>
<li><strong>OO</strong> - Whether you are a seasoned object-oriented programmer or a beginner, you&#8217;ll feel comfortable</li>

</ul>

</p>


<p>
<h2><?php echo __('Interesting Links') ?></h2>
Manual and Communities
<?php
$list = [];

//$list[]=$this->Html->link('CakePHP - the MANUAL (very helpful)','/manual/', array('target'=>'_blank'));
$list[] = $this->Html->link('CakePHP - the MANUAL (very helpful)', 'http://book.cakephp.org/complete/3/the-manual', ['target' => '_blank']);

$list[] = $this->Html->link('CakePHP API (Code Reference)', 'http://api.cakephp.org', ['target' => '_blank']);
$list[] = $this->Html->link('CakePHP Codesnippets/Tutorials', 'http://bakery.cakephp.org/', ['target' => '_blank']);

$list[] = $this->Html->link('Unofficial CakePHP Forum (!)', 'http://cakephpforum.net', ['target' => '_blank']);
$list[] = $this->Html->link('CakePHP German Forum (the smaller one)', 'http://www.cakephp-forum.com', ['target' => '_blank']);

$list[] = $this->Html->link('CakePHP Google Group (the biggest around?)', 'http://groups.google.com/group/cake-php', ['target' => '_blank']);
$list[] = $this->Html->link('CakePHP German Google Group (the smaller one)', 'http://groups.google.com/group/cakephp-de', ['target' => '_blank']);

echo $this->Html->nestedList($list, ['class' => 'links']);

echo '<br>Examples and Code Pieces';
$list = [];

$list[] = $this->Html->link('CakePHP Links (Blogs etc.)', 'http://cakephp.org/#read', ['target' => '_blank']);
$list[] = $this->Html->link('A nice CakePHP Introduction (German)', 'http://blog.dievolution.net/cakephp/cakephp-einfuhrung/', ['target' => '_blank']);
$list[] = $this->Html->link('Good to know about these little things', 'http://teknoid.wordpress.com/category/cakephp/', ['target' => '_blank']);
$list[] = $this->Html->link('And about these too', 'http://labs.iamkoa.net/category/cakephp/', ['target' => '_blank']);
$list[] = $this->Html->link('Page: reazulk', 'http://reazulk.wordpress.com/category/cakephp/', ['target' => '_blank']);
$list[] = $this->Html->link('Blog: Adam Royle', 'http://blogs.bigfish.tv/adam/category/cakephp/', ['target' => '_blank']);
$list[] = $this->Html->link('Blog: m3nt0r', 'http://www.m3nt0r.de/blog/2007/07/29/cakephp-sanitize-fur-alle-controller/', ['target' => '_blank']);
$list[] = $this->Html->link('Blog: ad7six', 'http://www.ad7six.com/MiBlog/Blogs/Index/CakePHP', ['target' => '_blank']);
$list[] = $this->Html->link('ACL with Ajax', 'http://dev.newnewmedia.com/cakephp/admin/acl/permissions', ['target' => '_blank']);

echo $this->Html->nestedList($list, ['class' => 'links']);



echo '<br>Other Links';
$list = [];

$list[] = $this->Html->link('Code-Snippets to test your application against XSS Hackings', 'http://ha.ckers.org/xss.html', ['target' => '_blank']);

echo $this->Html->nestedList($list, ['class' => 'links']);
?>
</p>
