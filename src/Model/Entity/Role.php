<?php

namespace App\Model\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @method int getIdOrFail()
 * @method string getNameOrFail()
 * @method string getAliasOrFail()
 * @method \Cake\I18n\FrozenTime getCreatedOrFail()
 * @method \Cake\I18n\FrozenTime getModifiedOrFail()
 */
class Role extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];

}
