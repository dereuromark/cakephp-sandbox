<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;
use RuntimeException;

/**
 * SimpleUserBasic DTO
 *
 * @property int|null $id
 * @property string|null $username
 * @property string|null $email
 */
class SimpleUserBasicDto extends AbstractImmutableDto {

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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'username' => 'username',
			'email' => 'email',
		],
		'dashed' => [
			'id' => 'id',
			'username' => 'username',
			'email' => 'email',
		],
	];

	/**
	 * Whether this DTO is immutable.
     * @var bool
	 */
	protected const IS_IMMUTABLE = true;

	/**
	 * Pre-computed setter method names for fast lookup.
	 *
	 * @var array<string, string>
	 */
	protected static array $_setters = [
		'id' => 'withId',
		'username' => 'withUsername',
		'email' => 'withEmail',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * This method is only called in lenient mode (ignoreMissing=true),
	 * where unknown fields are silently ignored.
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
			throw new RuntimeException('Value not set for field `id` (expected to be not null)');
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
			throw new RuntimeException('Value not set for field `username` (expected to be not null)');
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
			throw new RuntimeException('Value not set for field `email` (expected to be not null)');
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
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, username: string|null, email: string|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, username: string|null, email: string|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
     * @phpstan-param array<string, mixed> $data
     * @param array{id: (int | null), username: (string | null), email: (string | null)}|array $data
     * @param bool $ignoreMissing
     * @param string|null $type
     *
     * @return static
	 */
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return static::_createFromArrayInternal($data, $ignoreMissing, $type);
	}

}
