<?php
declare(strict_types=1);

namespace App\Dto;

use Cake\I18n\DateTime;

/**
 * DTO for Tagged (_joinData pivot table).
 */
readonly class TaggedDto {

	/**
	 * @param int $id Tagged ID
	 * @param int $tag_id Tag ID
	 * @param int $fk_id Foreign key ID
	 * @param string|null $fk_model Foreign key model
	 * @param \Cake\I18n\DateTime|null $created Created timestamp
	 */
	public function __construct(
		public int $id,
		public int $tag_id,
		public int $fk_id,
		public ?string $fk_model = null,
		public ?DateTime $created = null,
	) {
	}

}
