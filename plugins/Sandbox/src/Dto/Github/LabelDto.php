<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

/**
 * Github/Label DTO
 */
class LabelDto extends \CakeDto\Dto\AbstractDto {

	const FIELD_NAME = 'name';
	const FIELD_COLOR = 'color';

	/**
	 * @var string|null
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $color;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array
	 */
	protected $_metadata = [
		'name' => [
			'name' => 'name',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'color' => [
			'name' => 'color',
			'type' => 'string',
			'required' => false,
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
			'name' => 'name',
			'color' => 'color',
		],
		'dashed' => [
			'name' => 'name',
			'color' => 'color',
		],
	];

	/**
	 * @param string|null $name
	 *
	 * @return $this
	 */
	public function setName($name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNameOrFail() {
		if (!isset($this->name)) {
			throw new \RuntimeException('Value not set for field `name` (expected to be not null)');
		}

		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName() {
		return $this->name !== null;
	}

	/**
	 * @param string|null $color
	 *
	 * @return $this
	 */
	public function setColor($color) {
		$this->color = $color;
		$this->_touchedFields[self::FIELD_COLOR] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getColorOrFail() {
		if (!isset($this->color)) {
			throw new \RuntimeException('Value not set for field `color` (expected to be not null)');
		}

		return $this->color;
	}

	/**
	 * @return bool
	 */
	public function hasColor() {
		return $this->color !== null;
	}

}
