<h2>Best practices</h2>
DOs and DONT's of common CakePHP problems.

<h3>Routing</h3>
Best to use the DashedRoute class (see <?php echo $this->Html->link('conventions', ['plugin' => 'Sandbox', 'controller' => 'Conventions', 'action' => 'index'])?>) as default one:
<pre><code>Router::defaultRouteClass('DashedRoute');
</code></pre>
This way your URLs are `my-prefix/my-plugin/controller-name/action-name` whereas your URL contains the CamelCase variants:
<pre><code>'prefix' => 'my-prefix // unmodified
'plugin' => 'MyPlugin, // camelCased
'controller' => 'ControllerName', // camelCased
'action' => 'actionName' // camelBacked
</code></pre>
The idea of CakePHP 3.x is to inflect internally as less as possible.

<h3>URLs</h3>
Use array URLs wherever possible, this saves you a lot of trouble once you actually want to customize the routing:
<pre><code>// URL /my-controller/my-action
echo $this->Html->link($title, ['controller' => 'MyController', 'action' => 'myAction']);
</code></pre>
You can then alter the URLs via Routing and all those URLs change cleanly.
The speed issue can be neglected compared to the advantages of the flexibility.

<h3>Don't sanitize the heck out your data</h3>
Use Sanitization wisely, and not blindly.<br />
Not without reason the Sanitize class has been kicked out of the core files.
<br /><br />
Sanitization is useful and necessary, when working with HTML content, that needs to be stripped of invalid/dangerous
markup. But here it is best to use <a href="https://github.com/FriendsOfCake/awesome-cakephp#filtering-and-validation">plugins</a> specifically
written for this job.
<br />
For most normal use cases, by using save(), SQL injections are already prevented. No need to modify the data upon save. Only use h() in the view
to secure (stringish) output by escaping potentially dangerous chars:
<pre><code>echo h($entity->name);
</code></pre>

<h3>Logging</h3>
By default the log streams catch all, even scoped logs that should only go to those scoped listeners.
As a result they are duplicated.
<br>
So I would change the scopes to false here for all default listeners:
<pre><code>// in your app.php config
'Log' => [
	'debug' => [
		'scopes' => false,
	],
	'error' => [
		'scopes' => false,
	],
	...
],
</code></pre>
