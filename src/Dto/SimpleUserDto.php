<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * SimpleUser DTO
 *
 * @property int|null $id
 * @property string|null $username
 * @property string|null $email
 * @property \App\Dto\SimpleRoleBasicDto|null $role
 * @property \Cake\I18n\DateTime|null $created
 */
class SimpleUserDto extends AbstractImmutableDto {

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
	public const FIELD_ROLE = 'role';

	/**
	 * @var string
	 */
	public const FIELD_CREATED = 'created';


	/**
	 * @var int|null
	 */
	protected ?int $id = null;

	/**
	 * @var string|null
	 */
	protected ?string $username = null;

	/**
	 * @var string|null
	 */
	protected ?string $email = null;

	/**
	 * @var \App\Dto\SimpleRoleBasicDto|null
	 */
	protected ?\App\Dto\SimpleRoleBasicDto $role = null;

	/**
	 * @var \Cake\I18n\DateTime|null
	 */
	protected ?\Cake\I18n\DateTime $created = null;

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
		'role' => [
			'name' => 'role',
			'type' => '\App\Dto\SimpleRoleBasicDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'SimpleRoleBasic',
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
			'username' => 'username',
			'email' => 'email',
			'role' => 'role',
			'created' => 'created',
		],
		'dashed' => [
			'id' => 'id',
			'username' => 'username',
			'email' => 'email',
			'role' => 'role',
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
		'username' => 'withUsername',
		'email' => 'withEmail',
		'role' => 'withRole',
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
		if (isset($data['username'])) {
			$this->username = $data['username'];
			$this->_touchedFields['username'] = true;
		}
		if (isset($data['email'])) {
			$this->email = $data['email'];
			$this->_touchedFields['email'] = true;
		}
		if (isset($data['role'])) {
			$value = $data['role'];
			if (is_array($value)) {
				$value = new \App\Dto\SimpleRoleBasicDto($value, true);
			}
			$this->role = $value;
			$this->_touchedFields['role'] = true;
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
			'username' => $this->username,
			'email' => $this->email,
			'role' => $this->role !== null ? $this->role->toArray() : null,
			'created' => $this->created,
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
	 * @param string|null $username
	 *
	 * @return static
	 */
	public function withUsername(?string $username = null): static {
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
	public function withUsernameOrFail(string $username): static {
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
	public function withEmail(?string $email = null): static {
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
	public function withEmailOrFail(string $email): static {
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
	 * @param \App\Dto\SimpleRoleBasicDto|null $role
	 *
	 * @return static
	 */
	public function withRole(?\App\Dto\SimpleRoleBasicDto $role = null): static {
		$new = clone $this;
		$new->role = $role;
		$new->_touchedFields[static::FIELD_ROLE] = true;

		return $new;
	}

	/**
	 * @param \App\Dto\SimpleRoleBasicDto $role
	 *
	 * @return static
	 */
	public function withRoleOrFail(\App\Dto\SimpleRoleBasicDto $role): static {
		$new = clone $this;
		$new->role = $role;
		$new->_touchedFields[static::FIELD_ROLE] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\SimpleRoleBasicDto|null
	 */
	public function getRole(): ?\App\Dto\SimpleRoleBasicDto {
		return $this->role;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\SimpleRoleBasicDto
	 */
	public function getRoleOrFail(): \App\Dto\SimpleRoleBasicDto {
		if ($this->role === null) {
			throw new \RuntimeException('Value not set for field `role` (expected to be not null)');
		}

		return $this->role;
	}

	/**
	 * @return bool
	 */
	public function hasRole(): bool {
		return $this->role !== null;
	}

	/**
	 * @param \Cake\I18n\DateTime|null $created
	 *
	 * @return static
	 */
	public function withCreated(?\Cake\I18n\DateTime $created = null): static {
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
	public function withCreatedOrFail(\Cake\I18n\DateTime $created): static {
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
	 * @return array{id: int|null, username: string|null, email: string|null, role: array{id: int|null, name: string|null}|null, created: \Cake\I18n\DateTime|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, username: string|null, email: string|null, role: array{id: int|null, name: string|null}|null, created: \Cake\I18n\DateTime|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, username: string|null, email: string|null, role: array{id: int|null, name: string|null}|null, created: \Cake\I18n\DateTime|null} $data
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
