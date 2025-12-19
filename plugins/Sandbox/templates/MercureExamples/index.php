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

<h3>What is Mercure?</h3>
<p>
	<a href="https://mercure.rocks/" target="_blank">Mercure</a> is an open protocol for real-time web APIs.
	It allows servers to push updates to clients in real-time using <strong>Server-Sent Events (SSE)</strong>.
</p>

<p>
	The <a href="https://github.com/josbeir/cakephp-mercure" target="_blank">cakephp-mercure</a> plugin provides seamless integration
	with Mercure hubs, offering:
</p>

<ul>
	<li><strong>Real-time push updates</strong> - Broadcast changes to connected clients instantly</li>
	<li><strong>Private/authorized updates</strong> - JWT-based access control for sensitive data</li>
	<li><strong>MercureComponent</strong> - Controller integration with fluent builder pattern</li>
	<li><strong>MercureHelper</strong> - Generate subscription URLs in your templates</li>
	<li><strong>Hub discovery</strong> - Automatic discovery via HTTP Link headers</li>
	<li><strong>View rendering</strong> - Publish rendered HTML fragments directly</li>
</ul>

<?php if (!$mercureConfigured) { ?>
<div class="alert alert-warning">
	<h5>Mercure Hub Not Configured</h5>
	<p class="mb-2">To use this plugin, you need a running Mercure hub. Quick start with Docker:</p>
	<pre class="mb-2"><code>docker run -d \
  --name mercure-sandbox \
  -e SERVER_NAME=:3080 \
  -e MERCURE_PUBLISHER_JWT_KEY='SandboxMercureSecretKey2024!' \
  -e MERCURE_SUBSCRIBER_JWT_KEY='SandboxMercureSecretKey2024!' \
  -e MERCURE_CORS_ALLOWED_ORIGINS='*' \
  -p 3080:3080 \
  dunglas/mercure</code></pre>
	<p class="mb-0">Then create <code>config/app_mercure.php</code> with the matching JWT secret.</p>
</div>
<?php } else { ?>
<div class="alert alert-success">
	<strong>Mercure is configured!</strong> The hub is available and the demos below are fully functional.
</div>
<?php } ?>

<h3>Basic Usage</h3>

<h4>Controller Setup</h4>
<p>Load the component in your controller:</p>
<pre><code class="language-php">public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('Mercure.Mercure', [
        'autoDiscover' => true,        // Automatic discovery headers
        'defaultTopics' => ['/notifications'],
    ]);
}</code></pre>

<h4>Publishing Updates</h4>
<p>Push real-time updates to connected clients:</p>
<pre><code class="language-php">// Publish JSON data
$this->Mercure->publishJson(
    topics: '/books/' . $book->id,
    data: ['status' => 'updated', 'title' => $book->title],
);

// Publish simple string/HTML
$this->Mercure->publishSimple(
    topics: '/notifications',
    data: 'New message received!',
);

// Publish rendered view/element
$this->Mercure->publishView(
    topics: '/dashboard',
    element: 'Dashboard/stats',
    data: ['stats' => $stats],
);</code></pre>

<h4>Client Subscription (JavaScript)</h4>
<p>Subscribe to updates in the browser:</p>
<pre><code class="language-javascript">// Using MercureHelper to generate URL
const url = '&lt;?= $this->Mercure->url(["/books/123"]) ?&gt;';
const eventSource = new EventSource(url);

eventSource.onmessage = (event) => {
    const data = JSON.parse(event.data);
    console.log('Update received:', data);
};</code></pre>

<h3>Key Features</h3>

<div class="row">
	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">Authorization</h5>
				<p class="card-text">Set JWT cookies for accessing private topics with the fluent builder pattern.</p>
				<?php echo $this->Html->link('View Demo', ['action' => 'authorization'], ['class' => 'btn btn-primary btn-sm']); ?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">Publishing</h5>
				<p class="card-text">Push updates to the Mercure hub from your controllers.</p>
				<?php echo $this->Html->link('View Demo', ['action' => 'publishing'], ['class' => 'btn btn-primary btn-sm']); ?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">Client Subscription</h5>
				<p class="card-text">Subscribe to topics and receive updates in real-time.</p>
				<?php echo $this->Html->link('View Demo', ['action' => 'subscription'], ['class' => 'btn btn-primary btn-sm']); ?>
			</div>
		</div>
	</div>
</div>

</div></div>
