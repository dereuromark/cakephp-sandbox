<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class SandboxUsersTable extends Table {

	public $displayField = 'username';

	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Mandatory',
				'last' => true
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email invalid',
				'last' => true
			)
		),
	);

}
