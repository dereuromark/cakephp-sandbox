<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/Object DTO
 *
 * @property string|null $url
 * @property int|null $id
 * @property string|null $nodeId
 * @property string|null $htmlUrl
 * @property string|null $diffUrl
 * @property string|null $patchUrl
 * @property string|null $issueUrl
 * @property string|null $commitsUrl
 * @property string|null $reviewCommentsUrl
 * @property string|null $reviewCommentUrl
 * @property string|null $commentsUrl
 * @property string|null $statusesUrl
 * @property int|null $number
 * @property string|null $state
 * @property bool|null $locked
 * @property string|null $title
 * @property \App\Dto\Test\Data\UserDto|null $user
 * @property string|null $body
 * @property \App\Dto\Test\Data\LabelDto[]|\ArrayObject $labels
 * @property \App\Dto\Test\Data\MilestoneDto|null $milestone
 * @property string|null $activeLockReason
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property string|null $closedAt
 * @property string|null $mergedAt
 * @property string|null $mergeCommitSha
 * @property \App\Dto\Test\Data\AssigneeDto|null $assignee
 * @property \App\Dto\Test\Data\AssigneeDto[]|\ArrayObject $assignees
 * @property \App\Dto\Test\Data\RequestedReviewerDto[]|\ArrayObject $requestedReviewers
 * @property \App\Dto\Test\Data\RequestedTeamDto[]|\ArrayObject $requestedTeams
 * @property \App\Dto\Test\Data\HeadDto|null $head
 * @property \App\Dto\Test\Data\BaseDto|null $base
 * @property string|null $authorAssociation
 * @property mixed|null $autoMerge
 * @property bool|null $draft
 * @property bool|null $merged
 * @property bool|null $mergeable
 * @property bool|null $rebaseable
 * @property string|null $mergeableState
 * @property \App\Dto\Test\Data\MergedByDto|null $mergedBy
 * @property int|null $comments
 * @property int|null $reviewComments
 * @property bool|null $maintainerCanModify
 * @property int|null $commits
 * @property int|null $additions
 * @property int|null $deletions
 * @property int|null $changedFiles
 */
class ObjectDto extends \CakeDto\Dto\AbstractDto {

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
	 * @var string|null
	 */
	protected $url;

	/**
	 * @var int|null
	 */
	protected $id;

	/**
	 * @var string|null
	 */
	protected $nodeId;

	/**
	 * @var string|null
	 */
	protected $htmlUrl;

	/**
	 * @var string|null
	 */
	protected $diffUrl;

	/**
	 * @var string|null
	 */
	protected $patchUrl;

	/**
	 * @var string|null
	 */
	protected $issueUrl;

	/**
	 * @var string|null
	 */
	protected $commitsUrl;

	/**
	 * @var string|null
	 */
	protected $reviewCommentsUrl;

	/**
	 * @var string|null
	 */
	protected $reviewCommentUrl;

	/**
	 * @var string|null
	 */
	protected $commentsUrl;

	/**
	 * @var string|null
	 */
	protected $statusesUrl;

	/**
	 * @var int|null
	 */
	protected $number;

	/**
	 * @var string|null
	 */
	protected $state;

	/**
	 * @var bool|null
	 */
	protected $locked;

	/**
	 * @var string|null
	 */
	protected $title;

	/**
	 * @var \App\Dto\Test\Data\UserDto|null
	 */
	protected $user;

	/**
	 * @var string|null
	 */
	protected $body;

	/**
	 * @var \App\Dto\Test\Data\LabelDto[]|\ArrayObject
	 */
	protected $labels;

	/**
	 * @var \App\Dto\Test\Data\MilestoneDto|null
	 */
	protected $milestone;

	/**
	 * @var string|null
	 */
	protected $activeLockReason;

	/**
	 * @var string|null
	 */
	protected $createdAt;

	/**
	 * @var string|null
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
	 * @var \App\Dto\Test\Data\AssigneeDto|null
	 */
	protected $assignee;

	/**
	 * @var \App\Dto\Test\Data\AssigneeDto[]|\ArrayObject
	 */
	protected $assignees;

	/**
	 * @var \App\Dto\Test\Data\RequestedReviewerDto[]|\ArrayObject
	 */
	protected $requestedReviewers;

	/**
	 * @var \App\Dto\Test\Data\RequestedTeamDto[]|\ArrayObject
	 */
	protected $requestedTeams;

	/**
	 * @var \App\Dto\Test\Data\HeadDto|null
	 */
	protected $head;

	/**
	 * @var \App\Dto\Test\Data\BaseDto|null
	 */
	protected $base;

	/**
	 * @var string|null
	 */
	protected $authorAssociation;

	/**
	 * @var mixed|null
	 */
	protected $autoMerge;

