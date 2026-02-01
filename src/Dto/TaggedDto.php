<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * Tagged DTO
 *
 * @property int|null $id
 * @property int|null $tagId
 * @property int|null $fkId
 * @property string|null $fkModel
 * @property \Cake\I18n\DateTime|null $created
 */
class TaggedDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_TAG_ID = 'tagId';

	/**
	 * @var string
	 */
	public const FIELD_FK_ID = 'fkId';

	/**
	 * @var string
	 */
	public const FIELD_FK_MODEL = 'fkModel';

	/**
	 * @var string
	 */
	public const FIELD_CREATED = 'created';


	/**
	 * @var int|null
	 */
	protected $id;

	/**
	 * @var int|null
	 */
	protected $tagId;

	/**
	 * @var int|null
	 */
	protected $fkId;

	/**
	 * @var string|null
	 */
	protected $fkModel;

	/**
	 * @var \Cake\I18n\DateTime|null
	 */
	protected $created;

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
		'tagId' => [
			'name' => 'tagId',
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
		'fkId' => [
			'name' => 'fkId',
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
		'fkModel' => [
			'name' => 'fkModel',
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
		'created' => [
			'name' => 'created',
			'type' => '\Cake\I18n\DateTime',
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
			'isClass' => true,
			'enum' => null,
		],
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'tag_id' => 'tagId',
			'fk_id' => 'fkId',
			'fk_model' => 'fkModel',
			'created' => 'created',
		],
		'dashed' => [
			'id' => 'id',
			'tag-id' => 'tagId',
			'fk-id' => 'fkId',
			'fk-model' => 'fkModel',
			'created' => 'created',
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
		'tagId' => 'withTagId',
		'fkId' => 'withFkId',
		'fkModel' => 'withFkModel',
		'created' => 'withCreated',
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
		if (isset($data['tagId'])) {
			$this->tagId = $data['tagId'];
			$this->_touchedFields['tagId'] = true;
		}
		if (isset($data['fkId'])) {
			$this->fkId = $data['fkId'];
			$this->_touchedFields['fkId'] = true;
		}
		if (isset($data['fkModel'])) {
			$this->fkModel = $data['fkModel'];
			$this->_touchedFields['fkModel'] = true;
		}
		if (isset($data['created'])) {
			$value = $data['created'];
			if (!is_object($value)) {
				$value = $this->createWithConstructor('created', $value, $this->_metadata['created']);
			}
			/** @var \Cake\I18n\DateTime $value */
			$this->created = $value;
			$this->_touchedFields['created'] = true;
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
			'tagId' => $this->tagId,
			'fkId' => $this->fkId,
			'fkModel' => $this->fkModel,
			'created' => $this->created,
		];
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
	}


	/**
	 * @param int|null $id
	 *
	 * @return static
	 */
	public function withId(?int $id = null) {
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
	public function withIdOrFail(int $id) {
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
	 * @param int|null $tagId
	 *
	 * @return static
	 */
	public function withTagId(?int $tagId = null) {
		$new = clone $this;
		$new->tagId = $tagId;
		$new->_touchedFields[static::FIELD_TAG_ID] = true;

		return $new;
	}

	/**
	 * @param int $tagId
	 *
	 * @return static
	 */
	public function withTagIdOrFail(int $tagId) {
		$new = clone $this;
		$new->tagId = $tagId;
		$new->_touchedFields[static::FIELD_TAG_ID] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getTagId(): ?int {
		return $this->tagId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getTagIdOrFail(): int {
		if ($this->tagId === null) {
			throw new \RuntimeException('Value not set for field `tagId` (expected to be not null)');
		}

		return $this->tagId;
	}

	/**
	 * @return bool
	 */
	public function hasTagId(): bool {
		return $this->tagId !== null;
	}

	/**
	 * @param int|null $fkId
	 *
	 * @return static
	 */
	public function withFkId(?int $fkId = null) {
		$new = clone $this;
		$new->fkId = $fkId;
		$new->_touchedFields[static::FIELD_FK_ID] = true;

		return $new;
	}

	/**
	 * @param int $fkId
	 *
	 * @return static
	 */
	public function withFkIdOrFail(int $fkId) {
		$new = clone $this;
		$new->fkId = $fkId;
		$new->_touchedFields[static::FIELD_FK_ID] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getFkId(): ?int {
		return $this->fkId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getFkIdOrFail(): int {
		if ($this->fkId === null) {
			throw new \RuntimeException('Value not set for field `fkId` (expected to be not null)');
		}

		return $this->fkId;
	}

	/**
	 * @return bool
	 */
	public function hasFkId(): bool {
		return $this->fkId !== null;
	}

	/**
	 * @param string|null $fkModel
	 *
	 * @return static
	 */
	public function withFkModel(?string $fkModel = null) {
		$new = clone $this;
		$new->fkModel = $fkModel;
		$new->_touchedFields[static::FIELD_FK_MODEL] = true;

		return $new;
	}

	/**
	 * @param string $fkModel
	 *
	 * @return static
	 */
	public function withFkModelOrFail(string $fkModel) {
		$new = clone $this;
		$new->fkModel = $fkModel;
		$new->_touchedFields[static::FIELD_FK_MODEL] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getFkModel(): ?string {
		return $this->fkModel;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getFkModelOrFail(): string {
		if ($this->fkModel === null) {
			throw new \RuntimeException('Value not set for field `fkModel` (expected to be not null)');
		}

		return $this->fkModel;
	}

	/**
	 * @return bool
	 */
	public function hasFkModel(): bool {
		return $this->fkModel !== null;
	}

	/**
	 * @param \Cake\I18n\DateTime|null $created
	 *
	 * @return static
	 */
	public function withCreated(?\Cake\I18n\DateTime $created = null) {
		$new = clone $this;
		$new->created = $created;
		$new->_touchedFields[static::FIELD_CREATED] = true;

		return $new;
	}

	/**
	 * @param \Cake\I18n\DateTime $created
	 *
	 * @return static
	 */
	public function withCreatedOrFail(\Cake\I18n\DateTime $created) {
		$new = clone $this;
		$new->created = $created;
		$new->_touchedFields[static::FIELD_CREATED] = true;

		return $new;
	}

	/**
	 * @return \Cake\I18n\DateTime|null
	 */
	public function getCreated(): ?\Cake\I18n\DateTime {
		return $this->created;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \Cake\I18n\DateTime
	 */
	public function getCreatedOrFail(): \Cake\I18n\DateTime {
		if ($this->created === null) {
			throw new \RuntimeException('Value not set for field `created` (expected to be not null)');
		}

		return $this->created;
	}

	/**
	 * @return bool
	 */
	public function hasCreated(): bool {
		return $this->created !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null} $data
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
