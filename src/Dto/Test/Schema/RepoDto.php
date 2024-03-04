<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Schema;

/**
 * Test/Schema/Repo DTO
 *
 * @property string $archiveUrl
 * @property string $assigneesUrl
 * @property string $blobsUrl
 * @property string $branchesUrl
 * @property string $collaboratorsUrl
 * @property string $commentsUrl
 * @property string $commitsUrl
 * @property string $compareUrl
 * @property string $contentsUrl
 * @property string $contributorsUrl
 * @property string $deploymentsUrl
 * @property string|null $description
 * @property string $downloadsUrl
 * @property string $eventsUrl
 * @property bool $fork
 * @property string $forksUrl
 * @property string $fullName
 * @property string $gitCommitsUrl
 * @property string $gitRefsUrl
 * @property string $gitTagsUrl
 * @property string $hooksUrl
 * @property string $htmlUrl
 * @property int $id
 * @property bool|null $isTemplate
 * @property string $nodeId
 * @property string $issueCommentUrl
 * @property string $issueEventsUrl
 * @property string $issuesUrl
 * @property string $keysUrl
 * @property string $labelsUrl
 * @property string $languagesUrl
 * @property string $mergesUrl
 * @property string $milestonesUrl
 * @property string $name
 * @property string $notificationsUrl
 * @property \App\Dto\Test\Schema\OwnerDto $owner
 * @property bool $private
 * @property string $pullsUrl
 * @property string $releasesUrl
 * @property string $stargazersUrl
 * @property string $statusesUrl
 * @property string $subscribersUrl
 * @property string $subscriptionUrl
 * @property string $tagsUrl
 * @property string $teamsUrl
 * @property string $treesUrl
 * @property string $url
 * @property string $cloneUrl
 * @property string $defaultBranch
 * @property int $forks
 * @property int $forksCount
 * @property string $gitUrl
 * @property bool $hasDownloads
 * @property bool $hasIssues
 * @property bool $hasProjects
 * @property bool $hasWiki
 * @property bool $hasPages
 * @property bool $hasDiscussions
 * @property string|null $homepage
 * @property string|null $language
 * @property string|null $masterBranch
 * @property bool $archived
 * @property bool $disabled
 * @property string|null $visibility
 * @property string|null $mirrorUrl
 * @property int $openIssues
 * @property int $openIssuesCount
 * @property \App\Dto\Test\Schema\PermissionsDto|null $permissions
 * @property string|null $tempCloneToken
 * @property bool|null $allowMergeCommit
 * @property bool|null $allowSquashMerge
 * @property bool|null $allowRebaseMerge
 * @property \App\Dto\Test\Schema\LicenseSimpleDto|null $license
 * @property string $pushedAt
 * @property int $size
 * @property string $sshUrl
 * @property int $stargazersCount
 * @property string $svnUrl
 * @property array|null $topics
 * @property int $watchers
 * @property int $watchersCount
 * @property string $createdAt
 * @property string $updatedAt
 * @property bool|null $allowForking
 * @property bool|null $webCommitSignoffRequired
 */
class RepoDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ARCHIVE_URL = 'archiveUrl';
	public const FIELD_ASSIGNEES_URL = 'assigneesUrl';
	public const FIELD_BLOBS_URL = 'blobsUrl';
	public const FIELD_BRANCHES_URL = 'branchesUrl';
	public const FIELD_COLLABORATORS_URL = 'collaboratorsUrl';
	public const FIELD_COMMENTS_URL = 'commentsUrl';
	public const FIELD_COMMITS_URL = 'commitsUrl';
	public const FIELD_COMPARE_URL = 'compareUrl';
	public const FIELD_CONTENTS_URL = 'contentsUrl';
	public const FIELD_CONTRIBUTORS_URL = 'contributorsUrl';
	public const FIELD_DEPLOYMENTS_URL = 'deploymentsUrl';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_DOWNLOADS_URL = 'downloadsUrl';
	public const FIELD_EVENTS_URL = 'eventsUrl';
	public const FIELD_FORK = 'fork';
	public const FIELD_FORKS_URL = 'forksUrl';
	public const FIELD_FULL_NAME = 'fullName';
	public const FIELD_GIT_COMMITS_URL = 'gitCommitsUrl';
	public const FIELD_GIT_REFS_URL = 'gitRefsUrl';
	public const FIELD_GIT_TAGS_URL = 'gitTagsUrl';
	public const FIELD_HOOKS_URL = 'hooksUrl';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_ID = 'id';
	public const FIELD_IS_TEMPLATE = 'isTemplate';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_ISSUE_COMMENT_URL = 'issueCommentUrl';
	public const FIELD_ISSUE_EVENTS_URL = 'issueEventsUrl';
	public const FIELD_ISSUES_URL = 'issuesUrl';
	public const FIELD_KEYS_URL = 'keysUrl';
	public const FIELD_LABELS_URL = 'labelsUrl';
	public const FIELD_LANGUAGES_URL = 'languagesUrl';
	public const FIELD_MERGES_URL = 'mergesUrl';
	public const FIELD_MILESTONES_URL = 'milestonesUrl';
	public const FIELD_NAME = 'name';
	public const FIELD_NOTIFICATIONS_URL = 'notificationsUrl';
	public const FIELD_OWNER = 'owner';
	public const FIELD_PRIVATE = 'private';
	public const FIELD_PULLS_URL = 'pullsUrl';
	public const FIELD_RELEASES_URL = 'releasesUrl';
	public const FIELD_STARGAZERS_URL = 'stargazersUrl';
	public const FIELD_STATUSES_URL = 'statusesUrl';
	public const FIELD_SUBSCRIBERS_URL = 'subscribersUrl';
	public const FIELD_SUBSCRIPTION_URL = 'subscriptionUrl';
	public const FIELD_TAGS_URL = 'tagsUrl';
	public const FIELD_TEAMS_URL = 'teamsUrl';
	public const FIELD_TREES_URL = 'treesUrl';
	public const FIELD_URL = 'url';
	public const FIELD_CLONE_URL = 'cloneUrl';
	public const FIELD_DEFAULT_BRANCH = 'defaultBranch';
	public const FIELD_FORKS = 'forks';
	public const FIELD_FORKS_COUNT = 'forksCount';
	public const FIELD_GIT_URL = 'gitUrl';
	public const FIELD_HAS_DOWNLOADS = 'hasDownloads';
	public const FIELD_HAS_ISSUES = 'hasIssues';
	public const FIELD_HAS_PROJECTS = 'hasProjects';
	public const FIELD_HAS_WIKI = 'hasWiki';
	public const FIELD_HAS_PAGES = 'hasPages';
	public const FIELD_HAS_DISCUSSIONS = 'hasDiscussions';
	public const FIELD_HOMEPAGE = 'homepage';
	public const FIELD_LANGUAGE = 'language';
	public const FIELD_MASTER_BRANCH = 'masterBranch';
	public const FIELD_ARCHIVED = 'archived';
	public const FIELD_DISABLED = 'disabled';
	public const FIELD_VISIBILITY = 'visibility';
	public const FIELD_MIRROR_URL = 'mirrorUrl';
	public const FIELD_OPEN_ISSUES = 'openIssues';
	public const FIELD_OPEN_ISSUES_COUNT = 'openIssuesCount';
	public const FIELD_PERMISSIONS = 'permissions';
	public const FIELD_TEMP_CLONE_TOKEN = 'tempCloneToken';
	public const FIELD_ALLOW_MERGE_COMMIT = 'allowMergeCommit';
	public const FIELD_ALLOW_SQUASH_MERGE = 'allowSquashMerge';
	public const FIELD_ALLOW_REBASE_MERGE = 'allowRebaseMerge';
	public const FIELD_LICENSE = 'license';
	public const FIELD_PUSHED_AT = 'pushedAt';
	public const FIELD_SIZE = 'size';
	public const FIELD_SSH_URL = 'sshUrl';
	public const FIELD_STARGAZERS_COUNT = 'stargazersCount';
	public const FIELD_SVN_URL = 'svnUrl';
	public const FIELD_TOPICS = 'topics';
	public const FIELD_WATCHERS = 'watchers';
	public const FIELD_WATCHERS_COUNT = 'watchersCount';
	public const FIELD_CREATED_AT = 'createdAt';
	public const FIELD_UPDATED_AT = 'updatedAt';
	public const FIELD_ALLOW_FORKING = 'allowForking';
	public const FIELD_WEB_COMMIT_SIGNOFF_REQUIRED = 'webCommitSignoffRequired';

	/**
	 * @var string
	 */
	protected $archiveUrl;

	/**
	 * @var string
	 */
	protected $assigneesUrl;

	/**
	 * @var string
	 */
	protected $blobsUrl;

	/**
	 * @var string
	 */
	protected $branchesUrl;

	/**
	 * @var string
	 */
	protected $collaboratorsUrl;

	/**
	 * @var string
	 */
	protected $commentsUrl;

	/**
	 * @var string
	 */
	protected $commitsUrl;

	/**
	 * @var string
	 */
	protected $compareUrl;

	/**
	 * @var string
	 */
	protected $contentsUrl;

	/**
	 * @var string
	 */
	protected $contributorsUrl;

	/**
	 * @var string
	 */
	protected $deploymentsUrl;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $downloadsUrl;

	/**
	 * @var string
	 */
	protected $eventsUrl;

	/**
	 * @var bool
	 */
	protected $fork;

	/**
	 * @var string
	 */
	protected $forksUrl;

	/**
	 * @var string
	 */
	protected $fullName;

	/**
	 * @var string
	 */
	protected $gitCommitsUrl;

	/**
	 * @var string
	 */
	protected $gitRefsUrl;

	/**
	 * @var string
	 */
	protected $gitTagsUrl;

	/**
	 * @var string
	 */
	protected $hooksUrl;

	/**
	 * @var string
	 */
	protected $htmlUrl;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var bool|null
	 */
	protected $isTemplate;

	/**
	 * @var string
	 */
	protected $nodeId;

	/**
	 * @var string
	 */
	protected $issueCommentUrl;

	/**
	 * @var string
	 */
	protected $issueEventsUrl;

	/**
	 * @var string
	 */
	protected $issuesUrl;

	/**
	 * @var string
	 */
	protected $keysUrl;

	/**
	 * @var string
	 */
	protected $labelsUrl;

	/**
	 * @var string
	 */
	protected $languagesUrl;

	/**
	 * @var string
	 */
	protected $mergesUrl;

	/**
	 * @var string
	 */
	protected $milestonesUrl;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $notificationsUrl;

	/**
	 * @var \App\Dto\Test\Schema\OwnerDto
	 */
	protected $owner;

	/**
	 * @var bool
	 */
	protected $private;

	/**
	 * @var string
	 */
	protected $pullsUrl;

	/**
	 * @var string
	 */
	protected $releasesUrl;

	/**
	 * @var string
	 */
	protected $stargazersUrl;

	/**
	 * @var string
	 */
	protected $statusesUrl;

	/**
	 * @var string
	 */
	protected $subscribersUrl;

	/**
	 * @var string
	 */
	protected $subscriptionUrl;

	/**
	 * @var string
	 */
	protected $tagsUrl;

	/**
	 * @var string
	 */
	protected $teamsUrl;

	/**
	 * @var string
	 */
	protected $treesUrl;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $cloneUrl;

	/**
	 * @var string
	 */
	protected $defaultBranch;

	/**
	 * @var int
	 */
	protected $forks;

	/**
	 * @var int
	 */
	protected $forksCount;

	/**
	 * @var string
	 */
	protected $gitUrl;

	/**
	 * @var bool
	 */
	protected $hasDownloads;

	/**
	 * @var bool
	 */
	protected $hasIssues;

	/**
	 * @var bool
	 */
	protected $hasProjects;

	/**
	 * @var bool
	 */
	protected $hasWiki;

	/**
	 * @var bool
	 */
	protected $hasPages;

	/**
	 * @var bool
	 */
	protected $hasDiscussions;

	/**
	 * @var string|null
	 */
	protected $homepage;

	/**
	 * @var string|null
	 */
	protected $language;

	/**
	 * @var string|null
	 */
	protected $masterBranch;

	/**
	 * @var bool
	 */
	protected $archived;

	/**
	 * @var bool
	 */
	protected $disabled;

	/**
	 * @var string|null
	 */
	protected $visibility;

	/**
	 * @var string|null
	 */
	protected $mirrorUrl;

	/**
	 * @var int
	 */
	protected $openIssues;

	/**
	 * @var int
	 */
	protected $openIssuesCount;

	/**
	 * @var \App\Dto\Test\Schema\PermissionsDto|null
	 */
	protected $permissions;

	/**
	 * @var string|null
	 */
	protected $tempCloneToken;

	/**
	 * @var bool|null
	 */
	protected $allowMergeCommit;

	/**
	 * @var bool|null
	 */
	protected $allowSquashMerge;

	/**
	 * @var bool|null
	 */
	protected $allowRebaseMerge;

	/**
	 * @var \App\Dto\Test\Schema\LicenseSimpleDto|null
	 */
	protected $license;

	/**
	 * @var string
	 */
	protected $pushedAt;

	/**
	 * @var int
	 */
	protected $size;

	/**
	 * @var string
	 */
	protected $sshUrl;

	/**
	 * @var int
	 */
	protected $stargazersCount;

	/**
	 * @var string
	 */
	protected $svnUrl;

	/**
	 * @var array|null
	 */
	protected $topics;

	/**
	 * @var int
	 */
	protected $watchers;

	/**
	 * @var int
	 */
	protected $watchersCount;

	/**
	 * @var string
	 */
	protected $createdAt;

	/**
	 * @var string
	 */
	protected $updatedAt;

	/**
	 * @var bool|null
	 */
	protected $allowForking;

	/**
	 * @var bool|null
	 */
	protected $webCommitSignoffRequired;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'archiveUrl' => [
			'name' => 'archiveUrl',
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
		'assigneesUrl' => [
			'name' => 'assigneesUrl',
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
		'blobsUrl' => [
			'name' => 'blobsUrl',
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
		'branchesUrl' => [
			'name' => 'branchesUrl',
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
		'collaboratorsUrl' => [
			'name' => 'collaboratorsUrl',
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
		'compareUrl' => [
			'name' => 'compareUrl',
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
		'contentsUrl' => [
			'name' => 'contentsUrl',
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
		'contributorsUrl' => [
			'name' => 'contributorsUrl',
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
		'deploymentsUrl' => [
			'name' => 'deploymentsUrl',
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
		'downloadsUrl' => [
			'name' => 'downloadsUrl',
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
		'eventsUrl' => [
			'name' => 'eventsUrl',
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
		'fork' => [
			'name' => 'fork',
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
		'forksUrl' => [
			'name' => 'forksUrl',
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
		'fullName' => [
			'name' => 'fullName',
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
		'gitCommitsUrl' => [
			'name' => 'gitCommitsUrl',
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
		'gitRefsUrl' => [
			'name' => 'gitRefsUrl',
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
		'gitTagsUrl' => [
			'name' => 'gitTagsUrl',
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
		'hooksUrl' => [
			'name' => 'hooksUrl',
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
		'isTemplate' => [
			'name' => 'isTemplate',
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
		'issueCommentUrl' => [
			'name' => 'issueCommentUrl',
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
		'issueEventsUrl' => [
			'name' => 'issueEventsUrl',
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
		'issuesUrl' => [
			'name' => 'issuesUrl',
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
		'keysUrl' => [
			'name' => 'keysUrl',
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
		'languagesUrl' => [
			'name' => 'languagesUrl',
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
		'mergesUrl' => [
			'name' => 'mergesUrl',
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
		'milestonesUrl' => [
			'name' => 'milestonesUrl',
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
		'name' => [
			'name' => 'name',
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
		'notificationsUrl' => [
			'name' => 'notificationsUrl',
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
		'owner' => [
			'name' => 'owner',
			'type' => '\App\Dto\Test\Schema\OwnerDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Owner',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'private' => [
			'name' => 'private',
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
		'pullsUrl' => [
			'name' => 'pullsUrl',
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
		'releasesUrl' => [
			'name' => 'releasesUrl',
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
		'stargazersUrl' => [
			'name' => 'stargazersUrl',
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
		'subscribersUrl' => [
			'name' => 'subscribersUrl',
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
		'subscriptionUrl' => [
			'name' => 'subscriptionUrl',
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
		'tagsUrl' => [
			'name' => 'tagsUrl',
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
		'teamsUrl' => [
			'name' => 'teamsUrl',
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
		'treesUrl' => [
			'name' => 'treesUrl',
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
		'cloneUrl' => [
			'name' => 'cloneUrl',
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
		'defaultBranch' => [
			'name' => 'defaultBranch',
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
		'forks' => [
			'name' => 'forks',
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
		'forksCount' => [
			'name' => 'forksCount',
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
		'gitUrl' => [
			'name' => 'gitUrl',
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
		'hasDownloads' => [
			'name' => 'hasDownloads',
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
		'hasIssues' => [
			'name' => 'hasIssues',
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
		'hasProjects' => [
			'name' => 'hasProjects',
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
		'hasWiki' => [
			'name' => 'hasWiki',
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
		'hasPages' => [
			'name' => 'hasPages',
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
		'hasDiscussions' => [
			'name' => 'hasDiscussions',
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
		'homepage' => [
			'name' => 'homepage',
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
		'language' => [
			'name' => 'language',
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
		'masterBranch' => [
			'name' => 'masterBranch',
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
		'archived' => [
			'name' => 'archived',
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
		'disabled' => [
			'name' => 'disabled',
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
		'visibility' => [
			'name' => 'visibility',
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
		'mirrorUrl' => [
			'name' => 'mirrorUrl',
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
		'openIssuesCount' => [
			'name' => 'openIssuesCount',
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
		'permissions' => [
			'name' => 'permissions',
			'type' => '\App\Dto\Test\Schema\PermissionsDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/Permissions',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'tempCloneToken' => [
			'name' => 'tempCloneToken',
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
		'allowMergeCommit' => [
			'name' => 'allowMergeCommit',
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
		'allowSquashMerge' => [
			'name' => 'allowSquashMerge',
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
		'allowRebaseMerge' => [
			'name' => 'allowRebaseMerge',
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
		'license' => [
			'name' => 'license',
			'type' => '\App\Dto\Test\Schema\LicenseSimpleDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Schema/LicenseSimple',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'pushedAt' => [
			'name' => 'pushedAt',
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
		'size' => [
			'name' => 'size',
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
		'sshUrl' => [
			'name' => 'sshUrl',
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
		'stargazersCount' => [
			'name' => 'stargazersCount',
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
		'svnUrl' => [
			'name' => 'svnUrl',
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
		'topics' => [
			'name' => 'topics',
			'type' => 'array',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'watchers' => [
			'name' => 'watchers',
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
		'watchersCount' => [
			'name' => 'watchersCount',
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
		'allowForking' => [
			'name' => 'allowForking',
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
		'webCommitSignoffRequired' => [
			'name' => 'webCommitSignoffRequired',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'archive_url' => 'archiveUrl',
			'assignees_url' => 'assigneesUrl',
			'blobs_url' => 'blobsUrl',
			'branches_url' => 'branchesUrl',
			'collaborators_url' => 'collaboratorsUrl',
			'comments_url' => 'commentsUrl',
			'commits_url' => 'commitsUrl',
			'compare_url' => 'compareUrl',
			'contents_url' => 'contentsUrl',
			'contributors_url' => 'contributorsUrl',
			'deployments_url' => 'deploymentsUrl',
			'description' => 'description',
			'downloads_url' => 'downloadsUrl',
			'events_url' => 'eventsUrl',
			'fork' => 'fork',
			'forks_url' => 'forksUrl',
			'full_name' => 'fullName',
			'git_commits_url' => 'gitCommitsUrl',
			'git_refs_url' => 'gitRefsUrl',
			'git_tags_url' => 'gitTagsUrl',
			'hooks_url' => 'hooksUrl',
			'html_url' => 'htmlUrl',
			'id' => 'id',
			'is_template' => 'isTemplate',
			'node_id' => 'nodeId',
			'issue_comment_url' => 'issueCommentUrl',
			'issue_events_url' => 'issueEventsUrl',
			'issues_url' => 'issuesUrl',
			'keys_url' => 'keysUrl',
			'labels_url' => 'labelsUrl',
			'languages_url' => 'languagesUrl',
			'merges_url' => 'mergesUrl',
			'milestones_url' => 'milestonesUrl',
			'name' => 'name',
			'notifications_url' => 'notificationsUrl',
			'owner' => 'owner',
			'private' => 'private',
			'pulls_url' => 'pullsUrl',
			'releases_url' => 'releasesUrl',
			'stargazers_url' => 'stargazersUrl',
			'statuses_url' => 'statusesUrl',
			'subscribers_url' => 'subscribersUrl',
			'subscription_url' => 'subscriptionUrl',
			'tags_url' => 'tagsUrl',
			'teams_url' => 'teamsUrl',
			'trees_url' => 'treesUrl',
			'url' => 'url',
			'clone_url' => 'cloneUrl',
			'default_branch' => 'defaultBranch',
			'forks' => 'forks',
			'forks_count' => 'forksCount',
			'git_url' => 'gitUrl',
			'has_downloads' => 'hasDownloads',
			'has_issues' => 'hasIssues',
			'has_projects' => 'hasProjects',
			'has_wiki' => 'hasWiki',
			'has_pages' => 'hasPages',
			'has_discussions' => 'hasDiscussions',
			'homepage' => 'homepage',
			'language' => 'language',
			'master_branch' => 'masterBranch',
			'archived' => 'archived',
			'disabled' => 'disabled',
			'visibility' => 'visibility',
			'mirror_url' => 'mirrorUrl',
			'open_issues' => 'openIssues',
			'open_issues_count' => 'openIssuesCount',
			'permissions' => 'permissions',
			'temp_clone_token' => 'tempCloneToken',
			'allow_merge_commit' => 'allowMergeCommit',
			'allow_squash_merge' => 'allowSquashMerge',
			'allow_rebase_merge' => 'allowRebaseMerge',
			'license' => 'license',
			'pushed_at' => 'pushedAt',
			'size' => 'size',
			'ssh_url' => 'sshUrl',
			'stargazers_count' => 'stargazersCount',
			'svn_url' => 'svnUrl',
			'topics' => 'topics',
			'watchers' => 'watchers',
			'watchers_count' => 'watchersCount',
			'created_at' => 'createdAt',
			'updated_at' => 'updatedAt',
			'allow_forking' => 'allowForking',
			'web_commit_signoff_required' => 'webCommitSignoffRequired',
		],
		'dashed' => [
			'archive-url' => 'archiveUrl',
			'assignees-url' => 'assigneesUrl',
			'blobs-url' => 'blobsUrl',
			'branches-url' => 'branchesUrl',
			'collaborators-url' => 'collaboratorsUrl',
			'comments-url' => 'commentsUrl',
			'commits-url' => 'commitsUrl',
			'compare-url' => 'compareUrl',
			'contents-url' => 'contentsUrl',
			'contributors-url' => 'contributorsUrl',
			'deployments-url' => 'deploymentsUrl',
			'description' => 'description',
			'downloads-url' => 'downloadsUrl',
			'events-url' => 'eventsUrl',
			'fork' => 'fork',
			'forks-url' => 'forksUrl',
			'full-name' => 'fullName',
			'git-commits-url' => 'gitCommitsUrl',
			'git-refs-url' => 'gitRefsUrl',
			'git-tags-url' => 'gitTagsUrl',
			'hooks-url' => 'hooksUrl',
			'html-url' => 'htmlUrl',
			'id' => 'id',
			'is-template' => 'isTemplate',
			'node-id' => 'nodeId',
			'issue-comment-url' => 'issueCommentUrl',
			'issue-events-url' => 'issueEventsUrl',
			'issues-url' => 'issuesUrl',
			'keys-url' => 'keysUrl',
			'labels-url' => 'labelsUrl',
			'languages-url' => 'languagesUrl',
			'merges-url' => 'mergesUrl',
			'milestones-url' => 'milestonesUrl',
			'name' => 'name',
			'notifications-url' => 'notificationsUrl',
			'owner' => 'owner',
			'private' => 'private',
			'pulls-url' => 'pullsUrl',
			'releases-url' => 'releasesUrl',
			'stargazers-url' => 'stargazersUrl',
			'statuses-url' => 'statusesUrl',
			'subscribers-url' => 'subscribersUrl',
			'subscription-url' => 'subscriptionUrl',
			'tags-url' => 'tagsUrl',
			'teams-url' => 'teamsUrl',
			'trees-url' => 'treesUrl',
			'url' => 'url',
			'clone-url' => 'cloneUrl',
			'default-branch' => 'defaultBranch',
			'forks' => 'forks',
			'forks-count' => 'forksCount',
			'git-url' => 'gitUrl',
			'has-downloads' => 'hasDownloads',
			'has-issues' => 'hasIssues',
			'has-projects' => 'hasProjects',
			'has-wiki' => 'hasWiki',
			'has-pages' => 'hasPages',
			'has-discussions' => 'hasDiscussions',
			'homepage' => 'homepage',
			'language' => 'language',
			'master-branch' => 'masterBranch',
			'archived' => 'archived',
			'disabled' => 'disabled',
			'visibility' => 'visibility',
			'mirror-url' => 'mirrorUrl',
			'open-issues' => 'openIssues',
			'open-issues-count' => 'openIssuesCount',
			'permissions' => 'permissions',
			'temp-clone-token' => 'tempCloneToken',
			'allow-merge-commit' => 'allowMergeCommit',
			'allow-squash-merge' => 'allowSquashMerge',
			'allow-rebase-merge' => 'allowRebaseMerge',
			'license' => 'license',
			'pushed-at' => 'pushedAt',
			'size' => 'size',
			'ssh-url' => 'sshUrl',
			'stargazers-count' => 'stargazersCount',
			'svn-url' => 'svnUrl',
			'topics' => 'topics',
			'watchers' => 'watchers',
			'watchers-count' => 'watchersCount',
			'created-at' => 'createdAt',
			'updated-at' => 'updatedAt',
			'allow-forking' => 'allowForking',
			'web-commit-signoff-required' => 'webCommitSignoffRequired',
		],
	];

	/**
	 * @param string $archiveUrl
	 *
	 * @return $this
	 */
	public function setArchiveUrl(string $archiveUrl) {
		$this->archiveUrl = $archiveUrl;
		$this->_touchedFields[self::FIELD_ARCHIVE_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getArchiveUrl(): string {
		return $this->archiveUrl;
	}

	/**
	 * @return bool
	 */
	public function hasArchiveUrl(): bool {
		return $this->archiveUrl !== null;
	}

	/**
	 * @param string $assigneesUrl
	 *
	 * @return $this
	 */
	public function setAssigneesUrl(string $assigneesUrl) {
		$this->assigneesUrl = $assigneesUrl;
		$this->_touchedFields[self::FIELD_ASSIGNEES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAssigneesUrl(): string {
		return $this->assigneesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasAssigneesUrl(): bool {
		return $this->assigneesUrl !== null;
	}

	/**
	 * @param string $blobsUrl
	 *
	 * @return $this
	 */
	public function setBlobsUrl(string $blobsUrl) {
		$this->blobsUrl = $blobsUrl;
		$this->_touchedFields[self::FIELD_BLOBS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBlobsUrl(): string {
		return $this->blobsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasBlobsUrl(): bool {
		return $this->blobsUrl !== null;
	}

	/**
	 * @param string $branchesUrl
	 *
	 * @return $this
	 */
	public function setBranchesUrl(string $branchesUrl) {
		$this->branchesUrl = $branchesUrl;
		$this->_touchedFields[self::FIELD_BRANCHES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBranchesUrl(): string {
		return $this->branchesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasBranchesUrl(): bool {
		return $this->branchesUrl !== null;
	}

	/**
	 * @param string $collaboratorsUrl
	 *
	 * @return $this
	 */
	public function setCollaboratorsUrl(string $collaboratorsUrl) {
		$this->collaboratorsUrl = $collaboratorsUrl;
		$this->_touchedFields[self::FIELD_COLLABORATORS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCollaboratorsUrl(): string {
		return $this->collaboratorsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCollaboratorsUrl(): bool {
		return $this->collaboratorsUrl !== null;
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
	 * @param string $compareUrl
	 *
	 * @return $this
	 */
	public function setCompareUrl(string $compareUrl) {
		$this->compareUrl = $compareUrl;
		$this->_touchedFields[self::FIELD_COMPARE_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCompareUrl(): string {
		return $this->compareUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCompareUrl(): bool {
		return $this->compareUrl !== null;
	}

	/**
	 * @param string $contentsUrl
	 *
	 * @return $this
	 */
	public function setContentsUrl(string $contentsUrl) {
		$this->contentsUrl = $contentsUrl;
		$this->_touchedFields[self::FIELD_CONTENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentsUrl(): string {
		return $this->contentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasContentsUrl(): bool {
		return $this->contentsUrl !== null;
	}

	/**
	 * @param string $contributorsUrl
	 *
	 * @return $this
	 */
	public function setContributorsUrl(string $contributorsUrl) {
		$this->contributorsUrl = $contributorsUrl;
		$this->_touchedFields[self::FIELD_CONTRIBUTORS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getContributorsUrl(): string {
		return $this->contributorsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasContributorsUrl(): bool {
		return $this->contributorsUrl !== null;
	}

	/**
	 * @param string $deploymentsUrl
	 *
	 * @return $this
	 */
	public function setDeploymentsUrl(string $deploymentsUrl) {
		$this->deploymentsUrl = $deploymentsUrl;
		$this->_touchedFields[self::FIELD_DEPLOYMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDeploymentsUrl(): string {
		return $this->deploymentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDeploymentsUrl(): bool {
		return $this->deploymentsUrl !== null;
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
	 * @param string $downloadsUrl
	 *
	 * @return $this
	 */
	public function setDownloadsUrl(string $downloadsUrl) {
		$this->downloadsUrl = $downloadsUrl;
		$this->_touchedFields[self::FIELD_DOWNLOADS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDownloadsUrl(): string {
		return $this->downloadsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDownloadsUrl(): bool {
		return $this->downloadsUrl !== null;
	}

	/**
	 * @param string $eventsUrl
	 *
	 * @return $this
	 */
	public function setEventsUrl(string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEventsUrl(): string {
		return $this->eventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasEventsUrl(): bool {
		return $this->eventsUrl !== null;
	}

	/**
	 * @param bool $fork
	 *
	 * @return $this
	 */
	public function setFork(bool $fork) {
		$this->fork = $fork;
		$this->_touchedFields[self::FIELD_FORK] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getFork(): bool {
		return $this->fork;
	}

	/**
	 * @return bool
	 */
	public function hasFork(): bool {
		return $this->fork !== null;
	}

	/**
	 * @param string $forksUrl
	 *
	 * @return $this
	 */
	public function setForksUrl(string $forksUrl) {
		$this->forksUrl = $forksUrl;
		$this->_touchedFields[self::FIELD_FORKS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getForksUrl(): string {
		return $this->forksUrl;
	}

	/**
	 * @return bool
	 */
	public function hasForksUrl(): bool {
		return $this->forksUrl !== null;
	}

	/**
	 * @param string $fullName
	 *
	 * @return $this
	 */
	public function setFullName(string $fullName) {
		$this->fullName = $fullName;
		$this->_touchedFields[self::FIELD_FULL_NAME] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFullName(): string {
		return $this->fullName;
	}

	/**
	 * @return bool
	 */
	public function hasFullName(): bool {
		return $this->fullName !== null;
	}

	/**
	 * @param string $gitCommitsUrl
	 *
	 * @return $this
	 */
	public function setGitCommitsUrl(string $gitCommitsUrl) {
		$this->gitCommitsUrl = $gitCommitsUrl;
		$this->_touchedFields[self::FIELD_GIT_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGitCommitsUrl(): string {
		return $this->gitCommitsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitCommitsUrl(): bool {
		return $this->gitCommitsUrl !== null;
	}

	/**
	 * @param string $gitRefsUrl
	 *
	 * @return $this
	 */
	public function setGitRefsUrl(string $gitRefsUrl) {
		$this->gitRefsUrl = $gitRefsUrl;
		$this->_touchedFields[self::FIELD_GIT_REFS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGitRefsUrl(): string {
		return $this->gitRefsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitRefsUrl(): bool {
		return $this->gitRefsUrl !== null;
	}

	/**
	 * @param string $gitTagsUrl
	 *
	 * @return $this
	 */
	public function setGitTagsUrl(string $gitTagsUrl) {
		$this->gitTagsUrl = $gitTagsUrl;
		$this->_touchedFields[self::FIELD_GIT_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGitTagsUrl(): string {
		return $this->gitTagsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitTagsUrl(): bool {
		return $this->gitTagsUrl !== null;
	}

	/**
	 * @param string $hooksUrl
	 *
	 * @return $this
	 */
	public function setHooksUrl(string $hooksUrl) {
		$this->hooksUrl = $hooksUrl;
		$this->_touchedFields[self::FIELD_HOOKS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHooksUrl(): string {
		return $this->hooksUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHooksUrl(): bool {
		return $this->hooksUrl !== null;
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
	 * @param bool|null $isTemplate
	 *
	 * @return $this
	 */
	public function setIsTemplate(?bool $isTemplate) {
		$this->isTemplate = $isTemplate;
		$this->_touchedFields[self::FIELD_IS_TEMPLATE] = true;

		return $this;
	}

	/**
	 * @param bool $isTemplate
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIsTemplateOrFail(bool $isTemplate) {
		$this->isTemplate = $isTemplate;
		$this->_touchedFields[self::FIELD_IS_TEMPLATE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getIsTemplate(): ?bool {
		return $this->isTemplate;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getIsTemplateOrFail(): bool {
		if ($this->isTemplate === null) {
			throw new \RuntimeException('Value not set for field `isTemplate` (expected to be not null)');
		}

		return $this->isTemplate;
	}

	/**
	 * @return bool
	 */
	public function hasIsTemplate(): bool {
		return $this->isTemplate !== null;
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
	 * @param string $issueCommentUrl
	 *
	 * @return $this
	 */
	public function setIssueCommentUrl(string $issueCommentUrl) {
		$this->issueCommentUrl = $issueCommentUrl;
		$this->_touchedFields[self::FIELD_ISSUE_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIssueCommentUrl(): string {
		return $this->issueCommentUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueCommentUrl(): bool {
		return $this->issueCommentUrl !== null;
	}

	/**
	 * @param string $issueEventsUrl
	 *
	 * @return $this
	 */
	public function setIssueEventsUrl(string $issueEventsUrl) {
		$this->issueEventsUrl = $issueEventsUrl;
		$this->_touchedFields[self::FIELD_ISSUE_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIssueEventsUrl(): string {
		return $this->issueEventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueEventsUrl(): bool {
		return $this->issueEventsUrl !== null;
	}

	/**
	 * @param string $issuesUrl
	 *
	 * @return $this
	 */
	public function setIssuesUrl(string $issuesUrl) {
		$this->issuesUrl = $issuesUrl;
		$this->_touchedFields[self::FIELD_ISSUES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIssuesUrl(): string {
		return $this->issuesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssuesUrl(): bool {
		return $this->issuesUrl !== null;
	}

	/**
	 * @param string $keysUrl
	 *
	 * @return $this
	 */
	public function setKeysUrl(string $keysUrl) {
		$this->keysUrl = $keysUrl;
		$this->_touchedFields[self::FIELD_KEYS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getKeysUrl(): string {
		return $this->keysUrl;
	}

	/**
	 * @return bool
	 */
	public function hasKeysUrl(): bool {
		return $this->keysUrl !== null;
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
	 * @param string $languagesUrl
	 *
	 * @return $this
	 */
	public function setLanguagesUrl(string $languagesUrl) {
		$this->languagesUrl = $languagesUrl;
		$this->_touchedFields[self::FIELD_LANGUAGES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguagesUrl(): string {
		return $this->languagesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasLanguagesUrl(): bool {
		return $this->languagesUrl !== null;
	}

	/**
	 * @param string $mergesUrl
	 *
	 * @return $this
	 */
	public function setMergesUrl(string $mergesUrl) {
		$this->mergesUrl = $mergesUrl;
		$this->_touchedFields[self::FIELD_MERGES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMergesUrl(): string {
		return $this->mergesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMergesUrl(): bool {
		return $this->mergesUrl !== null;
	}

	/**
	 * @param string $milestonesUrl
	 *
	 * @return $this
	 */
	public function setMilestonesUrl(string $milestonesUrl) {
		$this->milestonesUrl = $milestonesUrl;
		$this->_touchedFields[self::FIELD_MILESTONES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMilestonesUrl(): string {
		return $this->milestonesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMilestonesUrl(): bool {
		return $this->milestonesUrl !== null;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName(): bool {
		return $this->name !== null;
	}

	/**
	 * @param string $notificationsUrl
	 *
	 * @return $this
	 */
	public function setNotificationsUrl(string $notificationsUrl) {
		$this->notificationsUrl = $notificationsUrl;
		$this->_touchedFields[self::FIELD_NOTIFICATIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNotificationsUrl(): string {
		return $this->notificationsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasNotificationsUrl(): bool {
		return $this->notificationsUrl !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\OwnerDto $owner
	 *
	 * @return $this
	 */
	public function setOwner(\App\Dto\Test\Schema\OwnerDto $owner) {
		$this->owner = $owner;
		$this->_touchedFields[self::FIELD_OWNER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\OwnerDto
	 */
	public function getOwner(): \App\Dto\Test\Schema\OwnerDto {
		return $this->owner;
	}

	/**
	 * @return bool
	 */
	public function hasOwner(): bool {
		return $this->owner !== null;
	}

	/**
	 * @param bool $private
	 *
	 * @return $this
	 */
	public function setPrivate(bool $private) {
		$this->private = $private;
		$this->_touchedFields[self::FIELD_PRIVATE] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPrivate(): bool {
		return $this->private;
	}

	/**
	 * @return bool
	 */
	public function hasPrivate(): bool {
		return $this->private !== null;
	}

	/**
	 * @param string $pullsUrl
	 *
	 * @return $this
	 */
	public function setPullsUrl(string $pullsUrl) {
		$this->pullsUrl = $pullsUrl;
		$this->_touchedFields[self::FIELD_PULLS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPullsUrl(): string {
		return $this->pullsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasPullsUrl(): bool {
		return $this->pullsUrl !== null;
	}

	/**
	 * @param string $releasesUrl
	 *
	 * @return $this
	 */
	public function setReleasesUrl(string $releasesUrl) {
		$this->releasesUrl = $releasesUrl;
		$this->_touchedFields[self::FIELD_RELEASES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReleasesUrl(): string {
		return $this->releasesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReleasesUrl(): bool {
		return $this->releasesUrl !== null;
	}

	/**
	 * @param string $stargazersUrl
	 *
	 * @return $this
	 */
	public function setStargazersUrl(string $stargazersUrl) {
		$this->stargazersUrl = $stargazersUrl;
		$this->_touchedFields[self::FIELD_STARGAZERS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStargazersUrl(): string {
		return $this->stargazersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStargazersUrl(): bool {
		return $this->stargazersUrl !== null;
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
	 * @param string $subscribersUrl
	 *
	 * @return $this
	 */
	public function setSubscribersUrl(string $subscribersUrl) {
		$this->subscribersUrl = $subscribersUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIBERS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubscribersUrl(): string {
		return $this->subscribersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscribersUrl(): bool {
		return $this->subscribersUrl !== null;
	}

	/**
	 * @param string $subscriptionUrl
	 *
	 * @return $this
	 */
	public function setSubscriptionUrl(string $subscriptionUrl) {
		$this->subscriptionUrl = $subscriptionUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTION_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubscriptionUrl(): string {
		return $this->subscriptionUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscriptionUrl(): bool {
		return $this->subscriptionUrl !== null;
	}

	/**
	 * @param string $tagsUrl
	 *
	 * @return $this
	 */
	public function setTagsUrl(string $tagsUrl) {
		$this->tagsUrl = $tagsUrl;
		$this->_touchedFields[self::FIELD_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTagsUrl(): string {
		return $this->tagsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTagsUrl(): bool {
		return $this->tagsUrl !== null;
	}

	/**
	 * @param string $teamsUrl
	 *
	 * @return $this
	 */
	public function setTeamsUrl(string $teamsUrl) {
		$this->teamsUrl = $teamsUrl;
		$this->_touchedFields[self::FIELD_TEAMS_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTeamsUrl(): string {
		return $this->teamsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTeamsUrl(): bool {
		return $this->teamsUrl !== null;
	}

	/**
	 * @param string $treesUrl
	 *
	 * @return $this
	 */
	public function setTreesUrl(string $treesUrl) {
		$this->treesUrl = $treesUrl;
		$this->_touchedFields[self::FIELD_TREES_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTreesUrl(): string {
		return $this->treesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTreesUrl(): bool {
		return $this->treesUrl !== null;
	}

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
	 * @param string $cloneUrl
	 *
	 * @return $this
	 */
	public function setCloneUrl(string $cloneUrl) {
		$this->cloneUrl = $cloneUrl;
		$this->_touchedFields[self::FIELD_CLONE_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCloneUrl(): string {
		return $this->cloneUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCloneUrl(): bool {
		return $this->cloneUrl !== null;
	}

	/**
	 * @param string $defaultBranch
	 *
	 * @return $this
	 */
	public function setDefaultBranch(string $defaultBranch) {
		$this->defaultBranch = $defaultBranch;
		$this->_touchedFields[self::FIELD_DEFAULT_BRANCH] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDefaultBranch(): string {
		return $this->defaultBranch;
	}

	/**
	 * @return bool
	 */
	public function hasDefaultBranch(): bool {
		return $this->defaultBranch !== null;
	}

	/**
	 * @param int $forks
	 *
	 * @return $this
	 */
	public function setForks(int $forks) {
		$this->forks = $forks;
		$this->_touchedFields[self::FIELD_FORKS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getForks(): int {
		return $this->forks;
	}

	/**
	 * @return bool
	 */
	public function hasForks(): bool {
		return $this->forks !== null;
	}

	/**
	 * @param int $forksCount
	 *
	 * @return $this
	 */
	public function setForksCount(int $forksCount) {
		$this->forksCount = $forksCount;
		$this->_touchedFields[self::FIELD_FORKS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getForksCount(): int {
		return $this->forksCount;
	}

	/**
	 * @return bool
	 */
	public function hasForksCount(): bool {
		return $this->forksCount !== null;
	}

	/**
	 * @param string $gitUrl
	 *
	 * @return $this
	 */
	public function setGitUrl(string $gitUrl) {
		$this->gitUrl = $gitUrl;
		$this->_touchedFields[self::FIELD_GIT_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGitUrl(): string {
		return $this->gitUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitUrl(): bool {
		return $this->gitUrl !== null;
	}

	/**
	 * @param bool $hasDownloads
	 *
	 * @return $this
	 */
	public function setHasDownloads(bool $hasDownloads) {
		$this->hasDownloads = $hasDownloads;
		$this->_touchedFields[self::FIELD_HAS_DOWNLOADS] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasDownloads(): bool {
		return $this->hasDownloads;
	}

	/**
	 * @return bool
	 */
	public function hasHasDownloads(): bool {
		return $this->hasDownloads !== null;
	}

	/**
	 * @param bool $hasIssues
	 *
	 * @return $this
	 */
	public function setHasIssues(bool $hasIssues) {
		$this->hasIssues = $hasIssues;
		$this->_touchedFields[self::FIELD_HAS_ISSUES] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasIssues(): bool {
		return $this->hasIssues;
	}

	/**
	 * @return bool
	 */
	public function hasHasIssues(): bool {
		return $this->hasIssues !== null;
	}

	/**
	 * @param bool $hasProjects
	 *
	 * @return $this
	 */
	public function setHasProjects(bool $hasProjects) {
		$this->hasProjects = $hasProjects;
		$this->_touchedFields[self::FIELD_HAS_PROJECTS] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasProjects(): bool {
		return $this->hasProjects;
	}

	/**
	 * @return bool
	 */
	public function hasHasProjects(): bool {
		return $this->hasProjects !== null;
	}

	/**
	 * @param bool $hasWiki
	 *
	 * @return $this
	 */
	public function setHasWiki(bool $hasWiki) {
		$this->hasWiki = $hasWiki;
		$this->_touchedFields[self::FIELD_HAS_WIKI] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasWiki(): bool {
		return $this->hasWiki;
	}

	/**
	 * @return bool
	 */
	public function hasHasWiki(): bool {
		return $this->hasWiki !== null;
	}

	/**
	 * @param bool $hasPages
	 *
	 * @return $this
	 */
	public function setHasPages(bool $hasPages) {
		$this->hasPages = $hasPages;
		$this->_touchedFields[self::FIELD_HAS_PAGES] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasPages(): bool {
		return $this->hasPages;
	}

	/**
	 * @return bool
	 */
	public function hasHasPages(): bool {
		return $this->hasPages !== null;
	}

	/**
	 * @param bool $hasDiscussions
	 *
	 * @return $this
	 */
	public function setHasDiscussions(bool $hasDiscussions) {
		$this->hasDiscussions = $hasDiscussions;
		$this->_touchedFields[self::FIELD_HAS_DISCUSSIONS] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getHasDiscussions(): bool {
		return $this->hasDiscussions;
	}

	/**
	 * @return bool
	 */
	public function hasHasDiscussions(): bool {
		return $this->hasDiscussions !== null;
	}

	/**
	 * @param string|null $homepage
	 *
	 * @return $this
	 */
	public function setHomepage(?string $homepage) {
		$this->homepage = $homepage;
		$this->_touchedFields[self::FIELD_HOMEPAGE] = true;

		return $this;
	}

	/**
	 * @param string $homepage
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHomepageOrFail(string $homepage) {
		$this->homepage = $homepage;
		$this->_touchedFields[self::FIELD_HOMEPAGE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHomepage(): ?string {
		return $this->homepage;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getHomepageOrFail(): string {
		if ($this->homepage === null) {
			throw new \RuntimeException('Value not set for field `homepage` (expected to be not null)');
		}

		return $this->homepage;
	}

	/**
	 * @return bool
	 */
	public function hasHomepage(): bool {
		return $this->homepage !== null;
	}

	/**
	 * @param string|null $language
	 *
	 * @return $this
	 */
	public function setLanguage(?string $language) {
		$this->language = $language;
		$this->_touchedFields[self::FIELD_LANGUAGE] = true;

		return $this;
	}

	/**
	 * @param string $language
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLanguageOrFail(string $language) {
		$this->language = $language;
		$this->_touchedFields[self::FIELD_LANGUAGE] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLanguage(): ?string {
		return $this->language;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLanguageOrFail(): string {
		if ($this->language === null) {
			throw new \RuntimeException('Value not set for field `language` (expected to be not null)');
		}

		return $this->language;
	}

	/**
	 * @return bool
	 */
	public function hasLanguage(): bool {
		return $this->language !== null;
	}

	/**
	 * @param string|null $masterBranch
	 *
	 * @return $this
	 */
	public function setMasterBranch(?string $masterBranch) {
		$this->masterBranch = $masterBranch;
		$this->_touchedFields[self::FIELD_MASTER_BRANCH] = true;

		return $this;
	}

	/**
	 * @param string $masterBranch
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMasterBranchOrFail(string $masterBranch) {
		$this->masterBranch = $masterBranch;
		$this->_touchedFields[self::FIELD_MASTER_BRANCH] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMasterBranch(): ?string {
		return $this->masterBranch;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMasterBranchOrFail(): string {
		if ($this->masterBranch === null) {
			throw new \RuntimeException('Value not set for field `masterBranch` (expected to be not null)');
		}

		return $this->masterBranch;
	}

	/**
	 * @return bool
	 */
	public function hasMasterBranch(): bool {
		return $this->masterBranch !== null;
	}

	/**
	 * @param bool $archived
	 *
	 * @return $this
	 */
	public function setArchived(bool $archived) {
		$this->archived = $archived;
		$this->_touchedFields[self::FIELD_ARCHIVED] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getArchived(): bool {
		return $this->archived;
	}

	/**
	 * @return bool
	 */
	public function hasArchived(): bool {
		return $this->archived !== null;
	}

	/**
	 * @param bool $disabled
	 *
	 * @return $this
	 */
	public function setDisabled(bool $disabled) {
		$this->disabled = $disabled;
		$this->_touchedFields[self::FIELD_DISABLED] = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getDisabled(): bool {
		return $this->disabled;
	}

	/**
	 * @return bool
	 */
	public function hasDisabled(): bool {
		return $this->disabled !== null;
	}

	/**
	 * @param string|null $visibility
	 *
	 * @return $this
	 */
	public function setVisibility(?string $visibility) {
		$this->visibility = $visibility;
		$this->_touchedFields[self::FIELD_VISIBILITY] = true;

		return $this;
	}

	/**
	 * @param string $visibility
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setVisibilityOrFail(string $visibility) {
		$this->visibility = $visibility;
		$this->_touchedFields[self::FIELD_VISIBILITY] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getVisibility(): ?string {
		return $this->visibility;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getVisibilityOrFail(): string {
		if ($this->visibility === null) {
			throw new \RuntimeException('Value not set for field `visibility` (expected to be not null)');
		}

		return $this->visibility;
	}

	/**
	 * @return bool
	 */
	public function hasVisibility(): bool {
		return $this->visibility !== null;
	}

	/**
	 * @param string|null $mirrorUrl
	 *
	 * @return $this
	 */
	public function setMirrorUrl(?string $mirrorUrl) {
		$this->mirrorUrl = $mirrorUrl;
		$this->_touchedFields[self::FIELD_MIRROR_URL] = true;

		return $this;
	}

	/**
	 * @param string $mirrorUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMirrorUrlOrFail(string $mirrorUrl) {
		$this->mirrorUrl = $mirrorUrl;
		$this->_touchedFields[self::FIELD_MIRROR_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMirrorUrl(): ?string {
		return $this->mirrorUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMirrorUrlOrFail(): string {
		if ($this->mirrorUrl === null) {
			throw new \RuntimeException('Value not set for field `mirrorUrl` (expected to be not null)');
		}

		return $this->mirrorUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMirrorUrl(): bool {
		return $this->mirrorUrl !== null;
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
	 * @param int $openIssuesCount
	 *
	 * @return $this
	 */
	public function setOpenIssuesCount(int $openIssuesCount) {
		$this->openIssuesCount = $openIssuesCount;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES_COUNT] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getOpenIssuesCount(): int {
		return $this->openIssuesCount;
	}

	/**
	 * @return bool
	 */
	public function hasOpenIssuesCount(): bool {
		return $this->openIssuesCount !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\PermissionsDto|null $permissions
	 *
	 * @return $this
	 */
	public function setPermissions(?\App\Dto\Test\Schema\PermissionsDto $permissions) {
		$this->permissions = $permissions;
		$this->_touchedFields[self::FIELD_PERMISSIONS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\PermissionsDto $permissions
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPermissionsOrFail(\App\Dto\Test\Schema\PermissionsDto $permissions) {
		$this->permissions = $permissions;
		$this->_touchedFields[self::FIELD_PERMISSIONS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\PermissionsDto|null
	 */
	public function getPermissions(): ?\App\Dto\Test\Schema\PermissionsDto {
		return $this->permissions;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\PermissionsDto
	 */
	public function getPermissionsOrFail(): \App\Dto\Test\Schema\PermissionsDto {
		if ($this->permissions === null) {
			throw new \RuntimeException('Value not set for field `permissions` (expected to be not null)');
		}

		return $this->permissions;
	}

	/**
	 * @return bool
	 */
	public function hasPermissions(): bool {
		return $this->permissions !== null;
	}

	/**
	 * @param string|null $tempCloneToken
	 *
	 * @return $this
	 */
	public function setTempCloneToken(?string $tempCloneToken) {
		$this->tempCloneToken = $tempCloneToken;
		$this->_touchedFields[self::FIELD_TEMP_CLONE_TOKEN] = true;

		return $this;
	}

	/**
	 * @param string $tempCloneToken
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTempCloneTokenOrFail(string $tempCloneToken) {
		$this->tempCloneToken = $tempCloneToken;
		$this->_touchedFields[self::FIELD_TEMP_CLONE_TOKEN] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTempCloneToken(): ?string {
		return $this->tempCloneToken;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTempCloneTokenOrFail(): string {
		if ($this->tempCloneToken === null) {
			throw new \RuntimeException('Value not set for field `tempCloneToken` (expected to be not null)');
		}

		return $this->tempCloneToken;
	}

	/**
	 * @return bool
	 */
	public function hasTempCloneToken(): bool {
		return $this->tempCloneToken !== null;
	}

	/**
	 * @param bool|null $allowMergeCommit
	 *
	 * @return $this
	 */
	public function setAllowMergeCommit(?bool $allowMergeCommit) {
		$this->allowMergeCommit = $allowMergeCommit;
		$this->_touchedFields[self::FIELD_ALLOW_MERGE_COMMIT] = true;

		return $this;
	}

	/**
	 * @param bool $allowMergeCommit
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAllowMergeCommitOrFail(bool $allowMergeCommit) {
		$this->allowMergeCommit = $allowMergeCommit;
		$this->_touchedFields[self::FIELD_ALLOW_MERGE_COMMIT] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getAllowMergeCommit(): ?bool {
		return $this->allowMergeCommit;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getAllowMergeCommitOrFail(): bool {
		if ($this->allowMergeCommit === null) {
			throw new \RuntimeException('Value not set for field `allowMergeCommit` (expected to be not null)');
		}

		return $this->allowMergeCommit;
	}

	/**
	 * @return bool
	 */
	public function hasAllowMergeCommit(): bool {
		return $this->allowMergeCommit !== null;
	}

	/**
	 * @param bool|null $allowSquashMerge
	 *
	 * @return $this
	 */
	public function setAllowSquashMerge(?bool $allowSquashMerge) {
		$this->allowSquashMerge = $allowSquashMerge;
		$this->_touchedFields[self::FIELD_ALLOW_SQUASH_MERGE] = true;

		return $this;
	}

	/**
	 * @param bool $allowSquashMerge
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAllowSquashMergeOrFail(bool $allowSquashMerge) {
		$this->allowSquashMerge = $allowSquashMerge;
		$this->_touchedFields[self::FIELD_ALLOW_SQUASH_MERGE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getAllowSquashMerge(): ?bool {
		return $this->allowSquashMerge;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getAllowSquashMergeOrFail(): bool {
		if ($this->allowSquashMerge === null) {
			throw new \RuntimeException('Value not set for field `allowSquashMerge` (expected to be not null)');
		}

		return $this->allowSquashMerge;
	}

	/**
	 * @return bool
	 */
	public function hasAllowSquashMerge(): bool {
		return $this->allowSquashMerge !== null;
	}

	/**
	 * @param bool|null $allowRebaseMerge
	 *
	 * @return $this
	 */
	public function setAllowRebaseMerge(?bool $allowRebaseMerge) {
		$this->allowRebaseMerge = $allowRebaseMerge;
		$this->_touchedFields[self::FIELD_ALLOW_REBASE_MERGE] = true;

		return $this;
	}

	/**
	 * @param bool $allowRebaseMerge
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAllowRebaseMergeOrFail(bool $allowRebaseMerge) {
		$this->allowRebaseMerge = $allowRebaseMerge;
		$this->_touchedFields[self::FIELD_ALLOW_REBASE_MERGE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getAllowRebaseMerge(): ?bool {
		return $this->allowRebaseMerge;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getAllowRebaseMergeOrFail(): bool {
		if ($this->allowRebaseMerge === null) {
			throw new \RuntimeException('Value not set for field `allowRebaseMerge` (expected to be not null)');
		}

		return $this->allowRebaseMerge;
	}

	/**
	 * @return bool
	 */
	public function hasAllowRebaseMerge(): bool {
		return $this->allowRebaseMerge !== null;
	}

	/**
	 * @param \App\Dto\Test\Schema\LicenseSimpleDto|null $license
	 *
	 * @return $this
	 */
	public function setLicense(?\App\Dto\Test\Schema\LicenseSimpleDto $license) {
		$this->license = $license;
		$this->_touchedFields[self::FIELD_LICENSE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Schema\LicenseSimpleDto $license
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLicenseOrFail(\App\Dto\Test\Schema\LicenseSimpleDto $license) {
		$this->license = $license;
		$this->_touchedFields[self::FIELD_LICENSE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Schema\LicenseSimpleDto|null
	 */
	public function getLicense(): ?\App\Dto\Test\Schema\LicenseSimpleDto {
		return $this->license;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Schema\LicenseSimpleDto
	 */
	public function getLicenseOrFail(): \App\Dto\Test\Schema\LicenseSimpleDto {
		if ($this->license === null) {
			throw new \RuntimeException('Value not set for field `license` (expected to be not null)');
		}

		return $this->license;
	}

	/**
	 * @return bool
	 */
	public function hasLicense(): bool {
		return $this->license !== null;
	}

	/**
	 * @param string $pushedAt
	 *
	 * @return $this
	 */
	public function setPushedAt(string $pushedAt) {
		$this->pushedAt = $pushedAt;
		$this->_touchedFields[self::FIELD_PUSHED_AT] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPushedAt(): string {
		return $this->pushedAt;
	}

	/**
	 * @return bool
	 */
	public function hasPushedAt(): bool {
		return $this->pushedAt !== null;
	}

	/**
	 * @param int $size
	 *
	 * @return $this
	 */
	public function setSize(int $size) {
		$this->size = $size;
		$this->_touchedFields[self::FIELD_SIZE] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSize(): int {
		return $this->size;
	}

	/**
	 * @return bool
	 */
	public function hasSize(): bool {
		return $this->size !== null;
	}

	/**
	 * @param string $sshUrl
	 *
	 * @return $this
	 */
	public function setSshUrl(string $sshUrl) {
		$this->sshUrl = $sshUrl;
		$this->_touchedFields[self::FIELD_SSH_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSshUrl(): string {
		return $this->sshUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSshUrl(): bool {
		return $this->sshUrl !== null;
	}

	/**
	 * @param int $stargazersCount
	 *
	 * @return $this
	 */
	public function setStargazersCount(int $stargazersCount) {
		$this->stargazersCount = $stargazersCount;
		$this->_touchedFields[self::FIELD_STARGAZERS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getStargazersCount(): int {
		return $this->stargazersCount;
	}

	/**
	 * @return bool
	 */
	public function hasStargazersCount(): bool {
		return $this->stargazersCount !== null;
	}

	/**
	 * @param string $svnUrl
	 *
	 * @return $this
	 */
	public function setSvnUrl(string $svnUrl) {
		$this->svnUrl = $svnUrl;
		$this->_touchedFields[self::FIELD_SVN_URL] = true;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSvnUrl(): string {
		return $this->svnUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSvnUrl(): bool {
		return $this->svnUrl !== null;
	}

	/**
	 * @param array|null $topics
	 *
	 * @return $this
	 */
	public function setTopics(?array $topics) {
		$this->topics = $topics;
		$this->_touchedFields[self::FIELD_TOPICS] = true;

		return $this;
	}

	/**
	 * @param array $topics
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTopicsOrFail(array $topics) {
		$this->topics = $topics;
		$this->_touchedFields[self::FIELD_TOPICS] = true;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getTopics(): ?array {
		return $this->topics;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return array
	 */
	public function getTopicsOrFail(): array {
		if ($this->topics === null) {
			throw new \RuntimeException('Value not set for field `topics` (expected to be not null)');
		}

		return $this->topics;
	}

	/**
	 * @return bool
	 */
	public function hasTopics(): bool {
		return $this->topics !== null;
	}

	/**
	 * @param int $watchers
	 *
	 * @return $this
	 */
	public function setWatchers(int $watchers) {
		$this->watchers = $watchers;
		$this->_touchedFields[self::FIELD_WATCHERS] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getWatchers(): int {
		return $this->watchers;
	}

	/**
	 * @return bool
	 */
	public function hasWatchers(): bool {
		return $this->watchers !== null;
	}

	/**
	 * @param int $watchersCount
	 *
	 * @return $this
	 */
	public function setWatchersCount(int $watchersCount) {
		$this->watchersCount = $watchersCount;
		$this->_touchedFields[self::FIELD_WATCHERS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getWatchersCount(): int {
		return $this->watchersCount;
	}

	/**
	 * @return bool
	 */
	public function hasWatchersCount(): bool {
		return $this->watchersCount !== null;
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
	 * @param bool|null $allowForking
	 *
	 * @return $this
	 */
	public function setAllowForking(?bool $allowForking) {
		$this->allowForking = $allowForking;
		$this->_touchedFields[self::FIELD_ALLOW_FORKING] = true;

		return $this;
	}

	/**
	 * @param bool $allowForking
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAllowForkingOrFail(bool $allowForking) {
		$this->allowForking = $allowForking;
		$this->_touchedFields[self::FIELD_ALLOW_FORKING] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getAllowForking(): ?bool {
		return $this->allowForking;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getAllowForkingOrFail(): bool {
		if ($this->allowForking === null) {
			throw new \RuntimeException('Value not set for field `allowForking` (expected to be not null)');
		}

		return $this->allowForking;
	}

	/**
	 * @return bool
	 */
	public function hasAllowForking(): bool {
		return $this->allowForking !== null;
	}

	/**
	 * @param bool|null $webCommitSignoffRequired
	 *
	 * @return $this
	 */
	public function setWebCommitSignoffRequired(?bool $webCommitSignoffRequired) {
		$this->webCommitSignoffRequired = $webCommitSignoffRequired;
		$this->_touchedFields[self::FIELD_WEB_COMMIT_SIGNOFF_REQUIRED] = true;

		return $this;
	}

	/**
	 * @param bool $webCommitSignoffRequired
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setWebCommitSignoffRequiredOrFail(bool $webCommitSignoffRequired) {
		$this->webCommitSignoffRequired = $webCommitSignoffRequired;
		$this->_touchedFields[self::FIELD_WEB_COMMIT_SIGNOFF_REQUIRED] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getWebCommitSignoffRequired(): ?bool {
		return $this->webCommitSignoffRequired;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getWebCommitSignoffRequiredOrFail(): bool {
		if ($this->webCommitSignoffRequired === null) {
			throw new \RuntimeException('Value not set for field `webCommitSignoffRequired` (expected to be not null)');
		}

		return $this->webCommitSignoffRequired;
	}

	/**
	 * @return bool
	 */
	public function hasWebCommitSignoffRequired(): bool {
		return $this->webCommitSignoffRequired !== null;
	}

}
