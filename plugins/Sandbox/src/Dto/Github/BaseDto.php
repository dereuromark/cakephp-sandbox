<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/Base DTO
 */
class BaseDto extends \CakeDto\Dto\AbstractDto {

	const FIELD_REF = 'ref';
	const FIELD_SHA = 'sha';
	const FIELD_USER = 'user';
	const FIELD_REPO = 'repo';

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
	 * @var array
	 */
	protected $_metadata = [
		'ref' => [
			'name' => 'ref',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'sha' => [
			'name' => 'sha',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'user' => [
			'name' => 'user',
			'type' => '\Sandbox\Dto\Github\UserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/User',
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
		'repo' => [
			'name' => 'repo',
			'type' => '\Sandbox\Dto\Github\RepoDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/Repo',
			'collectionType' => null,
			'associative' => false,
			'serializable' => false,
			'toArray' => false,
		],
	];

	/**
	* @var array
	*/
	protected $_keyMap = [
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
	public function hasRef() {
		return $this->ref !== null;
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
	public function hasSha() {
		return $this->sha !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\UserDto $user
	 *
	 * @return $this
	 */
	public function setUser(\Sandbox\Dto\Github\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

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
	public function hasUser() {
		return $this->user !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\RepoDto $repo
	 *
	 * @return $this
	 */
	public function setRepo(\Sandbox\Dto\Github\RepoDto $repo) {
		$this->repo = $repo;
		$this->_touchedFields[self::FIELD_REPO] = true;

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
	public function hasRepo() {
		return $this->repo !== null;
	}

}
