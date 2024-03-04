<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/RequestedTeam DTO
 *
 * @property int $id
 * @property string $nodeId
 * @property string $url
 * @property string $membersUrl
 * @property string $name
 * @property string|null $description
 * @property string $permission
 * @property string|null $privacy
 * @property string|null $notificationSetting
 * @property string $htmlUrl
 * @property string $repositoriesUrl
 * @property string $slug
 * @property string|null $ldapDn
 */
class RequestedTeamDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_URL = 'url';
	public const FIELD_MEMBERS_URL = 'membersUrl';
	public const FIELD_NAME = 'name';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_PERMISSION = 'permission';
	public const FIELD_PRIVACY = 'privacy';
	public const FIELD_NOTIFICATION_SETTING = 'notificationSetting';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_REPOSITORIES_URL = 'repositoriesUrl';
	public const FIELD_SLUG = 'slug';
	public const FIELD_LDAP_DN = 'ldapDn';

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $membersUrl;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $permission;

	/**
	 * @var string|null
	 */
	protected $privacy;

	/**
	 * @var string|null
	 */
	protected $notificationSetting;

	/**
	 * @var string
	 */
	protected $htmlUrl;

	/**
	 * @var string
	 */
	protected $repositoriesUrl;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var string|null
	 */
	protected $ldapDn;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'id' => [
			'name' => 'id',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'nodeId' => [
			'name' => 'nodeId',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'url' => [
			'name' => 'url',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'membersUrl' => [
			'name' => 'membersUrl',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'name' => [
			'name' => 'name',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'description' => [
			'name' => 'description',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'permission' => [
			'name' => 'permission',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'privacy' => [
			'name' => 'privacy',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'notificationSetting' => [
			'name' => 'notificationSetting',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'htmlUrl' => [
			'name' => 'htmlUrl',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'repositoriesUrl' => [
			'name' => 'repositoriesUrl',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'slug' => [
			'name' => 'slug',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'ldapDn' => [
			'name' => 'ldapDn',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'node_id' => 'nodeId',
			'url' => 'url',
			'members_url' => 'membersUrl',
			'name' => 'name',
			'description' => 'description',
			'permission' => 'permission',
			'privacy' => 'privacy',
			'notification_setting' => 'notificationSetting',
			'html_url' => 'htmlUrl',
			'repositories_url' => 'repositoriesUrl',
			'slug' => 'slug',
			'ldap_dn' => 'ldapDn',
		],
		'dashed' => [
			'id' => 'id',
			'node-id' => 'nodeId',
			'url' => 'url',
			'members-url' => 'membersUrl',
			'name' => 'name',
			'description' => 'description',
			'permission' => 'permission',
			'privacy' => 'privacy',
			'notification-setting' => 'notificationSetting',
			'html-url' => 'htmlUrl',
			'repositories-url' => 'repositoriesUrl',
			'slug' => 'slug',
			'ldap-dn' => 'ldapDn',
		],
	];

	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setId(int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNodeId(): string {
		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

	/**
	 * @param string $membersUrl
	 *
	 * @return $this
	 */
	public function setMembersUrl(string $membersUrl) {
		$this->membersUrl = $membersUrl;
		$this->_touchedFields[self::FIELD_MEMBERS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMembersUrl(): string {
		return $this->membersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMembersUrl(): bool {
		return $this->membersUrl !== null;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName(): bool {
		return $this->name !== null;
	}

	/**
	 * @param string|null $description
	 *
	 * @return $this
	 */
	public function setDescription(?string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDescriptionOrFail(string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDescriptionOrFail(): string {
		if ($this->description === null) {
			throw new \RuntimeException('Value not set for field `description` (expected to be not null)');
		}

		return $this->description;
	}

	/**
	 * @return bool
	 */
	public function hasDescription(): bool {
		return $this->description !== null;
	}

	/**
	 * @param string $permission
	 *
	 * @return $this
	 */
	public function setPermission(string $permission) {
		$this->permission = $permission;
		$this->_touchedFields[self::FIELD_PERMISSION] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPermission(): string {
		return $this->permission;
	}

	/**
	 * @return bool
	 */
	public function hasPermission(): bool {
		return $this->permission !== null;
	}

	/**
	 * @param string|null $privacy
	 *
	 * @return $this
	 */
	public function setPrivacy(?string $privacy) {
		$this->privacy = $privacy;
		$this->_touchedFields[self::FIELD_PRIVACY] = true;

		return $this;
	}

	/**
	 * @param string $privacy
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPrivacyOrFail(string $privacy) {
		$this->privacy = $privacy;
		$this->_touchedFields[self::FIELD_PRIVACY] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPrivacy(): ?string {
		return $this->privacy;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getPrivacyOrFail(): string {
		if ($this->privacy === null) {
			throw new \RuntimeException('Value not set for field `privacy` (expected to be not null)');
		}

		return $this->privacy;
	}

	/**
	 * @return bool
	 */
	public function hasPrivacy(): bool {
		return $this->privacy !== null;
	}

	/**
	 * @param string|null $notificationSetting
	 *
	 * @return $this
	 */
	public function setNotificationSetting(?string $notificationSetting) {
		$this->notificationSetting = $notificationSetting;
		$this->_touchedFields[self::FIELD_NOTIFICATION_SETTING] = true;

		return $this;
	}

	/**
	 * @param string $notificationSetting
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNotificationSettingOrFail(string $notificationSetting) {
		$this->notificationSetting = $notificationSetting;
		$this->_touchedFields[self::FIELD_NOTIFICATION_SETTING] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNotificationSetting(): ?string {
		return $this->notificationSetting;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNotificationSettingOrFail(): string {
		if ($this->notificationSetting === null) {
			throw new \RuntimeException('Value not set for field `notificationSetting` (expected to be not null)');
		}

		return $this->notificationSetting;
	}

	/**
	 * @return bool
	 */
	public function hasNotificationSetting(): bool {
		return $this->notificationSetting !== null;
	}

	/**
	 * @param string $htmlUrl
	 *
	 * @return $this
	 */
	public function setHtmlUrl(string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHtmlUrl(): string {
		return $this->htmlUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHtmlUrl(): bool {
		return $this->htmlUrl !== null;
	}

	/**
	 * @param string $repositoriesUrl
	 *
	 * @return $this
	 */
	public function setRepositoriesUrl(string $repositoriesUrl) {
		$this->repositoriesUrl = $repositoriesUrl;
		$this->_touchedFields[self::FIELD_REPOSITORIES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRepositoriesUrl(): string {
		return $this->repositoriesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasRepositoriesUrl(): bool {
		return $this->repositoriesUrl !== null;
	}

	/**
	 * @param string $slug
	 *
	 * @return $this
	 */
	public function setSlug(string $slug) {
		$this->slug = $slug;
		$this->_touchedFields[self::FIELD_SLUG] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * @return bool
	 */
	public function hasSlug(): bool {
		return $this->slug !== null;
	}

	/**
	 * @param string|null $ldapDn
	 *
	 * @return $this
	 */
	public function setLdapDn(?string $ldapDn) {
		$this->ldapDn = $ldapDn;
		$this->_touchedFields[self::FIELD_LDAP_DN] = true;

		return $this;
	}

	/**
	 * @param string $ldapDn
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLdapDnOrFail(string $ldapDn) {
		$this->ldapDn = $ldapDn;
		$this->_touchedFields[self::FIELD_LDAP_DN] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLdapDn(): ?string {
		return $this->ldapDn;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLdapDnOrFail(): string {
		if ($this->ldapDn === null) {
			throw new \RuntimeException('Value not set for field `ldapDn` (expected to be not null)');
		}

		return $this->ldapDn;
	}

	/**
	 * @return bool
	 */
	public function hasLdapDn(): bool {
		return $this->ldapDn !== null;
	}

}
