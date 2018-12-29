<?php
namespace Sandbox\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Model\Table\EventsTable Test Case
 */
class EventsTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\EventsTable
	 */
	public $Events;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
        'plugin.Sandbox.Events'
    ];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('Events') ? [] : ['className' => 'Sandbox\Model\Table\EventsTable'];
		$this->Events = TableRegistry::get('Events', $config);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->Events);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testBasicSave() {
		$event = $this->Events->newEntity([
			'title' => 'Foo',
			'location' => 'Bar',
			'description' => 'Baz',
		]);
		$result = $this->Events->save($event);

		$this->assertTrue((bool)$result);
	}

}
