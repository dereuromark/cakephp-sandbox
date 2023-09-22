<?php
declare(strict_types = 1);

namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExposedUser Entity
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class ExposedUser extends Entity {

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
		'uuid' => false,
		'id' => false,
	];

}
