<?php
declare(strict_types=1);

namespace StateMachineSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property int $id
 * @property string $session_id
 * @property int $user_id
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \StateMachine\Model\Entity\StateMachineItem|null $registration_state
 */
class Registration extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_SESSION_ID = 'session_id';

	/**
	 * @var string
	 */
	public const FIELD_USER_ID = 'user_id';

	/**
	 * @var string
	 */
	public const FIELD_STATUS = 'status';

	/**
	 * @var string
	 */
	public const FIELD_CREATED = 'created';

	/**
	 * @var string
	 */
	public const FIELD_MODIFIED = 'modified';

	/**
	 * @var string
	 */
	public const FIELD_USER = 'user';

	/**
	 * @var string
	 */
	public const FIELD_REGISTRATION_STATE = 'registration_state';

}
