<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/Permissions DTO
 *
 * @property bool|null $admin
 * @property bool|null $push
 * @property bool|null $pull
 */
class PermissionsDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ADMIN = 'admin';
	public const FIELD_PUSH = 'push';
	public const FIELD_PULL = 'pull';

	/**
	 * @var bool|null
	 */
	protected $admin;

	/**
	 * @var bool|null
	 */
	protected $push;

	/**
	 * @var bool|null
	 */
	protected $pull;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'admin' => [
			'name' => 'admin',
			'type' => 'bool',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'push' => [
			'name' => 'push',
			'type' => 'bool',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'pull' => [
			'name' => 'pull',
			'type' => 'bool',
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
			'admin' => 'admin',
			'push' => 'push',
			'pull' => 'pull',
		],
		'dashed' => [
			'admin' => 'admin',
			'push' => 'push',
			'pull' => 'pull',
		],
	];

	/**
	 * @param bool|null $admin
	 *
	 * @return $this
	 */
	public function setAdmin(?bool $admin) {
		$this->admin = $admin;
		$this->_touchedFields[self::FIELD_ADMIN] = true;

		return $this;
	}

	/**
	 * @param bool $admin
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAdminOrFail(bool $admin) {
		$this->admin = $admin;
		$this->_touchedFields[self::FIELD_ADMIN] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getAdmin(): ?bool {
		return $this->admin;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getAdminOrFail(): bool {
		if ($this->admin === null) {
			throw new \RuntimeException('Value not set for field `admin` (expected to be not null)');
		}

		return $this->admin;
	}

	/**
	 * @return bool
	 */
	public function hasAdmin(): bool {
		return $this->admin !== null;
	}

	/**
	 * @param bool|null $push
	 *
	 * @return $this
	 */
	public function setPush(?bool $push) {
		$this->push = $push;
		$this->_touchedFields[self::FIELD_PUSH] = true;

		return $this;
	}

	/**
	 * @param bool $push
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPushOrFail(bool $push) {
		$this->push = $push;
		$this->_touchedFields[self::FIELD_PUSH] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getPush(): ?bool {
		return $this->push;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getPushOrFail(): bool {
		if ($this->push === null) {
			throw new \RuntimeException('Value not set for field `push` (expected to be not null)');
		}

		return $this->push;
	}

	/**
	 * @return bool
	 */
	public function hasPush(): bool {
		return $this->push !== null;
	}

	/**
	 * @param bool|null $pull
	 *
	 * @return $this
	 */
	public function setPull(?bool $pull) {
		$this->pull = $pull;
		$this->_touchedFields[self::FIELD_PULL] = true;

		return $this;
	}

	/**
	 * @param bool $pull
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPullOrFail(bool $pull) {
		$this->pull = $pull;
		$this->_touchedFields[self::FIELD_PULL] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getPull(): ?bool {
		return $this->pull;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getPullOrFail(): bool {
		if ($this->pull === null) {
			throw new \RuntimeException('Value not set for field `pull` (expected to be not null)');
		}

		return $this->pull;
	}

	/**
	 * @return bool
	 */
	public function hasPull(): bool {
		return $this->pull !== null;
	}

}
