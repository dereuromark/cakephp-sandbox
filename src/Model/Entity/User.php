<?php
namespace App\Model\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $logins
 * @property bool $active
 * @property int $role_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property \Cake\ORM\Entity $role
 * @method int getIdOrFail()
 * @method bool getActiveOrFail()
 * @method \Cake\I18n\FrozenTime getLastLoginOrFail()
 * @method \Cake\I18n\FrozenTime getCreatedOrFail()
 * @method \Cake\I18n\FrozenTime getModifiedOrFail()
 * @method int getLoginsOrFail()
 * @method string getUsernameOrFail()
 * @method string getPasswordOrFail()
 * @method string getEmailOrFail()
 * @method int getRoleIdOrFail()
 * @method \Cake\ORM\Entity getRoleOrFail()
 */
class User extends Entity {

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
		'id' => false,
	];

	/**
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array
	 */
	protected $_hidden = [
		'password'
	];

}
