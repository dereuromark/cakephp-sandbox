<?php
declare(strict_types=1);

namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * SandboxProduct Entity
 *
 * @property int $id
 * @property string $title
 * @property string $price
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Product extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'title' => true,
		'price' => true,
		'created' => true,
		'modified' => true,
	];

}
