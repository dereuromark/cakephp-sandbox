<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/User DTO
 *
 * @property string $login
 * @property string $html_url
 * @property string $type
 */
class UserDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_LOGIN = 'login';
	public const FIELD_HTML_URL = 'html_url';
	public const FIELD_TYPE = 'type';

	/**
	 * @var string
	 */
	protected $login;

	/**
	 * @var string
	 */
	protected $html_url;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array
	 */
	protected $_metadata = [
		'login' => [
			'name' => 'login',
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
		'type' => [
			'name' => 'type',
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
	];

	/**
	* @var array
	*/
	protected $_keyMap = [
		'underscored' => [
			'login' => 'login',
			'html_url' => 'html_url',
			'type' => 'type',
		],
		'dashed' => [
			'login' => 'login',
			'html-url' => 'html_url',
			'type' => 'type',
		],
	];

	/**
	 * @param string $login
	 *
	 * @return $this
	 */
	public function setLogin(string $login) {
		$this->login = $login;
		$this->_touchedFields[self::FIELD_LOGIN] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogin(): string {
		return $this->login;
	}

	/**
	 * @return bool
	 */
	public function hasLogin(): bool {
		return $this->login !== null;
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
	public function hasHtml_url(): bool {
		return $this->html_url !== null;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setType(string $type) {
		$this->type = $type;
		$this->_touchedFields[self::FIELD_TYPE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function hasType(): bool {
		return $this->type !== null;
	}

}
