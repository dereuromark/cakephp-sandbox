<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use RuntimeException;
use Tools\I18n\DateTime;

class QueueExamplesController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Queue.QueuedJobs';

	/**
	 * @return void
	 */
	public function index() {
		$queuedJobsTable = $this->fetchTable();

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$queuedJobs = $queuedJobsTable->find()->where(['reference LIKE' => 'demo-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function scheduling() {
		$queuedJobsTable = $this->fetchTable();
		$tasks = ['Queue.Example' => 'Queue.Example', 'Queue.ProgressExample' => 'Queue.ProgressExample'];

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();
		$queuedJob = $queuedJobsTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$queuedJob = $queuedJobsTable->patchEntity($queuedJob, $this->request->getData());
			$notBefore = $queuedJob->notbefore;
			$task = $queuedJob->job_task;

			if (!$task || !isset($tasks[$task])) {
				$queuedJob->setError('task', 'Required field.');
			}
			if (!$notBefore || !$notBefore->isFuture()) {
				$queuedJob->setError('notbefore', 'Invalid value. Must be a date/time in the near future.');
			}

			if ($notBefore && $notBefore->subDays(1)->isFuture()) {
				$queuedJob->setError('notbefore', 'Too far in the future. Max 1 day.');
			}

			if (!$queuedJob->getErrors()) {
				if ($notBefore && $this->scheduleDelayedDemo($task, $notBefore)) {
					$rel = DateTime::relLengthOfTime($notBefore);
					if (!is_string($rel)) {
						throw new RuntimeException('Expected string result');
					}
					$this->Flash->success('Scheduled ' . $task . ' for ' . $notBefore . ' (' . $rel . '). Check again at that time.');

					return $this->redirect(['action' => 'scheduling']);
				}

				$this->Flash->error('There is already a task scheduled. Please wait.');

			} else {
				$this->Flash->error('Please correct the errors to continue.');
			}
		}

		$queuedJobs = $queuedJobsTable->find()->where(['reference LIKE' => 'scheduling-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs', 'queuedJob', 'tasks'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function config() {
		$queueProcessesTable = $this->fetchTable('Queue.QueueProcesses');
		$status = $queueProcessesTable->status();

		$queuedJobsTable = $this->fetchTable();
		$length = $queuedJobsTable->getLength();

		$this->set(compact('status', 'length'));
	}

	/**
	 * @param int|null $id
	 *
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return \Cake\Http\Response|null
	 */
	public function cancelJob($id = null) {
		$this->request->allowMethod('post');

		$queuedJobsTable = $this->fetchTable();
		$job = $queuedJobsTable->get($id);

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();
		if (strpos((string)$job->reference, '-' . $sid) === false) {
			throw new NotFoundException();
		}

		if ($job->fetched) {
			$this->Flash->error('Already started, can not be cancelled anymore.');
		} else {
			$queuedJobsTable->delete($job);
			$this->Flash->success('Job cancelled.');
		}

		return $this->redirect($this->referer(['action' => 'schedule']));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function scheduleDemo() {
		$this->request->allowMethod('post');

		$queuedJobsTable = $this->fetchTable();

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$seconds = 20;
		$reference = 'demo-' . $sid;
		if ($queuedJobsTable->isQueued($reference, 'Queue.ProgressExample')) {
			$this->Flash->error('Job already running or scheduled. Refresh the page for details.');

			return $this->redirect($this->referer(['action' => 'index']));
		}

		$queuedJobsTable->createJob(
			'Queue.ProgressExample',
			['duration' => $seconds],
			['reference' => $reference],
		);

		$this->Flash->success('Queued: Queue.ProgressExample with ' . $seconds . 's long job.');

		return $this->redirect($this->referer(['action' => 'index']));
	}

	/**
  * @param string $task
  * @param \Cake\I18n\DateTime $notBefore
  * @return bool
  */
	protected function scheduleDelayedDemo(string $task, $notBefore) {
		$queuedJobsTable = $this->fetchTable();

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$reference = 'scheduling-' . $sid;

		if ($queuedJobsTable->isQueued($reference, $task)) {
			return false;
		}

		$data = [];
		if ($task === 'Queue.ProgressExample') {
			$data = [
				'duration' => 10,
			];
		}

		$queuedJobsTable->createJob(
			$task,
			$data,
			['reference' => $reference, 'notBefore' => $notBefore],
		);

		return true;
	}

}
