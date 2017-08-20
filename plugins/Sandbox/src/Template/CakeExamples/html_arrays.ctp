<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Working with HTML arrays and CakePHP's entities</h2>
<p>
When creating single entities, the method is pretty simple and there are many examples. When creating multiple entities with one post
thing start to get a little more difficult, but with little effort you could achieve this.

We want to achieve this by mocking what a single entity looks like.
</p>

<pre>
 $this->Form->control('person.1.name');
 $this->Form->control('person.1.phone');
 $this->Form->control('person.1.email');
 
 $this->Form->control('person.2.name');
 $this->Form->control('person.2.phone');
 $this->Form->control('person.2.email');
</pre>

When we run this, we get:

<pre>
  [
	'person' => [
		(int) 1 => [
			'name' => 'Test1',
			'phone' => '111-111-1111',
			'email' => '111@1.com',
		],
		(int) 2 => [
			'name' => 'Test2',
			'phone' => '222-222-2222',
			'email' => '222@2.com',
		]
	]
]
</pre>

To create multiple entities, in our Controller:

<pre>
  $people = $this->People->newEntities($this->request->getData('person'));
</pre>

<p>
Note:
If you wanted to dynamically create an unsaid amount of entries, you could use javascript to count the amount of fields already present,
and use that count to append new "Entities" to your form.
</p>
