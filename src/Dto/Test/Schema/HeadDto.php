<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/Head DTO
 *
 * @property string $label
 * @property string $ref
 * @property \App\Dto\Test\Schema\RepoDto|null $repo
 * @property string $sha
 * @property \App\Dto\Test\Schema\UserDto $user
 */
class HeadDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_LABEL = 'label';
	public const FIELD_REF = 'ref';
	public const FIELD_REPO = 'repo';
	public const FIELD_SHA = 'sha';
	public const FIELD_USER = 'user';

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $ref;

	/**
	 * @var \App\Dto\Test\Schema\RepoDto|null
	 */
	protected $repo;

	/**
	 * @var string
	 */
	protected $sha;

	/**
	 * @var \App\Dto\Test\Schema\UserDto
	 */
	protected $user;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'label' => [
			'name' => 'label',
			'type' => 'string',
			'required' => true,
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
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'repo' => [
			'name' => 'repo',
			'type' => '\App\Dto\Test\Schema\RepoDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Repo',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
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
		],
		'user' => [
			'name' => 'user',
			'type' => '\App\Dto\Test\Schema\UserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Test/Schema/User',
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
			'repo' => 'repo',
			'sha' => 'sha',
			'user' => 'user',
		],
		'dashed' => [
			'label' => 'label',
			'ref' => 'ref',
			'repo' => 'repo',
			'sha' => 'sha',
			'user' => 'user',
		],
	];

	/**
	 * @param string $label
	 *
	 * @return $this
	 */
	public function setLabel(string $label) {
		$this->label = $label;
		$this->_touchedFields[self::FIELD_LABEL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLabel(): string {
		return $this->label;
	}

	/**
	 * @return bool
	 */
	public function hasLabel(): bool {
		return $this->label !== null;
	}

	/**
	 * @param string $ref
	 *
	 * @return $this
	 */
	public function setRef(string $ref) {
		$this->ref = $ref;
		$this->_touchedFields[self::FIELD_REF] = true;

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
	 * @param \App\Dto\Test\Schema\RepoDto|null $repo
	 *
	 * @return $this
	 */
	public function setRepo(?\App\Dto\Test\Schema\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[self::FIELD_REPO] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\RepoDto $repo
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setRepoOrFail(\App\Dto\Test\Schema\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[self::FIELD_REPO] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\RepoDto|null
	 */
	public function getRepo(): ?\App\Dto\Test\Schema\RepoDto {
		return $this->repo;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\RepoDto
	 */
	public function getRepoOrFail(): \App\Dto\Test\Schema\RepoDto {
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

	/**
	 * @param string $sha
	 *
	 * @return $this
	 */
	public function setSha(string $sha) {
		$this->sha = $sha;
		$this->_touchedFields[self::FIELD_SHA] = true;

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
	 * @param \App\Dto\Test\Schema\UserDto $user
	 *
	 * @return $this
	 */
	public function setUser(\App\Dto\Test\Schema\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\UserDto
	 */
	public function getUser(): \App\Dto\Test\Schema\UserDto {
		return $this->user;
	}

	/**
	 * @return bool
	 */
	public function hasUser(): bool {
		return $this->user !== null;
	}

}
