<?php
declare(strict_types = 1);

namespace Sandbox\Model\Entity;

use Tools\Model\Entity\Entity;

/**
 * BitmaskedRecord Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $flag_optional
 * @property int $flag_required
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class BitmaskedRecord extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * @param int|null $value
	 *
	 * @return array<string>|string|null
	 */
	public static function flags($value = null) {
		$options = [
			static::STATUS_IMPORTANT => __('Important'),
			static::STATUS_FEATURED => __('Featured'),
			static::STATUS_APPROVED => __('Approved'),
			static::STATUS_FLAGGED => __('Flagged'),
		];

		return parent::enum($value, $options);
	}

	/**
	 * @var int
	 */
	public const STATUS_IMPORTANT = 1;

	/**
	 * @var int
	 */
	public const STATUS_FEATURED = 2;

	/**
	 * @var int
	 */
	public const STATUS_APPROVED = 4;

	/**
	 * @var int
	 */
	public const STATUS_FLAGGED = 8;

}
