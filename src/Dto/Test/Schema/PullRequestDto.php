<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/PullRequest DTO
 *
 * @property string $url
 * @property int $id
 * @property string $nodeId
 * @property string $htmlUrl
 * @property string $diffUrl
 * @property string $patchUrl
 * @property string $issueUrl
 * @property string $commitsUrl
 * @property string $reviewCommentsUrl
 * @property string $reviewCommentUrl
 * @property string $commentsUrl
 * @property string $statusesUrl
 * @property int $number
 * @property string $state
 * @property bool $locked
 * @property string $title
 * @property \App\Dto\Test\Schema\SimpleUserDto $user
 * @property string|null $body
 * @property \App\Dto\Test\Schema\LabelDto[]|\ArrayObject $labels
 * @property \App\Dto\Test\Schema\MilestoneDto|null $milestone
 * @property string|null $activeLockReason
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $closedAt
 * @property string|null $mergedAt
 * @property string|null $mergeCommitSha
 * @property \App\Dto\Test\Schema\SimpleUserDto|null $assignee
 * @property \App\Dto\Test\Schema\AssigneeDto[]|\ArrayObject $assignees
 * @property \App\Dto\Test\Schema\RequestedReviewerDto[]|\ArrayObject $requestedReviewers
 * @property \App\Dto\Test\Schema\RequestedTeamDto[]|\ArrayObject $requestedTeams
 * @property \App\Dto\Test\Schema\HeadDto $head
 * @property \App\Dto\Test\Schema\BaseDto $base
 * @property string $authorAssociation
 * @property \App\Dto\Test\Schema\AutoMergeDto|null $autoMerge
 * @property bool|null $draft
 * @property bool $merged
 * @property bool|null $mergeable
 * @property bool|null $rebaseable
 * @property string $mergeableState
 * @property \App\Dto\Test\Schema\SimpleUserDto|null $mergedBy
 * @property int $comments
 * @property int $reviewComments
 * @property bool $maintainerCanModify
 * @property int $commits
 * @property int $additions
 * @property int $deletions
 * @property int $changedFiles
 */
class PullRequestDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_URL = 'url';
	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_DIFF_URL = 'diffUrl';
	public const FIELD_PATCH_URL = 'patchUrl';
	public const FIELD_ISSUE_URL = 'issueUrl';
	public const FIELD_COMMITS_URL = 'commitsUrl';
	public const FIELD_REVIEW_COMMENTS_URL = 'reviewCommentsUrl';
	public const FIELD_REVIEW_COMMENT_URL = 'reviewCommentUrl';
	public const FIELD_COMMENTS_URL = 'commentsUrl';
	public const FIELD_STATUSES_URL = 'statusesUrl';
	public const FIELD_NUMBER = 'number';
	public const FIELD_STATE = 'state';
	public const FIELD_LOCKED = 'locked';
	public const FIELD_TITLE = 'title';
	public const FIELD_USER = 'user';
	public const FIELD_BODY = 'body';
	public const FIELD_LABELS = 'labels';
	public const FIELD_MILESTONE = 'milestone';
	public const FIELD_ACTIVE_LOCK_REASON = 'activeLockReason';
	public const FIELD_CREATED_AT = 'createdAt';
	public const FIELD_UPDATED_AT = 'updatedAt';
	public const FIELD_CLOSED_AT = 'closedAt';
	public const FIELD_MERGED_AT = 'mergedAt';
	public const FIELD_MERGE_COMMIT_SHA = 'mergeCommitSha';
	public const FIELD_ASSIGNEE = 'assignee';
	public const FIELD_ASSIGNEES = 'assignees';
	public const FIELD_REQUESTED_REVIEWERS = 'requestedReviewers';
	public const FIELD_REQUESTED_TEAMS = 'requestedTeams';
	public const FIELD_HEAD = 'head';
	public const FIELD_BASE = 'base';
	public const FIELD_AUTHOR_ASSOCIATION = 'authorAssociation';
	public const FIELD_AUTO_MERGE = 'autoMerge';
	public const FIELD_DRAFT = 'draft';
	public const FIELD_MERGED = 'merged';
	public const FIELD_MERGEABLE = 'mergeable';
	public const FIELD_REBASEABLE = 'rebaseable';
	public const FIELD_MERGEABLE_STATE = 'mergeableState';
	public const FIELD_MERGED_BY = 'mergedBy';
	public const FIELD_COMMENTS = 'comments';
	public const FIELD_REVIEW_COMMENTS = 'reviewComments';
	public const FIELD_MAINTAINER_CAN_MODIFY = 'maintainerCanModify';
	public const FIELD_COMMITS = 'commits';
	public const FIELD_ADDITIONS = 'additions';
	public const FIELD_DELETIONS = 'deletions';
	public const FIELD_CHANGED_FILES = 'changedFiles';

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * @var string
	 */
	protected $htmlUrl;

	/**
	 * @var string
	 */
	protected $diffUrl;

	/**
	 * @var string
	 */
	protected $patchUrl;

	/**
	 * @var string
	 */
	protected $issueUrl;

	/**
	 * @var string
	 */
	protected $commitsUrl;

	/**
	 * @var string
	 */
	protected $reviewCommentsUrl;

	/**
	 * @var string
	 */
	protected $reviewCommentUrl;

	/**
	 * @var string
	 */
	protected $commentsUrl;

	/**
	 * @var string
	 */
	protected $statusesUrl;

	/**
	 * @var int
	 */
	protected $number;

	/**
	 * @var string
	 */
	protected $state;

	/**
	 * @var bool
	 */
	protected $locked;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var \App\Dto\Test\Schema\SimpleUserDto
	 */
	protected $user;

	/**
	 * @var string|null
	 */
	protected $body;

	/**
	 * @var \App\Dto\Test\Schema\LabelDto[]|\ArrayObject
	 */
	protected $labels;

	/**
	 * @var \App\Dto\Test\Schema\MilestoneDto|null
	 */
	protected $milestone;

	/**
	 * @var string|null
	 */
	protected $activeLockReason;

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
	protected $mergedAt;

	/**
	 * @var string|null
	 */
	protected $mergeCommitSha;

	/**
	 * @var \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	protected $assignee;

	/**
	 * @var \App\Dto\Test\Schema\AssigneeDto[]|\ArrayObject
	 */
	protected $assignees;

	/**
	 * @var \App\Dto\Test\Schema\RequestedReviewerDto[]|\ArrayObject
	 */
	protected $requestedReviewers;

	/**
	 * @var \App\Dto\Test\Schema\RequestedTeamDto[]|\ArrayObject
	 */
	protected $requestedTeams;

	/**
	 * @var \App\Dto\Test\Schema\HeadDto
	 */
	protected $head;

	/**
	 * @var \App\Dto\Test\Schema\BaseDto
	 */
	protected $base;

	/**
	 * @var string
	 */
	protected $authorAssociation;

	/**
	 * @var \App\Dto\Test\Schema\AutoMergeDto|null
	 */
	protected $autoMerge;

	/**
	 * @var bool|null
	 */
	protected $draft;

	/**
	 * @var bool
	 */
	protected $merged;

	/**
	 * @var bool|null
	 */
	protected $mergeable;

	/**
	 * @var bool|null
	 */
	protected $rebaseable;

	/**
	 * @var string
	 */
	protected $mergeableState;

	/**
	 * @var \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	protected $mergedBy;

	/**
	 * @var int
	 */
	protected $comments;

	/**
	 * @var int
	 */
	protected $reviewComments;

	/**
	 * @var bool
	 */
	protected $maintainerCanModify;

	/**
	 * @var int
	 */
	protected $commits;

	/**
	 * @var int
	 */
	protected $additions;

	/**
	 * @var int
	 */
	protected $deletions;

	/**
	 * @var int
	 */
	protected $changedFiles;

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
		'diffUrl' => [
			'name' => 'diffUrl',
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
		'patchUrl' => [
			'name' => 'patchUrl',
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
		'issueUrl' => [
			'name' => 'issueUrl',
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
		'commitsUrl' => [
			'name' => 'commitsUrl',
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
		'reviewCommentsUrl' => [
			'name' => 'reviewCommentsUrl',
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
		'reviewCommentUrl' => [
			'name' => 'reviewCommentUrl',
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
		'commentsUrl' => [
			'name' => 'commentsUrl',
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
		'statusesUrl' => [
			'name' => 'statusesUrl',
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
		'locked' => [
			'name' => 'locked',
			'type' => 'bool',
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
		'user' => [
			'name' => 'user',
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
		'body' => [
			'name' => 'body',
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
		'labels' => [
			'name' => 'labels',
			'type' => '\App\Dto\Test\Schema\LabelDto[]|\ArrayObject',
			'required' => true,
			'associative' => true,
			'key' => 'name',
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Schema\LabelDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Schema\LabelDto',
		],
		'milestone' => [
			'name' => 'milestone',
			'type' => '\App\Dto\Test\Schema\MilestoneDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Milestone',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'activeLockReason' => [
			'name' => 'activeLockReason',
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
		'mergedAt' => [
			'name' => 'mergedAt',
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
		'mergeCommitSha' => [
			'name' => 'mergeCommitSha',
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
		'assignee' => [
			'name' => 'assignee',
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
		'assignees' => [
			'name' => 'assignees',
			'type' => '\App\Dto\Test\Schema\AssigneeDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'login',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Schema\AssigneeDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Schema\AssigneeDto',
		],
		'requestedReviewers' => [
			'name' => 'requestedReviewers',
			'type' => '\App\Dto\Test\Schema\RequestedReviewerDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'login',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Schema\RequestedReviewerDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Schema\RequestedReviewerDto',
		],
		'requestedTeams' => [
			'name' => 'requestedTeams',
			'type' => '\App\Dto\Test\Schema\RequestedTeamDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'slug',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Schema\RequestedTeamDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Schema\RequestedTeamDto',
		],
		'head' => [
			'name' => 'head',
			'type' => '\App\Dto\Test\Schema\HeadDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Head',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'base' => [
			'name' => 'base',
			'type' => '\App\Dto\Test\Schema\BaseDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Base',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'authorAssociation' => [
			'name' => 'authorAssociation',
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
		'autoMerge' => [
			'name' => 'autoMerge',
			'type' => '\App\Dto\Test\Schema\AutoMergeDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/AutoMerge',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'draft' => [
			'name' => 'draft',
			'type' => 'bool',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'merged' => [
			'name' => 'merged',
			'type' => 'bool',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'mergeable' => [
			'name' => 'mergeable',
			'type' => 'bool',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'rebaseable' => [
			'name' => 'rebaseable',
			'type' => 'bool',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'mergeableState' => [
			'name' => 'mergeableState',
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
		'mergedBy' => [
			'name' => 'mergedBy',
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
		'comments' => [
			'name' => 'comments',
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
		'reviewComments' => [
			'name' => 'reviewComments',
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
		'maintainerCanModify' => [
			'name' => 'maintainerCanModify',
			'type' => 'bool',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'commits' => [
			'name' => 'commits',
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
		'additions' => [
			'name' => 'additions',
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
		'deletions' => [
			'name' => 'deletions',
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
		'changedFiles' => [
			'name' => 'changedFiles',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'url' => 'url',
			'id' => 'id',
			'node_id' => 'nodeId',
			'html_url' => 'htmlUrl',
			'diff_url' => 'diffUrl',
			'patch_url' => 'patchUrl',
			'issue_url' => 'issueUrl',
			'commits_url' => 'commitsUrl',
			'review_comments_url' => 'reviewCommentsUrl',
			'review_comment_url' => 'reviewCommentUrl',
			'comments_url' => 'commentsUrl',
			'statuses_url' => 'statusesUrl',
			'number' => 'number',
			'state' => 'state',
			'locked' => 'locked',
			'title' => 'title',
			'user' => 'user',
			'body' => 'body',
			'labels' => 'labels',
			'milestone' => 'milestone',
			'active_lock_reason' => 'activeLockReason',
			'created_at' => 'createdAt',
			'updated_at' => 'updatedAt',
			'closed_at' => 'closedAt',
			'merged_at' => 'mergedAt',
			'merge_commit_sha' => 'mergeCommitSha',
			'assignee' => 'assignee',
			'assignees' => 'assignees',
			'requested_reviewers' => 'requestedReviewers',
			'requested_teams' => 'requestedTeams',
			'head' => 'head',
			'base' => 'base',
			'author_association' => 'authorAssociation',
			'auto_merge' => 'autoMerge',
			'draft' => 'draft',
			'merged' => 'merged',
			'mergeable' => 'mergeable',
			'rebaseable' => 'rebaseable',
			'mergeable_state' => 'mergeableState',
			'merged_by' => 'mergedBy',
			'comments' => 'comments',
			'review_comments' => 'reviewComments',
			'maintainer_can_modify' => 'maintainerCanModify',
			'commits' => 'commits',
			'additions' => 'additions',
			'deletions' => 'deletions',
			'changed_files' => 'changedFiles',
		],
		'dashed' => [
			'url' => 'url',
			'id' => 'id',
			'node-id' => 'nodeId',
			'html-url' => 'htmlUrl',
			'diff-url' => 'diffUrl',
			'patch-url' => 'patchUrl',
			'issue-url' => 'issueUrl',
			'commits-url' => 'commitsUrl',
			'review-comments-url' => 'reviewCommentsUrl',
			'review-comment-url' => 'reviewCommentUrl',
			'comments-url' => 'commentsUrl',
			'statuses-url' => 'statusesUrl',
			'number' => 'number',
			'state' => 'state',
			'locked' => 'locked',
			'title' => 'title',
			'user' => 'user',
			'body' => 'body',
			'labels' => 'labels',
			'milestone' => 'milestone',
			'active-lock-reason' => 'activeLockReason',
			'created-at' => 'createdAt',
			'updated-at' => 'updatedAt',
			'closed-at' => 'closedAt',
			'merged-at' => 'mergedAt',
			'merge-commit-sha' => 'mergeCommitSha',
			'assignee' => 'assignee',
			'assignees' => 'assignees',
			'requested-reviewers' => 'requestedReviewers',
			'requested-teams' => 'requestedTeams',
			'head' => 'head',
			'base' => 'base',
			'author-association' => 'authorAssociation',
			'auto-merge' => 'autoMerge',
			'draft' => 'draft',
			'merged' => 'merged',
			'mergeable' => 'mergeable',
			'rebaseable' => 'rebaseable',
			'mergeable-state' => 'mergeableState',
			'merged-by' => 'mergedBy',
			'comments' => 'comments',
			'review-comments' => 'reviewComments',
			'maintainer-can-modify' => 'maintainerCanModify',
			'commits' => 'commits',
			'additions' => 'additions',
			'deletions' => 'deletions',
			'changed-files' => 'changedFiles',
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
	 * @param string $diffUrl
	 *
	 * @return $this
	 */
	public function setDiffUrl(string $diffUrl) {
		$this->diffUrl = $diffUrl;
		$this->_touchedFields[self::FIELD_DIFF_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDiffUrl(): string {
		return $this->diffUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDiffUrl(): bool {
		return $this->diffUrl !== null;
	}

	/**
	 * @param string $patchUrl
	 *
	 * @return $this
	 */
	public function setPatchUrl(string $patchUrl) {
		$this->patchUrl = $patchUrl;
		$this->_touchedFields[self::FIELD_PATCH_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPatchUrl(): string {
		return $this->patchUrl;
	}

	/**
	 * @return bool
	 */
	public function hasPatchUrl(): bool {
		return $this->patchUrl !== null;
	}

	/**
	 * @param string $issueUrl
	 *
	 * @return $this
	 */
	public function setIssueUrl(string $issueUrl) {
		$this->issueUrl = $issueUrl;
		$this->_touchedFields[self::FIELD_ISSUE_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIssueUrl(): string {
		return $this->issueUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueUrl(): bool {
		return $this->issueUrl !== null;
	}

	/**
	 * @param string $commitsUrl
	 *
	 * @return $this
	 */
	public function setCommitsUrl(string $commitsUrl) {
		$this->commitsUrl = $commitsUrl;
		$this->_touchedFields[self::FIELD_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCommitsUrl(): string {
		return $this->commitsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCommitsUrl(): bool {
		return $this->commitsUrl !== null;
	}

	/**
	 * @param string $reviewCommentsUrl
	 *
	 * @return $this
	 */
	public function setReviewCommentsUrl(string $reviewCommentsUrl) {
		$this->reviewCommentsUrl = $reviewCommentsUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReviewCommentsUrl(): string {
		return $this->reviewCommentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReviewCommentsUrl(): bool {
		return $this->reviewCommentsUrl !== null;
	}

	/**
	 * @param string $reviewCommentUrl
	 *
	 * @return $this
	 */
	public function setReviewCommentUrl(string $reviewCommentUrl) {
		$this->reviewCommentUrl = $reviewCommentUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReviewCommentUrl(): string {
		return $this->reviewCommentUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReviewCommentUrl(): bool {
		return $this->reviewCommentUrl !== null;
	}

	/**
	 * @param string $commentsUrl
	 *
	 * @return $this
	 */
	public function setCommentsUrl(string $commentsUrl) {
		$this->commentsUrl = $commentsUrl;
		$this->_touchedFields[self::FIELD_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCommentsUrl(): string {
		return $this->commentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCommentsUrl(): bool {
		return $this->commentsUrl !== null;
	}

	/**
	 * @param string $statusesUrl
	 *
	 * @return $this
	 */
	public function setStatusesUrl(string $statusesUrl) {
		$this->statusesUrl = $statusesUrl;
		$this->_touchedFields[self::FIELD_STATUSES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatusesUrl(): string {
		return $this->statusesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStatusesUrl(): bool {
		return $this->statusesUrl !== null;
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
	 * @param bool $locked
	 *
	 * @return $this
	 */
	public function setLocked(bool $locked) {
		$this->locked = $locked;
		$this->_touchedFields[self::FIELD_LOCKED] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getLocked(): bool {
		return $this->locked;
	}

	/**
	 * @return bool
	 */
	public function hasLocked(): bool {
		return $this->locked !== null;
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
	 * @param \App\Dto\Test\Schema\SimpleUserDto $user
	 *
	 * @return $this
	 */
	public function setUser(\App\Dto\Test\Schema\SimpleUserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\SimpleUserDto
	 */
	public function getUser(): \App\Dto\Test\Schema\SimpleUserDto {
		return $this->user;
	}

	/**
	 * @return bool
	 */
	public function hasUser(): bool {
		return $this->user !== null;
	}

	/**
	 * @param string|null $body
	 *
	 * @return $this
	 */
	public function setBody(?string $body) {
		$this->body = $body;
		$this->_touchedFields[self::FIELD_BODY] = true;

		return $this;
	}

	/**
	 * @param string $body
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setBodyOrFail(string $body) {
		$this->body = $body;
		$this->_touchedFields[self::FIELD_BODY] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getBody(): ?string {
		return $this->body;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getBodyOrFail(): string {
		if ($this->body === null) {
			throw new \RuntimeException('Value not set for field `body` (expected to be not null)');
		}

		return $this->body;
	}

	/**
	 * @return bool
	 */
	public function hasBody(): bool {
		return $this->body !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\LabelDto[]|\ArrayObject $labels
	 *
	 * @return $this
	 */
	public function setLabels(\ArrayObject $labels) {
		$this->labels = $labels;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\LabelDto[]|\ArrayObject
	 */
	public function getLabels(): \ArrayObject {
		if ($this->labels === null) {
			return new \ArrayObject([]);
		}

		return $this->labels;
	}

	/**
	 * @param string|int $key
	 *
	 * @return \App\Dto\Test\Schema\LabelDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getLabel($key): \App\Dto\Test\Schema\LabelDto {
		if (!isset($this->labels[$key])) {
			throw new \RuntimeException(sprintf('Value not set for field `labels` and key `%s` (expected to be not null)', $key));
		}

		return $this->labels[$key];
	}

	/**
	 * @return bool
	 */
	public function hasLabels(): bool {
		if ($this->labels === null) {
			return false;
		}

		return $this->labels->count() > 0;
	}

	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function hasLabel($key): bool {
		return isset($this->labels[$key]);
	}

	/**
	 * @param string|int $key
	 * @param \App\Dto\Test\Schema\LabelDto $label
	 * @return $this
	 */
	public function addLabel($key, \App\Dto\Test\Schema\LabelDto $label) {
		if ($this->labels === null) {
			$this->labels = new \ArrayObject([]);
		}

		$this->labels[$key] = $label;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\MilestoneDto|null $milestone
	 *
	 * @return $this
	 */
	public function setMilestone(?\App\Dto\Test\Schema\MilestoneDto $milestone) {
		$this->milestone = $milestone;
		$this->_touchedFields[self::FIELD_MILESTONE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\MilestoneDto $milestone
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMilestoneOrFail(\App\Dto\Test\Schema\MilestoneDto $milestone) {
		$this->milestone = $milestone;
		$this->_touchedFields[self::FIELD_MILESTONE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\MilestoneDto|null
	 */
	public function getMilestone(): ?\App\Dto\Test\Schema\MilestoneDto {
		return $this->milestone;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\MilestoneDto
	 */
	public function getMilestoneOrFail(): \App\Dto\Test\Schema\MilestoneDto {
		if ($this->milestone === null) {
			throw new \RuntimeException('Value not set for field `milestone` (expected to be not null)');
		}

		return $this->milestone;
	}

	/**
	 * @return bool
	 */
	public function hasMilestone(): bool {
		return $this->milestone !== null;
	}

	/**
	 * @param string|null $activeLockReason
	 *
	 * @return $this
	 */
	public function setActiveLockReason(?string $activeLockReason) {
		$this->activeLockReason = $activeLockReason;
		$this->_touchedFields[self::FIELD_ACTIVE_LOCK_REASON] = true;

		return $this;
	}

	/**
	 * @param string $activeLockReason
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setActiveLockReasonOrFail(string $activeLockReason) {
		$this->activeLockReason = $activeLockReason;
		$this->_touchedFields[self::FIELD_ACTIVE_LOCK_REASON] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getActiveLockReason(): ?string {
		return $this->activeLockReason;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getActiveLockReasonOrFail(): string {
		if ($this->activeLockReason === null) {
			throw new \RuntimeException('Value not set for field `activeLockReason` (expected to be not null)');
		}

		return $this->activeLockReason;
	}

	/**
	 * @return bool
	 */
	public function hasActiveLockReason(): bool {
		return $this->activeLockReason !== null;
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
	 * @param string|null $mergedAt
	 *
	 * @return $this
	 */
	public function setMergedAt(?string $mergedAt) {
		$this->mergedAt = $mergedAt;
		$this->_touchedFields[self::FIELD_MERGED_AT] = true;

		return $this;
	}

	/**
	 * @param string $mergedAt
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergedAtOrFail(string $mergedAt) {
		$this->mergedAt = $mergedAt;
		$this->_touchedFields[self::FIELD_MERGED_AT] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMergedAt(): ?string {
		return $this->mergedAt;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMergedAtOrFail(): string {
		if ($this->mergedAt === null) {
			throw new \RuntimeException('Value not set for field `mergedAt` (expected to be not null)');
		}

		return $this->mergedAt;
	}

	/**
	 * @return bool
	 */
	public function hasMergedAt(): bool {
		return $this->mergedAt !== null;
	}

	/**
	 * @param string|null $mergeCommitSha
	 *
	 * @return $this
	 */
	public function setMergeCommitSha(?string $mergeCommitSha) {
		$this->mergeCommitSha = $mergeCommitSha;
		$this->_touchedFields[self::FIELD_MERGE_COMMIT_SHA] = true;

		return $this;
	}

	/**
	 * @param string $mergeCommitSha
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergeCommitShaOrFail(string $mergeCommitSha) {
		$this->mergeCommitSha = $mergeCommitSha;
		$this->_touchedFields[self::FIELD_MERGE_COMMIT_SHA] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMergeCommitSha(): ?string {
		return $this->mergeCommitSha;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMergeCommitShaOrFail(): string {
		if ($this->mergeCommitSha === null) {
			throw new \RuntimeException('Value not set for field `mergeCommitSha` (expected to be not null)');
		}

		return $this->mergeCommitSha;
	}

	/**
	 * @return bool
	 */
	public function hasMergeCommitSha(): bool {
		return $this->mergeCommitSha !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto|null $assignee
	 *
	 * @return $this
	 */
	public function setAssignee(?\App\Dto\Test\Schema\SimpleUserDto $assignee) {
		$this->assignee = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto $assignee
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAssigneeOrFail(\App\Dto\Test\Schema\SimpleUserDto $assignee) {
		$this->assignee = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	public function getAssignee(): ?\App\Dto\Test\Schema\SimpleUserDto {
		return $this->assignee;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\SimpleUserDto
	 */
	public function getAssigneeOrFail(): \App\Dto\Test\Schema\SimpleUserDto {
		if ($this->assignee === null) {
			throw new \RuntimeException('Value not set for field `assignee` (expected to be not null)');
		}

		return $this->assignee;
	}

	/**
	 * @return bool
	 */
	public function hasAssignee(): bool {
		return $this->assignee !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\AssigneeDto[]|\ArrayObject $assignees
	 *
	 * @return $this
	 */
	public function setAssignees(\ArrayObject $assignees) {
		$this->assignees = $assignees;
		$this->_touchedFields[self::FIELD_ASSIGNEES] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\AssigneeDto[]|\ArrayObject
	 */
	public function getAssignees(): \ArrayObject {
		if ($this->assignees === null) {
			return new \ArrayObject([]);
		}

		return $this->assignees;
	}

	/**
	 * @param string|int $key
	 *
	 * @return \App\Dto\Test\Schema\AssigneeDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getAssignee($key): \App\Dto\Test\Schema\AssigneeDto {
		if (!isset($this->assignees[$key])) {
			throw new \RuntimeException(sprintf('Value not set for field `assignees` and key `%s` (expected to be not null)', $key));
		}

		return $this->assignees[$key];
	}

	/**
	 * @return bool
	 */
	public function hasAssignees(): bool {
		if ($this->assignees === null) {
			return false;
		}

		return $this->assignees->count() > 0;
	}

	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function hasAssignee($key): bool {
		return isset($this->assignees[$key]);
	}

	/**
	 * @param string|int $key
	 * @param \App\Dto\Test\Schema\AssigneeDto $assignee
	 * @return $this
	 */
	public function addAssignee($key, \App\Dto\Test\Schema\AssigneeDto $assignee) {
		if ($this->assignees === null) {
			$this->assignees = new \ArrayObject([]);
		}

		$this->assignees[$key] = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEES] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\RequestedReviewerDto[]|\ArrayObject $requestedReviewers
	 *
	 * @return $this
	 */
	public function setRequestedReviewers(\ArrayObject $requestedReviewers) {
		$this->requestedReviewers = $requestedReviewers;
		$this->_touchedFields[self::FIELD_REQUESTED_REVIEWERS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\RequestedReviewerDto[]|\ArrayObject
	 */
	public function getRequestedReviewers(): \ArrayObject {
		if ($this->requestedReviewers === null) {
			return new \ArrayObject([]);
		}

		return $this->requestedReviewers;
	}

	/**
	 * @param string|int $key
	 *
	 * @return \App\Dto\Test\Schema\RequestedReviewerDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getRequestedReviewer($key): \App\Dto\Test\Schema\RequestedReviewerDto {
		if (!isset($this->requestedReviewers[$key])) {
			throw new \RuntimeException(sprintf('Value not set for field `requestedReviewers` and key `%s` (expected to be not null)', $key));
		}

		return $this->requestedReviewers[$key];
	}

	/**
	 * @return bool
	 */
	public function hasRequestedReviewers(): bool {
		if ($this->requestedReviewers === null) {
			return false;
		}

		return $this->requestedReviewers->count() > 0;
	}

	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function hasRequestedReviewer($key): bool {
		return isset($this->requestedReviewers[$key]);
	}

	/**
	 * @param string|int $key
	 * @param \App\Dto\Test\Schema\RequestedReviewerDto $requestedReviewer
	 * @return $this
	 */
	public function addRequestedReviewer($key, \App\Dto\Test\Schema\RequestedReviewerDto $requestedReviewer) {
		if ($this->requestedReviewers === null) {
			$this->requestedReviewers = new \ArrayObject([]);
		}

		$this->requestedReviewers[$key] = $requestedReviewer;
		$this->_touchedFields[self::FIELD_REQUESTED_REVIEWERS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\RequestedTeamDto[]|\ArrayObject $requestedTeams
	 *
	 * @return $this
	 */
	public function setRequestedTeams(\ArrayObject $requestedTeams) {
		$this->requestedTeams = $requestedTeams;
		$this->_touchedFields[self::FIELD_REQUESTED_TEAMS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\RequestedTeamDto[]|\ArrayObject
	 */
	public function getRequestedTeams(): \ArrayObject {
		if ($this->requestedTeams === null) {
			return new \ArrayObject([]);
		}

		return $this->requestedTeams;
	}

	/**
	 * @param string|int $key
	 *
	 * @return \App\Dto\Test\Schema\RequestedTeamDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getRequestedTeam($key): \App\Dto\Test\Schema\RequestedTeamDto {
		if (!isset($this->requestedTeams[$key])) {
			throw new \RuntimeException(sprintf('Value not set for field `requestedTeams` and key `%s` (expected to be not null)', $key));
		}

		return $this->requestedTeams[$key];
	}

	/**
	 * @return bool
	 */
	public function hasRequestedTeams(): bool {
		if ($this->requestedTeams === null) {
			return false;
		}

		return $this->requestedTeams->count() > 0;
	}

	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function hasRequestedTeam($key): bool {
		return isset($this->requestedTeams[$key]);
	}

	/**
	 * @param string|int $key
	 * @param \App\Dto\Test\Schema\RequestedTeamDto $requestedTeam
	 * @return $this
	 */
	public function addRequestedTeam($key, \App\Dto\Test\Schema\RequestedTeamDto $requestedTeam) {
		if ($this->requestedTeams === null) {
			$this->requestedTeams = new \ArrayObject([]);
		}

		$this->requestedTeams[$key] = $requestedTeam;
		$this->_touchedFields[self::FIELD_REQUESTED_TEAMS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\HeadDto $head
	 *
	 * @return $this
	 */
	public function setHead(\App\Dto\Test\Schema\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[self::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\HeadDto
	 */
	public function getHead(): \App\Dto\Test\Schema\HeadDto {
		return $this->head;
	}

	/**
	 * @return bool
	 */
	public function hasHead(): bool {
		return $this->head !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\BaseDto $base
	 *
	 * @return $this
	 */
	public function setBase(\App\Dto\Test\Schema\BaseDto $base) {
		$this->base = $base;
		$this->_touchedFields[self::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\BaseDto
	 */
	public function getBase(): \App\Dto\Test\Schema\BaseDto {
		return $this->base;
	}

	/**
	 * @return bool
	 */
	public function hasBase(): bool {
		return $this->base !== null;
	}

	/**
	 * @param string $authorAssociation
	 *
	 * @return $this
	 */
	public function setAuthorAssociation(string $authorAssociation) {
		$this->authorAssociation = $authorAssociation;
		$this->_touchedFields[self::FIELD_AUTHOR_ASSOCIATION] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthorAssociation(): string {
		return $this->authorAssociation;
	}

	/**
	 * @return bool
	 */
	public function hasAuthorAssociation(): bool {
		return $this->authorAssociation !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\AutoMergeDto|null $autoMerge
	 *
	 * @return $this
	 */
	public function setAutoMerge(?\App\Dto\Test\Schema\AutoMergeDto $autoMerge) {
		$this->autoMerge = $autoMerge;
		$this->_touchedFields[self::FIELD_AUTO_MERGE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\AutoMergeDto $autoMerge
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAutoMergeOrFail(\App\Dto\Test\Schema\AutoMergeDto $autoMerge) {
		$this->autoMerge = $autoMerge;
		$this->_touchedFields[self::FIELD_AUTO_MERGE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\AutoMergeDto|null
	 */
	public function getAutoMerge(): ?\App\Dto\Test\Schema\AutoMergeDto {
		return $this->autoMerge;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\AutoMergeDto
	 */
	public function getAutoMergeOrFail(): \App\Dto\Test\Schema\AutoMergeDto {
		if ($this->autoMerge === null) {
			throw new \RuntimeException('Value not set for field `autoMerge` (expected to be not null)');
		}

		return $this->autoMerge;
	}

	/**
	 * @return bool
	 */
	public function hasAutoMerge(): bool {
		return $this->autoMerge !== null;
	}

	/**
	 * @param bool|null $draft
	 *
	 * @return $this
	 */
	public function setDraft(?bool $draft) {
		$this->draft = $draft;
		$this->_touchedFields[self::FIELD_DRAFT] = true;

		return $this;
	}

	/**
	 * @param bool $draft
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDraftOrFail(bool $draft) {
		$this->draft = $draft;
		$this->_touchedFields[self::FIELD_DRAFT] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getDraft(): ?bool {
		return $this->draft;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getDraftOrFail(): bool {
		if ($this->draft === null) {
			throw new \RuntimeException('Value not set for field `draft` (expected to be not null)');
		}

		return $this->draft;
	}

	/**
	 * @return bool
	 */
	public function hasDraft(): bool {
		return $this->draft !== null;
	}

	/**
	 * @param bool $merged
	 *
	 * @return $this
	 */
	public function setMerged(bool $merged) {
		$this->merged = $merged;
		$this->_touchedFields[self::FIELD_MERGED] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getMerged(): bool {
		return $this->merged;
	}

	/**
	 * @return bool
	 */
	public function hasMerged(): bool {
		return $this->merged !== null;
	}

	/**
	 * @param bool|null $mergeable
	 *
	 * @return $this
	 */
	public function setMergeable(?bool $mergeable) {
		$this->mergeable = $mergeable;
		$this->_touchedFields[self::FIELD_MERGEABLE] = true;

		return $this;
	}

	/**
	 * @param bool $mergeable
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergeableOrFail(bool $mergeable) {
		$this->mergeable = $mergeable;
		$this->_touchedFields[self::FIELD_MERGEABLE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getMergeable(): ?bool {
		return $this->mergeable;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getMergeableOrFail(): bool {
		if ($this->mergeable === null) {
			throw new \RuntimeException('Value not set for field `mergeable` (expected to be not null)');
		}

		return $this->mergeable;
	}

	/**
	 * @return bool
	 */
	public function hasMergeable(): bool {
		return $this->mergeable !== null;
	}

	/**
	 * @param bool|null $rebaseable
	 *
	 * @return $this
	 */
	public function setRebaseable(?bool $rebaseable) {
		$this->rebaseable = $rebaseable;
		$this->_touchedFields[self::FIELD_REBASEABLE] = true;

		return $this;
	}

	/**
	 * @param bool $rebaseable
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setRebaseableOrFail(bool $rebaseable) {
		$this->rebaseable = $rebaseable;
		$this->_touchedFields[self::FIELD_REBASEABLE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getRebaseable(): ?bool {
		return $this->rebaseable;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getRebaseableOrFail(): bool {
		if ($this->rebaseable === null) {
			throw new \RuntimeException('Value not set for field `rebaseable` (expected to be not null)');
		}

		return $this->rebaseable;
	}

	/**
	 * @return bool
	 */
	public function hasRebaseable(): bool {
		return $this->rebaseable !== null;
	}

	/**
	 * @param string $mergeableState
	 *
	 * @return $this
	 */
	public function setMergeableState(string $mergeableState) {
		$this->mergeableState = $mergeableState;
		$this->_touchedFields[self::FIELD_MERGEABLE_STATE] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMergeableState(): string {
		return $this->mergeableState;
	}

	/**
	 * @return bool
	 */
	public function hasMergeableState(): bool {
		return $this->mergeableState !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto|null $mergedBy
	 *
	 * @return $this
	 */
	public function setMergedBy(?\App\Dto\Test\Schema\SimpleUserDto $mergedBy) {
		$this->mergedBy = $mergedBy;
		$this->_touchedFields[self::FIELD_MERGED_BY] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\SimpleUserDto $mergedBy
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergedByOrFail(\App\Dto\Test\Schema\SimpleUserDto $mergedBy) {
		$this->mergedBy = $mergedBy;
		$this->_touchedFields[self::FIELD_MERGED_BY] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\SimpleUserDto|null
	 */
	public function getMergedBy(): ?\App\Dto\Test\Schema\SimpleUserDto {
		return $this->mergedBy;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\SimpleUserDto
	 */
	public function getMergedByOrFail(): \App\Dto\Test\Schema\SimpleUserDto {
		if ($this->mergedBy === null) {
			throw new \RuntimeException('Value not set for field `mergedBy` (expected to be not null)');
		}

		return $this->mergedBy;
	}

	/**
	 * @return bool
	 */
	public function hasMergedBy(): bool {
		return $this->mergedBy !== null;
	}

	/**
	 * @param int $comments
	 *
	 * @return $this
	 */
	public function setComments(int $comments) {
		$this->comments = $comments;
		$this->_touchedFields[self::FIELD_COMMENTS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getComments(): int {
		return $this->comments;
	}

	/**
	 * @return bool
	 */
	public function hasComments(): bool {
		return $this->comments !== null;
	}

	/**
	 * @param int $reviewComments
	 *
	 * @return $this
	 */
	public function setReviewComments(int $reviewComments) {
		$this->reviewComments = $reviewComments;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getReviewComments(): int {
		return $this->reviewComments;
	}

	/**
	 * @return bool
	 */
	public function hasReviewComments(): bool {
		return $this->reviewComments !== null;
	}

	/**
	 * @param bool $maintainerCanModify
	 *
	 * @return $this
	 */
	public function setMaintainerCanModify(bool $maintainerCanModify) {
		$this->maintainerCanModify = $maintainerCanModify;
		$this->_touchedFields[self::FIELD_MAINTAINER_CAN_MODIFY] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getMaintainerCanModify(): bool {
		return $this->maintainerCanModify;
	}

	/**
	 * @return bool
	 */
	public function hasMaintainerCanModify(): bool {
		return $this->maintainerCanModify !== null;
	}

	/**
	 * @param int $commits
	 *
	 * @return $this
	 */
	public function setCommits(int $commits) {
		$this->commits = $commits;
		$this->_touchedFields[self::FIELD_COMMITS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCommits(): int {
		return $this->commits;
	}

	/**
	 * @return bool
	 */
	public function hasCommits(): bool {
		return $this->commits !== null;
	}

	/**
	 * @param int $additions
	 *
	 * @return $this
	 */
	public function setAdditions(int $additions) {
		$this->additions = $additions;
		$this->_touchedFields[self::FIELD_ADDITIONS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAdditions(): int {
		return $this->additions;
	}

	/**
	 * @return bool
	 */
	public function hasAdditions(): bool {
		return $this->additions !== null;
	}

	/**
	 * @param int $deletions
	 *
	 * @return $this
	 */
	public function setDeletions(int $deletions) {
		$this->deletions = $deletions;
		$this->_touchedFields[self::FIELD_DELETIONS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDeletions(): int {
		return $this->deletions;
	}

	/**
	 * @return bool
	 */
	public function hasDeletions(): bool {
		return $this->deletions !== null;
	}

	/**
	 * @param int $changedFiles
	 *
	 * @return $this
	 */
	public function setChangedFiles(int $changedFiles) {
		$this->changedFiles = $changedFiles;
		$this->_touchedFields[self::FIELD_CHANGED_FILES] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getChangedFiles(): int {
		return $this->changedFiles;
	}

	/**
	 * @return bool
	 */
	public function hasChangedFiles(): bool {
		return $this->changedFiles !== null;
	}

}
