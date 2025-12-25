<?php
/**
 * @var \App\View\AppView $this
 * @var bool $mercureConfigured
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/mercure'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Publishing Updates</h3>

<p>
	The Mercure component provides several methods to publish updates to connected clients.
	All publishing happens server-side - the update is sent to the Mercure hub, which then pushes it to all subscribed clients.
</p>

<?php if (!$mercureConfigured) { ?>
<div class="alert alert-warning">
	<strong>Mercure Hub Not Configured</strong>
	<p class="mb-0">Publishing requires a running Mercure hub. See the <a href="<?php echo $this->Url->build(['action' => 'index']); ?>">setup instructions</a>.</p>
</div>
<?php } ?>

<h4>Try It Out</h4>
<?php if ($mercureConfigured) { ?>
<div class="card mb-4">
	<div class="card-body">
		<?php echo $this->Form->create(null, ['url' => ['action' => 'publishing']]); ?>
		<div class="mb-3">
			<?php echo $this->Form->control('topic', [
				'label' => 'Topic',
				'default' => '/sandbox/demo',
				'help' => 'The topic URL that clients subscribe to',
			]); ?>
		</div>
		<div class="mb-3">
			<?php echo $this->Form->control('message', [
				'label' => 'Message',
				'default' => 'Hello from CakePHP Sandbox!',
				'help' => 'The message content to publish',
			]); ?>
		</div>
		<div class="mb-3">
			<?php echo $this->Form->control('type', [
				'label' => 'Type',
				'type' => 'select',
				'options' => ['json' => 'JSON (structured data)', 'simple' => 'Simple (plain text)'],
				'default' => 'json',
			]); ?>
		</div>
		<?php echo $this->Form->button('Publish Update', ['class' => 'btn btn-primary']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php } else { ?>
<div class="card mb-4 bg-light">
	<div class="card-body">
		<p class="text-muted mb-0">Publishing form is disabled because Mercure is not configured.</p>
	</div>
</div>
<?php } ?>

<h4>Publishing Methods</h4>

<h5>publishJson()</h5>
<p>Publish structured JSON data. The data is automatically encoded:</p>
<pre><code class="language-php">// Simple JSON publish
$this->Mercure->publishJson(
    topics: '/books/123',
    data: ['status' => 'updated', 'title' => 'New Title'],
);

// Multiple topics
$this->Mercure->publishJson(
    topics: ['/books/123', '/notifications'],
    data: ['message' => 'Book updated'],
);

// Private update (requires authorization)
$this->Mercure->publishJson(
    topics: '/users/123/private',
    data: ['secret' => 'message'],
    private: true,
);

// With event metadata
$this->Mercure->publishJson(
    topics: '/events',
    data: ['action' => 'created'],
    id: 'event-123',
    type: 'book.created',
    retry: 5000,  // Retry delay in ms
);</code></pre>

<h5>publishSimple()</h5>
<p>Publish raw string data without encoding - useful for pre-formatted content:</p>
<pre><code class="language-php">// Plain text
$this->Mercure->publishSimple(
    topics: '/notifications',
    data: 'Server maintenance in 5 minutes',
);

// Pre-encoded JSON
$json = json_encode(['custom' => 'structure']);
$this->Mercure->publishSimple('/updates', $json);

// HTML fragment for direct DOM insertion
$html = '&lt;div class="alert"&gt;New notification&lt;/div&gt;';
$this->Mercure->publishSimple('/alerts', $html);</code></pre>

<h5>publishView()</h5>
<p>Render a CakePHP element or template and publish the HTML:</p>
<pre><code class="language-php">// Render and publish an element
$this->Mercure->publishView(
    topics: '/books/123',
    element: 'Books/item',
    data: ['book' => $book],
);

// Render a template with layout
$this->Mercure->publishView(
    topics: '/dashboard',
    template: 'Dashboard/stats',
    layout: 'ajax',
    data: ['stats' => $stats],
);</code></pre>

<h5>publish()</h5>
<p>Publish a custom Update object for full control:</p>
<pre><code class="language-php">use Mercure\Update\JsonUpdate;

// Using the builder pattern
$update = (new JsonUpdate('/books/123'))
    ->data(['status' => 'available'])
    ->private(true)
    ->id('update-456')
    ->build();

$this->Mercure->publish($update);</code></pre>

<h4>Update Types</h4>
<table class="table">
	<thead>
		<tr>
			<th>Class</th>
			<th>Use Case</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><code>JsonUpdate</code></td>
			<td>Structured data that needs JSON encoding</td>
		</tr>
		<tr>
			<td><code>SimpleUpdate</code></td>
			<td>Raw strings, pre-encoded JSON, HTML fragments</td>
		</tr>
		<tr>
			<td><code>ViewUpdate</code></td>
			<td>Rendered CakePHP templates/elements</td>
		</tr>
	</tbody>
</table>

</div></div>
