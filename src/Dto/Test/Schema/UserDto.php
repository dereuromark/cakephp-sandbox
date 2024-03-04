<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/User DTO
 *
 * @property string $avatarUrl
 * @property string $eventsUrl
 * @property string $followersUrl
 * @property string $followingUrl
 * @property string $gistsUrl
 * @property string|null $gravatarId
 * @property string $htmlUrl
 * @property int $id
 * @property string $nodeId
 * @property string $login
 * @property string $organizationsUrl
 * @property string $receivedEventsUrl
 * @property string $reposUrl
 * @property bool $siteAdmin
 * @property string $starredUrl
 * @property string $subscriptionsUrl
 * @property string $type
 * @property string $url
 */
class UserDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_AVATAR_URL = 'avatarUrl';
	public const FIELD_EVENTS_URL = 'eventsUrl';
	public const FIELD_FOLLOWERS_URL = 'followersUrl';
	public const FIELD_FOLLOWING_URL = 'followingUrl';
	public const FIELD_GISTS_URL = 'gistsUrl';
	public const FIELD_GRAVATAR_ID = 'gravatarId';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_LOGIN = 'login';
	public const FIELD_ORGANIZATIONS_URL = 'organizationsUrl';
	public const FIELD_RECEIVED_EVENTS_URL = 'receivedEventsUrl';
	public const FIELD_REPOS_URL = 'reposUrl';
	public const FIELD_SITE_ADMIN = 'siteAdmin';
	public const FIELD_STARRED_URL = 'starredUrl';
	public const FIELD_SUBSCRIPTIONS_URL = 'subscriptionsUrl';
	public const FIELD_TYPE = 'type';
	public const FIELD_URL = 'url';

	/**
	 * @var string
	 */
	protected $avatarUrl;

	/**
	 * @var string
	 */
	protected $eventsUrl;

	/**
	 * @var string
	 */
	protected $followersUrl;

	/**
	 * @var string
	 */
	protected $followingUrl;

	/**
	 * @var string
	 */
	protected $gistsUrl;

	/**
	 * @var string|null
	 */
	protected $gravatarId;

	/**
	 * @var string
	 */
	protected $htmlUrl;

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
	protected $login;

	/**
	 * @var string
	 */
	protected $organizationsUrl;

	/**
	 * @var string
	 */
	protected $receivedEventsUrl;

	/**
	 * @var string
	 */
	protected $reposUrl;

	/**
	 * @var bool
	 */
	protected $siteAdmin;

	/**
	 * @var string
	 */
	protected $starredUrl;

	/**
	 * @var string
	 */
	protected $subscriptionsUrl;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'avatarUrl' => [
			'name' => 'avatarUrl',
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
		'eventsUrl' => [
			'name' => 'eventsUrl',
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
		'followersUrl' => [
			'name' => 'followersUrl',
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
		'followingUrl' => [
			'name' => 'followingUrl',
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
		'gistsUrl' => [
			'name' => 'gistsUrl',
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
		'login' => [
			'name' => 'login',
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
		'organizationsUrl' => [
			'name' => 'organizationsUrl',
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
		'receivedEventsUrl' => [
			'name' => 'receivedEventsUrl',
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
		'reposUrl' => [
			'name' => 'reposUrl',
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
		'siteAdmin' => [
			'name' => 'siteAdmin',
			'type' => 'bool',
			'required' => true,
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
			'required' => true,
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
			'required' => true,
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'avatar_url' => 'avatarUrl',
			'events_url' => 'eventsUrl',
			'followers_url' => 'followersUrl',
			'following_url' => 'followingUrl',
			'gists_url' => 'gistsUrl',
			'gravatar_id' => 'gravatarId',
			'html_url' => 'htmlUrl',
			'id' => 'id',
			'node_id' => 'nodeId',
			'login' => 'login',
			'organizations_url' => 'organizationsUrl',
			'received_events_url' => 'receivedEventsUrl',
			'repos_url' => 'reposUrl',
			'site_admin' => 'siteAdmin',
			'starred_url' => 'starredUrl',
			'subscriptions_url' => 'subscriptionsUrl',
			'type' => 'type',
			'url' => 'url',
		],
		'dashed' => [
			'avatar-url' => 'avatarUrl',
			'events-url' => 'eventsUrl',
			'followers-url' => 'followersUrl',
			'following-url' => 'followingUrl',
			'gists-url' => 'gistsUrl',
			'gravatar-id' => 'gravatarId',
			'html-url' => 'htmlUrl',
			'id' => 'id',
			'node-id' => 'nodeId',
			'login' => 'login',
			'organizations-url' => 'organizationsUrl',
			'received-events-url' => 'receivedEventsUrl',
			'repos-url' => 'reposUrl',
			'site-admin' => 'siteAdmin',
			'starred-url' => 'starredUrl',
			'subscriptions-url' => 'subscriptionsUrl',
			'type' => 'type',
			'url' => 'url',
		],
	];

	/**
	 * @param string $avatarUrl
	 *
	 * @return $this
	 */
	public function setAvatarUrl(string $avatarUrl) {
		$this->avatarUrl = $avatarUrl;
		$this->_touchedFields[self::FIELD_AVATAR_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAvatarUrl(): string {
		return $this->avatarUrl;
	}

	/**
	 * @return bool
	 */
	public function hasAvatarUrl(): bool {
		return $this->avatarUrl !== null;
	}

	/**
	 * @param string $eventsUrl
	 *
	 * @return $this
	 */
	public function setEventsUrl(string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEventsUrl(): string {
		return $this->eventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasEventsUrl(): bool {
		return $this->eventsUrl !== null;
	}

	/**
	 * @param string $followersUrl
	 *
	 * @return $this
	 */
	public function setFollowersUrl(string $followersUrl) {
		$this->followersUrl = $followersUrl;
		$this->_touchedFields[self::FIELD_FOLLOWERS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFollowersUrl(): string {
		return $this->followersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasFollowersUrl(): bool {
		return $this->followersUrl !== null;
	}

	/**
	 * @param string $followingUrl
	 *
	 * @return $this
	 */
	public function setFollowingUrl(string $followingUrl) {
		$this->followingUrl = $followingUrl;
		$this->_touchedFields[self::FIELD_FOLLOWING_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFollowingUrl(): string {
		return $this->followingUrl;
	}

	/**
	 * @return bool
	 */
	public function hasFollowingUrl(): bool {
		return $this->followingUrl !== null;
	}

	/**
	 * @param string $gistsUrl
	 *
	 * @return $this
	 */
	public function setGistsUrl(string $gistsUrl) {
		$this->gistsUrl = $gistsUrl;
		$this->_touchedFields[self::FIELD_GISTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGistsUrl(): string {
		return $this->gistsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGistsUrl(): bool {
		return $this->gistsUrl !== null;
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
	 * @param string $login
	 *
	 * @return $this
	 */
	public function setLogin(string $login) {
		$this->login = $login;
		$this->_touchedFields[self::FIELD_LOGIN] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogin(): string {
		return $this->login;
	}

	/**
	 * @return bool
	 */
	public function hasLogin(): bool {
		return $this->login !== null;
	}

	/**
	 * @param string $organizationsUrl
	 *
	 * @return $this
	 */
	public function setOrganizationsUrl(string $organizationsUrl) {
		$this->organizationsUrl = $organizationsUrl;
		$this->_touchedFields[self::FIELD_ORGANIZATIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrganizationsUrl(): string {
		return $this->organizationsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasOrganizationsUrl(): bool {
		return $this->organizationsUrl !== null;
	}

	/**
	 * @param string $receivedEventsUrl
	 *
	 * @return $this
	 */
	public function setReceivedEventsUrl(string $receivedEventsUrl) {
		$this->receivedEventsUrl = $receivedEventsUrl;
		$this->_touchedFields[self::FIELD_RECEIVED_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReceivedEventsUrl(): string {
		return $this->receivedEventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReceivedEventsUrl(): bool {
		return $this->receivedEventsUrl !== null;
	}

	/**
	 * @param string $reposUrl
	 *
	 * @return $this
	 */
	public function setReposUrl(string $reposUrl) {
		$this->reposUrl = $reposUrl;
		$this->_touchedFields[self::FIELD_REPOS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReposUrl(): string {
		return $this->reposUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReposUrl(): bool {
		return $this->reposUrl !== null;
	}

	/**
	 * @param bool $siteAdmin
	 *
	 * @return $this
	 */
	public function setSiteAdmin(bool $siteAdmin) {
		$this->siteAdmin = $siteAdmin;
		$this->_touchedFields[self::FIELD_SITE_ADMIN] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getSiteAdmin(): bool {
		return $this->siteAdmin;
	}

	/**
	 * @return bool
	 */
	public function hasSiteAdmin(): bool {
		return $this->siteAdmin !== null;
	}

	/**
	 * @param string $starredUrl
	 *
	 * @return $this
	 */
	public function setStarredUrl(string $starredUrl) {
		$this->starredUrl = $starredUrl;
		$this->_touchedFields[self::FIELD_STARRED_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStarredUrl(): string {
		return $this->starredUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStarredUrl(): bool {
		return $this->starredUrl !== null;
	}

	/**
	 * @param string $subscriptionsUrl
	 *
	 * @return $this
	 */
	public function setSubscriptionsUrl(string $subscriptionsUrl) {
		$this->subscriptionsUrl = $subscriptionsUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubscriptionsUrl(): string {
		return $this->subscriptionsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscriptionsUrl(): bool {
		return $this->subscriptionsUrl !== null;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setType(string $type) {
		$this->type = $type;
		$this->_touchedFields[self::FIELD_TYPE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function hasType(): bool {
		return $this->type !== null;
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

}
