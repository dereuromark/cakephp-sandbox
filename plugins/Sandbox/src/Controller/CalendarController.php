<?php

namespace Sandbox\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\I18n\Time;

/**
 * @property \Sandbox\Model\Table\EventsTable $Events
 * @property \Data\Model\Table\StatesTable $States
 * @property \Calendar\Controller\Component\CalendarComponent $Calendar
 */
class CalendarController extends SandboxAppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Sandbox.Events';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Calendar.Calendar');

		$this->viewBuilder()->setHelpers(['Calendar.Calendar']);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(EventInterface $event) {
		return parent::beforeFilter($event);
	}

	/**
	 * @param string|null $year
	 * @param string|null $month
	 * @return void
	 */
	public function index($year = null, $month = null) {
		$this->Calendar->init($year, $month, 5);

		$options = [
			'year' => $this->Calendar->year(),
			'month' => $this->Calendar->month(),
		];
		$this->_populateDemoData($options);

		$events = $this->Events->find('calendar', $options);

		$this->set(compact('events'));
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$event = $this->Events->get($id);

		$year = null;
		$month = null;
		$this->set(compact('event', 'year', 'month'));
	}

	/**
	 * @param array $options
	 * @return void
	 * @throws \Cake\Http\Exception\InternalErrorException
	 */
	protected function _populateDemoData(array $options) {
		if ($this->Events->find('calendar', $options)->count()) {
			return;
		}

		$this->loadModel('Data.States');

		$count = random_int(3, 8);
		for ($i = 0; $i < $count; $i++) {
			$config = $this->Events->getConnection()->config();
			$driver = $config['driver'];
			$random = strpos($driver, 'Sqlite') !== false ? 'RANDOM()' : 'RAND()';

			/** @var \Data\Model\Entity\State $state */
			$state = $this->States
				->find()
				->where(['abbr !=' => '', 'lat !=' => 0, 'lng !=' => 0])
				->order($random)
				->firstOrFail();

			$event = $this->Events->newEntity([
				'title' => $this->_getRandomWord(random_int(10, 20)),
				'lat' => $state->lat,
				'lng' => $state->lng,
				'location' => $state->name,
				'description' => 'Some cool event @ ' . $state->abbr,
				'beginning' => new Time(mktime(random_int(8, 22), 0, 0, $options['month'], random_int(1, 28), $options['year'])),
			]);
			if (!$this->Events->save($event)) {
				throw new InternalErrorException('Cannot save Event - ' . print_r($event->getErrors()));
			}
		}
	}

	/**
	 * @param int $length
	 * @return string
	 */
	protected function _getRandomWord($length = 10) {
		$word = array_merge(range('a', 'z'), [' ']);
		shuffle($word);
		return ucwords(substr(implode($word), 0, $length));
	}

}
