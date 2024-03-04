<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/License DTO
 *
 * @property string|null $key
 * @property string|null $name
 * @property string|null $url
 * @property string|null $spdxId
 * @property string|null $nodeId
 */
class LicenseDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_KEY = 'key';
	public const FIELD_NAME = 'name';
	public const FIELD_URL = 'url';
	public const FIELD_SPDX_ID = 'spdxId';
	public const FIELD_NODE_ID = 'nodeId';

	/**
	 * @var string|null
	 */
	protected $key;

	/**
	 * @var string|null
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
	 * @var string|null
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
	 * @param string|null $key
	 *
	 * @return $this
	 */
	public function setKey(?string $key) {
		$this->key = $key;
		$this->_touchedFields[self::FIELD_KEY] = true;

		return $this;
	}

	/**
	 * @param string $key
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setKeyOrFail(string $key) {
		$this->key = $key;
		$this->_touchedFields[self::FIELD_KEY] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getKey(): ?string {
		return $this->key;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getKeyOrFail(): string {
		if ($this->key === null) {
			throw new \RuntimeException('Value not set for field `key` (expected to be not null)');
		}

		return $this->key;
	}

	/**
	 * @return bool
	 */
	public function hasKey(): bool {
		return $this->key !== null;
	}

	/**
	 * @param string|null $name
	 *
	 * @return $this
	 */
	public function setName(?string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNameOrFail(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNameOrFail(): string {
		if ($this->name === null) {
			throw new \RuntimeException('Value not set for field `name` (expected to be not null)');
		}

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
	 * @param string|null $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(?string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @param string $nodeId
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNodeIdOrFail(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNodeId(): ?string {
		return $this->nodeId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNodeIdOrFail(): string {
		if ($this->nodeId === null) {
			throw new \RuntimeException('Value not set for field `nodeId` (expected to be not null)');
		}

		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

}
