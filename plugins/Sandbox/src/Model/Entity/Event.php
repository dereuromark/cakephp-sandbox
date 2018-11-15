<?php
namespace Sandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string $title
 * @property string $location
 * @property float|null $lat
 * @property float|null $lng
 * @property string $description
 * @property \Cake\I18n\FrozenTime|null $beginning
 * @property \Cake\I18n\FrozenTime|null $end
 */
class Event extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false
	];

}
