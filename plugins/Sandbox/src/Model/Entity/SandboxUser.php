<?php
declare(strict_types=1);

namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * SandboxUser Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string $username
 * @property string $slug
 * @property string $password
 * @property string $email
 * @property int $role_id
 * @property \Sandbox\Model\Enum\UserStatus $status
 */
class SandboxUser extends Entity {

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
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array<string>
	 */
	protected array $_hidden = [
		'password',
	];

}
