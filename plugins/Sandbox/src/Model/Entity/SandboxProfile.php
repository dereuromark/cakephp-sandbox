<?php
declare(strict_types=1);

namespace Sandbox\Model\Entity;

use App\Model\Entity\Entity;

/**
 * SandboxProfile Entity
 *
 * @property int $id
 * @property string $username
 * @property string $balance
 * @property string|null $extra
 * @method int getIdOrFail()
 * @method string getUsernameOrFail()
 * @method string getBalanceOrFail()
 * @method string getExtraOrFail()
 * @method $this setIdOrFail(int $value)
 * @method $this setUsernameOrFail(string $value)
 * @method $this setBalanceOrFail(string $value)
 * @method $this setExtraOrFail(string $value)
 */
class SandboxProfile extends Entity {

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
