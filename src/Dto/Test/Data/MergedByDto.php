<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/MergedBy DTO
 *
 * @property string|null $login
 * @property int|null $id
 * @property string|null $nodeId
 * @property string|null $avatarUrl
 * @property string|null $gravatarId
 * @property string|null $url
 * @property string|null $htmlUrl
 * @property string|null $followersUrl
 * @property string|null $followingUrl
 * @property string|null $gistsUrl
 * @property string|null $starredUrl
 * @property string|null $subscriptionsUrl
 * @property string|null $organizationsUrl
 * @property string|null $reposUrl
 * @property string|null $eventsUrl
 * @property string|null $receivedEventsUrl
 * @property string|null $type
 * @property bool|null $siteAdmin
 */
class MergedByDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_LOGIN = 'login';
	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_AVATAR_URL = 'avatarUrl';
	public const FIELD_GRAVATAR_ID = 'gravatarId';
	public const FIELD_URL = 'url';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_FOLLOWERS_URL = 'followersUrl';
	public const FIELD_FOLLOWING_URL = 'followingUrl';
	public const FIELD_GISTS_URL = 'gistsUrl';
	public const FIELD_STARRED_URL = 'starredUrl';
	public const FIELD_SUBSCRIPTIONS_URL = 'subscriptionsUrl';
	public const FIELD_ORGANIZATIONS_URL = 'organizationsUrl';
	public const FIELD_REPOS_URL = 'reposUrl';
	public const FIELD_EVENTS_URL = 'eventsUrl';
	public const FIELD_RECEIVED_EVENTS_URL = 'receivedEventsUrl';
	public const FIELD_TYPE = 'type';
	public const FIELD_SITE_ADMIN = 'siteAdmin';

	/**
	 * @var string|null
	 */
	protected $login;

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
	protected $avatarUrl;

	/**
	 * @var string|null
	 */
	protected $gravatarId;

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
	protected $followersUrl;

	/**
	 * @var string|null
	 */
	protected $followingUrl;

	/**
	 * @var string|null
	 */
	protected $gistsUrl;

	/**
	 * @var string|null
	 */
	protected $starredUrl;

	/**
	 * @var string|null
	 */
	protected $subscriptionsUrl;

	/**
	 * @var string|null
	 */
	protected $organizationsUrl;

	/**
	 * @var string|null
	 */
	protected $reposUrl;

	/**
	 * @var string|null
	 */
	protected $eventsUrl;

	/**
	 * @var string|null
	 */
	protected $receivedEventsUrl;

	/**
	 * @var string|null
	 */
	protected $type;

	/**
	 * @var bool|null
	 */
	protected $siteAdmin;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'login' => [
			'name' => 'login',
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
		'avatarUrl' => [
			'name' => 'avatarUrl',
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
		'gravatarId' => [
			'name' => 'gravatarId',
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
		'followersUrl' => [
			'name' => 'followersUrl',
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
		'followingUrl' => [
			'name' => 'followingUrl',
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
		'gistsUrl' => [
			'name' => 'gistsUrl',
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
		'starredUrl' => [
			'name' => 'starredUrl',
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
		'subscriptionsUrl' => [
			'name' => 'subscriptionsUrl',
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
		'organizationsUrl' => [
			'name' => 'organizationsUrl',
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
		'reposUrl' => [
			'name' => 'reposUrl',
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
		'eventsUrl' => [
			'name' => 'eventsUrl',
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
		'receivedEventsUrl' => [
			'name' => 'receivedEventsUrl',
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
		'type' => [
			'name' => 'type',
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
		'siteAdmin' => [
			'name' => 'siteAdmin',
			'type' => 'bool',
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
			'login' => 'login',
			'id' => 'id',
			'node_id' => 'nodeId',
			'avatar_url' => 'avatarUrl',
			'gravatar_id' => 'gravatarId',
			'url' => 'url',
			'html_url' => 'htmlUrl',
			'followers_url' => 'followersUrl',
			'following_url' => 'followingUrl',
			'gists_url' => 'gistsUrl',
			'starred_url' => 'starredUrl',
			'subscriptions_url' => 'subscriptionsUrl',
			'organizations_url' => 'organizationsUrl',
			'repos_url' => 'reposUrl',
			'events_url' => 'eventsUrl',
			'received_events_url' => 'receivedEventsUrl',
			'type' => 'type',
			'site_admin' => 'siteAdmin',
		],
		'dashed' => [
			'login' => 'login',
			'id' => 'id',
			'node-id' => 'nodeId',
			'avatar-url' => 'avatarUrl',
			'gravatar-id' => 'gravatarId',
			'url' => 'url',
			'html-url' => 'htmlUrl',
			'followers-url' => 'followersUrl',
			'following-url' => 'followingUrl',
			'gists-url' => 'gistsUrl',
			'starred-url' => 'starredUrl',
			'subscriptions-url' => 'subscriptionsUrl',
			'organizations-url' => 'organizationsUrl',
			'repos-url' => 'reposUrl',
			'events-url' => 'eventsUrl',
			'received-events-url' => 'receivedEventsUrl',
			'type' => 'type',
			'site-admin' => 'siteAdmin',
		],
	];

	/**
	 * @param string|null $login
	 *
	 * @return $this
	 */
	public function setLogin(?string $login) {
		$this->login = $login;
		$this->_touchedFields[self::FIELD_LOGIN] = true;

		return $this;
	}

	/**
	 * @param string $login
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLoginOrFail(string $login) {
		$this->login = $login;
		$this->_touchedFields[self::FIELD_LOGIN] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLogin(): ?string {
		return $this->login;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLoginOrFail(): string {
		if ($this->login === null) {
			throw new \RuntimeException('Value not set for field `login` (expected to be not null)');
		}

		return $this->login;
	}

	/**
	 * @return bool
	 */
	public function hasLogin(): bool {
		return $this->login !== null;
	}

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
	 * @param string|null $avatarUrl
	 *
	 * @return $this
	 */
	public function setAvatarUrl(?string $avatarUrl) {
		$this->avatarUrl = $avatarUrl;
		$this->_touchedFields[self::FIELD_AVATAR_URL] = true;

		return $this;
	}

	/**
	 * @param string $avatarUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAvatarUrlOrFail(string $avatarUrl) {
		$this->avatarUrl = $avatarUrl;
		$this->_touchedFields[self::FIELD_AVATAR_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAvatarUrl(): ?string {
		return $this->avatarUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getAvatarUrlOrFail(): string {
		if ($this->avatarUrl === null) {
			throw new \RuntimeException('Value not set for field `avatarUrl` (expected to be not null)');
		}

		return $this->avatarUrl;
	}

	/**
	 * @return bool
	 */
	public function hasAvatarUrl(): bool {
		return $this->avatarUrl !== null;
	}

	/**
	 * @param string|null $gravatarId
	 *
	 * @return $this
	 */
	public function setGravatarId(?string $gravatarId) {
		$this->gravatarId = $gravatarId;
		$this->_touchedFields[self::FIELD_GRAVATAR_ID] = true;

		return $this;
	}

	/**
	 * @param string $gravatarId
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGravatarIdOrFail(string $gravatarId) {
		$this->gravatarId = $gravatarId;
		$this->_touchedFields[self::FIELD_GRAVATAR_ID] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGravatarId(): ?string {
		return $this->gravatarId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGravatarIdOrFail(): string {
		if ($this->gravatarId === null) {
			throw new \RuntimeException('Value not set for field `gravatarId` (expected to be not null)');
		}

		return $this->gravatarId;
	}

	/**
	 * @return bool
	 */
	public function hasGravatarId(): bool {
		return $this->gravatarId !== null;
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
	 * @param string|null $followersUrl
	 *
	 * @return $this
	 */
	public function setFollowersUrl(?string $followersUrl) {
		$this->followersUrl = $followersUrl;
		$this->_touchedFields[self::FIELD_FOLLOWERS_URL] = true;

		return $this;
	}

	/**
	 * @param string $followersUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setFollowersUrlOrFail(string $followersUrl) {
		$this->followersUrl = $followersUrl;
		$this->_touchedFields[self::FIELD_FOLLOWERS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFollowersUrl(): ?string {
		return $this->followersUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getFollowersUrlOrFail(): string {
		if ($this->followersUrl === null) {
			throw new \RuntimeException('Value not set for field `followersUrl` (expected to be not null)');
		}

		return $this->followersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasFollowersUrl(): bool {
		return $this->followersUrl !== null;
	}

	/**
	 * @param string|null $followingUrl
	 *
	 * @return $this
	 */
	public function setFollowingUrl(?string $followingUrl) {
		$this->followingUrl = $followingUrl;
		$this->_touchedFields[self::FIELD_FOLLOWING_URL] = true;

		return $this;
	}

	/**
	 * @param string $followingUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setFollowingUrlOrFail(string $followingUrl) {
		$this->followingUrl = $followingUrl;
		$this->_touchedFields[self::FIELD_FOLLOWING_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFollowingUrl(): ?string {
		return $this->followingUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getFollowingUrlOrFail(): string {
		if ($this->followingUrl === null) {
			throw new \RuntimeException('Value not set for field `followingUrl` (expected to be not null)');
		}

		return $this->followingUrl;
	}

	/**
	 * @return bool
	 */
	public function hasFollowingUrl(): bool {
		return $this->followingUrl !== null;
	}

	/**
	 * @param string|null $gistsUrl
	 *
	 * @return $this
	 */
	public function setGistsUrl(?string $gistsUrl) {
		$this->gistsUrl = $gistsUrl;
		$this->_touchedFields[self::FIELD_GISTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $gistsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGistsUrlOrFail(string $gistsUrl) {
		$this->gistsUrl = $gistsUrl;
		$this->_touchedFields[self::FIELD_GISTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGistsUrl(): ?string {
		return $this->gistsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGistsUrlOrFail(): string {
		if ($this->gistsUrl === null) {
			throw new \RuntimeException('Value not set for field `gistsUrl` (expected to be not null)');
		}

		return $this->gistsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGistsUrl(): bool {
		return $this->gistsUrl !== null;
	}

	/**
	 * @param string|null $starredUrl
	 *
	 * @return $this
	 */
	public function setStarredUrl(?string $starredUrl) {
		$this->starredUrl = $starredUrl;
		$this->_touchedFields[self::FIELD_STARRED_URL] = true;

		return $this;
	}

	/**
	 * @param string $starredUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setStarredUrlOrFail(string $starredUrl) {
		$this->starredUrl = $starredUrl;
		$this->_touchedFields[self::FIELD_STARRED_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getStarredUrl(): ?string {
		return $this->starredUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getStarredUrlOrFail(): string {
		if ($this->starredUrl === null) {
			throw new \RuntimeException('Value not set for field `starredUrl` (expected to be not null)');
		}

		return $this->starredUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStarredUrl(): bool {
		return $this->starredUrl !== null;
	}

	/**
	 * @param string|null $subscriptionsUrl
	 *
	 * @return $this
	 */
	public function setSubscriptionsUrl(?string $subscriptionsUrl) {
		$this->subscriptionsUrl = $subscriptionsUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTIONS_URL] = true;

		return $this;
	}

	/**
	 * @param string $subscriptionsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSubscriptionsUrlOrFail(string $subscriptionsUrl) {
		$this->subscriptionsUrl = $subscriptionsUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSubscriptionsUrl(): ?string {
		return $this->subscriptionsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSubscriptionsUrlOrFail(): string {
		if ($this->subscriptionsUrl === null) {
			throw new \RuntimeException('Value not set for field `subscriptionsUrl` (expected to be not null)');
		}

		return $this->subscriptionsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscriptionsUrl(): bool {
		return $this->subscriptionsUrl !== null;
	}

	/**
	 * @param string|null $organizationsUrl
	 *
	 * @return $this
	 */
	public function setOrganizationsUrl(?string $organizationsUrl) {
		$this->organizationsUrl = $organizationsUrl;
		$this->_touchedFields[self::FIELD_ORGANIZATIONS_URL] = true;

		return $this;
	}

	/**
	 * @param string $organizationsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setOrganizationsUrlOrFail(string $organizationsUrl) {
		$this->organizationsUrl = $organizationsUrl;
		$this->_touchedFields[self::FIELD_ORGANIZATIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getOrganizationsUrl(): ?string {
		return $this->organizationsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getOrganizationsUrlOrFail(): string {
		if ($this->organizationsUrl === null) {
			throw new \RuntimeException('Value not set for field `organizationsUrl` (expected to be not null)');
		}

		return $this->organizationsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasOrganizationsUrl(): bool {
		return $this->organizationsUrl !== null;
	}

	/**
	 * @param string|null $reposUrl
	 *
	 * @return $this
	 */
	public function setReposUrl(?string $reposUrl) {
		$this->reposUrl = $reposUrl;
		$this->_touchedFields[self::FIELD_REPOS_URL] = true;

		return $this;
	}

	/**
	 * @param string $reposUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReposUrlOrFail(string $reposUrl) {
		$this->reposUrl = $reposUrl;
		$this->_touchedFields[self::FIELD_REPOS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getReposUrl(): ?string {
		return $this->reposUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getReposUrlOrFail(): string {
		if ($this->reposUrl === null) {
			throw new \RuntimeException('Value not set for field `reposUrl` (expected to be not null)');
		}

		return $this->reposUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReposUrl(): bool {
		return $this->reposUrl !== null;
	}

	/**
	 * @param string|null $eventsUrl
	 *
	 * @return $this
	 */
	public function setEventsUrl(?string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $eventsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setEventsUrlOrFail(string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getEventsUrl(): ?string {
		return $this->eventsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getEventsUrlOrFail(): string {
		if ($this->eventsUrl === null) {
			throw new \RuntimeException('Value not set for field `eventsUrl` (expected to be not null)');
		}

		return $this->eventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasEventsUrl(): bool {
		return $this->eventsUrl !== null;
	}

	/**
	 * @param string|null $receivedEventsUrl
	 *
	 * @return $this
	 */
	public function setReceivedEventsUrl(?string $receivedEventsUrl) {
		$this->receivedEventsUrl = $receivedEventsUrl;
		$this->_touchedFields[self::FIELD_RECEIVED_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $receivedEventsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReceivedEventsUrlOrFail(string $receivedEventsUrl) {
		$this->receivedEventsUrl = $receivedEventsUrl;
		$this->_touchedFields[self::FIELD_RECEIVED_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getReceivedEventsUrl(): ?string {
		return $this->receivedEventsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getReceivedEventsUrlOrFail(): string {
		if ($this->receivedEventsUrl === null) {
			throw new \RuntimeException('Value not set for field `receivedEventsUrl` (expected to be not null)');
		}

		return $this->receivedEventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReceivedEventsUrl(): bool {
		return $this->receivedEventsUrl !== null;
	}

	/**
	 * @param string|null $type
	 *
	 * @return $this
	 */
	public function setType(?string $type) {
		$this->type = $type;
		$this->_touchedFields[self::FIELD_TYPE] = true;

		return $this;
	}

	/**
	 * @param string $type
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTypeOrFail(string $type) {
		$this->type = $type;
		$this->_touchedFields[self::FIELD_TYPE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getType(): ?string {
		return $this->type;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTypeOrFail(): string {
		if ($this->type === null) {
			throw new \RuntimeException('Value not set for field `type` (expected to be not null)');
		}

		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function hasType(): bool {
		return $this->type !== null;
	}

	/**
	 * @param bool|null $siteAdmin
	 *
	 * @return $this
	 */
	public function setSiteAdmin(?bool $siteAdmin) {
		$this->siteAdmin = $siteAdmin;
		$this->_touchedFields[self::FIELD_SITE_ADMIN] = true;

		return $this;
	}

	/**
	 * @param bool $siteAdmin
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSiteAdminOrFail(bool $siteAdmin) {
		$this->siteAdmin = $siteAdmin;
		$this->_touchedFields[self::FIELD_SITE_ADMIN] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getSiteAdmin(): ?bool {
		return $this->siteAdmin;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getSiteAdminOrFail(): bool {
		if ($this->siteAdmin === null) {
			throw new \RuntimeException('Value not set for field `siteAdmin` (expected to be not null)');
		}

		return $this->siteAdmin;
	}

	/**
	 * @return bool
	 */
	public function hasSiteAdmin(): bool {
		return $this->siteAdmin !== null;
	}

}
