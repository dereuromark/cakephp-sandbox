<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use RuntimeException;
use Tools\Utility\DateTime;

/**
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \Queue\Model\Table\QueueProcessesTable $QueueProcesses
 */
class QueueExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Queue.QueuedJobs';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();
	}

	/**
	 * @return void
	 */
	public function index() {
		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$queuedJobs = $this->QueuedJobs->find()->where(['reference LIKE' => 'demo-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function scheduling() {
		$tasks = ['Queue.Example' => 'Queue.Example', 'Queue.ProgressExample' => 'Queue.ProgressExample'];

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();
		$queuedJob = $this->QueuedJobs->newEmptyEntity();

		if ($this->request->is('post')) {
			$queuedJob = $this->QueuedJobs->patchEntity($queuedJob, $this->request->getData());
			$notBefore = $queuedJob->notbefore;
			$task = $queuedJob->job_task;

			if (!$task || !isset($tasks[$task])) {
				$queuedJob->setError('task', 'Required field.');
			}
			if (!$notBefore || !$notBefore->isFuture()) {
				$queuedJob->setError('notbefore', 'Invalid value. Must be a date/time in the near future.');
			}

			if ($notBefore && $notBefore->subDay()->isFuture()) {
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

		$queuedJobs = $this->QueuedJobs->find()->where(['reference LIKE' => 'scheduling-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs', 'queuedJob', 'tasks'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function config() {
		$this->loadModel('Queue.QueueProcesses');
		$status = $this->QueueProcesses->status();

		$length = $this->QueuedJobs->getLength();

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

		$job = $this->QueuedJobs->get($id);

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();
		if (strpos((string)$job->reference, '-' . $sid) === false) {
			throw new NotFoundException();
		}

		if ($job->fetched) {
			$this->Flash->error('Already started, can not be cancelled anymore.');
		} else {
			$this->QueuedJobs->delete($job);
			$this->Flash->success('Job cancelled.');
		}

		return $this->redirect($this->referer(['action' => 'schedule']));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function scheduleDemo() {
		$this->request->allowMethod('post');

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$seconds = 20;
		$reference = 'demo-' . $sid;
		if ($this->QueuedJobs->isQueued($reference, 'Queue.ProgressExample')) {
			$this->Flash->error('Job already running or scheduled. Refresh the page for details.');

			return $this->redirect($this->referer(['action' => 'index']));
		}

		$this->QueuedJobs->createJob(
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
		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$reference = 'scheduling-' . $sid;

		if ($this->QueuedJobs->isQueued($reference, $task)) {
			return false;
		}

		$data = [];
		if ($task === 'Queue.ProgressExample') {
			$data = [
				'duration' => 10,
			];
		}

		$this->QueuedJobs->createJob(
			$task,
			$data,
			['reference' => $reference, 'notBefore' => $notBefore],
		);

		return true;
	}

}
