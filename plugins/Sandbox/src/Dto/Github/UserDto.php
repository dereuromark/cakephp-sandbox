<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use CakeDto\Dto\AbstractDto;

/**
 * Github/User DTO
 *
 * @property string $login
 * @property string $htmlUrl
 * @property string $type
 */
class UserDto extends AbstractDto {

	/**
	 * @var string
	 */
	public const FIELD_LOGIN = 'login';
	/**
	 * @var string
	 */
	public const FIELD_HTML_URL = 'htmlUrl';
	/**
	 * @var string
	 */
	public const FIELD_TYPE = 'type';

	/**
	 * @var string
	 */
	protected $login;

	/**
	 * @var string
	 */
	protected $htmlUrl;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'login' => [
			'name' => 'login',
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
		'htmlUrl' => [
			'name' => 'htmlUrl',
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
		'type' => [
			'name' => 'type',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'login' => 'login',
			'html_url' => 'htmlUrl',
			'type' => 'type',
		],
		'dashed' => [
			'login' => 'login',
			'html-url' => 'htmlUrl',
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
		$this->_touchedFields[static::FIELD_LOGIN] = true;

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
	 * @param string $htmlUrl
	 *
	 * @return $this
	 */
	public function setHtmlUrl(string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[static::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHtmlUrl(): string {
		return $this->htmlUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHtmlUrl(): bool {
		return $this->htmlUrl !== null;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setType(string $type) {
		$this->type = $type;
		$this->_touchedFields[static::FIELD_TYPE] = true;

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
