<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/PullRequest DTO
 */
class PullRequestDto extends \CakeDto\Dto\AbstractDto {

	const FIELD_URL = 'url';
	const FIELD_NUMBER = 'number';
	const FIELD_STATE = 'state';
	const FIELD_TITLE = 'title';
	const FIELD_BODY = 'body';
	const FIELD_USER = 'user';
	const FIELD_CREATED_AT = 'createdAt';
	const FIELD_LABELS = 'labels';
	const FIELD_HEAD = 'head';
	const FIELD_BASE = 'base';

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var int
	 */
	protected $number;

	/**
	 * @var string
	 */
	protected $state;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $body;

	/**
	 * @var \Sandbox\Dto\Github\UserDto
	 */
	protected $user;

	/**
	 * @var \Cake\I18n\FrozenTime
	 */
	protected $createdAt;

	/**
	 * @var \Sandbox\Dto\Github\LabelDto[]
	 */
	protected $labels;

	/**
	 * @var \Sandbox\Dto\Github\HeadDto|null
	 */
	protected $head;

	/**
	 * @var \Sandbox\Dto\Github\BaseDto|null
	 */
	protected $base;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array
	 */
	protected $_metadata = [
		'url' => [
			'name' => 'url',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'number' => [
			'name' => 'number',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'state' => [
			'name' => 'state',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'title' => [
			'name' => 'title',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'body' => [
			'name' => 'body',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'user' => [
			'name' => 'user',
			'type' => '\Sandbox\Dto\Github\UserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/User',
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'createdAt' => [
			'name' => 'createdAt',
			'type' => '\Cake\I18n\FrozenTime',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
			'isClass' => true,
		],
		'labels' => [
			'name' => 'labels',
			'type' => '\Sandbox\Dto\Github\LabelDto[]',
			'associative' => true,
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => 'array',
			'serializable' => false,
			'toArray' => false,
			'singularType' => '\Sandbox\Dto\Github\LabelDto',
		],
		'head' => [
			'name' => 'head',
			'type' => '\Sandbox\Dto\Github\HeadDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Github/Head',
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'base' => [
			'name' => 'base',
			'type' => '\Sandbox\Dto\Github\BaseDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Github/Base',
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
	];

	/**
	* @var array
	*/
	protected $_keyMap = [
		'underscored' => [
			'url' => 'url',
			'number' => 'number',
			'state' => 'state',
			'title' => 'title',
			'body' => 'body',
			'user' => 'user',
			'created_at' => 'createdAt',
			'labels' => 'labels',
			'head' => 'head',
			'base' => 'base',
		],
		'dashed' => [
			'url' => 'url',
			'number' => 'number',
			'state' => 'state',
			'title' => 'title',
			'body' => 'body',
			'user' => 'user',
			'created-at' => 'createdAt',
			'labels' => 'labels',
			'head' => 'head',
			'base' => 'base',
		],
	];

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
	public function hasUrl() {
		return $this->url !== null;
	}

	/**
	 * @param int $number
	 *
	 * @return $this
	 */
	public function setNumber(int $number) {
		$this->number = $number;
		$this->_touchedFields[self::FIELD_NUMBER] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumber(): int {
		return $this->number;
	}

	/**
	 * @return bool
	 */
	public function hasNumber() {
		return $this->number !== null;
	}

	/**
	 * @param string $state
	 *
	 * @return $this
	 */
	public function setState(string $state) {
		$this->state = $state;
		$this->_touchedFields[self::FIELD_STATE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getState(): string {
		return $this->state;
	}

	/**
	 * @return bool
	 */
	public function hasState() {
		return $this->state !== null;
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function setTitle(string $title) {
		$this->title = $title;
		$this->_touchedFields[self::FIELD_TITLE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function hasTitle() {
		return $this->title !== null;
	}

	/**
	 * @param string $body
	 *
	 * @return $this
	 */
	public function setBody(string $body) {
		$this->body = $body;
		$this->_touchedFields[self::FIELD_BODY] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody(): string {
		return $this->body;
	}

	/**
	 * @return bool
	 */
	public function hasBody() {
		return $this->body !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\UserDto $user
	 *
	 * @return $this
	 */
	public function setUser(\Sandbox\Dto\Github\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\UserDto
	 */
	public function getUser(): \Sandbox\Dto\Github\UserDto {
		return $this->user;
	}

	/**
	 * @return bool
	 */
	public function hasUser() {
		return $this->user !== null;
	}

	/**
	 * @param \Cake\I18n\FrozenTime $createdAt
	 *
	 * @return $this
	 */
	public function setCreatedAt(\Cake\I18n\FrozenTime $createdAt) {
		$this->createdAt = $createdAt;
		$this->_touchedFields[self::FIELD_CREATED_AT] = true;

		return $this;
	}

	/**
	 * @return \Cake\I18n\FrozenTime
	 */
	public function getCreatedAt(): \Cake\I18n\FrozenTime {
		return $this->createdAt;
	}

	/**
	 * @return bool
	 */
	public function hasCreatedAt() {
		return $this->createdAt !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\LabelDto[] $labels
	 *
	 * @return $this
	 */
	public function setLabels(array $labels) {
		$this->labels = $labels;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\LabelDto[]
	 */
	public function getLabels(): array {
		if ($this->labels === null) {
			return [];
		}

		return $this->labels;
	}

	/**
	 * @param string $key
	 *
	 * @return \Sandbox\Dto\Github\LabelDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getLabel($key): \Sandbox\Dto\Github\LabelDto {
		if (!isset($this->labels[$key])) {
			throw new \RuntimeException(sprintf('Value not set for field `labels` and key `%s` (expected to be not null)', $key));
		}

		return $this->labels[$key];
	}

	/**
	 * @return bool
	 */
	public function hasLabels() {
		if ($this->labels === null) {
			return false;
		}

		return count($this->labels) > 0;
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function hasLabel($key) {
		return isset($this->labels[$key]);
	}

	/**
	 * @param string $key
	 * @param \Sandbox\Dto\Github\LabelDto $label
	 * @return $this
	 */
	public function addLabel($key, \Sandbox\Dto\Github\LabelDto $label) {
		if (!isset($this->labels)) {
			$this->labels = [];
		}

		$this->labels[$key] = $label;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\HeadDto|null $head
	 *
	 * @return $this
	 */
	public function setHead(?\Sandbox\Dto\Github\HeadDto $head = null) {
		$this->head = $head;
		$this->_touchedFields[self::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\HeadDto|null
	 */
	public function getHead(): ?\Sandbox\Dto\Github\HeadDto {
		return $this->head;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \Sandbox\Dto\Github\HeadDto
	 */
	public function getHeadOrFail(): \Sandbox\Dto\Github\HeadDto {
		if (!isset($this->head)) {
			throw new \RuntimeException('Value not set for field `head` (expected to be not null)');
		}

		return $this->head;
	}

	/**
	 * @return bool
	 */
	public function hasHead() {
		return $this->head !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\BaseDto|null $base
	 *
	 * @return $this
	 */
	public function setBase(?\Sandbox\Dto\Github\BaseDto $base = null) {
		$this->base = $base;
		$this->_touchedFields[self::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\BaseDto|null
	 */
	public function getBase(): ?\Sandbox\Dto\Github\BaseDto {
		return $this->base;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \Sandbox\Dto\Github\BaseDto
	 */
	public function getBaseOrFail(): \Sandbox\Dto\Github\BaseDto {
		if (!isset($this->base)) {
			throw new \RuntimeException('Value not set for field `base` (expected to be not null)');
		}

		return $this->base;
	}

	/**
	 * @return bool
	 */
	public function hasBase() {
		return $this->base !== null;
	}

}
