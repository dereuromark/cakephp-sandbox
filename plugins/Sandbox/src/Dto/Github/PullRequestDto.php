<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/PullRequest DTO
 *
 * @property string $url
 * @property int $number
 * @property string $state
 * @property string $title
 * @property string $body
 * @property \Sandbox\Dto\Github\UserDto $user
 * @property \Cake\I18n\FrozenTime $createdAt
 * @property \Sandbox\Dto\Github\LabelDto[] $labels
 * @property \Sandbox\Dto\Github\HeadDto|null $head
 * @property \Sandbox\Dto\Github\BaseDto|null $base
 */
class PullRequestDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_URL = 'url';
	public const FIELD_NUMBER = 'number';
	public const FIELD_STATE = 'state';
	public const FIELD_TITLE = 'title';
	public const FIELD_BODY = 'body';
	public const FIELD_USER = 'user';
	public const FIELD_CREATED_AT = 'createdAt';
	public const FIELD_LABELS = 'labels';
	public const FIELD_HEAD = 'head';
	public const FIELD_BASE = 'base';

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
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
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
		'number' => [
			'name' => 'number',
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
		'state' => [
			'name' => 'state',
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
		'title' => [
			'name' => 'title',
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
		'body' => [
			'name' => 'body',
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
		'user' => [
			'name' => 'user',
			'type' => '\Sandbox\Dto\Github\UserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/User',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'createdAt' => [
			'name' => 'createdAt',
			'type' => '\Cake\I18n\FrozenTime',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'isClass' => true,
		],
		'labels' => [
			'name' => 'labels',
			'type' => '\Sandbox\Dto\Github\LabelDto[]',
			'associative' => true,
			'key' => 'name',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => 'array',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\Sandbox\Dto\Github\LabelDto',
			'singularNullable' => false,
			'singularTypeHint' => '\Sandbox\Dto\Github\LabelDto',
		],
		'head' => [
			'name' => 'head',
			'type' => '\Sandbox\Dto\Github\HeadDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Github/Head',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'base' => [
			'name' => 'base',
			'type' => '\Sandbox\Dto\Github\BaseDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Github/Base',
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
	public function hasUrl(): bool {
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
	public function hasNumber(): bool {
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
	public function hasState(): bool {
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
	public function hasTitle(): bool {
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
	public function hasBody(): bool {
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
	public function hasUser(): bool {
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
	public function hasCreatedAt(): bool {
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
	 * @param string|int $key
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
	public function hasLabels(): bool {
		if ($this->labels === null) {
			return false;
		}

		return count($this->labels) > 0;
	}

	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function hasLabel($key): bool {
		return isset($this->labels[$key]);
	}

	/**
	 * @param string|int $key
	 * @param \Sandbox\Dto\Github\LabelDto $label
	 * @return $this
	 */
	public function addLabel($key, \Sandbox\Dto\Github\LabelDto $label) {
		if ($this->labels === null) {
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
	public function setHead(?\Sandbox\Dto\Github\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[self::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\HeadDto $head
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHeadOrFail(\Sandbox\Dto\Github\HeadDto $head) {
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
		if ($this->head === null) {
			throw new \RuntimeException('Value not set for field `head` (expected to be not null)');
		}

		return $this->head;
	}

	/**
	 * @return bool
	 */
	public function hasHead(): bool {
		return $this->head !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\BaseDto|null $base
	 *
	 * @return $this
	 */
	public function setBase(?\Sandbox\Dto\Github\BaseDto $base) {
		$this->base = $base;
		$this->_touchedFields[self::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\BaseDto $base
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setBaseOrFail(\Sandbox\Dto\Github\BaseDto $base) {
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
		if ($this->base === null) {
			throw new \RuntimeException('Value not set for field `base` (expected to be not null)');
		}

		return $this->base;
	}

	/**
	 * @return bool
	 */
	public function hasBase(): bool {
		return $this->base !== null;
	}

}
