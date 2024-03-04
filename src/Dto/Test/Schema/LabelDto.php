<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/Label DTO
 *
 * @property int $id
 * @property string $nodeId
 * @property string $url
 * @property string $name
 * @property string|null $description
 * @property string $color
 * @property bool $default
 */
class LabelDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_URL = 'url';
	public const FIELD_NAME = 'name';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_COLOR = 'color';
	public const FIELD_DEFAULT = 'default';

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $color;

	/**
	 * @var bool
	 */
	protected $default;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'id' => [
			'name' => 'id',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'nodeId' => [
			'name' => 'nodeId',
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
		'url' => [
			'name' => 'url',
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
		],
		'description' => [
			'name' => 'description',
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
		'color' => [
			'name' => 'color',
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
		'default' => [
			'name' => 'default',
			'type' => 'bool',
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
			'id' => 'id',
			'node_id' => 'nodeId',
			'url' => 'url',
			'name' => 'name',
			'description' => 'description',
			'color' => 'color',
			'default' => 'default',
		],
		'dashed' => [
			'id' => 'id',
			'node-id' => 'nodeId',
			'url' => 'url',
			'name' => 'name',
			'description' => 'description',
			'color' => 'color',
			'default' => 'default',
		],
	];

	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setId(int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNodeId(): string {
		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

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
	public function hasName(): bool {
		return $this->name !== null;
	}

	/**
	 * @param string|null $description
	 *
	 * @return $this
	 */
	public function setDescription(?string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDescriptionOrFail(string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDescriptionOrFail(): string {
		if ($this->description === null) {
			throw new \RuntimeException('Value not set for field `description` (expected to be not null)');
		}

		return $this->description;
	}

	/**
	 * @return bool
	 */
	public function hasDescription(): bool {
		return $this->description !== null;
	}

	/**
	 * @param string $color
	 *
	 * @return $this
	 */
	public function setColor(string $color) {
		$this->color = $color;
		$this->_touchedFields[self::FIELD_COLOR] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getColor(): string {
		return $this->color;
	}

	/**
	 * @return bool
	 */
	public function hasColor(): bool {
		return $this->color !== null;
	}

	/**
	 * @param bool $default
	 *
	 * @return $this
	 */
	public function setDefault(bool $default) {
		$this->default = $default;
		$this->_touchedFields[self::FIELD_DEFAULT] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getDefault(): bool {
		return $this->default;
	}

	/**
	 * @return bool
	 */
	public function hasDefault(): bool {
		return $this->default !== null;
	}

}
