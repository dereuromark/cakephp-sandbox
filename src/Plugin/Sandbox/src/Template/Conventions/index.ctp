<h2>Naming Conventions in CakePHP</h2>
<p>
First, you should definitly read <a href="http://book.cakephp.org/2.0/en/getting-started/cakephp-conventions.html">cakephp-conventions.html</a>.
This should clarify the basics.
</p>

<p>
Bottom line: Controllers are plural, their models singular.
</p>

<h3>Class names and URLs</h3>
<p>
Then, with a basic request, we take a closer look at the naming scheme in URLs:
</p>

<pre>/example_pages/action_name/passed_param?limit=1</pre>
<p>
This url includes already all basic elements: A controller "ExamplePages" with an action "action_name"
as well as a passed param "passed_param" and query string "limit" with a value of "1".
<br />
If the controller has a model, its name would be "ExamplePage".
</p>

<p>
If you also use prefix routing (usually with the prefix "admin") as well as a plugin "Data", this could be the
url to the the same controller in that plugin:
</p>
<pre>/admin/data/example_pages/action_name/passed_param</pre>
<p>
What you need to understand is, that the class names as well as the namespaces like plugins are CamelCase, but
the url representation is always lowercase_underscored (snake_case).
This is what many confuse and what will hopefully not be supported in 3.x anymore. The ambiguity is not good for SEO purposes for example.
</p>

<h3>Hands on</h3>
Try it out with the <?php echo $this->Html->link('Inflector', array('controller' => 'inflector')); ?>.