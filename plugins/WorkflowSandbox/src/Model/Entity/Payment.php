<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * Demonstrates automated payment verification with retry logic.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $status
 * @property string $transaction_id
 * @property string $amount
 * @property string|null $currency
 * @property string|null $provider
 * @property string|null $provider_reference
 * @property int $retry_count
 * @property string|null $failure_reason
 * @property \Cake\I18n\DateTime|null $verified_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 */
class Payment extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
