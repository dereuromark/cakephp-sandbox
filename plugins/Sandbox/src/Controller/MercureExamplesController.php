<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Exception;

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

}
