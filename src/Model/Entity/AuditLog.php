<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditLog Entity
 *
 * @property int $id
 * @property string $transaction
 * @property \App\Model\Enum\AuditLogType $type
 * @property int|null $primary_key
 * @property string $source
 * @property string|null $display_value
 * @property string|null $original
 * @property string|null $changed
 * @property string|null $meta
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property array|null $original_data
 * @property array|null $changed_data
 * @property array|null $meta_data
 * @property array<string> $changed_fields
 * @property string|null $parent_source
 * @property string|null $user
 */
class AuditLog extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * Virtual fields that should be exposed
	 *
	 * @var array<string>
	 */
	protected array $_virtual = [
		'original_data',
		'changed_data',
		'meta_data',
		'changed_fields',
	];

	/**
	 * Get decoded original data
	 *
	 * @return array|null
	 */
	protected function _getOriginalData(): ?array {
		if (!$this->original) {
			return null;
		}

		return json_decode($this->original, true);
	}

	/**
	 * Get decoded changed data
	 *
	 * @return array|null
	 */
	protected function _getChangedData(): ?array {
		if (!$this->changed) {
			return null;
		}

		return json_decode($this->changed, true);
	}

	/**
	 * Get decoded meta data
	 *
	 * @return array|null
	 */
	protected function _getMetaData(): ?array {
		if (!$this->meta) {
			return null;
		}

		return json_decode($this->meta, true);
	}

	/**
	 * Get list of changed field names
	 *
	 * @return array<string>
	 */
	protected function _getChangedFields(): array {
		$changed = $this->changed_data;
		if (!$changed) {
			return [];
		}

		return array_keys($changed);
	}

}
