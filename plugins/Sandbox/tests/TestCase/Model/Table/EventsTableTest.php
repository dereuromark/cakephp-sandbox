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
	protected $Events;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.Events',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('Events') ? [] : ['className' => 'Sandbox\Model\Table\EventsTable'];
		$this->Events = $this->fetchTable('Events', $config);
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
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
