<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/RequestedTeam DTO
 *
 * @property int|null $id
 * @property string|null $nodeId
 * @property string|null $url
 * @property string|null $htmlUrl
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $privacy
 * @property string|null $notificationSetting
 * @property string|null $permission
 * @property string|null $membersUrl
 * @property string|null $repositoriesUrl
 */
class RequestedTeamDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_URL = 'url';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_NAME = 'name';
	public const FIELD_SLUG = 'slug';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_PRIVACY = 'privacy';
	public const FIELD_NOTIFICATION_SETTING = 'notificationSetting';
	public const FIELD_PERMISSION = 'permission';
	public const FIELD_MEMBERS_URL = 'membersUrl';
	public const FIELD_REPOSITORIES_URL = 'repositoriesUrl';

	/**
	 * @var int|null
	 */
	protected $id;

	/**
	 * @var string|null
	 */
	protected $nodeId;

	/**
	 * @var string|null
	 */
	protected $url;

	/**
	 * @var string|null
	 */
	protected $htmlUrl;

	/**
	 * @var string|null
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $slug;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var string|null
	 */
	protected $privacy;

	/**
	 * @var string|null
	 */
	protected $notificationSetting;

	/**
	 * @var string|null
	 */
	protected $permission;

	/**
	 * @var string|null
	 */
	protected $membersUrl;

	/**
	 * @var string|null
	 */
	protected $repositoriesUrl;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'id' => [
			'name' => 'id',
			'type' => 'int',
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
		'permission' => [
			'name' => 'permission',
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
		'membersUrl' => [
			'name' => 'membersUrl',
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
		'repositoriesUrl' => [
			'name' => 'repositoriesUrl',
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
			'html_url' => 'htmlUrl',
			'name' => 'name',
			'slug' => 'slug',
			'description' => 'description',
			'privacy' => 'privacy',
			'notification_setting' => 'notificationSetting',
			'permission' => 'permission',
			'members_url' => 'membersUrl',
			'repositories_url' => 'repositoriesUrl',
		],
		'dashed' => [
			'id' => 'id',
			'node-id' => 'nodeId',
			'url' => 'url',
			'html-url' => 'htmlUrl',
			'name' => 'name',
			'slug' => 'slug',
			'description' => 'description',
			'privacy' => 'privacy',
			'notification-setting' => 'notificationSetting',
			'permission' => 'permission',
			'members-url' => 'membersUrl',
			'repositories-url' => 'repositoriesUrl',
		],
	];

	/**
	 * @param int|null $id
	 *
	 * @return $this
	 */
	public function setId(?int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @param int $id
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIdOrFail(int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getIdOrFail(): int {
		if ($this->id === null) {
			throw new \RuntimeException('Value not set for field `id` (expected to be not null)');
		}

		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string|null $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(?string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @param string $nodeId
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNodeIdOrFail(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNodeId(): ?string {
		return $this->nodeId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNodeIdOrFail(): string {
		if ($this->nodeId === null) {
			throw new \RuntimeException('Value not set for field `nodeId` (expected to be not null)');
		}

		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

	/**
	 * @param string|null $url
	 *
	 * @return $this
	 */
	public function setUrl(?string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @param string $url
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUrlOrFail(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string {
		return $this->url;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getUrlOrFail(): string {
		if ($this->url === null) {
			throw new \RuntimeException('Value not set for field `url` (expected to be not null)');
		}

		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

	/**
	 * @param string|null $htmlUrl
	 *
	 * @return $this
	 */
	public function setHtmlUrl(?string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @param string $htmlUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHtmlUrlOrFail(string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHtmlUrl(): ?string {
		return $this->htmlUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getHtmlUrlOrFail(): string {
		if ($this->htmlUrl === null) {
			throw new \RuntimeException('Value not set for field `htmlUrl` (expected to be not null)');
		}

		return $this->htmlUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHtmlUrl(): bool {
		return $this->htmlUrl !== null;
	}

	/**
	 * @param string|null $name
	 *
	 * @return $this
	 */
	public function setName(?string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNameOrFail(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNameOrFail(): string {
		if ($this->name === null) {
			throw new \RuntimeException('Value not set for field `name` (expected to be not null)');
		}

		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName(): bool {
		return $this->name !== null;
	}

	/**
	 * @param string|null $slug
	 *
	 * @return $this
	 */
	public function setSlug(?string $slug) {
		$this->slug = $slug;
		$this->_touchedFields[self::FIELD_SLUG] = true;

		return $this;
	}

	/**
	 * @param string $slug
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSlugOrFail(string $slug) {
		$this->slug = $slug;
		$this->_touchedFields[self::FIELD_SLUG] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSlug(): ?string {
		return $this->slug;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSlugOrFail(): string {
		if ($this->slug === null) {
			throw new \RuntimeException('Value not set for field `slug` (expected to be not null)');
		}

		return $this->slug;
	}

	/**
	 * @return bool
	 */
	public function hasSlug(): bool {
		return $this->slug !== null;
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
	 * @param string|null $permission
	 *
	 * @return $this
	 */
	public function setPermission(?string $permission) {
		$this->permission = $permission;
		$this->_touchedFields[self::FIELD_PERMISSION] = true;

		return $this;
	}

	/**
	 * @param string $permission
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPermissionOrFail(string $permission) {
		$this->permission = $permission;
		$this->_touchedFields[self::FIELD_PERMISSION] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPermission(): ?string {
		return $this->permission;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getPermissionOrFail(): string {
		if ($this->permission === null) {
			throw new \RuntimeException('Value not set for field `permission` (expected to be not null)');
		}

		return $this->permission;
	}

	/**
	 * @return bool
	 */
	public function hasPermission(): bool {
		return $this->permission !== null;
	}

	/**
	 * @param string|null $membersUrl
	 *
	 * @return $this
	 */
	public function setMembersUrl(?string $membersUrl) {
		$this->membersUrl = $membersUrl;
		$this->_touchedFields[self::FIELD_MEMBERS_URL] = true;

		return $this;
	}

	/**
	 * @param string $membersUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMembersUrlOrFail(string $membersUrl) {
		$this->membersUrl = $membersUrl;
		$this->_touchedFields[self::FIELD_MEMBERS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMembersUrl(): ?string {
		return $this->membersUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMembersUrlOrFail(): string {
		if ($this->membersUrl === null) {
			throw new \RuntimeException('Value not set for field `membersUrl` (expected to be not null)');
		}

		return $this->membersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMembersUrl(): bool {
		return $this->membersUrl !== null;
	}

	/**
	 * @param string|null $repositoriesUrl
	 *
	 * @return $this
	 */
	public function setRepositoriesUrl(?string $repositoriesUrl) {
		$this->repositoriesUrl = $repositoriesUrl;
		$this->_touchedFields[self::FIELD_REPOSITORIES_URL] = true;

		return $this;
	}

	/**
	 * @param string $repositoriesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setRepositoriesUrlOrFail(string $repositoriesUrl) {
		$this->repositoriesUrl = $repositoriesUrl;
		$this->_touchedFields[self::FIELD_REPOSITORIES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getRepositoriesUrl(): ?string {
		return $this->repositoriesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getRepositoriesUrlOrFail(): string {
		if ($this->repositoriesUrl === null) {
			throw new \RuntimeException('Value not set for field `repositoriesUrl` (expected to be not null)');
		}

		return $this->repositoriesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasRepositoriesUrl(): bool {
		return $this->repositoriesUrl !== null;
	}

}
