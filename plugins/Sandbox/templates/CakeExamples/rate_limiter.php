<?php
/**
 * @var \App\View\AppView $this
 * @var int $requestCount
 */
?>

<div class="page index">
	<h2>Rate Limit Middleware</h2>

	<div class="alert alert-info">
		<h4>CakePHP 5.3 Feature</h4>
		<p>
			<strong>RateLimitMiddleware</strong> provides built-in request rate limiting to protect your application from abuse.
		</p>
		<p>
			This demo shows how to limit requests by IP address. Try refreshing this page multiple times quickly!
		</p>
	</div>

	<div class="card">
		<div class="card-body">
			<h3>Request Counter</h3>
			<p class="lead">You've made <strong><?= $requestCount ?></strong> requests in this session.</p>

			<div class="alert alert-warning">
				<strong>Rate Limit:</strong> 5 requests per minute per IP address
			</div>

			<p>If you exceed the limit, you'll receive a <code>429 Too Many Requests</code> response.</p>

			<button class="btn btn-primary" onclick="location.reload()">
				Make Another Request
			</button>
		</div>
	</div>

	<h3>Implementation Example</h3>
	<pre><code class="language-php">// src/Http/Middleware/DemoRateLimitMiddleware.php
use Cake\Http\Middleware\RateLimitMiddleware;

class DemoRateLimitMiddleware extends RateLimitMiddleware
{
    public function __construct()
    {
        parent::__construct([
            'limit' => 5,                   // Max requests
            'window' => 60,                 // Time window (seconds)
            'identifier' => 'ip',           // Identify by IP address
            'strategy' => 'sliding_window', // Rate limit strategy
            'headers' => true,              // Add X-RateLimit-* headers
        ]);
    }
}</code></pre>

	<h3>Features</h3>
	<ul>
		<li><strong>Multiple Strategies:</strong> <code>sliding_window</code>, <code>token_bucket</code>, or <code>fixed_window</code></li>
		<li><strong>Built-in Identifiers:</strong> <code>ip</code>, <code>user</code>, <code>session</code>, or custom via callback</li>
		<li><strong>Automatic Headers:</strong> Sends <code>X-RateLimit-Limit</code>, <code>X-RateLimit-Remaining</code>, <code>X-RateLimit-Reset</code></li>
		<li><strong>429 Response:</strong> Returns standard HTTP 429 status when limit exceeded</li>
		<li><strong>Cache Integration:</strong> Uses CakePHP cache for efficient rate tracking</li>
	</ul>

	<h3>Common Use Cases</h3>
	<ul>
		<li>API rate limiting (per API key or user)</li>
		<li>Login attempt throttling (prevent brute force)</li>
		<li>Contact form spam protection</li>
		<li>Resource-intensive endpoint protection</li>
	</ul>
</div>

<style>
pre {
	background: #f5f5f5;
	padding: 15px;
	border-radius: 5px;
	overflow-x: auto;
}
</style>
