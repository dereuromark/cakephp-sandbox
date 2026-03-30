<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $assignee_id
 * @property string $ticket_number
 * @property string $subject
 * @property string|null $description
 * @property string $priority
 * @property string $status
 * @property \Cake\I18n\DateTime|null $escalated_at
 * @property \Cake\I18n\DateTime|null $resolved_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\User|null $assignee
 */
class Ticket extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
