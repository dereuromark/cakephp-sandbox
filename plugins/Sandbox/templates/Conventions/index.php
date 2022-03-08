<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Naming Conventions in CakePHP</h2>
<p>
First, you should definitly read <a href="https://book.cakephp.org/4.0/en/intro/conventions.html">cakephp-conventions.html</a>.
This should clarify the basics.
</p>

<p>
Bottom line: Controllers are plural, their tables plural as well, the entity is singular.
</p>

<h3>Class names and URLs</h3>
It is recommended to use the "DashedRoute" (which is tbe default since 3.1 anyway).

<p>
With a basic example, we take a closer look at the naming scheme in URLs:
</p>

<pre>/example-plugin/example-pages/action-name/passed-param?my-limit=1</pre>
<p>
This URL includes already all basic elements: A controller "ExamplePages" in the "ExamplePlugin" with an action "actionName"
as well as a passed param "passed-param" and query string "my-limit" with a value of "1".
<br />
If the controller had a model, its table class would be "ExamplePages" and the entity class "ExamplePage". The table would be "example_pages".
</p>

<p>
If you also use prefix routing (usually with the prefix "Admin") as well, this could be the
URL to the the same controller in that plugin:
</p>
<pre>/admin/example-plugin/example-pages/action-name/passed-param</pre>
<p>
What you need to understand is, that the class names as well as the prefixes and namespaces like plugins are CamelCase, but
the URL representation is always lowercase-dashed due to the "DashedRoute" class. Actions are camelBacked and also will get lowercase-dashed inside URLs.
</p>

<h3>Hands on</h3>
Try it out the different inflections with the <?php echo $this->Html->link('Inflector', ['controller' => 'inflector']); ?>.
