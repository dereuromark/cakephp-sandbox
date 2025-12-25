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

<h3>Authorization for Private Topics</h3>

<p>
	Mercure supports <strong>private updates</strong> that are only delivered to authorized subscribers.
	Authorization is handled via JWT tokens stored in HTTP-only cookies.
</p>

<?php if (!$mercureConfigured) { ?>
<div class="alert alert-warning">
	<strong>Mercure Hub Not Configured</strong>
	<p class="mb-0">Authorization requires a running Mercure hub. See the <a href="<?php echo $this->Url->build(['action' => 'index']); ?>">setup instructions</a>.</p>
</div>
<?php } ?>

<h4>How It Works</h4>
<ol>
	<li>Server generates a JWT with allowed subscription topics</li>
	<li>JWT is stored in an HTTP-only cookie (sent automatically with SSE requests)</li>
	<li>Mercure hub validates the JWT and only delivers matching private updates</li>
</ol>

<h4>Try It Out</h4>
<?php if ($mercureConfigured) { ?>
<div class="card mb-4">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->create(null, ['url' => ['action' => 'authorization']]); ?>
				<?php echo $this->Form->hidden('action', ['value' => 'authorize']); ?>
				<?php echo $this->Form->button('Set Authorization Cookie', ['class' => 'btn btn-primary']); ?>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->create(null, ['url' => ['action' => 'authorization']]); ?>
				<?php echo $this->Form->hidden('action', ['value' => 'clear']); ?>
				<?php echo $this->Form->button('Clear Authorization', ['class' => 'btn btn-outline-secondary']); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="card mb-4 bg-light">
	<div class="card-body">
		<p class="text-muted mb-0">Authorization demo is disabled because Mercure is not configured.</p>
	</div>
</div>
<?php } ?>

<h4>Authorization Patterns</h4>

<h5>Fluent Builder Pattern</h5>
<p>Build up authorization with multiple topics and claims:</p>
<pre><code class="language-php">// Chain topics and authorize
$this->Mercure
    ->addSubscribe('/books/123', ['sub' => $userId])
    ->addSubscribe('/notifications/*', ['role' => 'user'])
    ->authorize();

// With discovery headers
$this->Mercure
    ->addTopic('/books/123')
    ->addSubscribe('/books/123', ['sub' => $userId])
    ->authorize()
    ->discover();</code></pre>

<h5>Direct Authorization</h5>
<p>Authorize with explicit topics array:</p>
<pre><code class="language-php">// Simple authorization
$this->Mercure->authorize(['/feeds/123', '/notifications/*']);

// With additional JWT claims
$this->Mercure->authorize(
    subscribe: ['/users/123/private'],
    additionalClaims: ['sub' => $userId, 'aud' => 'my-app'],
);</code></pre>

<h5>Clear Authorization</h5>
<p>Remove the authorization cookie (e.g., on logout):</p>
<pre><code class="language-php">public function logout()
{
    $this->Mercure->clearAuthorization();
    return $this->redirect(['action' => 'login']);
}</code></pre>

<h4>Private Updates</h4>
<p>Mark updates as private to require authorization:</p>
<pre><code class="language-php">// Only delivered to authorized subscribers
$this->Mercure->publishJson(
    topics: '/users/123/messages',
    data: ['text' => 'Private message'],
    private: true,
);</code></pre>

<h4>Hub Discovery</h4>
<p>Add Link headers for automatic hub discovery by clients:</p>
<pre><code class="language-php">// Basic discovery
$this->Mercure->discover();

// With subscription topics in the self URL
$this->Mercure
    ->addSubscribe('/books/123')
    ->authorize()
    ->discover(includeTopics: true);

// Or enable via component config
$this->loadComponent('Mercure.Mercure', [
    'autoDiscover' => true,
    'discoverWithTopics' => true,
]);</code></pre>

<h4>JWT Claims</h4>
<p>Common claims you might include:</p>
<table class="table">
	<thead>
		<tr>
			<th>Claim</th>
			<th>Purpose</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><code>sub</code></td>
			<td>Subject (user identifier)</td>
		</tr>
		<tr>
			<td><code>aud</code></td>
			<td>Audience (application identifier)</td>
		</tr>
		<tr>
			<td><code>role</code></td>
			<td>User role for topic-level access control</td>
		</tr>
		<tr>
			<td><code>exp</code></td>
			<td>Expiration time (added automatically)</td>
		</tr>
	</tbody>
</table>

</div></div>
