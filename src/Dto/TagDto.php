<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * Tag DTO
 *
 * @property int|null $id
 * @property string|null $label
 * @property string|null $slug
 * @property int|null $counter
 * @property \App\Dto\TaggedDto|null $_joinData
 */
class TagDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_LABEL = 'label';

	/**
	 * @var string
	 */
	public const FIELD_SLUG = 'slug';

	/**
	 * @var string
	 */
	public const FIELD_COUNTER = 'counter';

	/**
	 * @var string
	 */
	public const FIELD_JOIN_DATA = '_joinData';


	/**
	 * @var int|null
	 */
	protected ?int $id = null;

	/**
	 * @var string|null
	 */
	protected ?string $label = null;

	/**
	 * @var string|null
	 */
	protected ?string $slug = null;

	/**
	 * @var int|null
	 */
	protected ?int $counter = null;

	/**
	 * @var \App\Dto\TaggedDto|null
	 */
	protected ?\App\Dto\TaggedDto $_joinData = null;

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
			'mapFrom' => null,
			'mapTo' => null,
		],
		'label' => [
			'name' => 'label',
			'type' => 'string',
			'required' => false,
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
			'mapFrom' => null,
			'mapTo' => null,
		],
		'counter' => [
			'name' => 'counter',
			'type' => 'int',
			'required' => false,
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
		'_joinData' => [
			'name' => '_joinData',
			'type' => '\App\Dto\TaggedDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Tagged',
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
			'id' => 'id',
			'label' => 'label',
			'slug' => 'slug',
			'counter' => 'counter',
			'_join_data' => '_joinData',
		],
		'dashed' => [
			'id' => 'id',
			'label' => 'label',
			'slug' => 'slug',
			'counter' => 'counter',
			'-join-data' => '_joinData',
		],
	];

	/**
	 * Whether this DTO is immutable.
	 *
	 * @var bool
	 */
	protected const IS_IMMUTABLE = true;

	/**
	 * Whether this DTO has generated fast-path methods.
	 *
	 * @var bool
	 */
	protected const HAS_FAST_PATH = true;

	/**
	 * Pre-computed setter method names for fast lookup.
	 *
	 * @var array<string, string>
	 */
	protected static array $_setters = [
		'id' => 'withId',
		'label' => 'withLabel',
		'slug' => 'withSlug',
		'counter' => 'withCounter',
		'_joinData' => 'withJoinData',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['id'])) {
			$this->id = $data['id'];
			$this->_touchedFields['id'] = true;
		}
		if (isset($data['label'])) {
			$this->label = $data['label'];
			$this->_touchedFields['label'] = true;
		}
		if (isset($data['slug'])) {
			$this->slug = $data['slug'];
			$this->_touchedFields['slug'] = true;
		}
		if (isset($data['counter'])) {
			$this->counter = $data['counter'];
			$this->_touchedFields['counter'] = true;
		}
		if (isset($data['_joinData'])) {
			$value = $data['_joinData'];
			if (is_array($value)) {
				$value = new \App\Dto\TaggedDto($value, true);
			}
			$this->_joinData = $value;
			$this->_touchedFields['_joinData'] = true;
		}
	}

	/**
	 * Optimized toArray for default type without dynamic dispatch.
	 *
	 * @return array<string, mixed>
	 */
	protected function toArrayFast(): array {
		return [
			'id' => $this->id,
			'label' => $this->label,
			'slug' => $this->slug,
			'counter' => $this->counter,
			'_joinData' => $this->_joinData !== null ? $this->_joinData->toArray() : null,
		];
	}


	/**
	 * Optimized setDefaults - only processes fields with default values.
	 *
	 * @return $this
	 */
	protected function setDefaults(): static {

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
	}


	/**
	 * @param int|null $id
	 *
	 * @return static
	 */
	public function withId(?int $id = null): static {
		$new = clone $this;
		$new->id = $id;
		$new->_touchedFields[static::FIELD_ID] = true;

		return $new;
	}

	/**
	 * @param int $id
	 *
	 * @return static
	 */
	public function withIdOrFail(int $id): static {
		$new = clone $this;
		$new->id = $id;
		$new->_touchedFields[static::FIELD_ID] = true;

		return $new;
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
	 * @param string|null $label
	 *
	 * @return static
	 */
	public function withLabel(?string $label = null): static {
		$new = clone $this;
		$new->label = $label;
		$new->_touchedFields[static::FIELD_LABEL] = true;

		return $new;
	}

	/**
	 * @param string $label
	 *
	 * @return static
	 */
	public function withLabelOrFail(string $label): static {
		$new = clone $this;
		$new->label = $label;
		$new->_touchedFields[static::FIELD_LABEL] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getLabel(): ?string {
		return $this->label;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLabelOrFail(): string {
		if ($this->label === null) {
			throw new \RuntimeException('Value not set for field `label` (expected to be not null)');
		}

		return $this->label;
	}

	/**
	 * @return bool
	 */
	public function hasLabel(): bool {
		return $this->label !== null;
	}

	/**
	 * @param string|null $slug
	 *
	 * @return static
	 */
	public function withSlug(?string $slug = null): static {
		$new = clone $this;
		$new->slug = $slug;
		$new->_touchedFields[static::FIELD_SLUG] = true;

		return $new;
	}

	/**
	 * @param string $slug
	 *
	 * @return static
	 */
	public function withSlugOrFail(string $slug): static {
		$new = clone $this;
		$new->slug = $slug;
		$new->_touchedFields[static::FIELD_SLUG] = true;

		return $new;
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
	 * @param int|null $counter
	 *
	 * @return static
	 */
	public function withCounter(?int $counter = null): static {
		$new = clone $this;
		$new->counter = $counter;
		$new->_touchedFields[static::FIELD_COUNTER] = true;

		return $new;
	}

	/**
	 * @param int $counter
	 *
	 * @return static
	 */
	public function withCounterOrFail(int $counter): static {
		$new = clone $this;
		$new->counter = $counter;
		$new->_touchedFields[static::FIELD_COUNTER] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getCounter(): ?int {
		return $this->counter;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getCounterOrFail(): int {
		if ($this->counter === null) {
			throw new \RuntimeException('Value not set for field `counter` (expected to be not null)');
		}

		return $this->counter;
	}

	/**
	 * @return bool
	 */
	public function hasCounter(): bool {
		return $this->counter !== null;
	}

	/**
	 * @param \App\Dto\TaggedDto|null $_joinData
	 *
	 * @return static
	 */
	public function withJoinData(?\App\Dto\TaggedDto $_joinData = null): static {
		$new = clone $this;
		$new->_joinData = $_joinData;
		$new->_touchedFields[static::FIELD_JOIN_DATA] = true;

		return $new;
	}

	/**
	 * @param \App\Dto\TaggedDto $_joinData
	 *
	 * @return static
	 */
	public function withJoinDataOrFail(\App\Dto\TaggedDto $_joinData): static {
		$new = clone $this;
		$new->_joinData = $_joinData;
		$new->_touchedFields[static::FIELD_JOIN_DATA] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\TaggedDto|null
	 */
	public function getJoinData(): ?\App\Dto\TaggedDto {
		return $this->_joinData;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\TaggedDto
	 */
	public function getJoinDataOrFail(): \App\Dto\TaggedDto {
		if ($this->_joinData === null) {
			throw new \RuntimeException('Value not set for field `_joinData` (expected to be not null)');
		}

		return $this->_joinData;
	}

	/**
	 * @return bool
	 */
	public function hasJoinData(): bool {
		return $this->_joinData !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null} $data
	 * @phpstan-param array<string, mixed> $data
	 * @param bool $ignoreMissing
	 * @param string|null $type
	 *
	 * @return static
	 */
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return static::_createFromArrayInternal($data, $ignoreMissing, $type);
	}

}
