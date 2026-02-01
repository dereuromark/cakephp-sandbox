<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * UserWithMatchingTyped DTO
 *
 * @property int|null $id
 * @property string|null $username
 * @property string|null $email
 * @property \Cake\I18n\DateTime|null $created
 * @property \App\Dto\MatchingDataDto|null $_matchingData
 */
class UserWithMatchingTypedDto extends AbstractImmutableDto {

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
	public const FIELD_CREATED = 'created';

	/**
	 * @var string
	 */
	public const FIELD_MATCHING_DATA = '_matchingData';


	/**
	 * @var int|null
	 */
	protected $id;

	/**
	 * @var string|null
	 */
	protected $username;

	/**
	 * @var string|null
	 */
	protected $email;

	/**
	 * @var \Cake\I18n\DateTime|null
	 */
	protected $created;

	/**
	 * @var \App\Dto\MatchingDataDto|null
	 */
	protected $_matchingData;

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
		'username' => [
			'name' => 'username',
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
		'email' => [
			'name' => 'email',
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
		'_matchingData' => [
			'name' => '_matchingData',
			'type' => '\App\Dto\MatchingDataDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'MatchingData',
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
			'username' => 'username',
			'email' => 'email',
			'created' => 'created',
			'_matching_data' => '_matchingData',
		],
		'dashed' => [
			'id' => 'id',
			'username' => 'username',
			'email' => 'email',
			'created' => 'created',
			'-matching-data' => '_matchingData',
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
		'username' => 'withUsername',
		'email' => 'withEmail',
		'created' => 'withCreated',
		'_matchingData' => 'withMatchingData',
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
		if (isset($data['username'])) {
			$this->username = $data['username'];
			$this->_touchedFields['username'] = true;
		}
		if (isset($data['email'])) {
			$this->email = $data['email'];
			$this->_touchedFields['email'] = true;
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
		if (isset($data['_matchingData'])) {
			$value = $data['_matchingData'];
			if (is_array($value)) {
				$value = new \App\Dto\MatchingDataDto($value, true);
			}
			$this->_matchingData = $value;
			$this->_touchedFields['_matchingData'] = true;
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
			'username' => $this->username,
			'email' => $this->email,
			'created' => $this->created,
			'_matchingData' => $this->_matchingData !== null ? $this->_matchingData->toArray() : null,
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
	 * @param string|null $username
	 *
	 * @return static
	 */
	public function withUsername(?string $username = null) {
		$new = clone $this;
		$new->username = $username;
		$new->_touchedFields[static::FIELD_USERNAME] = true;

		return $new;
	}

	/**
	 * @param string $username
	 *
	 * @return static
	 */
	public function withUsernameOrFail(string $username) {
		$new = clone $this;
		$new->username = $username;
		$new->_touchedFields[static::FIELD_USERNAME] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getUsername(): ?string {
		return $this->username;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getUsernameOrFail(): string {
		if ($this->username === null) {
			throw new \RuntimeException('Value not set for field `username` (expected to be not null)');
		}

		return $this->username;
	}

	/**
	 * @return bool
	 */
	public function hasUsername(): bool {
		return $this->username !== null;
	}

	/**
	 * @param string|null $email
	 *
	 * @return static
	 */
	public function withEmail(?string $email = null) {
		$new = clone $this;
		$new->email = $email;
		$new->_touchedFields[static::FIELD_EMAIL] = true;

		return $new;
	}

	/**
	 * @param string $email
	 *
	 * @return static
	 */
	public function withEmailOrFail(string $email) {
		$new = clone $this;
		$new->email = $email;
		$new->_touchedFields[static::FIELD_EMAIL] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getEmail(): ?string {
		return $this->email;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getEmailOrFail(): string {
		if ($this->email === null) {
			throw new \RuntimeException('Value not set for field `email` (expected to be not null)');
		}

		return $this->email;
	}

	/**
	 * @return bool
	 */
	public function hasEmail(): bool {
		return $this->email !== null;
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
	 * @param \App\Dto\MatchingDataDto|null $_matchingData
	 *
	 * @return static
	 */
	public function withMatchingData(?\App\Dto\MatchingDataDto $_matchingData = null) {
		$new = clone $this;
		$new->_matchingData = $_matchingData;
		$new->_touchedFields[static::FIELD_MATCHING_DATA] = true;

		return $new;
	}

	/**
	 * @param \App\Dto\MatchingDataDto $_matchingData
	 *
	 * @return static
	 */
	public function withMatchingDataOrFail(\App\Dto\MatchingDataDto $_matchingData) {
		$new = clone $this;
		$new->_matchingData = $_matchingData;
		$new->_touchedFields[static::FIELD_MATCHING_DATA] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\MatchingDataDto|null
	 */
	public function getMatchingData(): ?\App\Dto\MatchingDataDto {
		return $this->_matchingData;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\MatchingDataDto
	 */
	public function getMatchingDataOrFail(): \App\Dto\MatchingDataDto {
		if ($this->_matchingData === null) {
			throw new \RuntimeException('Value not set for field `_matchingData` (expected to be not null)');
		}

		return $this->_matchingData;
	}

	/**
	 * @return bool
	 */
	public function hasMatchingData(): bool {
		return $this->_matchingData !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, username: string|null, email: string|null, created: \Cake\I18n\DateTime|null, _matchingData: array{Roles: array{id: int|null, name: string|null}|null}|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, username: string|null, email: string|null, created: \Cake\I18n\DateTime|null, _matchingData: array{Roles: array{id: int|null, name: string|null}|null}|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, username: string|null, email: string|null, created: \Cake\I18n\DateTime|null, _matchingData: array{Roles: array{id: int|null, name: string|null}|null}|null} $data
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
