<?php
declare(strict_types=1);

namespace Sandbox\Controller;

use App\Model\Enum\AuditLogType;
use Cake\I18n\DateTime;
use Exception;

/**
 * AuditStash Controller
 *
 * Demonstrates the AuditStash plugin for tracking changes to database records.
 */
class AuditStashController extends SandboxAppController {

	/**
	 * Index method - shows list of articles and their audit logs
	 *
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		// Auto-rotate logs older than 1 hour on page load - for demo purposes
		$this->rotateOldLogs();

		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$articles = $sandboxArticlesTable->find()->toArray();

		$auditLogsTable = $this->fetchTable('AuditLogs');
		$auditLogs = $auditLogsTable->find()
			->where(['source' => 'sandbox_articles'])
			->orderBy(['created' => 'DESC'])
			->limit(50)
			->toArray();

		$this->set(compact('articles', 'auditLogs'));
	}

	/**
	 * Add method - creates a new article
	 *
	 * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$article = $sandboxArticlesTable->patchEntity($article, $this->request->getData());
			if ($sandboxArticlesTable->save($article)) {
				$this->Flash->success(__('The article has been saved and logged to audit trail.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The article could not be saved. Please, try again.'));
		}

		$this->set(compact('article'));
	}

	/**
	 * Edit method - updates an existing article
	 *
	 * @param string|null $id Article id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 */
	public function edit($id = null) {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->get($id);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$article = $sandboxArticlesTable->patchEntity($article, $this->request->getData());
			if ($sandboxArticlesTable->save($article)) {
				$this->Flash->success(__('The article has been updated and changes logged to audit trail.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The article could not be updated. Please, try again.'));
		}

		$this->set(compact('article'));
	}

