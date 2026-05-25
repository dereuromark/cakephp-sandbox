<?php

namespace Sandbox\Model\Table;

use Reactions\Model\Entity\Reaction;
use Reactions\Model\Table\ReactionsTable;

/**
 * Sandbox reactions, owned by the demo {@see \Sandbox\Model\Table\SandboxUsersTable}
 * instead of the app's main users table. Re-points the inherited `Users` association
 * (and therefore the `existsIn` rule) so the demo users validate, regardless of when
 * the table is first loaded.
 */
class SandboxReactionsTable extends ReactionsTable {

	/**
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setEntityClass(Reaction::class);

		// Re-point the inherited association from the app users to the demo SandboxUsers.
		$this->associations()->remove('Users');
		$this->belongsTo('Users', [
			'className' => 'Sandbox.SandboxUsers',
			'foreignKey' => 'user_id',
		]);
	}

}
