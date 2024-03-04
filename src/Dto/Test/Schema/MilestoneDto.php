<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/Milestone DTO
 *
 * @property string $url
 * @property string $htmlUrl
 * @property string $labelsUrl
 * @property int $id
 * @property string $nodeId
 * @property int $number
 * @property string $state
 * @property string $title
 * @property string|null $description
 * @property \App\Dto\Test\Schema\SimpleUserDto|null $creator
 * @property int $openIssues
 * @property int $closedIssues
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $closedAt
 * @property string|null $dueOn
 */
class MilestoneDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_URL = 'url';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_LABELS_URL = 'labelsUrl';
	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_NUMBER = 'number';
	public const FIELD_STATE = 'state';
	public const FIELD_TITLE = 'title';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_CREATOR = 'creator';
	public const FIELD_OPEN_ISSUES = 'openIssues';
	public const FIELD_CLOSED_ISSUES = 'closedIssues';
	public const FIELD_CREATED_AT = 'createdAt';
	public const FIELD_UPDATED_AT = 'updatedAt';
	public const FIELD_CLOSED_AT = 'closedAt';
	public const FIELD_DUE_ON = 'dueOn';

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $htmlUrl;

	/**
	 * @var string
	 */
	protected $labelsUrl;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * @var int
	 */
	protected $number;

	/**
	 * @var string
	 */
	protected $state;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	protected $creator;

	/**
	 * @var int
	 */
	protected $openIssues;

	/**
	 * @var int
	 */
	protected $closedIssues;

	/**
	 * @var string
	 */
	protected $createdAt;

	/**
	 * @var string
	 */
	protected $updatedAt;

	/**
	 * @var string|null
	 */
	protected $closedAt;

	/**
	 * @var string|null
	 */
	protected $dueOn;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'url' => [
			'name' => 'url',
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
		'htmlUrl' => [
			'name' => 'htmlUrl',
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
		'labelsUrl' => [
			'name' => 'labelsUrl',
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
		'id' => [
			'name' => 'id',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'nodeId' => [
			'name' => 'nodeId',
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
		'number' => [
			'name' => 'number',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'state' => [
			'name' => 'state',
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
		'title' => [
			'name' => 'title',
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
		'description' => [
			'name' => 'description',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'creator' => [
			'name' => 'creator',
			'type' => '\App\Dto\Test\Schema\SimpleUserDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/SimpleUser',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'openIssues' => [
			'name' => 'openIssues',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'closedIssues' => [
			'name' => 'closedIssues',
			'type' => 'int',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'createdAt' => [
			'name' => 'createdAt',
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
		'updatedAt' => [
			'name' => 'updatedAt',
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
		'closedAt' => [
			'name' => 'closedAt',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'dueOn' => [
			'name' => 'dueOn',
			'type' => 'string',
			'required' => false,
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
			'url' => 'url',
			'html_url' => 'htmlUrl',
			'labels_url' => 'labelsUrl',
			'id' => 'id',
			'node_id' => 'nodeId',
			'number' => 'number',
			'state' => 'state',
			'title' => 'title',
			'description' => 'description',
			'creator' => 'creator',
			'open_issues' => 'openIssues',
			'closed_issues' => 'closedIssues',
			'created_at' => 'createdAt',
			'updated_at' => 'updatedAt',
			'closed_at' => 'closedAt',
			'due_on' => 'dueOn',
		],
		'dashed' => [
			'url' => 'url',
			'html-url' => 'htmlUrl',
			'labels-url' => 'labelsUrl',
			'id' => 'id',
			'node-id' => 'nodeId',
			'number' => 'number',
			'state' => 'state',
			'title' => 'title',
			'description' => 'description',
			'creator' => 'creator',
			'open-issues' => 'openIssues',
			'closed-issues' => 'closedIssues',
			'created-at' => 'createdAt',
			'updated-at' => 'updatedAt',
			'closed-at' => 'closedAt',
			'due-on' => 'dueOn',
		],
	];

	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

	/**
	 * @param string $htmlUrl
	 *
	 * @return $this
	 */
	public function setHtmlUrl(string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHtmlUrl(): string {
		return $this->htmlUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHtmlUrl(): bool {
		return $this->htmlUrl !== null;
	}

	/**
	 * @param string $labelsUrl
	 *
	 * @return $this
	 */
	public function setLabelsUrl(string $labelsUrl) {
		$this->labelsUrl = $labelsUrl;
		$this->_touchedFields[self::FIELD_LABELS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLabelsUrl(): string {
		return $this->labelsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasLabelsUrl(): bool {
		return $this->labelsUrl !== null;
	}

	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setId(int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNodeId(): string {
		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

	/**
	 * @param int $number
	 *
	 * @return $this
	 */
	public function setNumber(int $number) {
		$this->number = $number;
		$this->_touchedFields[self::FIELD_NUMBER] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumber(): int {
		return $this->number;
	}

	/**
	 * @return bool
	 */
	public function hasNumber(): bool {
		return $this->number !== null;
	}

	/**
	 * @param string $state
	 *
	 * @return $this
	 */
	public function setState(string $state) {
		$this->state = $state;
		$this->_touchedFields[self::FIELD_STATE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getState(): string {
		return $this->state;
	}

	/**
	 * @return bool
	 */
	public function hasState(): bool {
		return $this->state !== null;
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function setTitle(string $title) {
		$this->title = $title;
		$this->_touchedFields[self::FIELD_TITLE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function hasTitle(): bool {
		return $this->title !== null;
	}

	/**
	 * @param string|null $description
	 *
	 * @return $this
	 */
	public function setDescription(?string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDescriptionOrFail(string $description) {
		$this->description = $description;
		$this->_touchedFields[self::FIELD_DESCRIPTION] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDescriptionOrFail(): string {
		if ($this->description === null) {
			throw new \RuntimeException('Value not set for field `description` (expected to be not null)');
		}

		return $this->description;
	}

	/**
	 * @return bool
	 */
	public function hasDescription(): bool {
		return $this->description !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto|null $creator
	 *
	 * @return $this
	 */
	public function setCreator(?\App\Dto\Test\Schema\SimpleUserDto $creator) {
		$this->creator = $creator;
		$this->_touchedFields[self::FIELD_CREATOR] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto $creator
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCreatorOrFail(\App\Dto\Test\Schema\SimpleUserDto $creator) {
		$this->creator = $creator;
		$this->_touchedFields[self::FIELD_CREATOR] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	public function getCreator(): ?\App\Dto\Test\Schema\SimpleUserDto {
		return $this->creator;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\SimpleUserDto
	 */
	public function getCreatorOrFail(): \App\Dto\Test\Schema\SimpleUserDto {
		if ($this->creator === null) {
			throw new \RuntimeException('Value not set for field `creator` (expected to be not null)');
		}

		return $this->creator;
	}

	/**
	 * @return bool
	 */
	public function hasCreator(): bool {
		return $this->creator !== null;
	}

	/**
	 * @param int $openIssues
	 *
	 * @return $this
	 */
	public function setOpenIssues(int $openIssues) {
		$this->openIssues = $openIssues;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getOpenIssues(): int {
		return $this->openIssues;
	}

	/**
	 * @return bool
	 */
	public function hasOpenIssues(): bool {
		return $this->openIssues !== null;
	}

	/**
	 * @param int $closedIssues
	 *
	 * @return $this
	 */
	public function setClosedIssues(int $closedIssues) {
		$this->closedIssues = $closedIssues;
		$this->_touchedFields[self::FIELD_CLOSED_ISSUES] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getClosedIssues(): int {
		return $this->closedIssues;
	}

	/**
	 * @return bool
	 */
	public function hasClosedIssues(): bool {
		return $this->closedIssues !== null;
	}

	/**
	 * @param string $createdAt
	 *
	 * @return $this
	 */
	public function setCreatedAt(string $createdAt) {
		$this->createdAt = $createdAt;
		$this->_touchedFields[self::FIELD_CREATED_AT] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreatedAt(): string {
		return $this->createdAt;
	}

	/**
	 * @return bool
	 */
	public function hasCreatedAt(): bool {
		return $this->createdAt !== null;
	}

	/**
	 * @param string $updatedAt
	 *
	 * @return $this
	 */
	public function setUpdatedAt(string $updatedAt) {
		$this->updatedAt = $updatedAt;
		$this->_touchedFields[self::FIELD_UPDATED_AT] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt(): string {
		return $this->updatedAt;
	}

	/**
	 * @return bool
	 */
	public function hasUpdatedAt(): bool {
		return $this->updatedAt !== null;
	}

	/**
	 * @param string|null $closedAt
	 *
	 * @return $this
	 */
	public function setClosedAt(?string $closedAt) {
		$this->closedAt = $closedAt;
		$this->_touchedFields[self::FIELD_CLOSED_AT] = true;

		return $this;
	}

	/**
	 * @param string $closedAt
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setClosedAtOrFail(string $closedAt) {
		$this->closedAt = $closedAt;
		$this->_touchedFields[self::FIELD_CLOSED_AT] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getClosedAt(): ?string {
		return $this->closedAt;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getClosedAtOrFail(): string {
		if ($this->closedAt === null) {
			throw new \RuntimeException('Value not set for field `closedAt` (expected to be not null)');
		}

		return $this->closedAt;
	}

	/**
	 * @return bool
	 */
	public function hasClosedAt(): bool {
		return $this->closedAt !== null;
	}

	/**
	 * @param string|null $dueOn
	 *
	 * @return $this
	 */
	public function setDueOn(?string $dueOn) {
		$this->dueOn = $dueOn;
		$this->_touchedFields[self::FIELD_DUE_ON] = true;

		return $this;
	}

	/**
	 * @param string $dueOn
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDueOnOrFail(string $dueOn) {
		$this->dueOn = $dueOn;
		$this->_touchedFields[self::FIELD_DUE_ON] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDueOn(): ?string {
		return $this->dueOn;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDueOnOrFail(): string {
		if ($this->dueOn === null) {
			throw new \RuntimeException('Value not set for field `dueOn` (expected to be not null)');
		}

		return $this->dueOn;
	}

	/**
	 * @return bool
	 */
	public function hasDueOn(): bool {
		return $this->dueOn !== null;
	}

}
