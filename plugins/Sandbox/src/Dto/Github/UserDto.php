<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use PhpCollective\Dto\Dto\AbstractDto;

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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'mapFrom' => null,
			'mapTo' => null,
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
	 * Whether this DTO is immutable.
	 */
	protected const IS_IMMUTABLE = false;

	/**
	 * Pre-computed setter method names for fast lookup.
	 *
	 * @var array<string, string>
	 */
	protected static array $_setters = [
		'login' => 'setLogin',
		'htmlUrl' => 'setHtmlurl',
		'type' => 'setType',
	];


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
		if ($this->login === null || $this->htmlUrl === null || $this->type === null) {
			$errors = [];
			if ($this->login === null) {
				$errors[] = 'login';
			}
			if ($this->htmlUrl === null) {
				$errors[] = 'htmlUrl';
			}
			if ($this->type === null) {
				$errors[] = 'type';
			}
			if ($errors) {
				throw new \InvalidArgumentException('Required fields missing: ' . implode(', ', $errors));
			}
		}
	}


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

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{login: string, htmlUrl: string, type: string}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{login: string, htmlUrl: string, type: string} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{login: string, htmlUrl: string, type: string} $data
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
