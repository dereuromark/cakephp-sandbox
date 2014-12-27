<?php
use Sandbox\Model\SandboxAppModel;

class NewsRecord extends SandboxAppModel {

	public $alias = 'News';

	//public $useTable = false;

	public $useDbConfig = 'array';

	public $records = array();

	public function __construct($id = false, $table = false, $ds = null) {
		ConnectionManager::create('array', array('datasource' => 'Datasources.ArraySource'));

		$this->records = array(
			array(
				'id' => 1,
				'title' => 'Foo',
				'content' => '<b>Bold text</b>',
				'published' => '2012-01-04 11:12:13',
			),
			array(
				'id' => 2,
				'title' => 'Bar',
				'content' => '<i>Italic text</b>',
				'published' => '2012-07-04 11:12:13',
			),
		);

		parent::__construct($id, $table, $ds);
	}

	/**
	 * NewsRecord::feed()
	 *
	 * @return array
	 */
	public function feed() {
		$res = $this->find('all');
		foreach ($res as $k => $v) {
			$res[$k]['User'] = array(
				'username' => 'Some user'
			);
		}
		return $res;
	}

}
