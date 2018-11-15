<?php
namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $description
 * @property int|null $status
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class SandboxCategory extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false
	];

}
