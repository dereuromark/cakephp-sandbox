<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $file_path
 * @property string $status
 * @property int $current_approver_level
 * @property string|null $approved_by
 * @property int|null $rejected_by
 * @property string|null $rejection_reason
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 * @property \App\Model\Entity\User|null $rejector
 */
class Document extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

	/**
	 * Get approvers as array
	 *
	 * @return array<int>
	 */
	public function getApprovers(): array {
		if (!$this->approved_by) {
			return [];
		}

		$decoded = json_decode($this->approved_by, true);

		return is_array($decoded) ? $decoded : [];
	}

	/**
	 * Add approver to list
	 *
	 * @param int $userId User ID
	 * @return void
	 */
	public function addApprover(int $userId): void {
		$approvers = $this->getApprovers();
		if (!in_array($userId, $approvers, true)) {
			$approvers[] = $userId;
			$this->approved_by = (string)json_encode($approvers);
		}
	}

}
