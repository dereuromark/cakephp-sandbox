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
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \Cake\I18n\DateTime|null $last_login
 * @property \App\Model\Entity\Role $role
 * @method int getIdOrFail()
 * @method bool getActiveOrFail()
 * @method \Cake\I18n\DateTime getLastLoginOrFail()
 * @method \Cake\I18n\DateTime getCreatedOrFail()
 * @method \Cake\I18n\DateTime getModifiedOrFail()
 * @method int getLoginsOrFail()
 * @method string getUsernameOrFail()
 * @method string getPasswordOrFail()
 * @method string getEmailOrFail()
 * @method int getRoleIdOrFail()
 * @method \App\Model\Entity\Role getRoleOrFail()
 * @method $this setIdOrFail(int $value)
 * @method $this setActiveOrFail(bool $value)
 * @method $this setLastLoginOrFail(\Cake\I18n\DateTime $value)
 * @method $this setCreatedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setModifiedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setLoginsOrFail(int $value)
 * @method $this setUsernameOrFail(string $value)
 * @method $this setPasswordOrFail(string $value)
 * @method $this setEmailOrFail(string $value)
 * @method $this setRoleIdOrFail(int $value)
 * @method $this setRoleOrFail(\App\Model\Entity\Role $value)
 */
class User extends Entity {

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
	 * @var list<string>
	 */
	protected array $_hidden = [
		'password',
	];

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_USERNAME = 'username';

	/**
	 * @var string
	 */
	public const FIELD_EMAIL = 'email';

	/**
	 * @var string
	 */
	public const FIELD_PASSWORD = 'password';

	/**
	 * @var string
	 */
	public const FIELD_LOGINS = 'logins';

	/**
	 * @var string
	 */
	public const FIELD_ACTIVE = 'active';

	/**
	 * @var string
	 */
	public const FIELD_ROLE_ID = 'role_id';

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
	public const FIELD_LAST_LOGIN = 'last_login';

	/**
	 * @var string
	 */
	public const FIELD_ROLE = 'role';

}
