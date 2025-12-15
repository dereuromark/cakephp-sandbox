<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace Sandbox\Dto\Github;

use PhpCollective\Dto\Dto\AbstractDto;

/**
 * Github/Label DTO
 *
 * @property string|null $name
 * @property string|null $color
 */
class LabelDto extends AbstractDto {

	/**
	 * @var string
	 */
	public const FIELD_NAME = 'name';
	/**
	 * @var string
	 */
	public const FIELD_COLOR = 'color';

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
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
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
			'mapFrom' => null,
			'mapTo' => null,
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
			'color' => 'color',
		],
		'dashed' => [
			'name' => 'name',
			'color' => 'color',
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
		'color' => 'setColor',
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
	}


	/**
	 * @param string|null $name
	 *
	 * @return $this
	 */
	public function setName(?string $name) {
		$this->name = $name;
		$this->_touchedFields[static::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setNameOrFail(string $name) {
		$this->name = $name;
		$this->_touchedFields[static::FIELD_NAME] = true;

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
	 * @param string|null $color
	 *
	 * @return $this
	 */
	public function setColor(?string $color) {
		$this->color = $color;
		$this->_touchedFields[static::FIELD_COLOR] = true;

		return $this;
	}

	/**
	 * @param string $color
	 *
	 * @return $this
	 */
	public function setColorOrFail(string $color) {
		$this->color = $color;
		$this->_touchedFields[static::FIELD_COLOR] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getColor(): ?string {
		return $this->color;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getColorOrFail(): string {
		if ($this->color === null) {
			throw new \RuntimeException('Value not set for field `color` (expected to be not null)');
		}

		return $this->color;
	}

	/**
	 * @return bool
	 */
	public function hasColor(): bool {
		return $this->color !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{name: string|null, color: string|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{name: string|null, color: string|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{name: string|null, color: string|null} $data
	 * @param bool $ignoreMissing
	 * @param string|null $type
	 *
	 * @return static
	 */
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return static::_createFromArrayInternal($data, $ignoreMissing, $type);
	}

}
