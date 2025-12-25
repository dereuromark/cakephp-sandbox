<?php
/**
 * @var \App\View\AppView $this
 * @var bool $mercureConfigured
 */

if ($mercureConfigured) {
	$this->loadHelper('Mercure.Mercure');
}
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/mercure'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Client-Side Subscription</h3>

<p>
	Clients subscribe to Mercure topics using the native <code>EventSource</code> API (Server-Sent Events).
	The MercureHelper generates the subscription URL with proper topic query parameters.
</p>

<?php if (!$mercureConfigured) { ?>
<div class="alert alert-warning">
	<strong>Mercure Hub Not Configured</strong>
	<p class="mb-0">Live subscription demo requires a running Mercure hub. See the <a href="<?php echo $this->Url->build(['action' => 'index']); ?>">setup instructions</a>.</p>
</div>
<?php } ?>

<h4>Using MercureHelper</h4>
<p>Generate subscription URLs in your templates:</p>
<pre><code class="language-php">// Load the helper
$this->loadHelper('Mercure.Mercure');

// Single topic
$url = $this->Mercure->url('/books/123');

// Multiple topics
$url = $this->Mercure->url(['/books/123', '/notifications']);

// Using default topics (configured in helper/component)
$url = $this->Mercure->url();  // Uses defaultTopics from config</code></pre>

<h4>JavaScript Subscription</h4>
<pre><code class="language-javascript">// Create EventSource connection
const hubUrl = '<?php echo $mercureConfigured ? $this->Mercure->url(['/sandbox/demo']) : 'https://hub.example.com/.well-known/mercure?topic=/sandbox/demo'; ?>';
const eventSource = new EventSource(hubUrl);

// Handle incoming messages
eventSource.onmessage = (event) => {
    const data = JSON.parse(event.data);
    console.log('Received update:', data);
    // Update your UI here
};

// Handle connection opened
eventSource.onopen = () => {
    console.log('Connected to Mercure hub');
};

// Handle errors
eventSource.onerror = (error) => {
    console.error('EventSource error:', error);
};

// Close connection when done
// eventSource.close();</code></pre>

<h4>Live Demo</h4>
<?php if ($mercureConfigured) { ?>
<div class="card mb-4">
	<div class="card-header">
		<strong>Subscription Status</strong>
	</div>
	<div class="card-body">
		<p>
			<span id="connection-status" class="badge bg-secondary">Disconnected</span>
			<button id="connect-btn" class="btn btn-sm btn-primary ms-2">Connect</button>
			<button id="disconnect-btn" class="btn btn-sm btn-outline-secondary ms-2" disabled>Disconnect</button>
		</p>
		<p class="mb-0">Subscribing to: <code>/sandbox/demo</code></p>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header">
		<strong>Received Messages</strong>
		<button id="clear-messages" class="btn btn-sm btn-outline-secondary float-end">Clear</button>
	</div>
	<div class="card-body">
		<div id="messages" style="max-height: 300px; overflow-y: auto;">
			<p class="text-muted"><em>No messages yet. Connect and publish an update to see it here.</em></p>
		</div>
	</div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
    const hubUrl = '<?php echo $this->Mercure->url(['/sandbox/demo']); ?>';
    let eventSource = null;

    const statusEl = document.getElementById('connection-status');
    const messagesEl = document.getElementById('messages');
    const connectBtn = document.getElementById('connect-btn');
    const disconnectBtn = document.getElementById('disconnect-btn');
    const clearBtn = document.getElementById('clear-messages');

    function connect() {
        if (eventSource) return;

        eventSource = new EventSource(hubUrl);

        eventSource.onopen = () => {
            statusEl.className = 'badge bg-success';
            statusEl.textContent = 'Connected';
            connectBtn.disabled = true;
            disconnectBtn.disabled = false;
        };

        eventSource.onmessage = (event) => {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'alert alert-info mb-2';

            let content;
            try {
                const data = JSON.parse(event.data);
                content = '<pre class="mb-0">' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (e) {
                content = '<code>' + event.data + '</code>';
            }

            messageDiv.innerHTML = '<small class="text-muted">' + new Date().toLocaleTimeString() + '</small><br>' + content;

            // Remove placeholder
            const placeholder = messagesEl.querySelector('p.text-muted');
            if (placeholder) placeholder.remove();

            messagesEl.insertBefore(messageDiv, messagesEl.firstChild);
        };

        eventSource.onerror = () => {
            statusEl.className = 'badge bg-danger';
            statusEl.textContent = 'Error';
        };
    }

    function disconnect() {
        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }
        statusEl.className = 'badge bg-secondary';
        statusEl.textContent = 'Disconnected';
        connectBtn.disabled = false;
        disconnectBtn.disabled = true;
    }

    connectBtn.addEventListener('click', connect);
    disconnectBtn.addEventListener('click', disconnect);
    clearBtn.addEventListener('click', () => {
        messagesEl.innerHTML = '<p class="text-muted"><em>No messages yet.</em></p>';
    });
})();
<?php $this->Html->scriptEnd(); ?>
<?php } else { ?>
<div class="card mb-4 bg-light">
	<div class="card-body">
		<p class="text-muted mb-0">Live demo is disabled because Mercure is not configured.</p>
	</div>
</div>
<?php } ?>

<h4>Topic Patterns</h4>
<p>Mercure supports topic patterns for flexible subscriptions:</p>
<pre><code class="language-javascript">// Exact topic
const url = hubUrl + '?topic=/books/123';

// Wildcard pattern (all books)
const url = hubUrl + '?topic=/books/*';

// Multiple topics
const url = hubUrl + '?topic=/books/123&amp;topic=/notifications';</code></pre>

<h4>Private Topics</h4>
<p>For private topics, ensure the authorization cookie is set before connecting:</p>
<pre><code class="language-javascript">// EventSource automatically sends cookies
// Make sure to set { withCredentials: true } if cross-origin
const eventSource = new EventSource(hubUrl, { withCredentials: true });</code></pre>

<h4>React/Vue Integration</h4>
<pre><code class="language-javascript">// React hook example
function useMercure(topics) {
    const [messages, setMessages] = useState([]);

    useEffect(() => {
        const url = buildMercureUrl(topics);
        const eventSource = new EventSource(url);

        eventSource.onmessage = (event) => {
            const data = JSON.parse(event.data);
            setMessages(prev => [...prev, data]);
        };

        return () => eventSource.close();
    }, [topics]);

    return messages;
}</code></pre>

</div></div>