	/**
	 * @var bool|null
	 */
	protected $draft;

	/**
	 * @var bool|null
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
	 * @var string|null
	 */
	protected $mergeableState;

	/**
	 * @var \App\Dto\Test\Data\MergedByDto|null
	 */
	protected $mergedBy;

	/**
	 * @var int|null
	 */
	protected $comments;

	/**
	 * @var int|null
	 */
	protected $reviewComments;

	/**
	 * @var bool|null
	 */
	protected $maintainerCanModify;

	/**
	 * @var int|null
	 */
	protected $commits;

	/**
	 * @var int|null
	 */
	protected $additions;

	/**
	 * @var int|null
	 */
	protected $deletions;

	/**
	 * @var int|null
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'type' => '\App\Dto\Test\Data\UserDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/User',
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
			'type' => '\App\Dto\Test\Data\LabelDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'name',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Data\LabelDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Data\LabelDto',
		],
		'milestone' => [
			'name' => 'milestone',
			'type' => '\App\Dto\Test\Data\MilestoneDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Milestone',
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
			'required' => false,
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
			'required' => false,
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
			'type' => '\App\Dto\Test\Data\AssigneeDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Assignee',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'assignees' => [
			'name' => 'assignees',
			'type' => '\App\Dto\Test\Data\AssigneeDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'login',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Data\AssigneeDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Data\AssigneeDto',
		],
		'requestedReviewers' => [
			'name' => 'requestedReviewers',
			'type' => '\App\Dto\Test\Data\RequestedReviewerDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'login',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Data\RequestedReviewerDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Data\RequestedReviewerDto',
		],
		'requestedTeams' => [
			'name' => 'requestedTeams',
			'type' => '\App\Dto\Test\Data\RequestedTeamDto[]|\ArrayObject',
			'associative' => true,
			'key' => 'slug',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => '\ArrayObject',
			'serialize' => null,
			'factory' => null,
			'singularType' => '\App\Dto\Test\Data\RequestedTeamDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\Test\Data\RequestedTeamDto',
		],
		'head' => [
			'name' => 'head',
			'type' => '\App\Dto\Test\Data\HeadDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Head',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'base' => [
			'name' => 'base',
			'type' => '\App\Dto\Test\Data\BaseDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Base',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'authorAssociation' => [
			'name' => 'authorAssociation',
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
		'autoMerge' => [
			'name' => 'autoMerge',
			'type' => 'mixed',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
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
			'required' => false,
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
			'required' => false,
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
			'type' => '\App\Dto\Test\Data\MergedByDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/MergedBy',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'comments' => [
			'name' => 'comments',
			'type' => 'int',
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
	 * @param string|null $url
	 *
	 * @return $this
	 */
	public function setUrl(?string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @param string $url
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUrlOrFail(string $url) {
		$this->url = $url;
		$this->_touchedFields[self::FIELD_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string {
		return $this->url;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getUrlOrFail(): string {
		if ($this->url === null) {
			throw new \RuntimeException('Value not set for field `url` (expected to be not null)');
		}

		return $this->url;
	}

	/**
	 * @return bool
	 */
	public function hasUrl(): bool {
		return $this->url !== null;
	}

	/**
	 * @param int|null $id
	 *
	 * @return $this
	 */
	public function setId(?int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @param int $id
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIdOrFail(int $id) {
		$this->id = $id;
		$this->_touchedFields[self::FIELD_ID] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getIdOrFail(): int {
		if ($this->id === null) {
			throw new \RuntimeException('Value not set for field `id` (expected to be not null)');
		}

		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string|null $nodeId
	 *
	 * @return $this
	 */
	public function setNodeId(?string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @param string $nodeId
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNodeIdOrFail(string $nodeId) {
		$this->nodeId = $nodeId;
		$this->_touchedFields[self::FIELD_NODE_ID] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNodeId(): ?string {
		return $this->nodeId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNodeIdOrFail(): string {
		if ($this->nodeId === null) {
			throw new \RuntimeException('Value not set for field `nodeId` (expected to be not null)');
		}

		return $this->nodeId;
	}

	/**
	 * @return bool
	 */
	public function hasNodeId(): bool {
		return $this->nodeId !== null;
	}

	/**
	 * @param string|null $htmlUrl
	 *
	 * @return $this
	 */
	public function setHtmlUrl(?string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @param string $htmlUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHtmlUrlOrFail(string $htmlUrl) {
		$this->htmlUrl = $htmlUrl;
		$this->_touchedFields[self::FIELD_HTML_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHtmlUrl(): ?string {
		return $this->htmlUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getHtmlUrlOrFail(): string {
		if ($this->htmlUrl === null) {
			throw new \RuntimeException('Value not set for field `htmlUrl` (expected to be not null)');
		}

		return $this->htmlUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHtmlUrl(): bool {
		return $this->htmlUrl !== null;
	}

	/**
	 * @param string|null $diffUrl
	 *
	 * @return $this
	 */
	public function setDiffUrl(?string $diffUrl) {
		$this->diffUrl = $diffUrl;
		$this->_touchedFields[self::FIELD_DIFF_URL] = true;

		return $this;
	}

	/**
	 * @param string $diffUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDiffUrlOrFail(string $diffUrl) {
		$this->diffUrl = $diffUrl;
		$this->_touchedFields[self::FIELD_DIFF_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDiffUrl(): ?string {
		return $this->diffUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDiffUrlOrFail(): string {
		if ($this->diffUrl === null) {
			throw new \RuntimeException('Value not set for field `diffUrl` (expected to be not null)');
		}

		return $this->diffUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDiffUrl(): bool {
		return $this->diffUrl !== null;
	}

	/**
	 * @param string|null $patchUrl
	 *
	 * @return $this
	 */
	public function setPatchUrl(?string $patchUrl) {
		$this->patchUrl = $patchUrl;
		$this->_touchedFields[self::FIELD_PATCH_URL] = true;

		return $this;
	}

	/**
	 * @param string $patchUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPatchUrlOrFail(string $patchUrl) {
		$this->patchUrl = $patchUrl;
		$this->_touchedFields[self::FIELD_PATCH_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPatchUrl(): ?string {
		return $this->patchUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getPatchUrlOrFail(): string {
		if ($this->patchUrl === null) {
			throw new \RuntimeException('Value not set for field `patchUrl` (expected to be not null)');
		}

		return $this->patchUrl;
	}

	/**
	 * @return bool
	 */
	public function hasPatchUrl(): bool {
		return $this->patchUrl !== null;
	}

	/**
	 * @param string|null $issueUrl
	 *
	 * @return $this
	 */
	public function setIssueUrl(?string $issueUrl) {
		$this->issueUrl = $issueUrl;
		$this->_touchedFields[self::FIELD_ISSUE_URL] = true;

		return $this;
	}

	/**
	 * @param string $issueUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIssueUrlOrFail(string $issueUrl) {
		$this->issueUrl = $issueUrl;
		$this->_touchedFields[self::FIELD_ISSUE_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIssueUrl(): ?string {
		return $this->issueUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getIssueUrlOrFail(): string {
		if ($this->issueUrl === null) {
			throw new \RuntimeException('Value not set for field `issueUrl` (expected to be not null)');
		}

		return $this->issueUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueUrl(): bool {
		return $this->issueUrl !== null;
	}

	/**
	 * @param string|null $commitsUrl
	 *
	 * @return $this
	 */
	public function setCommitsUrl(?string $commitsUrl) {
		$this->commitsUrl = $commitsUrl;
		$this->_touchedFields[self::FIELD_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @param string $commitsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCommitsUrlOrFail(string $commitsUrl) {
		$this->commitsUrl = $commitsUrl;
		$this->_touchedFields[self::FIELD_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCommitsUrl(): ?string {
		return $this->commitsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCommitsUrlOrFail(): string {
		if ($this->commitsUrl === null) {
			throw new \RuntimeException('Value not set for field `commitsUrl` (expected to be not null)');
		}

		return $this->commitsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCommitsUrl(): bool {
		return $this->commitsUrl !== null;
	}

	/**
	 * @param string|null $reviewCommentsUrl
	 *
	 * @return $this
	 */
	public function setReviewCommentsUrl(?string $reviewCommentsUrl) {
		$this->reviewCommentsUrl = $reviewCommentsUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $reviewCommentsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReviewCommentsUrlOrFail(string $reviewCommentsUrl) {
		$this->reviewCommentsUrl = $reviewCommentsUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getReviewCommentsUrl(): ?string {
		return $this->reviewCommentsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getReviewCommentsUrlOrFail(): string {
		if ($this->reviewCommentsUrl === null) {
			throw new \RuntimeException('Value not set for field `reviewCommentsUrl` (expected to be not null)');
		}

		return $this->reviewCommentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReviewCommentsUrl(): bool {
		return $this->reviewCommentsUrl !== null;
	}

	/**
	 * @param string|null $reviewCommentUrl
	 *
	 * @return $this
	 */
	public function setReviewCommentUrl(?string $reviewCommentUrl) {
		$this->reviewCommentUrl = $reviewCommentUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @param string $reviewCommentUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReviewCommentUrlOrFail(string $reviewCommentUrl) {
		$this->reviewCommentUrl = $reviewCommentUrl;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getReviewCommentUrl(): ?string {
		return $this->reviewCommentUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getReviewCommentUrlOrFail(): string {
		if ($this->reviewCommentUrl === null) {
			throw new \RuntimeException('Value not set for field `reviewCommentUrl` (expected to be not null)');
		}

		return $this->reviewCommentUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReviewCommentUrl(): bool {
		return $this->reviewCommentUrl !== null;
	}

	/**
	 * @param string|null $commentsUrl
	 *
	 * @return $this
	 */
	public function setCommentsUrl(?string $commentsUrl) {
		$this->commentsUrl = $commentsUrl;
		$this->_touchedFields[self::FIELD_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $commentsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCommentsUrlOrFail(string $commentsUrl) {
		$this->commentsUrl = $commentsUrl;
		$this->_touchedFields[self::FIELD_COMMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCommentsUrl(): ?string {
		return $this->commentsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCommentsUrlOrFail(): string {
		if ($this->commentsUrl === null) {
			throw new \RuntimeException('Value not set for field `commentsUrl` (expected to be not null)');
		}

		return $this->commentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCommentsUrl(): bool {
		return $this->commentsUrl !== null;
	}

	/**
	 * @param string|null $statusesUrl
	 *
	 * @return $this
	 */
	public function setStatusesUrl(?string $statusesUrl) {
		$this->statusesUrl = $statusesUrl;
		$this->_touchedFields[self::FIELD_STATUSES_URL] = true;

		return $this;
	}

	/**
	 * @param string $statusesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setStatusesUrlOrFail(string $statusesUrl) {
		$this->statusesUrl = $statusesUrl;
		$this->_touchedFields[self::FIELD_STATUSES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getStatusesUrl(): ?string {
		return $this->statusesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getStatusesUrlOrFail(): string {
		if ($this->statusesUrl === null) {
			throw new \RuntimeException('Value not set for field `statusesUrl` (expected to be not null)');
		}

		return $this->statusesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStatusesUrl(): bool {
		return $this->statusesUrl !== null;
	}

	/**
	 * @param int|null $number
	 *
	 * @return $this
	 */
	public function setNumber(?int $number) {
		$this->number = $number;
		$this->_touchedFields[self::FIELD_NUMBER] = true;

		return $this;
	}

	/**
	 * @param int $number
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNumberOrFail(int $number) {
		$this->number = $number;
		$this->_touchedFields[self::FIELD_NUMBER] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getNumber(): ?int {
		return $this->number;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getNumberOrFail(): int {
		if ($this->number === null) {
			throw new \RuntimeException('Value not set for field `number` (expected to be not null)');
		}

		return $this->number;
	}

	/**
	 * @return bool
	 */
	public function hasNumber(): bool {
		return $this->number !== null;
	}

	/**
	 * @param string|null $state
	 *
	 * @return $this
	 */
	public function setState(?string $state) {
		$this->state = $state;
		$this->_touchedFields[self::FIELD_STATE] = true;

		return $this;
	}

	/**
	 * @param string $state
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setStateOrFail(string $state) {
		$this->state = $state;
		$this->_touchedFields[self::FIELD_STATE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getState(): ?string {
		return $this->state;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getStateOrFail(): string {
		if ($this->state === null) {
			throw new \RuntimeException('Value not set for field `state` (expected to be not null)');
		}

		return $this->state;
	}

	/**
	 * @return bool
	 */
	public function hasState(): bool {
		return $this->state !== null;
	}

	/**
	 * @param bool|null $locked
	 *
	 * @return $this
	 */
	public function setLocked(?bool $locked) {
		$this->locked = $locked;
		$this->_touchedFields[self::FIELD_LOCKED] = true;

		return $this;
	}

	/**
	 * @param bool $locked
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLockedOrFail(bool $locked) {
		$this->locked = $locked;
		$this->_touchedFields[self::FIELD_LOCKED] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getLocked(): ?bool {
		return $this->locked;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getLockedOrFail(): bool {
		if ($this->locked === null) {
			throw new \RuntimeException('Value not set for field `locked` (expected to be not null)');
		}

		return $this->locked;
	}

	/**
	 * @return bool
	 */
	public function hasLocked(): bool {
		return $this->locked !== null;
	}

	/**
	 * @param string|null $title
	 *
	 * @return $this
	 */
	public function setTitle(?string $title) {
		$this->title = $title;
		$this->_touchedFields[self::FIELD_TITLE] = true;

		return $this;
	}

	/**
	 * @param string $title
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTitleOrFail(string $title) {
		$this->title = $title;
		$this->_touchedFields[self::FIELD_TITLE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string {
		return $this->title;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTitleOrFail(): string {
		if ($this->title === null) {
			throw new \RuntimeException('Value not set for field `title` (expected to be not null)');
		}

		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function hasTitle(): bool {
		return $this->title !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\UserDto|null $user
	 *
	 * @return $this
	 */
	public function setUser(?\App\Dto\Test\Data\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\UserDto $user
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUserOrFail(\App\Dto\Test\Data\UserDto $user) {
		$this->user = $user;
		$this->_touchedFields[self::FIELD_USER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\UserDto|null
	 */
	public function getUser(): ?\App\Dto\Test\Data\UserDto {
		return $this->user;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\UserDto
	 */
	public function getUserOrFail(): \App\Dto\Test\Data\UserDto {
		if ($this->user === null) {
			throw new \RuntimeException('Value not set for field `user` (expected to be not null)');
		}

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
	 * @param \App\Dto\Test\Data\LabelDto[]|\ArrayObject $labels
	 *
	 * @return $this
	 */
	public function setLabels(\ArrayObject $labels) {
		$this->labels = $labels;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\LabelDto[]|\ArrayObject
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
	 * @return \App\Dto\Test\Data\LabelDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getLabel($key): \App\Dto\Test\Data\LabelDto {
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
	 * @param \App\Dto\Test\Data\LabelDto $label
	 * @return $this
	 */
	public function addLabel($key, \App\Dto\Test\Data\LabelDto $label) {
		if ($this->labels === null) {
			$this->labels = new \ArrayObject([]);
		}

		$this->labels[$key] = $label;
		$this->_touchedFields[self::FIELD_LABELS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\MilestoneDto|null $milestone
	 *
	 * @return $this
	 */
	public function setMilestone(?\App\Dto\Test\Data\MilestoneDto $milestone) {
		$this->milestone = $milestone;
		$this->_touchedFields[self::FIELD_MILESTONE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\MilestoneDto $milestone
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMilestoneOrFail(\App\Dto\Test\Data\MilestoneDto $milestone) {
		$this->milestone = $milestone;
		$this->_touchedFields[self::FIELD_MILESTONE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\MilestoneDto|null
	 */
	public function getMilestone(): ?\App\Dto\Test\Data\MilestoneDto {
		return $this->milestone;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\MilestoneDto
	 */
	public function getMilestoneOrFail(): \App\Dto\Test\Data\MilestoneDto {
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
	 * @param string|null $createdAt
	 *
	 * @return $this
	 */
	public function setCreatedAt(?string $createdAt) {
		$this->createdAt = $createdAt;
		$this->_touchedFields[self::FIELD_CREATED_AT] = true;

		return $this;
	}

	/**
	 * @param string $createdAt
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCreatedAtOrFail(string $createdAt) {
		$this->createdAt = $createdAt;
		$this->_touchedFields[self::FIELD_CREATED_AT] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCreatedAt(): ?string {
		return $this->createdAt;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCreatedAtOrFail(): string {
		if ($this->createdAt === null) {
			throw new \RuntimeException('Value not set for field `createdAt` (expected to be not null)');
		}

		return $this->createdAt;
	}

	/**
	 * @return bool
	 */
	public function hasCreatedAt(): bool {
		return $this->createdAt !== null;
	}

	/**
	 * @param string|null $updatedAt
	 *
	 * @return $this
	 */
	public function setUpdatedAt(?string $updatedAt) {
		$this->updatedAt = $updatedAt;
		$this->_touchedFields[self::FIELD_UPDATED_AT] = true;

		return $this;
	}

	/**
	 * @param string $updatedAt
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setUpdatedAtOrFail(string $updatedAt) {
		$this->updatedAt = $updatedAt;
		$this->_touchedFields[self::FIELD_UPDATED_AT] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUpdatedAt(): ?string {
		return $this->updatedAt;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getUpdatedAtOrFail(): string {
		if ($this->updatedAt === null) {
			throw new \RuntimeException('Value not set for field `updatedAt` (expected to be not null)');
		}

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
	 * @param \App\Dto\Test\Data\AssigneeDto|null $assignee
	 *
	 * @return $this
	 */
	public function setAssignee(?\App\Dto\Test\Data\AssigneeDto $assignee) {
		$this->assignee = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\AssigneeDto $assignee
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAssigneeOrFail(\App\Dto\Test\Data\AssigneeDto $assignee) {
		$this->assignee = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\AssigneeDto|null
	 */
	public function getAssignee(): ?\App\Dto\Test\Data\AssigneeDto {
		return $this->assignee;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\AssigneeDto
	 */
	public function getAssigneeOrFail(): \App\Dto\Test\Data\AssigneeDto {
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
	 * @param \App\Dto\Test\Data\AssigneeDto[]|\ArrayObject $assignees
	 *
	 * @return $this
	 */
	public function setAssignees(\ArrayObject $assignees) {
		$this->assignees = $assignees;
		$this->_touchedFields[self::FIELD_ASSIGNEES] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\AssigneeDto[]|\ArrayObject
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
	 * @return \App\Dto\Test\Data\AssigneeDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getAssignee($key): \App\Dto\Test\Data\AssigneeDto {
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
	 * @param \App\Dto\Test\Data\AssigneeDto $assignee
	 * @return $this
	 */
	public function addAssignee($key, \App\Dto\Test\Data\AssigneeDto $assignee) {
		if ($this->assignees === null) {
			$this->assignees = new \ArrayObject([]);
		}

		$this->assignees[$key] = $assignee;
		$this->_touchedFields[self::FIELD_ASSIGNEES] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\RequestedReviewerDto[]|\ArrayObject $requestedReviewers
	 *
	 * @return $this
	 */
	public function setRequestedReviewers(\ArrayObject $requestedReviewers) {
		$this->requestedReviewers = $requestedReviewers;
		$this->_touchedFields[self::FIELD_REQUESTED_REVIEWERS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\RequestedReviewerDto[]|\ArrayObject
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
	 * @return \App\Dto\Test\Data\RequestedReviewerDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getRequestedReviewer($key): \App\Dto\Test\Data\RequestedReviewerDto {
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
	 * @param \App\Dto\Test\Data\RequestedReviewerDto $requestedReviewer
	 * @return $this
	 */
	public function addRequestedReviewer($key, \App\Dto\Test\Data\RequestedReviewerDto $requestedReviewer) {
		if ($this->requestedReviewers === null) {
			$this->requestedReviewers = new \ArrayObject([]);
		}

		$this->requestedReviewers[$key] = $requestedReviewer;
		$this->_touchedFields[self::FIELD_REQUESTED_REVIEWERS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\RequestedTeamDto[]|\ArrayObject $requestedTeams
	 *
	 * @return $this
	 */
	public function setRequestedTeams(\ArrayObject $requestedTeams) {
		$this->requestedTeams = $requestedTeams;
		$this->_touchedFields[self::FIELD_REQUESTED_TEAMS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\RequestedTeamDto[]|\ArrayObject
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
	 * @return \App\Dto\Test\Data\RequestedTeamDto
	 *
	 * @throws \RuntimeException If value with this key is not set.
	 */
	public function getRequestedTeam($key): \App\Dto\Test\Data\RequestedTeamDto {
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
	 * @param \App\Dto\Test\Data\RequestedTeamDto $requestedTeam
	 * @return $this
	 */
	public function addRequestedTeam($key, \App\Dto\Test\Data\RequestedTeamDto $requestedTeam) {
		if ($this->requestedTeams === null) {
			$this->requestedTeams = new \ArrayObject([]);
		}

		$this->requestedTeams[$key] = $requestedTeam;
		$this->_touchedFields[self::FIELD_REQUESTED_TEAMS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\HeadDto|null $head
	 *
	 * @return $this
	 */
	public function setHead(?\App\Dto\Test\Data\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[self::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\HeadDto $head
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHeadOrFail(\App\Dto\Test\Data\HeadDto $head) {
		$this->head = $head;
		$this->_touchedFields[self::FIELD_HEAD] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\HeadDto|null
	 */
	public function getHead(): ?\App\Dto\Test\Data\HeadDto {
		return $this->head;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\HeadDto
	 */
	public function getHeadOrFail(): \App\Dto\Test\Data\HeadDto {
		if ($this->head === null) {
			throw new \RuntimeException('Value not set for field `head` (expected to be not null)');
		}

		return $this->head;
	}

	/**
	 * @return bool
	 */
	public function hasHead(): bool {
		return $this->head !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\BaseDto|null $base
	 *
	 * @return $this
	 */
	public function setBase(?\App\Dto\Test\Data\BaseDto $base) {
		$this->base = $base;
		$this->_touchedFields[self::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\BaseDto $base
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setBaseOrFail(\App\Dto\Test\Data\BaseDto $base) {
		$this->base = $base;
		$this->_touchedFields[self::FIELD_BASE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\BaseDto|null
	 */
	public function getBase(): ?\App\Dto\Test\Data\BaseDto {
		return $this->base;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\BaseDto
	 */
	public function getBaseOrFail(): \App\Dto\Test\Data\BaseDto {
		if ($this->base === null) {
			throw new \RuntimeException('Value not set for field `base` (expected to be not null)');
		}

		return $this->base;
	}

	/**
	 * @return bool
	 */
	public function hasBase(): bool {
		return $this->base !== null;
	}

	/**
	 * @param string|null $authorAssociation
	 *
	 * @return $this
	 */
	public function setAuthorAssociation(?string $authorAssociation) {
		$this->authorAssociation = $authorAssociation;
		$this->_touchedFields[self::FIELD_AUTHOR_ASSOCIATION] = true;

		return $this;
	}

	/**
	 * @param string $authorAssociation
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAuthorAssociationOrFail(string $authorAssociation) {
		$this->authorAssociation = $authorAssociation;
		$this->_touchedFields[self::FIELD_AUTHOR_ASSOCIATION] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAuthorAssociation(): ?string {
		return $this->authorAssociation;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getAuthorAssociationOrFail(): string {
		if ($this->authorAssociation === null) {
			throw new \RuntimeException('Value not set for field `authorAssociation` (expected to be not null)');
		}

		return $this->authorAssociation;
	}

	/**
	 * @return bool
	 */
	public function hasAuthorAssociation(): bool {
		return $this->authorAssociation !== null;
	}

	/**
	 * @param mixed|null $autoMerge
	 *
	 * @return $this
	 */
	public function setAutoMerge($autoMerge) {
		$this->autoMerge = $autoMerge;
		$this->_touchedFields[self::FIELD_AUTO_MERGE] = true;

		return $this;
	}

	/**
	 * @param mixed $autoMerge
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAutoMergeOrFail($autoMerge) {
		if ($autoMerge === null) {
			throw new \RuntimeException('Value not present (expected to be not null)');
		}
		$this->autoMerge = $autoMerge;
		$this->_touchedFields[self::FIELD_AUTO_MERGE] = true;

		return $this;
	}

	/**
	 * @return mixed|null
	 */
	public function getAutoMerge() {
		return $this->autoMerge;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return mixed
	 */
	public function getAutoMergeOrFail() {
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
	 * @param bool|null $merged
	 *
	 * @return $this
	 */
	public function setMerged(?bool $merged) {
		$this->merged = $merged;
		$this->_touchedFields[self::FIELD_MERGED] = true;

		return $this;
	}

	/**
	 * @param bool $merged
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergedOrFail(bool $merged) {
		$this->merged = $merged;
		$this->_touchedFields[self::FIELD_MERGED] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getMerged(): ?bool {
		return $this->merged;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getMergedOrFail(): bool {
		if ($this->merged === null) {
			throw new \RuntimeException('Value not set for field `merged` (expected to be not null)');
		}

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
	 * @param string|null $mergeableState
	 *
	 * @return $this
	 */
	public function setMergeableState(?string $mergeableState) {
		$this->mergeableState = $mergeableState;
		$this->_touchedFields[self::FIELD_MERGEABLE_STATE] = true;

		return $this;
	}

	/**
	 * @param string $mergeableState
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergeableStateOrFail(string $mergeableState) {
		$this->mergeableState = $mergeableState;
		$this->_touchedFields[self::FIELD_MERGEABLE_STATE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMergeableState(): ?string {
		return $this->mergeableState;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMergeableStateOrFail(): string {
		if ($this->mergeableState === null) {
			throw new \RuntimeException('Value not set for field `mergeableState` (expected to be not null)');
		}

		return $this->mergeableState;
	}

	/**
	 * @return bool
	 */
	public function hasMergeableState(): bool {
		return $this->mergeableState !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\MergedByDto|null $mergedBy
	 *
	 * @return $this
	 */
	public function setMergedBy(?\App\Dto\Test\Data\MergedByDto $mergedBy) {
		$this->mergedBy = $mergedBy;
		$this->_touchedFields[self::FIELD_MERGED_BY] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\MergedByDto $mergedBy
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergedByOrFail(\App\Dto\Test\Data\MergedByDto $mergedBy) {
		$this->mergedBy = $mergedBy;
		$this->_touchedFields[self::FIELD_MERGED_BY] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\MergedByDto|null
	 */
	public function getMergedBy(): ?\App\Dto\Test\Data\MergedByDto {
		return $this->mergedBy;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\MergedByDto
	 */
	public function getMergedByOrFail(): \App\Dto\Test\Data\MergedByDto {
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
	 * @param int|null $comments
	 *
	 * @return $this
	 */
	public function setComments(?int $comments) {
		$this->comments = $comments;
		$this->_touchedFields[self::FIELD_COMMENTS] = true;

		return $this;
	}

	/**
	 * @param int $comments
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCommentsOrFail(int $comments) {
		$this->comments = $comments;
		$this->_touchedFields[self::FIELD_COMMENTS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getComments(): ?int {
		return $this->comments;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getCommentsOrFail(): int {
		if ($this->comments === null) {
			throw new \RuntimeException('Value not set for field `comments` (expected to be not null)');
		}

		return $this->comments;
	}

	/**
	 * @return bool
	 */
	public function hasComments(): bool {
		return $this->comments !== null;
	}

	/**
	 * @param int|null $reviewComments
	 *
	 * @return $this
	 */
	public function setReviewComments(?int $reviewComments) {
		$this->reviewComments = $reviewComments;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS] = true;

		return $this;
	}

	/**
	 * @param int $reviewComments
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReviewCommentsOrFail(int $reviewComments) {
		$this->reviewComments = $reviewComments;
		$this->_touchedFields[self::FIELD_REVIEW_COMMENTS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getReviewComments(): ?int {
		return $this->reviewComments;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getReviewCommentsOrFail(): int {
		if ($this->reviewComments === null) {
			throw new \RuntimeException('Value not set for field `reviewComments` (expected to be not null)');
		}

		return $this->reviewComments;
	}

	/**
	 * @return bool
	 */
	public function hasReviewComments(): bool {
		return $this->reviewComments !== null;
	}

	/**
	 * @param bool|null $maintainerCanModify
	 *
	 * @return $this
	 */
	public function setMaintainerCanModify(?bool $maintainerCanModify) {
		$this->maintainerCanModify = $maintainerCanModify;
		$this->_touchedFields[self::FIELD_MAINTAINER_CAN_MODIFY] = true;

		return $this;
	}

	/**
	 * @param bool $maintainerCanModify
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMaintainerCanModifyOrFail(bool $maintainerCanModify) {
		$this->maintainerCanModify = $maintainerCanModify;
		$this->_touchedFields[self::FIELD_MAINTAINER_CAN_MODIFY] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getMaintainerCanModify(): ?bool {
		return $this->maintainerCanModify;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getMaintainerCanModifyOrFail(): bool {
		if ($this->maintainerCanModify === null) {
			throw new \RuntimeException('Value not set for field `maintainerCanModify` (expected to be not null)');
		}

		return $this->maintainerCanModify;
	}

	/**
	 * @return bool
	 */
	public function hasMaintainerCanModify(): bool {
		return $this->maintainerCanModify !== null;
	}

	/**
	 * @param int|null $commits
	 *
	 * @return $this
	 */
	public function setCommits(?int $commits) {
		$this->commits = $commits;
		$this->_touchedFields[self::FIELD_COMMITS] = true;

		return $this;
	}

	/**
	 * @param int $commits
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCommitsOrFail(int $commits) {
		$this->commits = $commits;
		$this->_touchedFields[self::FIELD_COMMITS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getCommits(): ?int {
		return $this->commits;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getCommitsOrFail(): int {
		if ($this->commits === null) {
			throw new \RuntimeException('Value not set for field `commits` (expected to be not null)');
		}

		return $this->commits;
	}

	/**
	 * @return bool
	 */
	public function hasCommits(): bool {
		return $this->commits !== null;
	}

	/**
	 * @param int|null $additions
	 *
	 * @return $this
	 */
	public function setAdditions(?int $additions) {
		$this->additions = $additions;
		$this->_touchedFields[self::FIELD_ADDITIONS] = true;

		return $this;
	}

	/**
	 * @param int $additions
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAdditionsOrFail(int $additions) {
		$this->additions = $additions;
		$this->_touchedFields[self::FIELD_ADDITIONS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getAdditions(): ?int {
		return $this->additions;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getAdditionsOrFail(): int {
		if ($this->additions === null) {
			throw new \RuntimeException('Value not set for field `additions` (expected to be not null)');
		}

		return $this->additions;
	}

	/**
	 * @return bool
	 */
	public function hasAdditions(): bool {
		return $this->additions !== null;
	}

	/**
	 * @param int|null $deletions
	 *
	 * @return $this
	 */
	public function setDeletions(?int $deletions) {
		$this->deletions = $deletions;
		$this->_touchedFields[self::FIELD_DELETIONS] = true;

		return $this;
	}

	/**
	 * @param int $deletions
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDeletionsOrFail(int $deletions) {
		$this->deletions = $deletions;
		$this->_touchedFields[self::FIELD_DELETIONS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getDeletions(): ?int {
		return $this->deletions;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getDeletionsOrFail(): int {
		if ($this->deletions === null) {
			throw new \RuntimeException('Value not set for field `deletions` (expected to be not null)');
		}

		return $this->deletions;
	}

	/**
	 * @return bool
	 */
	public function hasDeletions(): bool {
		return $this->deletions !== null;
	}

	/**
	 * @param int|null $changedFiles
	 *
	 * @return $this
	 */
	public function setChangedFiles(?int $changedFiles) {
		$this->changedFiles = $changedFiles;
		$this->_touchedFields[self::FIELD_CHANGED_FILES] = true;

		return $this;
	}

	/**
	 * @param int $changedFiles
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setChangedFilesOrFail(int $changedFiles) {
		$this->changedFiles = $changedFiles;
		$this->_touchedFields[self::FIELD_CHANGED_FILES] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getChangedFiles(): ?int {
		return $this->changedFiles;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getChangedFilesOrFail(): int {
		if ($this->changedFiles === null) {
			throw new \RuntimeException('Value not set for field `changedFiles` (expected to be not null)');
		}

		return $this->changedFiles;
	}

	/**
	 * @return bool
	 */
	public function hasChangedFiles(): bool {
		return $this->changedFiles !== null;
	}

}
