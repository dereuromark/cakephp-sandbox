<?php
/**
 * @var \App\View\AppView $this
 * @var bool $mercureConfigured
 * @var string|null $mercurePublicUrl
 */

$this->assign('title', 'Real-Time Chat Demo');
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/mercure'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Real-Time Chat Demo</h3>

<p class="text-muted">
	Open this page in multiple browser windows or tabs to see messages appear instantly across all clients.
	This demonstrates Mercure's real-time messaging capabilities.
</p>

<?php if (!$mercureConfigured): ?>
	<div class="alert alert-warning">
		<strong>Mercure not configured.</strong>
		Copy <code>config/app_mercure.php</code> to your local config and configure the Mercure hub URL.
	</div>
<?php else: ?>

<div class="card mb-3">
	<div class="card-header d-flex justify-content-between align-items-center">
		<span>Chat Messages</span>
		<span>
			<span class="badge bg-info me-2">Topic: /sandbox/chat</span>
			<span class="badge bg-secondary" id="connection-status">Connecting...</span>
		</span>
	</div>
	<div class="card-body" style="height: 350px; overflow-y: auto;" id="messages-container">
		<div class="text-center text-muted" id="no-messages">
			<em>No messages yet. Be the first to say something!</em>
		</div>
	</div>
	<div class="card-footer">
		<form id="chat-form" class="row g-2">
			<div class="col-4 col-md-3">
				<input type="text" class="form-control" id="chat-name" placeholder="Your name" maxlength="50" required>
			</div>
			<div class="col-8 col-md-7">
				<input type="text" class="form-control" id="chat-message" placeholder="Type your message..." maxlength="500" required>
			</div>
			<div class="col-12 col-md-2">
				<button type="submit" class="btn btn-primary w-100" id="send-btn">Send</button>
			</div>
		</form>
	</div>
</div>

<p class="small text-muted">
	<strong>How it works:</strong> Enter your name and message, click Send. The message is published to the Mercure hub,
	which instantly pushes it to all connected clients via Server-Sent Events. No polling required.
	<span class="float-end">Messages received: <strong id="message-count">0</strong></span>
</p>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const mercureUrl = <?= json_encode($mercurePublicUrl) ?>;
	const topic = '/sandbox/chat';
	const messagesContainer = document.getElementById('messages-container');
	const noMessages = document.getElementById('no-messages');
	const chatForm = document.getElementById('chat-form');
	const chatName = document.getElementById('chat-name');
	const chatMessage = document.getElementById('chat-message');
	const sendBtn = document.getElementById('send-btn');
	const connectionStatus = document.getElementById('connection-status');
	const messageCount = document.getElementById('message-count');
	let count = 0;

	// Load saved name from localStorage
	const savedName = localStorage.getItem('mercure-chat-name');
	if (savedName) {
		chatName.value = savedName;
	}

	// Subscribe to Mercure topic
	const url = new URL(mercureUrl);
	url.searchParams.append('topic', topic);

	const eventSource = new EventSource(url);

	eventSource.onopen = function() {
		connectionStatus.textContent = 'Connected';
		connectionStatus.classList.remove('bg-secondary', 'bg-danger');
		connectionStatus.classList.add('bg-success');
	};

	eventSource.onerror = function() {
		connectionStatus.textContent = 'Disconnected';
		connectionStatus.classList.remove('bg-secondary', 'bg-success');
		connectionStatus.classList.add('bg-danger');
	};

	eventSource.onmessage = function(event) {
		const data = JSON.parse(event.data);
		addMessage(data);
		count++;
		messageCount.textContent = count;
	};

	function addMessage(data) {
		// Hide "no messages" placeholder
		noMessages.style.display = 'none';

		const messageDiv = document.createElement('div');
		messageDiv.className = 'mb-2 p-2 border rounded';
		messageDiv.id = data.id;

		const time = new Date(data.timestamp).toLocaleTimeString();

		messageDiv.innerHTML = `
			<div class="d-flex justify-content-between">
				<strong class="text-primary">${escapeHtml(data.name)}</strong>
				<small class="text-muted">${time}</small>
			</div>
			<div>${escapeHtml(data.message)}</div>
		`;

		messagesContainer.appendChild(messageDiv);
		messagesContainer.scrollTop = messagesContainer.scrollHeight;
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	// Handle form submission
	chatForm.addEventListener('submit', function(e) {
		e.preventDefault();

		const name = chatName.value.trim();
		const message = chatMessage.value.trim();

		if (!name || !message) return;

		// Save name to localStorage
		localStorage.setItem('mercure-chat-name', name);

		// Disable form while sending
		sendBtn.disabled = true;
		sendBtn.textContent = 'Sending...';

		fetch('<?= $this->Url->build(['action' => 'postMessage']) ?>', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
			},
			body: new URLSearchParams({
				name: name,
				message: message
			})
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				chatMessage.value = '';
				chatMessage.focus();
			} else {
				alert('Error: ' + (data.error || 'Unknown error'));
			}
		})
		.catch(error => {
			alert('Failed to send message: ' + error.message);
		})
		.finally(() => {
			sendBtn.disabled = false;
			sendBtn.textContent = 'Send';
		});
	});
});
</script>

<?php endif; ?>

</div></div>
