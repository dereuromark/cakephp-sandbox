<?php

namespace App\Model\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @method int getIdOrFail()
 * @method string getNameOrFail()
 * @method string getAliasOrFail()
 * @method \Cake\I18n\DateTime getCreatedOrFail()
 * @method \Cake\I18n\DateTime getModifiedOrFail()
 * @property array<\App\Model\Entity\User> $users
 * @method array<\App\Model\Entity\User> getUsersOrFail()
 * @method $this setIdOrFail(int $value)
 * @method $this setNameOrFail(string $value)
 * @method $this setAliasOrFail(string $value)
 * @method $this setCreatedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setModifiedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setUsersOrFail(array $value)
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
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
