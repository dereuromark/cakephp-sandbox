<?php

namespace Sandbox\Model\Entity;

use App\Model\Entity\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string $title
 * @property string $location
 * @property float|null $lat
 * @property float|null $lng
 * @property string $description
 * @property \Cake\I18n\DateTime|null $beginning
 * @property \Cake\I18n\DateTime|null $end
 * @method int getIdOrFail()
 * @method string getTitleOrFail()
 * @method string getLocationOrFail()
 * @method float getLatOrFail()
 * @method float getLngOrFail()
 * @method string getDescriptionOrFail()
 * @method \Cake\I18n\DateTime getBeginningOrFail()
 * @method \Cake\I18n\DateTime getEndOrFail()
 * @property-read string|null $coordinates
 * @method string getCoordinatesOrFail()
 * @method $this setIdOrFail(int $value)
 * @method $this setTitleOrFail(string $value)
 * @method $this setLocationOrFail(string $value)
 * @method $this setLatOrFail(float $value)
 * @method $this setLngOrFail(float $value)
 * @method $this setDescriptionOrFail(string $value)
 * @method $this setBeginningOrFail(\Cake\I18n\DateTime $value)
 * @method $this setEndOrFail(\Cake\I18n\DateTime $value)
 * @method $this setCoordinatesOrFail(string $value)
 */
class Event extends Entity {

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

	/**
	 * @var list<string>
	 */
	protected array $_virtual = [
		'coordinates',
	];

	/**
	 * Demo to showcase virtual fields, here just lat/lng combination.
	 *
	 * Always make sure those are nullable, or in some rare cases
	 * throw exception here if necessary.
	 *
	 * @see \Sandbox\Model\Entity\Event::$coordinates
	 *
	 * @return string|null
	 */
	protected function _getCoordinates(): ?string {
		if ($this->lat === null || $this->lng === null) {
			return null;
		}

		return $this->lat . '/' . $this->lng;
	}

}
