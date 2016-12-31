<?php
namespace Sandbox\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\InternalErrorException;

/**
 * @property \Sandbox\Model\Table\EventsTable $Events
 * @property \Data\Model\Table\CountryProvincesTable $CountryProvinces
 */
class CalendarController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.Events';

	/**
	 * @var array
	 */
	public $components = ['Calendar.Calendar'];

	/**
	 * @var array
	 */
	public $helpers = ['Calendar.Calendar'];

	/**
	 * @param Event $event
	 * @return \Cake\Network\Response|null
	 */
	public function beforeFilter(Event $event)
	{
		return parent::beforeFilter($event);
	}

	/**
	 * @param string|null $year
	 * @param string|null $month
	 * @return void
	 */
	public function index($year = null, $month = null) {
		$this->Calendar->init($year, $month);

		$options = [
			'year' => $this->Calendar->year(),
			'month' => $this->Calendar->month(),
		];
		$this->_populateDemoData($options);

		$events = $this->Events->find('calendar', $options);

		$this->set(compact('events'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function view($id = null) {
		$event = $this->Events->get($id);

		$this->set(compact('event', 'year', 'month'));
	}

	/**
	 * @param array $options
	 * @return void
	 */
	protected function _populateDemoData(array $options)
	{
		if ($this->Events->find('calendar', $options)->count()) {
			return;
		}

		$this->loadModel('Data.CountryProvinces');

		$count = mt_rand(3, 8);
		for ($i = 0; $i < $count; $i++) {
			$countryProvince = $this->CountryProvinces
				->find()
				->where(['abbr !=' => '', 'lat !=' => 0, 'lng !=' => 0])
				->order('rand()')
				->first();

			$event = $this->Events->newEntity([
				'title' => $this->_getRandomWord(mt_rand(10, 20)),
				'lat' => $countryProvince->lat,
				'lng' => $countryProvince->lng,
				'location' => $countryProvince->name,
				'description' => 'Some cool event @ ' . $countryProvince->abbr,
				'beginning' => new \Cake\I18n\Time(mktime(mt_rand(8, 22), 0, 0, $options['month'], mt_rand(1, 28), $options['year'])),
			]);
			if (!$this->Events->save($event)) {
				throw new InternalErrorException('Cannot save Event - ' . print_r($event->errors()));
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
