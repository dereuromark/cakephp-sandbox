<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/Permissions DTO
 *
 * @property bool $admin
 * @property bool|null $maintain
 * @property bool $push
 * @property bool|null $triage
 * @property bool $pull
 */
class PermissionsDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ADMIN = 'admin';
	public const FIELD_MAINTAIN = 'maintain';
	public const FIELD_PUSH = 'push';
	public const FIELD_TRIAGE = 'triage';
	public const FIELD_PULL = 'pull';

	/**
	 * @var bool
	 */
	protected $admin;

	/**
	 * @var bool|null
	 */
	protected $maintain;

	/**
	 * @var bool
	 */
	protected $push;

	/**
	 * @var bool|null
	 */
	protected $triage;

	/**
	 * @var bool
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
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'maintain' => [
			'name' => 'maintain',
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
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'triage' => [
			'name' => 'triage',
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
			'admin' => 'admin',
			'maintain' => 'maintain',
			'push' => 'push',
			'triage' => 'triage',
			'pull' => 'pull',
		],
		'dashed' => [
			'admin' => 'admin',
			'maintain' => 'maintain',
			'push' => 'push',
			'triage' => 'triage',
			'pull' => 'pull',
		],
	];

	/**
	 * @param bool $admin
	 *
	 * @return $this
	 */
	public function setAdmin(bool $admin) {
		$this->admin = $admin;
		$this->_touchedFields[self::FIELD_ADMIN] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getAdmin(): bool {
		return $this->admin;
	}

	/**
	 * @return bool
	 */
	public function hasAdmin(): bool {
		return $this->admin !== null;
	}

	/**
	 * @param bool|null $maintain
	 *
	 * @return $this
	 */
	public function setMaintain(?bool $maintain) {
		$this->maintain = $maintain;
		$this->_touchedFields[self::FIELD_MAINTAIN] = true;

		return $this;
	}

	/**
	 * @param bool $maintain
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMaintainOrFail(bool $maintain) {
		$this->maintain = $maintain;
		$this->_touchedFields[self::FIELD_MAINTAIN] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getMaintain(): ?bool {
		return $this->maintain;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getMaintainOrFail(): bool {
		if ($this->maintain === null) {
			throw new \RuntimeException('Value not set for field `maintain` (expected to be not null)');
		}

		return $this->maintain;
	}

	/**
	 * @return bool
	 */
	public function hasMaintain(): bool {
		return $this->maintain !== null;
	}

	/**
	 * @param bool $push
	 *
	 * @return $this
	 */
	public function setPush(bool $push) {
		$this->push = $push;
		$this->_touchedFields[self::FIELD_PUSH] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPush(): bool {
		return $this->push;
	}

	/**
	 * @return bool
	 */
	public function hasPush(): bool {
		return $this->push !== null;
	}

	/**
	 * @param bool|null $triage
	 *
	 * @return $this
	 */
	public function setTriage(?bool $triage) {
		$this->triage = $triage;
		$this->_touchedFields[self::FIELD_TRIAGE] = true;

		return $this;
	}

	/**
	 * @param bool $triage
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTriageOrFail(bool $triage) {
		$this->triage = $triage;
		$this->_touchedFields[self::FIELD_TRIAGE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getTriage(): ?bool {
		return $this->triage;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getTriageOrFail(): bool {
		if ($this->triage === null) {
			throw new \RuntimeException('Value not set for field `triage` (expected to be not null)');
		}

		return $this->triage;
	}

	/**
	 * @return bool
	 */
	public function hasTriage(): bool {
		return $this->triage !== null;
	}

	/**
	 * @param bool $pull
	 *
	 * @return $this
	 */
	public function setPull(bool $pull) {
		$this->pull = $pull;
		$this->_touchedFields[self::FIELD_PULL] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPull(): bool {
		return $this->pull;
	}

	/**
	 * @return bool
	 */
	public function hasPull(): bool {
		return $this->pull !== null;
	}

}
