<?php
declare(strict_types=1);

namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * SandboxCity Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $alias
 * @property int $country_id
 * @property float|null $lat
 * @property float|null $lng
 * @property string $coordinates
 *
 * @property \Data\Model\Entity\Country $country
 */
class SandboxCity extends Entity {

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
		'*' => true,
		'id' => false,
	];

}
