<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string $status
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $payment_requested_at
 * @property \Cake\I18n\DateTime|null $confirmation_sent_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 */
class Registration extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
