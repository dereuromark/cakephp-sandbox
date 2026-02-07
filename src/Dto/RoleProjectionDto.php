<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * RoleProjection DTO
 *
 * @property int|null $id
 * @property string|null $name
 * @property array<int, \App\Dto\UserSimpleProjectionDto> $users
 */
class RoleProjectionDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_NAME = 'name';

	/**
	 * @var string
	 */
	public const FIELD_USERS = 'users';


	/**
	 * @var int|null
	 */
	protected ?int $id = null;

	/**
	 * @var string|null
	 */
	protected ?string $name = null;

	/**
	 * @var array<int, \App\Dto\UserSimpleProjectionDto>
	 */
	protected $users;

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
			'transformFrom' => null,
			'transformTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
		],
		'users' => [
			'name' => 'users',
			'type' => '\App\Dto\UserSimpleProjectionDto[]',
			'collectionType' => 'array',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
			'singularType' => '\App\Dto\UserSimpleProjectionDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\UserSimpleProjectionDto',
		],
	];

	/**
	 * @var array<string, array<string, string>>
	 */
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'name' => 'name',
			'users' => 'users',
		],
		'dashed' => [
			'id' => 'id',
			'name' => 'name',
			'users' => 'users',
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
		'name' => 'withName',
		'users' => 'withUsers',
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
			/** @var int|null $value */
			$value = $data['id'];
			$this->id = $value;
			$this->_touchedFields['id'] = true;
		}
		if (isset($data['name'])) {
			/** @var string|null $value */
			$value = $data['name'];
			$this->name = $value;
			$this->_touchedFields['name'] = true;
		}
		if (isset($data['users'])) {
			$collection = [];
			/** @var array $dataItems */
			$dataItems = $data['users'];
			foreach ($dataItems as $key => $item) {
				if (is_array($item)) {
					$item = new \App\Dto\UserSimpleProjectionDto($item, true);
				}
				$collection[$key] = $item;
			}
			$this->users = $collection;
			$this->_touchedFields['users'] = true;
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
			'name' => $this->name,
			'users' => (static function (?array $a): array {
				if (!$a) {
					return [];
				}
				$r = [];
				foreach ($a as $k => $v) {
					$r[$k] = $v->toArray();
				}
				return $r;
			})($this->users),
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
	 * @param string|null $name
	 *
	 * @return static
	 */
	public function withName(?string $name = null): static {
		$new = clone $this;
		$new->name = $name;
		$new->_touchedFields[static::FIELD_NAME] = true;

		return $new;
	}

	/**
	 * @param string $name
	 *
	 * @return static
	 */
	public function withNameOrFail(string $name): static {
		$new = clone $this;
		$new->name = $name;
		$new->_touchedFields[static::FIELD_NAME] = true;

		return $new;
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
	 * @param array<int, \App\Dto\UserSimpleProjectionDto> $users
	 *
	 * @return static
	 */
	public function withUsers(array $users): static {
		$new = clone $this;
		$new->users = $users;
		$new->_touchedFields[static::FIELD_USERS] = true;

		return $new;
	}

	/**
	 * @return array<int, \App\Dto\UserSimpleProjectionDto>
	 */
	public function getUsers(): array {
		if ($this->users === null) {
			return [];
		}

		return $this->users;
	}

	/**
	 * @return bool
	 */
	public function hasUsers(): bool {
		if ($this->users === null) {
			return false;
		}

		return count($this->users) > 0;
	}
	/**
	 * @param \App\Dto\UserSimpleProjectionDto $user
	 * @return static
	 */
	public function withAddedUser(\App\Dto\UserSimpleProjectionDto $user): static {
		$new = clone $this;

		if ($new->users === null) {
			$new->users = [];
		}

		$new->users[] = $user;
		$new->_touchedFields[static::FIELD_USERS] = true;

		return $new;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, name: string|null, users: array<int, array{id: int|null, username: string|null, email: string|null}>}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, name: string|null, users: array<int, array{id: int|null, username: string|null, email: string|null}>} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, name: string|null, users: array<int, array{id: int|null, username: string|null, email: string|null}>} $data
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
