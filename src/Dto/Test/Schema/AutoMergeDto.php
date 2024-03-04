<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/AutoMerge DTO
 *
 * @property \App\Dto\Test\Schema\SimpleUserDto $enabledBy
 * @property string $mergeMethod
 * @property string $commitTitle
 * @property string $commitMessage
 */
class AutoMergeDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ENABLED_BY = 'enabledBy';
	public const FIELD_MERGE_METHOD = 'mergeMethod';
	public const FIELD_COMMIT_TITLE = 'commitTitle';
	public const FIELD_COMMIT_MESSAGE = 'commitMessage';

	/**
	 * @var \App\Dto\Test\Schema\SimpleUserDto
	 */
	protected $enabledBy;

	/**
	 * @var string
	 */
	protected $mergeMethod;

	/**
	 * @var string
	 */
	protected $commitTitle;

	/**
	 * @var string
	 */
	protected $commitMessage;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'enabledBy' => [
			'name' => 'enabledBy',
			'type' => '\App\Dto\Test\Schema\SimpleUserDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Test/Schema/SimpleUser',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'mergeMethod' => [
			'name' => 'mergeMethod',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'commitTitle' => [
			'name' => 'commitTitle',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'commitMessage' => [
			'name' => 'commitMessage',
			'type' => 'string',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'enabled_by' => 'enabledBy',
			'merge_method' => 'mergeMethod',
			'commit_title' => 'commitTitle',
			'commit_message' => 'commitMessage',
		],
		'dashed' => [
			'enabled-by' => 'enabledBy',
			'merge-method' => 'mergeMethod',
			'commit-title' => 'commitTitle',
			'commit-message' => 'commitMessage',
		],
	];

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto $enabledBy
	 *
	 * @return $this
	 */
	public function setEnabledBy(\App\Dto\Test\Schema\SimpleUserDto $enabledBy) {
		$this->enabledBy = $enabledBy;
		$this->_touchedFields[self::FIELD_ENABLED_BY] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\SimpleUserDto
	 */
	public function getEnabledBy(): \App\Dto\Test\Schema\SimpleUserDto {
		return $this->enabledBy;
	}

	/**
	 * @return bool
	 */
	public function hasEnabledBy(): bool {
		return $this->enabledBy !== null;
	}

	/**
	 * @param string $mergeMethod
	 *
	 * @return $this
	 */
	public function setMergeMethod(string $mergeMethod) {
		$this->mergeMethod = $mergeMethod;
		$this->_touchedFields[self::FIELD_MERGE_METHOD] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMergeMethod(): string {
		return $this->mergeMethod;
	}

	/**
	 * @return bool
	 */
	public function hasMergeMethod(): bool {
		return $this->mergeMethod !== null;
	}

	/**
	 * @param string $commitTitle
	 *
	 * @return $this
	 */
	public function setCommitTitle(string $commitTitle) {
		$this->commitTitle = $commitTitle;
		$this->_touchedFields[self::FIELD_COMMIT_TITLE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCommitTitle(): string {
		return $this->commitTitle;
	}

	/**
	 * @return bool
	 */
	public function hasCommitTitle(): bool {
		return $this->commitTitle !== null;
	}

	/**
	 * @param string $commitMessage
	 *
	 * @return $this
	 */
	public function setCommitMessage(string $commitMessage) {
		$this->commitMessage = $commitMessage;
		$this->_touchedFields[self::FIELD_COMMIT_MESSAGE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCommitMessage(): string {
		return $this->commitMessage;
	}

	/**
	 * @return bool
	 */
	public function hasCommitMessage(): bool {
		return $this->commitMessage !== null;
	}

}
