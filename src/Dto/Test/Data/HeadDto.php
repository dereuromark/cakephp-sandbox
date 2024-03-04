<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/Head DTO
 *
 * @property string|null $label
 * @property string|null $ref
 * @property string|null $sha
 * @property \App\Dto\Test\Data\UserDto|null $user
 * @property \App\Dto\Test\Data\RepoDto|null $repo
 */
class HeadDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_LABEL = 'label';
	public const FIELD_REF = 'ref';
	public const FIELD_SHA = 'sha';
	public const FIELD_USER = 'user';
	public const FIELD_REPO = 'repo';

	/**
	 * @var string|null
	 */
	protected $label;

	/**
	 * @var string|null
	 */
	protected $ref;

	/**
	 * @var string|null
	 */
	protected $sha;

	/**
	 * @var \App\Dto\Test\Data\UserDto|null
	 */
	protected $user;

	/**
	 * @var \App\Dto\Test\Data\RepoDto|null
	 */
	protected $repo;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
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
		],
		'ref' => [
			'name' => 'ref',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'sha' => [
			'name' => 'sha',
			'type' => 'string',
			'required' => false,
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
			'type' => '\App\Dto\Test\Data\UserDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/User',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'repo' => [
			'name' => 'repo',
			'type' => '\App\Dto\Test\Data\RepoDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Repo',
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
			'label' => 'label',
			'ref' => 'ref',
			'sha' => 'sha',
			'user' => 'user',
			'repo' => 'repo',
		],
		'dashed' => [
			'label' => 'label',
			'ref' => 'ref',
			'sha' => 'sha',
			'user' => 'user',
			'repo' => 'repo',
		],
	];

	/**
	 * @param string|null $label
	 *
	 * @return $this
	 */
	public function setLabel(?string $label) {
		$this->label = $label;
		$this->_touchedFields[self::FIELD_LABEL] = true;

		return $this;
	}

	/**
	 * @param string $label
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLabelOrFail(string $label) {
		$this->label = $label;
		$this->_touchedFields[self::FIELD_LABEL] = true;

		return $this;
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
	 * @param string|null $ref
	 *
	 * @return $this
	 */
	public function setRef(?string $ref) {
		$this->ref = $ref;
		$this->_touchedFields[self::FIELD_REF] = true;

		return $this;
	}

	/**
	 * @param string $ref
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setRefOrFail(string $ref) {
		$this->ref = $ref;
		$this->_touchedFields[self::FIELD_REF] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getRef(): ?string {
		return $this->ref;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getRefOrFail(): string {
		if ($this->ref === null) {
			throw new \RuntimeException('Value not set for field `ref` (expected to be not null)');
		}

		return $this->ref;
	}

	/**
	 * @return bool
	 */
	public function hasRef(): bool {
		return $this->ref !== null;
	}

	/**
	 * @param string|null $sha
	 *
	 * @return $this
	 */
	public function setSha(?string $sha) {
		$this->sha = $sha;
		$this->_touchedFields[self::FIELD_SHA] = true;

		return $this;
	}

	/**
	 * @param string $sha
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setShaOrFail(string $sha) {
		$this->sha = $sha;
		$this->_touchedFields[self::FIELD_SHA] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSha(): ?string {
		return $this->sha;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getShaOrFail(): string {
		if ($this->sha === null) {
			throw new \RuntimeException('Value not set for field `sha` (expected to be not null)');
		}

		return $this->sha;
	}

	/**
	 * @return bool
	 */
	public function hasSha(): bool {
		return $this->sha !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\UserDto|null $user
	 *
	 * @return $this
	 */
	public function setUser(?\App\Dto\Test\Data\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\UserDto $user
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUserOrFail(\App\Dto\Test\Data\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\UserDto|null
	 */
	public function getUser(): ?\App\Dto\Test\Data\UserDto {
		return $this->user;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\UserDto
	 */
	public function getUserOrFail(): \App\Dto\Test\Data\UserDto {
		if ($this->user === null) {
			throw new \RuntimeException('Value not set for field `user` (expected to be not null)');
		}

		return $this->user;
	}

	/**
	 * @return bool
	 */
	public function hasUser(): bool {
		return $this->user !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\RepoDto|null $repo
	 *
	 * @return $this
	 */
	public function setRepo(?\App\Dto\Test\Data\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[self::FIELD_REPO] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\RepoDto $repo
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setRepoOrFail(\App\Dto\Test\Data\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[self::FIELD_REPO] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\RepoDto|null
	 */
	public function getRepo(): ?\App\Dto\Test\Data\RepoDto {
		return $this->repo;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\RepoDto
	 */
	public function getRepoOrFail(): \App\Dto\Test\Data\RepoDto {
		if ($this->repo === null) {
			throw new \RuntimeException('Value not set for field `repo` (expected to be not null)');
		}

		return $this->repo;
	}

	/**
	 * @return bool
	 */
	public function hasRepo(): bool {
		return $this->repo !== null;
	}

}