	/**
	 * Delete method - removes an article
	 *
	 * @param string|null $id Article id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->get($id);

		if ($sandboxArticlesTable->delete($article)) {
			$this->Flash->success(__('The article has been deleted and logged to audit trail.'));
		} else {
			$this->Flash->error(__('The article could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * View audit log details
	 *
	 * @param string|null $id Audit log id.
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function viewLog($id = null) {
		$auditLogsTable = $this->fetchTable('AuditLogs');
		$auditLog = $auditLogsTable->get($id);

		$this->set(compact('auditLog'));
	}

	/**
	 * Revert changes from an audit log entry
	 *
	 * @param string|null $id Audit log id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 */
	public function revert($id = null) {
		$this->request->allowMethod(['post']);
		$auditLogsTable = $this->fetchTable('AuditLogs');
		$auditLog = $auditLogsTable->get($id);

		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');

		// Only allow reverting updated records
		if ($auditLog->type !== AuditLogType::Update) {
			$this->Flash->error(__('Only updates can be reverted. Type: {0}', $auditLog->type->value));

			return $this->redirect(['action' => 'index']);
		}

		try {
			// Get the current article
			$article = $sandboxArticlesTable->get($auditLog->primary_key);

			// Restore original values
			$originalData = $auditLog->original_data;
			if (!$originalData) {
				$this->Flash->error(__('No original data found in audit log.'));

				return $this->redirect(['action' => 'index']);
			}

			// Patch the article with original values
			$article = $sandboxArticlesTable->patchEntity($article, $originalData);

			if ($sandboxArticlesTable->save($article)) {
				$this->Flash->success(__('Successfully reverted to previous version.'));
			} else {
				$this->Flash->error(__('Could not revert changes. Please try again.'));
			}
		} catch (Exception $e) {
			$this->Flash->error(__('Error reverting: {0}', $e->getMessage()));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Restore a deleted record from an audit log entry
	 *
	 * @param string|null $id Audit log id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 */
	public function restore($id = null) {
		$this->request->allowMethod(['post']);
		$auditLogsTable = $this->fetchTable('AuditLogs');
		$auditLog = $auditLogsTable->get($id);

		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');

		// Only allow restoring deleted records
		if ($auditLog->type !== AuditLogType::Delete) {
			$this->Flash->error(__('Only deleted records can be restored. Type: {0}', $auditLog->type->value));

			return $this->redirect(['action' => 'index']);
		}

		try {
			// Check if a record with this ID already exists
			$exists = $sandboxArticlesTable->exists(['id' => $auditLog->primary_key]);
			if ($exists) {
				$this->Flash->error(__('A record with ID {0} already exists.', $auditLog->primary_key));

				return $this->redirect(['action' => 'index']);
			}

			// Get original data from the audit log
			$originalData = $auditLog->original_data;
			if (!$originalData) {
				$this->Flash->error(__('No original data found in audit log.'));

				return $this->redirect(['action' => 'index']);
			}

			// Create a new entity with the original data and ID
			$article = $sandboxArticlesTable->newEntity([
				'id' => $auditLog->primary_key,
				...$originalData,
			]);

			if ($sandboxArticlesTable->save($article)) {
				$this->Flash->success(__('Successfully restored deleted article #{0}.', $auditLog->primary_key));
			} else {
				$this->Flash->error(__('Could not restore article. Please try again.'));
			}
		} catch (Exception $e) {
			$this->Flash->error(__('Error restoring: {0}', $e->getMessage()));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Show form for partial revert (select specific fields)
	 *
	 * @param string|null $id Audit log id.
	 * @return \Cake\Http\Response|null|void Redirects on successful partial revert, renders view otherwise.
	 */
	public function partialRevert($id = null) {
		$auditLogsTable = $this->fetchTable('AuditLogs');
		$auditLog = $auditLogsTable->get($id);

		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');

		// Only allow partial revert for updated records
		if ($auditLog->type !== AuditLogType::Update) {
			$this->Flash->error(__('Only updates can be partially reverted. Type: {0}', $auditLog->type->value));

			return $this->redirect(['action' => 'index']);
		}

		if (!$auditLog->original_data || !$auditLog->changed_data) {
			$this->Flash->error(__('No change data found in audit log.'));

			return $this->redirect(['action' => 'index']);
		}

		// Check if the record still exists
		if (!$sandboxArticlesTable->exists(['id' => $auditLog->primary_key])) {
			$this->Flash->error(__('The record no longer exists and cannot be reverted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is(['patch', 'post', 'put'])) {
			$selectedFields = $this->request->getData('fields');
			if (empty($selectedFields)) {
				$this->Flash->error(__('Please select at least one field to revert.'));
			} else {
				try {
					// Get the current article
					$article = $sandboxArticlesTable->get($auditLog->primary_key);

					// Build data with only selected fields from original
					$revertData = [];
					foreach ($selectedFields as $field) {
						if (isset($auditLog->original_data[$field])) {
							$revertData[$field] = $auditLog->original_data[$field];
						}
					}

					// Patch the article with selected original values
					$article = $sandboxArticlesTable->patchEntity($article, $revertData);

					if ($sandboxArticlesTable->save($article)) {
						$this->Flash->success(__(
							'Successfully reverted {0} field(s): {1}',
							count($selectedFields),
							implode(', ', $selectedFields),
						));

						return $this->redirect(['action' => 'index']);
					}

					$this->Flash->error(__('Could not revert changes. Please try again.'));
				} catch (Exception $e) {
					$this->Flash->error(__('Error reverting: {0}', $e->getMessage()));
				}
			}
		}

		$this->set(compact('auditLog'));
	}

	/**
	 * Rotate old audit logs and articles (delete older than 1 hour)
	 *
	 * This is called automatically on the index page for demo purposes
	 * to keep the demo clean and prevent indefinite growth.
	 *
	 * @return void
	 */
	protected function rotateOldLogs(): void {
		// Delete old audit logs
		$oneHourAgo = new DateTime('-1 hour');
		$auditLogsTable = $this->fetchTable('AuditLogs');
		$deletedLogs = $auditLogsTable->deleteAll([
			'source' => 'sandbox_articles',
			'created <' => $oneHourAgo,
		]);

		// Delete old articles
		$oneHourAgo = new DateTime('-2 hour');
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$deletedArticles = $sandboxArticlesTable->deleteAll([
			'created <' => $oneHourAgo,
		]);

		if ($deletedLogs > 0 || $deletedArticles > 0) {
			$this->log(
				sprintf(
					'Auto-rotated %d audit log(s) and %d article(s) older than 1 hour',
					$deletedLogs,
					$deletedArticles,
				),
				'info',
			);
		}
	}

}
