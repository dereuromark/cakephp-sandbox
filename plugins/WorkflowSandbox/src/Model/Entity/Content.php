<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Content Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $reviewer_id
 * @property string $title
 * @property string|null $body
 * @property string $status
 * @property string|null $rejection_reason
 * @property \Cake\I18n\DateTime|null $published_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\User|null $reviewer
 */
class Content extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
