<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/Repo DTO
 */
class RepoDto extends \CakeDto\Dto\AbstractDto {

	const FIELD_NAME = 'name';
	const FIELD_HTML_URL = 'html_url';
	const FIELD_PRIVATE = 'private';
	const FIELD_OWNER = 'owner';

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $html_url;

	/**
	 * @var bool
	 */
	protected $private;

	/**
	 * @var \Sandbox\Dto\Github\UserDto
	 */
	protected $owner;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array
	 */
	protected $_metadata = [
		'name' => [
			'name' => 'name',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'html_url' => [
			'name' => 'html_url',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'private' => [
			'name' => 'private',
			'type' => 'bool',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'owner' => [
			'name' => 'owner',
			'type' => '\Sandbox\Dto\Github\UserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Github/User',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
	];

	/**
	* @var array
	*/
	protected $_keyMap = [
		'underscored' => [
			'name' => 'name',
			'html_url' => 'html_url',
			'private' => 'private',
			'owner' => 'owner',
		],
		'dashed' => [
			'name' => 'name',
			'html-url' => 'html_url',
			'private' => 'private',
			'owner' => 'owner',
		],
	];

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName() {
		return $this->name !== null;
	}

	/**
	 * @param string $html_url
	 *
	 * @return $this
	 */
	public function setHtml_url(string $html_url) {
		$this->html_url = $html_url;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHtml_url(): string {
		return $this->html_url;
	}

	/**
	 * @return bool
	 */
	public function hasHtml_url() {
		return $this->html_url !== null;
	}

	/**
	 * @param bool $private
	 *
	 * @return $this
	 */
	public function setPrivate(bool $private) {
		$this->private = $private;
		$this->_touchedFields[self::FIELD_PRIVATE] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPrivate(): bool {
		return $this->private;
	}

	/**
	 * @return bool
	 */
	public function hasPrivate() {
		return $this->private !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\UserDto $owner
	 *
	 * @return $this
	 */
	public function setOwner(\Sandbox\Dto\Github\UserDto $owner) {
		$this->owner = $owner;
		$this->_touchedFields[self::FIELD_OWNER] = true;

		return $this;
	}

	/**
	 * @return \Sandbox\Dto\Github\UserDto
	 */
	public function getOwner(): \Sandbox\Dto\Github\UserDto {
		return $this->owner;
	}

	/**
	 * @return bool
	 */
	public function hasOwner() {
		return $this->owner !== null;
	}

}
