<?php

namespace Sandbox\Model\Entity;

use App\Model\Entity\Entity;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $rating_count
 * @property int $rating_sum
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property array<\Tags\Model\Entity\Tagged> $tagged
 * @property array<\Tags\Model\Entity\Tag> $tags
 * @property string $tag_list !
 * @method int getIdOrFail()
 * @method string getTitleOrFail()
 * @method string getContentOrFail()
 * @method int getRatingCountOrFail()
 * @method int getRatingSumOrFail()
 * @method \Cake\I18n\DateTime getCreatedOrFail()
 * @method \Cake\I18n\DateTime getModifiedOrFail()
 * @method array<\Tags\Model\Entity\Tagged> getTaggedOrFail()
 * @method array<\Tags\Model\Entity\Tag> getTagsOrFail()
 * @method $this setIdOrFail(int $value)
 * @method $this setTitleOrFail(string $value)
 * @method $this setContentOrFail(string $value)
 * @method $this setRatingCountOrFail(int $value)
 * @method $this setRatingSumOrFail(int $value)
 * @method $this setCreatedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setModifiedOrFail(\Cake\I18n\DateTime $value)
 * @method $this setTaggedOrFail(array $value)
 * @method $this setTagsOrFail(array $value)
 * @property \Tags\Model\Entity\Tagged $_joinData
 * @method \Tags\Model\Entity\Tagged getJoinDataOrFail()
 * @method $this setJoinDataOrFail(\Tags\Model\Entity\Tagged $value)
 */
class SandboxPost extends Entity {

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
