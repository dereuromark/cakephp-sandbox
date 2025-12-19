<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $queuedJobs
 * @var string $reference
 * @var string|null $mercurePublicUrl
 * @var bool $mercureConfigured
 */

$sid = $this->request->getSession()->id();
$topic = '/sandbox/queue/' . $sid;
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/mercure'); ?>
</nav>
<div class="page col-sm-8 col-12">

<h2>Queue Integration</h2>

<p>This demonstrates one of the most valuable use cases for Mercure: <strong>real-time background job progress</strong>.</p>
<p>Instead of polling the server or requiring page refreshes, the queue worker pushes updates directly to your browser via Server-Sent Events.</p>

<?php if (!$mercureConfigured) { ?>
	<div class="alert alert-warning">
		<strong>Mercure not configured.</strong> The queue job will still run, but you won't see real-time updates.
		Progress will only be visible after page refresh.
	</div>
<?php } ?>

<h3>How it works</h3>
<ol>
	<li>Click the button to queue a background job</li>
	<li>The job runs in a separate worker process</li>
	<li>Each progress step publishes a Mercure update</li>
	<li>Your browser receives updates instantly via EventSource</li>
</ol>

<h3>Try it</h3>
<p>
	<?php echo $this->Form->postLink(
		'Start Background Job',
		['action' => 'scheduleQueueDemo'],
		['class' => 'btn btn-primary', 'id' => 'start-job-btn'],
	); ?>
</p>
	<p>This puts a background job in the queue that runs for 15 seconds to process some data and create a report or alike (demo only here)</p>

<div id="job-status" class="mt-4">
	<h4>Job Progress</h4>

	<div id="no-job-message" class="text-muted">
		<?php if ($queuedJobs) { ?>
			<p>Job is queued, waiting for worker to pick it up...</p>
		<?php } else { ?>
			<p>No job running. Click the button above to start one.</p>
		<?php } ?>
	</div>

	<div id="progress-container" style="display: none;">
		<div class="mb-2">
			<strong>Status:</strong> <span id="status-text">Waiting...</span>
		</div>
		<div class="progress mb-2" style="height: 25px;">
			<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
		</div>
		<div class="text-muted">
			<small id="progress-message">Initializing...</small>
		</div>
	</div>

	<div id="completed-message" class="alert alert-success" style="display: none;">
		<strong>Done!</strong> Job completed successfully.
	</div>

	<div id="event-log" class="mt-3">
		<h5>Event Log</h5>
		<pre id="log-output" class="bg-light p-2" style="max-height: 200px; overflow-y: auto; font-size: 12px;"></pre>
	</div>
</div>

<h3 class="mt-4">Code Example</h3>
<p>The queue task uses <code>Publisher::publish()</code> to send updates:</p>
<pre><code>// In your queue task's run() method:
use Mercure\Publisher;
use Mercure\Update\JsonUpdate;

Publisher::publish(JsonUpdate::create(
    topics: '/sandbox/queue/' . $jobId,
    data: [
        'status' => 'progress',
        'progress' => 50,
        'message' => 'Halfway there!',
    ],
));</code></pre>

</div>
</div>

<?php if ($mercureConfigured && $mercurePublicUrl) { ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
    const topic = <?php echo json_encode($topic); ?>;
    const mercureUrl = <?php echo json_encode($mercurePublicUrl); ?>;

    const progressContainer = document.getElementById('progress-container');
    const noJobMessage = document.getElementById('no-job-message');
    const completedMessage = document.getElementById('completed-message');
    const progressBar = document.getElementById('progress-bar');
    const statusText = document.getElementById('status-text');
    const progressMessage = document.getElementById('progress-message');
    const logOutput = document.getElementById('log-output');
    const startBtn = document.getElementById('start-job-btn');

    function log(message) {
        const time = new Date().toLocaleTimeString();
        logOutput.textContent += '[' + time + '] ' + message + '\n';
        logOutput.scrollTop = logOutput.scrollHeight;
    }

    function updateProgress(data) {
        noJobMessage.style.display = 'none';
        completedMessage.style.display = 'none';
        progressContainer.style.display = 'block';

        const percent = data.progress || 0;
        progressBar.style.width = percent + '%';
        progressBar.textContent = percent + '%';
        statusText.textContent = data.status || 'Processing';
        progressMessage.textContent = data.message || '';

        if (data.status === 'completed') {
            progressBar.classList.remove('progress-bar-animated', 'progress-bar-striped');
            progressBar.classList.add('bg-success');
            completedMessage.style.display = 'block';
            if (startBtn) {
                startBtn.classList.remove('disabled');
            }
        } else if (data.status === 'started') {
            progressBar.classList.add('progress-bar-animated', 'progress-bar-striped');
            progressBar.classList.remove('bg-success');
            if (startBtn) {
                startBtn.classList.add('disabled');
            }
        }
    }

    // Build subscription URL
    const url = new URL(mercureUrl);
    url.searchParams.append('topic', topic);

    log('Connecting to Mercure hub...');
    log('Topic: ' + topic);

    const eventSource = new EventSource(url, { withCredentials: true });

    eventSource.onopen = function() {
        log('Connected! Waiting for updates...');
    };

    eventSource.onmessage = function(event) {
        try {
            const data = JSON.parse(event.data);
            log('Received: ' + JSON.stringify(data));
            updateProgress(data);
        } catch (e) {
            log('Error parsing message: ' + e.message);
        }
    };

    eventSource.onerror = function(event) {
        log('Connection error (will auto-reconnect)');
    };

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        eventSource.close();
    });
})();
<?php $this->Html->scriptEnd(); ?>
<?php } ?>
