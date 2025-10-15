<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\InternalErrorException;
use Cake\I18n\DateTime;
use RuntimeException;

/**
 * @property \Calendar\Controller\Component\CalendarComponent $Calendar
 * @property \Sandbox\Model\Table\EventsTable $Events
 */
class CalendarController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Sandbox.Events';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Calendar.Calendar');

		$this->viewBuilder()->addHelpers(['Calendar.Calendar']);
	}

	/**
	 * @param string|null $year
	 * @param string|null $month
	 * @return void
	 */
	public function index($year = null, $month = null) {
		$eventsTable = $this->fetchTable();

		$this->Calendar->init((string)$year, (string)$month, 5);

		$options = [
			'year' => $this->Calendar->year(),
			'month' => $this->Calendar->month(),
		];
		$this->_populateDemoData($options);

		$events = $eventsTable->find('calendar', $options);

		$this->set(compact('events'));
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$eventsTable = $this->fetchTable();
		$event = $eventsTable->get($id);

		$year = null;
		$month = null;
		$this->set(compact('event', 'year', 'month'));
	}

	/**
	 * @param array<string, mixed> $options
	 * @throws \Cake\Http\Exception\InternalErrorException
	 * @return void
	 */
	protected function _populateDemoData(array $options) {
		$eventsTable = $this->fetchTable();

		if ($eventsTable->find('calendar', $options)->count()) {
			return;
		}

		$statesTable = $this->fetchTable('Data.States');

		$count = random_int(3, 8);
		for ($i = 0; $i < $count; $i++) {
			$config = $eventsTable->getConnection()->config();
			$driver = $config['driver'];
			$random = str_contains($driver, 'Mysql') ? 'RAND()' : 'RANDOM()';

			/** @var \Data\Model\Entity\State $state */
			$state = $statesTable
				->find()
				->where(['code !=' => '', 'lat IS NOT' => null, 'lng IS NOT' => null])
				->orderBy($random)
				->firstOrFail();

			$time = mktime(random_int(8, 22), 0, 0, $options['month'], random_int(1, 28), $options['year']);
			if (!$time) {
				throw new RuntimeException('Invalid time');
			}
			$event = $eventsTable->newEntity([
				'title' => $this->_getRandomWord(random_int(10, 20)),
				'lat' => $state->lat,
				'lng' => $state->lng,
				'location' => $state->name,
				'description' => 'Some cool event @ ' . $state->code,
				'beginning' => new DateTime($time),
			]);
			if (!$eventsTable->save($event)) {
				throw new InternalErrorException('Cannot save Event - ' . print_r($event->getErrors(), true));
			}
		}
	}

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	protected function _getRandomWord(int $length = 10): string {
		$word = array_merge(range('a', 'z'), [' ']);
		shuffle($word);

		return ucwords(substr(implode($word), 0, $length));
	}

}
