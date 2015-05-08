<h2>Naming Conventions in CakePHP</h2>
<p>
First, you should definitly read <a href="http://book.cakephp.org/3.0/en/intro/conventions.html">cakephp-conventions.html</a>.
This should clarify the basics.
</p>

<p>
Bottom line: Controllers are plural, their tables plural as well, the entity is singular.
</p>

<h3>Class names and URLs</h3>
It is recommended to use the "DashedRoute" (which will tbe default in 3.1 anyway).

<p>
With a basic example, we take a closer look at the naming scheme in URLs:
</p>

<pre>/example-plugin/example-pages/action-name/passed-param?limit=1</pre>
<p>
This URL includes already all basic elements: A controller "ExamplePages" in the "ExamplePlugin" with an action "actionName"
as well as a passed param "passed-param" and query string "limit" with a value of "1".
<br />
If the controller had a model, its table class would be "ExamplePages" and the entity class "ExamplePage". The table would be "example_pages".
</p>

<p>
If you also use prefix routing (usually with the prefix "admin") as well, this could be the
URL to the the same controller in that plugin:
</p>
<pre>/admin/example-plugin/example-pages/action-name/passed-param</pre>
<p>
What you need to understand is, that the class names as well as the namespaces like plugins are CamelCase, but
the URL representation is always lowercase-underscored (dashed) due to the "DashedRoute" class.
</p>

<h4>Coming from 2.x</h4>
If you upgrade a 2.x app, you can stick to the "InflectedRoute" however for BC and to stay URL-consistent for SEO reasons.
<pre>/example_plugin/example_pages/action_name/passed_param?limit=1</pre>
Would then resolve into a controller "ExamplePages" in the "ExamplePlugin" with an action "action_name" (!)
as well as a passed param "passed_param" and query string "limit" with a value of "1".


<h3>Hands on</h3>
Try it out the different inflections with the <?php echo $this->Html->link('Inflector', ['controller' => 'inflector']); ?>.
