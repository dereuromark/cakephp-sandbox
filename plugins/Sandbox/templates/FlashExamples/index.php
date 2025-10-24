<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/flash'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Overview</h3>
	<p>
		The Flash plugin provides enhanced flash messaging capabilities for CakePHP applications, including:
	</p>
	<ul>
		<li><strong>Transient Messages:</strong> Temporary messages that can be displayed without page reload</li>
		<li><strong>Message Types:</strong> Success, error, warning, and info messages with customizable styling</li>
		<li><strong>AJAX Support:</strong> X-Flash header integration for seamless AJAX interactions</li>
		<li><strong>Grouped Messages:</strong> Organize messages by type for better user experience</li>
	</ul>

	<h3>Basic Flash Messages</h3>
	<p>
		Explore different types of flash messages and how to display them in your application.
	</p>
	<ul>
		<li><?php echo $this->Html->link('All flash message types', ['action' => 'messages']); ?> - See all available message types in action</li>
		<li><?php echo $this->Html->link('Grouped types', ['action' => 'messageGroups']); ?> - View-level message grouping</li>
	</ul>

	<h3>AJAX Integration</h3>
	<p>
		The Flash plugin seamlessly integrates with AJAX requests using the X-Flash header, allowing you to display flash messages without full page reloads.
	</p>
	<ul>
		<li><?php echo $this->Html->link('AJAX Buttons', ['action' => 'ajax']); ?> - Basic AJAX flash message handling</li>
		<li><?php echo $this->Html->link('AJAX with Ajax Plugin', ['action' => 'ajaxPlugin']); ?> - Advanced AJAX with redirect support</li>
		<li><?php echo $this->Html->link('AJAX Forms', ['controller' => 'AjaxExamples', 'action' => 'form']); ?> - Form submission with flash messages</li>
	</ul>

	<h3>Key Features</h3>
	<div class="row">
		<div class="col-md-6">
			<h4>X-Flash Header</h4>
			<p>Flash messages are automatically injected into the X-Flash response header for AJAX requests, making it easy to handle flash messages in JavaScript frameworks like HTMX.</p>
		</div>
		<div class="col-md-6">
			<h4>Transient Messages</h4>
			<p>Use <code>transientSuccess()</code>, <code>transientError()</code>, and other transient methods for temporary messages that don't persist across redirects.</p>
		</div>
	</div>

</div>
