<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use PhpCollective\Dto\Dto\AbstractDto;

/**
 * Github/Repo DTO
 *
 * @property string $name
 * @property string $htmlUrl
 * @property bool $private
 * @property \Sandbox\Dto\Github\UserDto $owner
 */
class RepoDto extends AbstractDto {

	/**
	 * @var string
	 */
	public const FIELD_NAME = 'name';
	/**
	 * @var string
	 */
	public const FIELD_HTML_URL = 'htmlUrl';
	/**
	 * @var string
	 */
	public const FIELD_PRIVATE = 'private';
	/**
	 * @var string
	 */
	public const FIELD_OWNER = 'owner';

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $htmlUrl;

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
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'name' => [
			'name' => 'name',
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
		'private' => [
			'name' => 'private',
			'type' => 'bool',
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
		'owner' => [
			'name' => 'owner',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'name' => 'name',
			'html_url' => 'htmlUrl',
			'private' => 'private',
			'owner' => 'owner',
		],
		'dashed' => [
			'name' => 'name',
			'html-url' => 'htmlUrl',
			'private' => 'private',
			'owner' => 'owner',
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
		'name' => 'setName',
		'htmlUrl' => 'setHtmlurl',
		'private' => 'setPrivate',
		'owner' => 'setOwner',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['name'])) {
			$this->name = $data['name'];
			$this->_touchedFields['name'] = true;
		}
		if (isset($data['htmlUrl'])) {
			$this->htmlUrl = $data['htmlUrl'];
			$this->_touchedFields['htmlUrl'] = true;
		}
		if (isset($data['private'])) {
			$this->private = $data['private'];
			$this->_touchedFields['private'] = true;
		}
		if (isset($data['owner'])) {
			$value = $data['owner'];
			if (is_array($value)) {
				$value = new \Sandbox\Dto\Github\UserDto($value);
			}
			$this->owner = $value;
			$this->_touchedFields['owner'] = true;
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
		if ($this->name === null || $this->htmlUrl === null || $this->private === null || $this->owner === null) {
			$errors = [];
			if ($this->name === null) {
				$errors[] = 'name';
			}
			if ($this->htmlUrl === null) {
				$errors[] = 'htmlUrl';
			}
			if ($this->private === null) {
				$errors[] = 'private';
			}
			if ($this->owner === null) {
				$errors[] = 'owner';
			}
			if ($errors) {
				throw new \InvalidArgumentException('Required fields missing: ' . implode(', ', $errors));
			}
		}
	}


	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(string $name) {
		$this->name = $name;
		$this->_touchedFields[static::FIELD_NAME] = true;

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
	public function hasName(): bool {
		return $this->name !== null;
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
	 * @param bool $private
	 *
	 * @return $this
	 */
	public function setPrivate(bool $private) {
		$this->private = $private;
		$this->_touchedFields[static::FIELD_PRIVATE] = true;

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
	public function hasPrivate(): bool {
		return $this->private !== null;
	}

	/**
	 * @param \Sandbox\Dto\Github\UserDto $owner
	 *
	 * @return $this
	 */
	public function setOwner(\Sandbox\Dto\Github\UserDto $owner) {
		$this->owner = $owner;
		$this->_touchedFields[static::FIELD_OWNER] = true;

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
	public function hasOwner(): bool {
		return $this->owner !== null;
	}


	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{name: string, htmlUrl: string, private: bool, owner: array<string, mixed>}
	 */
	#[\Override]
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @phpstan-ignore return.type (parent returns array, we provide shape for IDE) */
		return parent::toArray($type, $fields, $touched);
	}

	/**
	 * @param array{name: string, htmlUrl: string, private: bool, owner: array<string, mixed>} $data
	 * @param bool $ignoreMissing
	 * @param string|null $type
	 *
	 * @return static
	 */
	#[\Override] // @phpstan-ignore method.childParameterType
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return parent::createFromArray($data, $ignoreMissing, $type);
	}

}
