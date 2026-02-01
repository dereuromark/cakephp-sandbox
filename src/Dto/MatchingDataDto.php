<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * MatchingData DTO
 *
 * @property \App\Dto\SimpleRoleBasicDto|null $Roles
 */
class MatchingDataDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ROLES = 'Roles';


	/**
	 * @var \App\Dto\SimpleRoleBasicDto|null
	 */
	protected ?\App\Dto\SimpleRoleBasicDto $Roles = null;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'Roles' => [
			'name' => 'Roles',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'roles' => 'Roles',
		],
		'dashed' => [
			'roles' => 'Roles',
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
		'Roles' => 'withRoles',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['Roles'])) {
			$value = $data['Roles'];
			if (is_array($value)) {
				$value = new \App\Dto\SimpleRoleBasicDto($value, true);
			}
			$this->Roles = $value;
			$this->_touchedFields['Roles'] = true;
		}
	}

	/**
	 * Optimized toArray for default type without dynamic dispatch.
	 *
	 * @return array<string, mixed>
	 */
	protected function toArrayFast(): array {
		return [
			'Roles' => $this->Roles !== null ? $this->Roles->toArray() : null,
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
	 * @param \App\Dto\SimpleRoleBasicDto|null $Roles
	 *
	 * @return static
	 */
	public function withRoles(?\App\Dto\SimpleRoleBasicDto $Roles = null): static {
		$new = clone $this;
		$new->Roles = $Roles;
		$new->_touchedFields[static::FIELD_ROLES] = true;

		return $new;
	}

	/**
	 * @param \App\Dto\SimpleRoleBasicDto $Roles
	 *
	 * @return static
	 */
	public function withRolesOrFail(\App\Dto\SimpleRoleBasicDto $Roles): static {
		$new = clone $this;
		$new->Roles = $Roles;
		$new->_touchedFields[static::FIELD_ROLES] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\SimpleRoleBasicDto|null
	 */
	public function getRoles(): ?\App\Dto\SimpleRoleBasicDto {
		return $this->Roles;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\SimpleRoleBasicDto
	 */
	public function getRolesOrFail(): \App\Dto\SimpleRoleBasicDto {
		if ($this->Roles === null) {
			throw new \RuntimeException('Value not set for field `Roles` (expected to be not null)');
		}

		return $this->Roles;
	}

	/**
	 * @return bool
	 */
	public function hasRoles(): bool {
		return $this->Roles !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{Roles: array{id: int|null, name: string|null}|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{Roles: array{id: int|null, name: string|null}|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{Roles: array{id: int|null, name: string|null}|null} $data
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
