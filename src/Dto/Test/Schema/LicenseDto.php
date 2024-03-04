<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/License DTO
 *
 * @property string $key
 * @property string $name
 * @property string|null $url
 * @property string|null $spdxId
 * @property string $nodeId
 */
class LicenseDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_KEY = 'key';
	public const FIELD_NAME = 'name';
	public const FIELD_URL = 'url';
	public const FIELD_SPDX_ID = 'spdxId';
	public const FIELD_NODE_ID = 'nodeId';

	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $url;

	/**
	 * @var string|null
	 */
	protected $spdxId;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'key' => [
			'name' => 'key',
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
		'url' => [
			'name' => 'url',
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
		'spdxId' => [
			'name' => 'spdxId',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'key' => 'key',
			'name' => 'name',
			'url' => 'url',
			'spdx_id' => 'spdxId',
			'node_id' => 'nodeId',
		],
		'dashed' => [
			'key' => 'key',
			'name' => 'name',
			'url' => 'url',
			'spdx-id' => 'spdxId',
			'node-id' => 'nodeId',
		],
	];

	/**
	 * @param string $key
	 *
	 * @return $this
	 */
	public function setKey(string $key) {
		$this->key = $key;
		$this->_touchedFields[self::FIELD_KEY] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getKey(): string {
		return $this->key;
	}

	/**
	 * @return bool
	 */
	public function hasKey(): bool {
		return $this->key !== null;
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
	 * @param string|null $url
	 *
	 * @return $this
	 */
	public function setUrl(?string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @param string $url
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUrlOrFail(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string {
		return $this->url;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getUrlOrFail(): string {
		if ($this->url === null) {
			throw new \RuntimeException('Value not set for field `url` (expected to be not null)');
		}

		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

	/**
	 * @param string|null $spdxId
	 *
	 * @return $this
	 */
	public function setSpdxId(?string $spdxId) {
		$this->spdxId = $spdxId;
		$this->_touchedFields[self::FIELD_SPDX_ID] = true;

		return $this;
	}

	/**
	 * @param string $spdxId
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSpdxIdOrFail(string $spdxId) {
		$this->spdxId = $spdxId;
		$this->_touchedFields[self::FIELD_SPDX_ID] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSpdxId(): ?string {
		return $this->spdxId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSpdxIdOrFail(): string {
		if ($this->spdxId === null) {
			throw new \RuntimeException('Value not set for field `spdxId` (expected to be not null)');
		}

		return $this->spdxId;
	}

	/**
	 * @return bool
	 */
	public function hasSpdxId(): bool {
		return $this->spdxId !== null;
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

}
