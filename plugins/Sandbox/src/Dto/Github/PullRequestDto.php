<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use PhpCollective\Dto\Dto\AbstractDto;

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
class PullRequestDto extends AbstractDto {

	/**
	 * @var string
	 */
	public const FIELD_URL = 'url';
	/**
	 * @var string
	 */
	public const FIELD_NUMBER = 'number';
	/**
	 * @var string
	 */
	public const FIELD_STATE = 'state';
	/**
	 * @var string
	 */
	public const FIELD_TITLE = 'title';
	/**
	 * @var string
	 */
	public const FIELD_BODY = 'body';
	/**
	 * @var string
	 */
	public const FIELD_USER = 'user';
	/**
	 * @var string
	 */
	public const FIELD_CREATED_AT = 'createdAt';
	/**
	 * @var string
	 */
	public const FIELD_LABELS = 'labels';
	/**
	 * @var string
	 */
	public const FIELD_HEAD = 'head';
	/**
	 * @var string
	 */
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
			'isClass' => true,
			'enum' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
	 * Whether this DTO is immutable.
	 */
	protected const IS_IMMUTABLE = false;

	/**
	 * Pre-computed setter method names for fast lookup.
	 *
	 * @var array<string, string>
	 */
	protected static array $_setters = [
		'url' => 'setUrl',
		'number' => 'setNumber',
		'state' => 'setState',
		'title' => 'setTitle',
		'body' => 'setBody',
		'user' => 'setUser',
		'createdAt' => 'setCreatedat',
		'labels' => 'setLabels',
		'head' => 'setHead',
		'base' => 'setBase',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['url'])) {
			$this->url = $data['url'];
			$this->_touchedFields['url'] = true;
		}
		if (isset($data['number'])) {
			$this->number = $data['number'];
			$this->_touchedFields['number'] = true;
		}
		if (isset($data['state'])) {
			$this->state = $data['state'];
			$this->_touchedFields['state'] = true;
		}
		if (isset($data['title'])) {
			$this->title = $data['title'];
			$this->_touchedFields['title'] = true;
		}
		if (isset($data['body'])) {
			$this->body = $data['body'];
			$this->_touchedFields['body'] = true;
		}
		if (isset($data['user'])) {
			$value = $data['user'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\UserDto($value);
			}
			$this->user = $value;
			$this->_touchedFields['user'] = true;
		}
		if (isset($data['createdAt'])) {
			$this->createdAt = $data['createdAt'];
			$this->_touchedFields['createdAt'] = true;
		}
		if (isset($data['labels'])) {
			$collection = [];
			foreach ($data['labels'] as $key => $item) {
				if (is_array($item)) {
					$item = new \Sandbox\Dto\Github\LabelDto($item);
				}
				$collection[$key] = $item;
			}
			$this->labels = $collection;
			$this->_touchedFields['labels'] = true;
		}
		if (isset($data['head'])) {
			$value = $data['head'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\HeadDto($value);
			}
			$this->head = $value;
			$this->_touchedFields['head'] = true;
		}
		if (isset($data['base'])) {
			$value = $data['base'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\BaseDto($value);
			}
			$this->base = $value;
			$this->_touchedFields['base'] = true;
		}
	}

	/**
	 * Optimized setDefaults - only processes fields with default values.
	 *
	 * @return $this
	 */
	protected function setDefaults() {

		return $this;
	}

	/**
	 * Optimized validate - only checks required fields.
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return void
	 */
	protected function validate(): void {
		if ($this->url === null || $this->number === null || $this->state === null || $this->title === null || $this->body === null || $this->user === null || $this->createdAt === null) {
			$errors = [];
			if ($this->url === null) {
				$errors[] = 'url';
			}
			if ($this->number === null) {
				$errors[] = 'number';
			}
			if ($this->state === null) {
				$errors[] = 'state';
			}
			if ($this->title === null) {
				$errors[] = 'title';
			}
			if ($this->body === null) {
				$errors[] = 'body';
			}
			if ($this->user === null) {
				$errors[] = 'user';
			}
			if ($this->createdAt === null) {
				$errors[] = 'createdAt';
			}
			if ($errors) {
				throw new \InvalidArgumentException('Required fields missing: ' . implode(', ', $errors));
			}
		}
	}


	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl(string $url) {
		$this->url = $url;
		$this->_touchedFields[static::FIELD_URL] = true;

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
		$this->_touchedFields[static::FIELD_NUMBER] = true;

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
		$this->_touchedFields[static::FIELD_STATE] = true;

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
		$this->_touchedFields[static::FIELD_TITLE] = true;

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
		$this->_touchedFields[static::FIELD_BODY] = true;

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
		$this->_touchedFields[static::FIELD_USER] = true;

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
		$this->_touchedFields[static::FIELD_CREATED_AT] = true;

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
		$this->_touchedFields[static::FIELD_LABELS] = true;

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
		$this->_touchedFields[static::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\HeadDto|null $head
	 *
	 * @return $this
	 */
	public function setHead(?\Sandbox\Dto\Github\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[static::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\HeadDto $head
	 *
	 * @return $this
	 */
	public function setHeadOrFail(\Sandbox\Dto\Github\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[static::FIELD_HEAD] = true;

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
		$this->_touchedFields[static::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @param \Sandbox\Dto\Github\BaseDto $base
	 *
	 * @return $this
	 */
	public function setBaseOrFail(\Sandbox\Dto\Github\BaseDto $base) {
		$this->base = $base;
		$this->_touchedFields[static::FIELD_BASE] = true;

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


	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{url: string, number: int, state: string, title: string, body: string, user: array<string, mixed>, createdAt: \Cake\I18n\FrozenTime, labels: array<string, \Sandbox\Dto\Github\LabelDto>, head: array<string, mixed>|null, base: array<string, mixed>|null}
	 */
	#[\Override]
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @phpstan-ignore return.type (parent returns array, we provide shape for IDE) */
		return parent::toArray($type, $fields, $touched);
	}

	/**
	 * @param array{url: string, number: int, state: string, title: string, body: string, user: array<string, mixed>, createdAt: \Cake\I18n\FrozenTime, labels: array<string, \Sandbox\Dto\Github\LabelDto>, head: array<string, mixed>|null, base: array<string, mixed>|null} $data
	 * @param bool $ignoreMissing
	 * @param string|null $type
	 *
	 * @return static
	 */
	#[\Override] // @phpstan-ignore method.childParameterType
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return parent::createFromArray($data, $ignoreMissing, $type);
	}

}
