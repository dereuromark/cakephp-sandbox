<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Exception;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Mercure Examples Controller
 *
 * Demonstrates the cakephp-mercure plugin for real-time updates via Server-Sent Events.
 *
 * @property \Mercure\Controller\Component\MercureComponent $Mercure
 */
class MercureExamplesController extends SandboxAppController {

	/**
	 * @var bool
	 */
	protected bool $mercureConfigured = false;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		// Check if Mercure is configured (via app_mercure.php or env)
		$this->mercureConfigured = (bool)Configure::read('Mercure.url');

		// Only load the component if Mercure is configured
		if ($this->mercureConfigured) {
			$this->loadComponent('Mercure.Mercure', [
				'autoDiscover' => false,
				'defaultTopics' => ['/sandbox/notifications'],
			]);
		}
	}

	/**
	 * @return \Queue\Model\Table\QueuedJobsTable
	 */
	protected function getQueuedJobsTable(): QueuedJobsTable {
		/** @var \Queue\Model\Table\QueuedJobsTable */
		return $this->fetchTable('Queue.QueuedJobs');
	}

	/**
	 * Index - Overview of Mercure plugin features.
	 *
	 * @return void
	 */
	public function index(): void {
		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Publishing updates demo.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function publishing() {
		if ($this->request->is('post') && $this->mercureConfigured) {
			$topic = $this->request->getData('topic', '/sandbox/demo');
			$message = $this->request->getData('message', 'Hello from CakePHP!');
			$type = $this->request->getData('type', 'json');

			try {
				if ($type === 'json') {
					$this->Mercure->publishJson(
						topics: $topic,
						data: [
							'message' => $message,
							'timestamp' => date('c'),
							'source' => 'sandbox-demo',
						],
					);
				} else {
					$this->Mercure->publishSimple(
						topics: $topic,
						data: $message,
					);
				}
				$this->Flash->success('Update published successfully to topic: ' . $topic);
			} catch (Exception $e) {
				$this->Flash->error('Failed to publish: ' . $e->getMessage());
			}

			return $this->redirect(['action' => 'publishing']);
		}

		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Authorization demo - Setting cookies for private topics.
	 *
	 * @return void
	 */
	public function authorization(): void {
		if ($this->mercureConfigured && $this->request->is('post')) {
			$action = $this->request->getData('action');
			$sid = $this->request->getSession()->id();

			if ($action === 'authorize') {
				// Authorize for private topics using builder pattern
				$this->Mercure
					->addSubscribe("/sandbox/private/{$sid}")
					->addSubscribe('/sandbox/private/notifications', ['demo' => true])
					->authorize();

				$this->Flash->success('Authorization cookie set for private topics.');
			} elseif ($action === 'clear') {
				$this->Mercure->clearAuthorization();
				$this->Flash->success('Authorization cookie cleared.');
			}
		}

		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Client-side subscription demo.
	 *
	 * @return void
	 */
	public function subscription(): void {
		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Queue integration demo - Real-time job progress via Mercure.
	 *
	 * @return void
	 */
	public function queueProgress(): void {
		$queuedJobsTable = $this->getQueuedJobsTable();

		// For the demo we bind it to the user session to avoid side-effects
		$sid = $this->request->getSession()->id();
		$reference = 'mercure-demo-' . $sid;

		$queuedJobs = $queuedJobsTable->find()
			->where(['reference' => $reference, 'completed IS' => null])
			->all()
			->toArray();

		$mercurePublicUrl = Configure::read('Mercure.public_url');

		$this->set(compact('queuedJobs', 'reference', 'mercurePublicUrl'));
		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Trigger a queue job with Mercure progress updates.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function scheduleQueueDemo() {
		$this->request->allowMethod('post');

		$queuedJobsTable = $this->getQueuedJobsTable();

		$sid = $this->request->getSession()->id();
		$reference = 'mercure-demo-' . $sid;
		$topic = '/sandbox/queue/' . $sid;

		if ($queuedJobsTable->isQueued($reference, 'Sandbox.MercureProgressExample')) {
			$this->Flash->error('Job already running or scheduled. Wait for it to complete.');

			return $this->redirect(['action' => 'queueProgress']);
		}

		$queuedJobsTable->createJob(
			'Sandbox.MercureProgressExample',
			[
				'duration' => 15,
				'steps' => 10,
				'topic' => $topic,
			],
			['reference' => $reference],
		);

		$this->Flash->success('Job queued! Watch the real-time progress below.');

		return $this->redirect(['action' => 'queueProgress']);
	}

	/**
	 * Real-time chat demo.
	 *
	 * Demonstrates multi-user real-time messaging via Mercure.
	 * Open in multiple browser windows to see messages appear instantly.
	 *
	 * @return void
	 */
	public function chat(): void {
		$mercurePublicUrl = Configure::read('Mercure.public_url');

		$this->set(compact('mercurePublicUrl'));
		$this->set('mercureConfigured', $this->mercureConfigured);
	}

	/**
	 * Post a chat message via AJAX.
	 *
	 * @return \Cake\Http\Response
	 */
	public function postMessage() {
		$this->request->allowMethod('post');
		$this->autoRender = false;

		if (!$this->mercureConfigured) {
			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode(['error' => 'Mercure not configured']));
		}

		$name = trim((string)$this->request->getData('name'));
		$message = trim((string)$this->request->getData('message'));

		if (!$name || !$message) {
			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode(['error' => 'Name and message are required']));
		}

		try {
			$this->Mercure->publishJson(
				topics: '/sandbox/chat',
				data: [
					'name' => h($name),
					'message' => h($message),
					'timestamp' => date('c'),
					'id' => uniqid('msg_'),
				],
			);

			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode(['success' => true]));
		} catch (Exception $e) {
			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode(['error' => $e->getMessage()]));
		}
	}

}
