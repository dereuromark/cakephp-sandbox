<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use PhpCollective\Dto\Dto\AbstractDto;

/**
 * Github/Base DTO
 *
 * @property string $ref
 * @property string $sha
 * @property \Sandbox\Dto\Github\UserDto $user
 * @property \Sandbox\Dto\Github\RepoDto $repo
 */
class BaseDto extends AbstractDto {

	/**
	 * @var string
	 */
	public const FIELD_REF = 'ref';

	/**
	 * @var string
	 */
	public const FIELD_SHA = 'sha';

	/**
	 * @var string
	 */
	public const FIELD_USER = 'user';

	/**
	 * @var string
	 */
	public const FIELD_REPO = 'repo';


	/**
	 * @var string
	 */
	protected $ref;

	/**
	 * @var string
	 */
	protected $sha;

	/**
	 * @var \Sandbox\Dto\Github\UserDto
	 */
	protected $user;

	/**
	 * @var \Sandbox\Dto\Github\RepoDto
	 */
	protected $repo;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'ref' => [
			'name' => 'ref',
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
		'sha' => [
			'name' => 'sha',
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
		'repo' => [
			'name' => 'repo',
			'type' => '\Sandbox\Dto\Github\RepoDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/Repo',
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
			'ref' => 'ref',
			'sha' => 'sha',
			'user' => 'user',
			'repo' => 'repo',
		],
		'dashed' => [
			'ref' => 'ref',
			'sha' => 'sha',
			'user' => 'user',
			'repo' => 'repo',
		],
	];

	/**
	 * Whether this DTO is immutable.
	 *
	 * @var bool
	 */
	protected const IS_IMMUTABLE = false;

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
		'ref' => 'setRef',
		'sha' => 'setSha',
		'user' => 'setUser',
		'repo' => 'setRepo',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['ref'])) {
			$this->ref = $data['ref'];
			$this->_touchedFields['ref'] = true;
		}
		if (isset($data['sha'])) {
			$this->sha = $data['sha'];
			$this->_touchedFields['sha'] = true;
		}
		if (isset($data['user'])) {
			$value = $data['user'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\UserDto($value, true);
			}
			$this->user = $value;
			$this->_touchedFields['user'] = true;
		}
		if (isset($data['repo'])) {
			$value = $data['repo'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\RepoDto($value, true);
			}
			$this->repo = $value;
			$this->_touchedFields['repo'] = true;
		}
	}

	/**
	 * Optimized toArray for default type without dynamic dispatch.
	 *
	 * @return array<string, mixed>
	 */
	protected function toArrayFast(): array {
		return [
			'ref' => $this->ref,
			'sha' => $this->sha,
			'user' => $this->user !== null ? $this->user->toArray() : null,
			'repo' => $this->repo !== null ? $this->repo->toArray() : null,
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
		if ($this->ref === null || $this->sha === null || $this->user === null || $this->repo === null) {
			$errors = [];
			if ($this->ref === null) {
				$errors[] = 'ref';
			}
			if ($this->sha === null) {
				$errors[] = 'sha';
			}
			if ($this->user === null) {
				$errors[] = 'user';
			}
			if ($this->repo === null) {
				$errors[] = 'repo';
			}
			if ($errors) {
				throw new \InvalidArgumentException('Required fields missing: ' . implode(', ', $errors));
			}
		}
	}


	/**
	 * @param string $ref
	 *
	 * @return $this
	 */
	public function setRef(string $ref) {
		$this->ref = $ref;
		$this->_touchedFields[static::FIELD_REF] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRef(): string {
		return $this->ref;
	}

	/**
	 * @return bool
	 */
	public function hasRef(): bool {
		return $this->ref !== null;
	}

	/**
	 * @param string $sha
	 *
	 * @return $this
	 */
	public function setSha(string $sha) {
		$this->sha = $sha;
		$this->_touchedFields[static::FIELD_SHA] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSha(): string {
		return $this->sha;
	}

	/**
	 * @return bool
	 */
	public function hasSha(): bool {
		return $this->sha !== null;
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
	 * @param \Sandbox\Dto\Github\RepoDto $repo
	 *
	 * @return $this
	 */
	public function setRepo(\Sandbox\Dto\Github\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[static::FIELD_REPO] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\RepoDto
	 */
	public function getRepo(): \Sandbox\Dto\Github\RepoDto {
		return $this->repo;
	}

	/**
	 * @return bool
	 */
	public function hasRepo(): bool {
		return $this->repo !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{ref: string, sha: string, user: array<string, mixed>, repo: array<string, mixed>}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{ref: string, sha: string, user: array<string, mixed>, repo: array<string, mixed>} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{ref: string, sha: string, user: array<string, mixed>, repo: array<string, mixed>} $data
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
