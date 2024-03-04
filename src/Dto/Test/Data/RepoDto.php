<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto\Test\Data;

/**
 * Test/Data/Repo DTO
 *
 * @property int|null $id
 * @property string|null $nodeId
 * @property string|null $name
 * @property string|null $fullName
 * @property \App\Dto\Test\Data\OwnerDto|null $owner
 * @property bool|null $private
 * @property string|null $htmlUrl
 * @property string|null $description
 * @property bool|null $fork
 * @property string|null $url
 * @property string|null $archiveUrl
 * @property string|null $assigneesUrl
 * @property string|null $blobsUrl
 * @property string|null $branchesUrl
 * @property string|null $collaboratorsUrl
 * @property string|null $commentsUrl
 * @property string|null $commitsUrl
 * @property string|null $compareUrl
 * @property string|null $contentsUrl
 * @property string|null $contributorsUrl
 * @property string|null $deploymentsUrl
 * @property string|null $downloadsUrl
 * @property string|null $eventsUrl
 * @property string|null $forksUrl
 * @property string|null $gitCommitsUrl
 * @property string|null $gitRefsUrl
 * @property string|null $gitTagsUrl
 * @property string|null $gitUrl
 * @property string|null $issueCommentUrl
 * @property string|null $issueEventsUrl
 * @property string|null $issuesUrl
 * @property string|null $keysUrl
 * @property string|null $labelsUrl
 * @property string|null $languagesUrl
 * @property string|null $mergesUrl
 * @property string|null $milestonesUrl
 * @property string|null $notificationsUrl
 * @property string|null $pullsUrl
 * @property string|null $releasesUrl
 * @property string|null $sshUrl
 * @property string|null $stargazersUrl
 * @property string|null $statusesUrl
 * @property string|null $subscribersUrl
 * @property string|null $subscriptionUrl
 * @property string|null $tagsUrl
 * @property string|null $teamsUrl
 * @property string|null $treesUrl
 * @property string|null $cloneUrl
 * @property string|null $mirrorUrl
 * @property string|null $hooksUrl
 * @property string|null $svnUrl
 * @property string|null $homepage
 * @property mixed|null $language
 * @property int|null $forksCount
 * @property int|null $stargazersCount
 * @property int|null $watchersCount
 * @property int|null $size
 * @property string|null $defaultBranch
 * @property int|null $openIssuesCount
 * @property array|null $topics
 * @property bool|null $hasIssues
 * @property bool|null $hasProjects
 * @property bool|null $hasWiki
 * @property bool|null $hasPages
 * @property bool|null $hasDownloads
 * @property bool|null $hasDiscussions
 * @property bool|null $archived
 * @property bool|null $disabled
 * @property string|null $pushedAt
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property \App\Dto\Test\Data\PermissionsDto|null $permissions
 * @property bool|null $allowRebaseMerge
 * @property string|null $tempCloneToken
 * @property bool|null $allowSquashMerge
 * @property bool|null $allowMergeCommit
 * @property int|null $forks
 * @property int|null $openIssues
 * @property \App\Dto\Test\Data\LicenseDto|null $license
 * @property int|null $watchers
 */
class RepoDto extends \CakeDto\Dto\AbstractDto {

	public const FIELD_ID = 'id';
	public const FIELD_NODE_ID = 'nodeId';
	public const FIELD_NAME = 'name';
	public const FIELD_FULL_NAME = 'fullName';
	public const FIELD_OWNER = 'owner';
	public const FIELD_PRIVATE = 'private';
	public const FIELD_HTML_URL = 'htmlUrl';
	public const FIELD_DESCRIPTION = 'description';
	public const FIELD_FORK = 'fork';
	public const FIELD_URL = 'url';
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
	public const FIELD_DOWNLOADS_URL = 'downloadsUrl';
	public const FIELD_EVENTS_URL = 'eventsUrl';
	public const FIELD_FORKS_URL = 'forksUrl';
	public const FIELD_GIT_COMMITS_URL = 'gitCommitsUrl';
	public const FIELD_GIT_REFS_URL = 'gitRefsUrl';
	public const FIELD_GIT_TAGS_URL = 'gitTagsUrl';
	public const FIELD_GIT_URL = 'gitUrl';
	public const FIELD_ISSUE_COMMENT_URL = 'issueCommentUrl';
	public const FIELD_ISSUE_EVENTS_URL = 'issueEventsUrl';
	public const FIELD_ISSUES_URL = 'issuesUrl';
	public const FIELD_KEYS_URL = 'keysUrl';
	public const FIELD_LABELS_URL = 'labelsUrl';
	public const FIELD_LANGUAGES_URL = 'languagesUrl';
	public const FIELD_MERGES_URL = 'mergesUrl';
	public const FIELD_MILESTONES_URL = 'milestonesUrl';
	public const FIELD_NOTIFICATIONS_URL = 'notificationsUrl';
	public const FIELD_PULLS_URL = 'pullsUrl';
	public const FIELD_RELEASES_URL = 'releasesUrl';
	public const FIELD_SSH_URL = 'sshUrl';
	public const FIELD_STARGAZERS_URL = 'stargazersUrl';
	public const FIELD_STATUSES_URL = 'statusesUrl';
	public const FIELD_SUBSCRIBERS_URL = 'subscribersUrl';
	public const FIELD_SUBSCRIPTION_URL = 'subscriptionUrl';
	public const FIELD_TAGS_URL = 'tagsUrl';
	public const FIELD_TEAMS_URL = 'teamsUrl';
	public const FIELD_TREES_URL = 'treesUrl';
	public const FIELD_CLONE_URL = 'cloneUrl';
	public const FIELD_MIRROR_URL = 'mirrorUrl';
	public const FIELD_HOOKS_URL = 'hooksUrl';
	public const FIELD_SVN_URL = 'svnUrl';
	public const FIELD_HOMEPAGE = 'homepage';
	public const FIELD_LANGUAGE = 'language';
	public const FIELD_FORKS_COUNT = 'forksCount';
	public const FIELD_STARGAZERS_COUNT = 'stargazersCount';
	public const FIELD_WATCHERS_COUNT = 'watchersCount';
	public const FIELD_SIZE = 'size';
	public const FIELD_DEFAULT_BRANCH = 'defaultBranch';
	public const FIELD_OPEN_ISSUES_COUNT = 'openIssuesCount';
	public const FIELD_TOPICS = 'topics';
	public const FIELD_HAS_ISSUES = 'hasIssues';
	public const FIELD_HAS_PROJECTS = 'hasProjects';
	public const FIELD_HAS_WIKI = 'hasWiki';
	public const FIELD_HAS_PAGES = 'hasPages';
	public const FIELD_HAS_DOWNLOADS = 'hasDownloads';
	public const FIELD_HAS_DISCUSSIONS = 'hasDiscussions';
	public const FIELD_ARCHIVED = 'archived';
	public const FIELD_DISABLED = 'disabled';
	public const FIELD_PUSHED_AT = 'pushedAt';
	public const FIELD_CREATED_AT = 'createdAt';
	public const FIELD_UPDATED_AT = 'updatedAt';
	public const FIELD_PERMISSIONS = 'permissions';
	public const FIELD_ALLOW_REBASE_MERGE = 'allowRebaseMerge';
	public const FIELD_TEMP_CLONE_TOKEN = 'tempCloneToken';
	public const FIELD_ALLOW_SQUASH_MERGE = 'allowSquashMerge';
	public const FIELD_ALLOW_MERGE_COMMIT = 'allowMergeCommit';
	public const FIELD_FORKS = 'forks';
	public const FIELD_OPEN_ISSUES = 'openIssues';
	public const FIELD_LICENSE = 'license';
	public const FIELD_WATCHERS = 'watchers';

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
	protected $name;

	/**
	 * @var string|null
	 */
	protected $fullName;

	/**
	 * @var \App\Dto\Test\Data\OwnerDto|null
	 */
	protected $owner;

	/**
	 * @var bool|null
	 */
	protected $private;

	/**
	 * @var string|null
	 */
	protected $htmlUrl;

	/**
	 * @var string|null
	 */
	protected $description;

	/**
	 * @var bool|null
	 */
	protected $fork;

	/**
	 * @var string|null
	 */
	protected $url;

	/**
	 * @var string|null
	 */
	protected $archiveUrl;

	/**
	 * @var string|null
	 */
	protected $assigneesUrl;

	/**
	 * @var string|null
	 */
	protected $blobsUrl;

	/**
	 * @var string|null
	 */
	protected $branchesUrl;

	/**
	 * @var string|null
	 */
	protected $collaboratorsUrl;

	/**
	 * @var string|null
	 */
	protected $commentsUrl;

	/**
	 * @var string|null
	 */
	protected $commitsUrl;

	/**
	 * @var string|null
	 */
	protected $compareUrl;

	/**
	 * @var string|null
	 */
	protected $contentsUrl;

	/**
	 * @var string|null
	 */
	protected $contributorsUrl;

	/**
	 * @var string|null
	 */
	protected $deploymentsUrl;

	/**
	 * @var string|null
	 */
	protected $downloadsUrl;

	/**
	 * @var string|null
	 */
	protected $eventsUrl;

	/**
	 * @var string|null
	 */
	protected $forksUrl;

	/**
	 * @var string|null
	 */
	protected $gitCommitsUrl;

	/**
	 * @var string|null
	 */
	protected $gitRefsUrl;

	/**
	 * @var string|null
	 */
	protected $gitTagsUrl;

	/**
	 * @var string|null
	 */
	protected $gitUrl;

	/**
	 * @var string|null
	 */
	protected $issueCommentUrl;

	/**
	 * @var string|null
	 */
	protected $issueEventsUrl;

	/**
	 * @var string|null
	 */
	protected $issuesUrl;

	/**
	 * @var string|null
	 */
	protected $keysUrl;

	/**
	 * @var string|null
	 */
	protected $labelsUrl;

	/**
	 * @var string|null
	 */
	protected $languagesUrl;

	/**
	 * @var string|null
	 */
	protected $mergesUrl;

	/**
	 * @var string|null
	 */
	protected $milestonesUrl;

	/**
	 * @var string|null
	 */
	protected $notificationsUrl;

	/**
	 * @var string|null
	 */
	protected $pullsUrl;

	/**
	 * @var string|null
	 */
	protected $releasesUrl;

	/**
	 * @var string|null
	 */
	protected $sshUrl;

	/**
	 * @var string|null
	 */
	protected $stargazersUrl;

	/**
	 * @var string|null
	 */
	protected $statusesUrl;

	/**
	 * @var string|null
	 */
	protected $subscribersUrl;

	/**
	 * @var string|null
	 */
	protected $subscriptionUrl;

	/**
	 * @var string|null
	 */
	protected $tagsUrl;

	/**
	 * @var string|null
	 */
	protected $teamsUrl;

	/**
	 * @var string|null
	 */
	protected $treesUrl;

	/**
	 * @var string|null
	 */
	protected $cloneUrl;

	/**
	 * @var string|null
	 */
	protected $mirrorUrl;

	/**
	 * @var string|null
	 */
	protected $hooksUrl;

	/**
	 * @var string|null
	 */
	protected $svnUrl;

	/**
	 * @var string|null
	 */
	protected $homepage;

	/**
	 * @var mixed|null
	 */
	protected $language;

	/**
	 * @var int|null
	 */
	protected $forksCount;

	/**
	 * @var int|null
	 */
	protected $stargazersCount;

	/**
	 * @var int|null
	 */
	protected $watchersCount;

	/**
	 * @var int|null
	 */
	protected $size;

	/**
	 * @var string|null
	 */
	protected $defaultBranch;

	/**
	 * @var int|null
	 */
	protected $openIssuesCount;

	/**
	 * @var array|null
	 */
	protected $topics;

	/**
	 * @var bool|null
	 */
	protected $hasIssues;

	/**
	 * @var bool|null
	 */
	protected $hasProjects;

	/**
	 * @var bool|null
	 */
	protected $hasWiki;

	/**
	 * @var bool|null
	 */
	protected $hasPages;

	/**
	 * @var bool|null
	 */
	protected $hasDownloads;

	/**
	 * @var bool|null
	 */
	protected $hasDiscussions;

	/**
	 * @var bool|null
	 */
	protected $archived;

	/**
	 * @var bool|null
	 */
	protected $disabled;

	/**
	 * @var string|null
	 */
	protected $pushedAt;

	/**
	 * @var string|null
	 */
	protected $createdAt;

	/**
	 * @var string|null
	 */
	protected $updatedAt;

	/**
	 * @var \App\Dto\Test\Data\PermissionsDto|null
	 */
	protected $permissions;

	/**
	 * @var bool|null
	 */
	protected $allowRebaseMerge;

	/**
	 * @var string|null
	 */
	protected $tempCloneToken;

	/**
	 * @var bool|null
	 */
	protected $allowSquashMerge;

	/**
	 * @var bool|null
	 */
	protected $allowMergeCommit;

	/**
	 * @var int|null
	 */
	protected $forks;

	/**
	 * @var int|null
	 */
	protected $openIssues;

	/**
	 * @var \App\Dto\Test\Data\LicenseDto|null
	 */
	protected $license;

	/**
	 * @var int|null
	 */
	protected $watchers;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
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
		'name' => [
			'name' => 'name',
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
		'fullName' => [
			'name' => 'fullName',
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
		'owner' => [
			'name' => 'owner',
			'type' => '\App\Dto\Test\Data\OwnerDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Owner',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'private' => [
			'name' => 'private',
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
		'fork' => [
			'name' => 'fork',
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
		'archiveUrl' => [
			'name' => 'archiveUrl',
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
		'assigneesUrl' => [
			'name' => 'assigneesUrl',
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
		'blobsUrl' => [
			'name' => 'blobsUrl',
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
		'branchesUrl' => [
			'name' => 'branchesUrl',
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
		'collaboratorsUrl' => [
			'name' => 'collaboratorsUrl',
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
		'compareUrl' => [
			'name' => 'compareUrl',
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
		'contentsUrl' => [
			'name' => 'contentsUrl',
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
		'contributorsUrl' => [
			'name' => 'contributorsUrl',
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
		'deploymentsUrl' => [
			'name' => 'deploymentsUrl',
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
			'required' => false,
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
		'subscribersUrl' => [
			'name' => 'subscribersUrl',
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
		'subscriptionUrl' => [
			'name' => 'subscriptionUrl',
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
		'tagsUrl' => [
			'name' => 'tagsUrl',
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
		'teamsUrl' => [
			'name' => 'teamsUrl',
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
		'treesUrl' => [
			'name' => 'treesUrl',
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
		'cloneUrl' => [
			'name' => 'cloneUrl',
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
		'hooksUrl' => [
			'name' => 'hooksUrl',
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
		'svnUrl' => [
			'name' => 'svnUrl',
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
		'forksCount' => [
			'name' => 'forksCount',
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
		'stargazersCount' => [
			'name' => 'stargazersCount',
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
		'watchersCount' => [
			'name' => 'watchersCount',
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
		'size' => [
			'name' => 'size',
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
		'defaultBranch' => [
			'name' => 'defaultBranch',
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
		'openIssuesCount' => [
			'name' => 'openIssuesCount',
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
		'hasIssues' => [
			'name' => 'hasIssues',
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
		'hasProjects' => [
			'name' => 'hasProjects',
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
		'hasWiki' => [
			'name' => 'hasWiki',
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
		'hasPages' => [
			'name' => 'hasPages',
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
		'hasDownloads' => [
			'name' => 'hasDownloads',
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
		'hasDiscussions' => [
			'name' => 'hasDiscussions',
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
		'archived' => [
			'name' => 'archived',
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
		'disabled' => [
			'name' => 'disabled',
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
		'pushedAt' => [
			'name' => 'pushedAt',
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
		'permissions' => [
			'name' => 'permissions',
			'type' => '\App\Dto\Test\Data\PermissionsDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/Permissions',
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
		'forks' => [
			'name' => 'forks',
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
		'openIssues' => [
			'name' => 'openIssues',
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
		'license' => [
			'name' => 'license',
			'type' => '\App\Dto\Test\Data\LicenseDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'Test/Data/License',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
		],
		'watchers' => [
			'name' => 'watchers',
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
			'id' => 'id',
			'node_id' => 'nodeId',
			'name' => 'name',
			'full_name' => 'fullName',
			'owner' => 'owner',
			'private' => 'private',
			'html_url' => 'htmlUrl',
			'description' => 'description',
			'fork' => 'fork',
			'url' => 'url',
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
			'downloads_url' => 'downloadsUrl',
			'events_url' => 'eventsUrl',
			'forks_url' => 'forksUrl',
			'git_commits_url' => 'gitCommitsUrl',
			'git_refs_url' => 'gitRefsUrl',
			'git_tags_url' => 'gitTagsUrl',
			'git_url' => 'gitUrl',
			'issue_comment_url' => 'issueCommentUrl',
			'issue_events_url' => 'issueEventsUrl',
			'issues_url' => 'issuesUrl',
			'keys_url' => 'keysUrl',
			'labels_url' => 'labelsUrl',
			'languages_url' => 'languagesUrl',
			'merges_url' => 'mergesUrl',
			'milestones_url' => 'milestonesUrl',
			'notifications_url' => 'notificationsUrl',
			'pulls_url' => 'pullsUrl',
			'releases_url' => 'releasesUrl',
			'ssh_url' => 'sshUrl',
			'stargazers_url' => 'stargazersUrl',
			'statuses_url' => 'statusesUrl',
			'subscribers_url' => 'subscribersUrl',
			'subscription_url' => 'subscriptionUrl',
			'tags_url' => 'tagsUrl',
			'teams_url' => 'teamsUrl',
			'trees_url' => 'treesUrl',
			'clone_url' => 'cloneUrl',
			'mirror_url' => 'mirrorUrl',
			'hooks_url' => 'hooksUrl',
			'svn_url' => 'svnUrl',
			'homepage' => 'homepage',
			'language' => 'language',
			'forks_count' => 'forksCount',
			'stargazers_count' => 'stargazersCount',
			'watchers_count' => 'watchersCount',
			'size' => 'size',
			'default_branch' => 'defaultBranch',
			'open_issues_count' => 'openIssuesCount',
			'topics' => 'topics',
			'has_issues' => 'hasIssues',
			'has_projects' => 'hasProjects',
			'has_wiki' => 'hasWiki',
			'has_pages' => 'hasPages',
			'has_downloads' => 'hasDownloads',
			'has_discussions' => 'hasDiscussions',
			'archived' => 'archived',
			'disabled' => 'disabled',
			'pushed_at' => 'pushedAt',
			'created_at' => 'createdAt',
			'updated_at' => 'updatedAt',
			'permissions' => 'permissions',
			'allow_rebase_merge' => 'allowRebaseMerge',
			'temp_clone_token' => 'tempCloneToken',
			'allow_squash_merge' => 'allowSquashMerge',
			'allow_merge_commit' => 'allowMergeCommit',
			'forks' => 'forks',
			'open_issues' => 'openIssues',
			'license' => 'license',
			'watchers' => 'watchers',
		],
		'dashed' => [
			'id' => 'id',
			'node-id' => 'nodeId',
			'name' => 'name',
			'full-name' => 'fullName',
			'owner' => 'owner',
			'private' => 'private',
			'html-url' => 'htmlUrl',
			'description' => 'description',
			'fork' => 'fork',
			'url' => 'url',
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
			'downloads-url' => 'downloadsUrl',
			'events-url' => 'eventsUrl',
			'forks-url' => 'forksUrl',
			'git-commits-url' => 'gitCommitsUrl',
			'git-refs-url' => 'gitRefsUrl',
			'git-tags-url' => 'gitTagsUrl',
			'git-url' => 'gitUrl',
			'issue-comment-url' => 'issueCommentUrl',
			'issue-events-url' => 'issueEventsUrl',
			'issues-url' => 'issuesUrl',
			'keys-url' => 'keysUrl',
			'labels-url' => 'labelsUrl',
			'languages-url' => 'languagesUrl',
			'merges-url' => 'mergesUrl',
			'milestones-url' => 'milestonesUrl',
			'notifications-url' => 'notificationsUrl',
			'pulls-url' => 'pullsUrl',
			'releases-url' => 'releasesUrl',
			'ssh-url' => 'sshUrl',
			'stargazers-url' => 'stargazersUrl',
			'statuses-url' => 'statusesUrl',
			'subscribers-url' => 'subscribersUrl',
			'subscription-url' => 'subscriptionUrl',
			'tags-url' => 'tagsUrl',
			'teams-url' => 'teamsUrl',
			'trees-url' => 'treesUrl',
			'clone-url' => 'cloneUrl',
			'mirror-url' => 'mirrorUrl',
			'hooks-url' => 'hooksUrl',
			'svn-url' => 'svnUrl',
			'homepage' => 'homepage',
			'language' => 'language',
			'forks-count' => 'forksCount',
			'stargazers-count' => 'stargazersCount',
			'watchers-count' => 'watchersCount',
			'size' => 'size',
			'default-branch' => 'defaultBranch',
			'open-issues-count' => 'openIssuesCount',
			'topics' => 'topics',
			'has-issues' => 'hasIssues',
			'has-projects' => 'hasProjects',
			'has-wiki' => 'hasWiki',
			'has-pages' => 'hasPages',
			'has-downloads' => 'hasDownloads',
			'has-discussions' => 'hasDiscussions',
			'archived' => 'archived',
			'disabled' => 'disabled',
			'pushed-at' => 'pushedAt',
			'created-at' => 'createdAt',
			'updated-at' => 'updatedAt',
			'permissions' => 'permissions',
			'allow-rebase-merge' => 'allowRebaseMerge',
			'temp-clone-token' => 'tempCloneToken',
			'allow-squash-merge' => 'allowSquashMerge',
			'allow-merge-commit' => 'allowMergeCommit',
			'forks' => 'forks',
			'open-issues' => 'openIssues',
			'license' => 'license',
			'watchers' => 'watchers',
		],
	];

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
	 * @param string|null $name
	 *
	 * @return $this
	 */
	public function setName(?string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNameOrFail(string $name) {
		$this->name = $name;
		$this->_touchedFields[self::FIELD_NAME] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNameOrFail(): string {
		if ($this->name === null) {
			throw new \RuntimeException('Value not set for field `name` (expected to be not null)');
		}

		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasName(): bool {
		return $this->name !== null;
	}

	/**
	 * @param string|null $fullName
	 *
	 * @return $this
	 */
	public function setFullName(?string $fullName) {
		$this->fullName = $fullName;
		$this->_touchedFields[self::FIELD_FULL_NAME] = true;

		return $this;
	}

	/**
	 * @param string $fullName
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setFullNameOrFail(string $fullName) {
		$this->fullName = $fullName;
		$this->_touchedFields[self::FIELD_FULL_NAME] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFullName(): ?string {
		return $this->fullName;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getFullNameOrFail(): string {
		if ($this->fullName === null) {
			throw new \RuntimeException('Value not set for field `fullName` (expected to be not null)');
		}

		return $this->fullName;
	}

	/**
	 * @return bool
	 */
	public function hasFullName(): bool {
		return $this->fullName !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\OwnerDto|null $owner
	 *
	 * @return $this
	 */
	public function setOwner(?\App\Dto\Test\Data\OwnerDto $owner) {
		$this->owner = $owner;
		$this->_touchedFields[self::FIELD_OWNER] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\OwnerDto $owner
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setOwnerOrFail(\App\Dto\Test\Data\OwnerDto $owner) {
		$this->owner = $owner;
		$this->_touchedFields[self::FIELD_OWNER] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\OwnerDto|null
	 */
	public function getOwner(): ?\App\Dto\Test\Data\OwnerDto {
		return $this->owner;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\OwnerDto
	 */
	public function getOwnerOrFail(): \App\Dto\Test\Data\OwnerDto {
		if ($this->owner === null) {
			throw new \RuntimeException('Value not set for field `owner` (expected to be not null)');
		}

		return $this->owner;
	}

	/**
	 * @return bool
	 */
	public function hasOwner(): bool {
		return $this->owner !== null;
	}

	/**
	 * @param bool|null $private
	 *
	 * @return $this
	 */
	public function setPrivate(?bool $private) {
		$this->private = $private;
		$this->_touchedFields[self::FIELD_PRIVATE] = true;

		return $this;
	}

	/**
	 * @param bool $private
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPrivateOrFail(bool $private) {
		$this->private = $private;
		$this->_touchedFields[self::FIELD_PRIVATE] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getPrivate(): ?bool {
		return $this->private;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getPrivateOrFail(): bool {
		if ($this->private === null) {
			throw new \RuntimeException('Value not set for field `private` (expected to be not null)');
		}

		return $this->private;
	}

	/**
	 * @return bool
	 */
	public function hasPrivate(): bool {
		return $this->private !== null;
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
	 * @param bool|null $fork
	 *
	 * @return $this
	 */
	public function setFork(?bool $fork) {
		$this->fork = $fork;
		$this->_touchedFields[self::FIELD_FORK] = true;

		return $this;
	}

	/**
	 * @param bool $fork
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setForkOrFail(bool $fork) {
		$this->fork = $fork;
		$this->_touchedFields[self::FIELD_FORK] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getFork(): ?bool {
		return $this->fork;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getForkOrFail(): bool {
		if ($this->fork === null) {
			throw new \RuntimeException('Value not set for field `fork` (expected to be not null)');
		}

		return $this->fork;
	}

	/**
	 * @return bool
	 */
	public function hasFork(): bool {
		return $this->fork !== null;
	}

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
	 * @param string|null $archiveUrl
	 *
	 * @return $this
	 */
	public function setArchiveUrl(?string $archiveUrl) {
		$this->archiveUrl = $archiveUrl;
		$this->_touchedFields[self::FIELD_ARCHIVE_URL] = true;

		return $this;
	}

	/**
	 * @param string $archiveUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setArchiveUrlOrFail(string $archiveUrl) {
		$this->archiveUrl = $archiveUrl;
		$this->_touchedFields[self::FIELD_ARCHIVE_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getArchiveUrl(): ?string {
		return $this->archiveUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getArchiveUrlOrFail(): string {
		if ($this->archiveUrl === null) {
			throw new \RuntimeException('Value not set for field `archiveUrl` (expected to be not null)');
		}

		return $this->archiveUrl;
	}

	/**
	 * @return bool
	 */
	public function hasArchiveUrl(): bool {
		return $this->archiveUrl !== null;
	}

	/**
	 * @param string|null $assigneesUrl
	 *
	 * @return $this
	 */
	public function setAssigneesUrl(?string $assigneesUrl) {
		$this->assigneesUrl = $assigneesUrl;
		$this->_touchedFields[self::FIELD_ASSIGNEES_URL] = true;

		return $this;
	}

	/**
	 * @param string $assigneesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setAssigneesUrlOrFail(string $assigneesUrl) {
		$this->assigneesUrl = $assigneesUrl;
		$this->_touchedFields[self::FIELD_ASSIGNEES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAssigneesUrl(): ?string {
		return $this->assigneesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getAssigneesUrlOrFail(): string {
		if ($this->assigneesUrl === null) {
			throw new \RuntimeException('Value not set for field `assigneesUrl` (expected to be not null)');
		}

		return $this->assigneesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasAssigneesUrl(): bool {
		return $this->assigneesUrl !== null;
	}

	/**
	 * @param string|null $blobsUrl
	 *
	 * @return $this
	 */
	public function setBlobsUrl(?string $blobsUrl) {
		$this->blobsUrl = $blobsUrl;
		$this->_touchedFields[self::FIELD_BLOBS_URL] = true;

		return $this;
	}

	/**
	 * @param string $blobsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setBlobsUrlOrFail(string $blobsUrl) {
		$this->blobsUrl = $blobsUrl;
		$this->_touchedFields[self::FIELD_BLOBS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getBlobsUrl(): ?string {
		return $this->blobsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getBlobsUrlOrFail(): string {
		if ($this->blobsUrl === null) {
			throw new \RuntimeException('Value not set for field `blobsUrl` (expected to be not null)');
		}

		return $this->blobsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasBlobsUrl(): bool {
		return $this->blobsUrl !== null;
	}

	/**
	 * @param string|null $branchesUrl
	 *
	 * @return $this
	 */
	public function setBranchesUrl(?string $branchesUrl) {
		$this->branchesUrl = $branchesUrl;
		$this->_touchedFields[self::FIELD_BRANCHES_URL] = true;

		return $this;
	}

	/**
	 * @param string $branchesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setBranchesUrlOrFail(string $branchesUrl) {
		$this->branchesUrl = $branchesUrl;
		$this->_touchedFields[self::FIELD_BRANCHES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getBranchesUrl(): ?string {
		return $this->branchesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getBranchesUrlOrFail(): string {
		if ($this->branchesUrl === null) {
			throw new \RuntimeException('Value not set for field `branchesUrl` (expected to be not null)');
		}

		return $this->branchesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasBranchesUrl(): bool {
		return $this->branchesUrl !== null;
	}

	/**
	 * @param string|null $collaboratorsUrl
	 *
	 * @return $this
	 */
	public function setCollaboratorsUrl(?string $collaboratorsUrl) {
		$this->collaboratorsUrl = $collaboratorsUrl;
		$this->_touchedFields[self::FIELD_COLLABORATORS_URL] = true;

		return $this;
	}

	/**
	 * @param string $collaboratorsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCollaboratorsUrlOrFail(string $collaboratorsUrl) {
		$this->collaboratorsUrl = $collaboratorsUrl;
		$this->_touchedFields[self::FIELD_COLLABORATORS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCollaboratorsUrl(): ?string {
		return $this->collaboratorsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCollaboratorsUrlOrFail(): string {
		if ($this->collaboratorsUrl === null) {
			throw new \RuntimeException('Value not set for field `collaboratorsUrl` (expected to be not null)');
		}

		return $this->collaboratorsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCollaboratorsUrl(): bool {
		return $this->collaboratorsUrl !== null;
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
	 * @param string|null $compareUrl
	 *
	 * @return $this
	 */
	public function setCompareUrl(?string $compareUrl) {
		$this->compareUrl = $compareUrl;
		$this->_touchedFields[self::FIELD_COMPARE_URL] = true;

		return $this;
	}

	/**
	 * @param string $compareUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCompareUrlOrFail(string $compareUrl) {
		$this->compareUrl = $compareUrl;
		$this->_touchedFields[self::FIELD_COMPARE_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCompareUrl(): ?string {
		return $this->compareUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCompareUrlOrFail(): string {
		if ($this->compareUrl === null) {
			throw new \RuntimeException('Value not set for field `compareUrl` (expected to be not null)');
		}

		return $this->compareUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCompareUrl(): bool {
		return $this->compareUrl !== null;
	}

	/**
	 * @param string|null $contentsUrl
	 *
	 * @return $this
	 */
	public function setContentsUrl(?string $contentsUrl) {
		$this->contentsUrl = $contentsUrl;
		$this->_touchedFields[self::FIELD_CONTENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $contentsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setContentsUrlOrFail(string $contentsUrl) {
		$this->contentsUrl = $contentsUrl;
		$this->_touchedFields[self::FIELD_CONTENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getContentsUrl(): ?string {
		return $this->contentsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getContentsUrlOrFail(): string {
		if ($this->contentsUrl === null) {
			throw new \RuntimeException('Value not set for field `contentsUrl` (expected to be not null)');
		}

		return $this->contentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasContentsUrl(): bool {
		return $this->contentsUrl !== null;
	}

	/**
	 * @param string|null $contributorsUrl
	 *
	 * @return $this
	 */
	public function setContributorsUrl(?string $contributorsUrl) {
		$this->contributorsUrl = $contributorsUrl;
		$this->_touchedFields[self::FIELD_CONTRIBUTORS_URL] = true;

		return $this;
	}

	/**
	 * @param string $contributorsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setContributorsUrlOrFail(string $contributorsUrl) {
		$this->contributorsUrl = $contributorsUrl;
		$this->_touchedFields[self::FIELD_CONTRIBUTORS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getContributorsUrl(): ?string {
		return $this->contributorsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getContributorsUrlOrFail(): string {
		if ($this->contributorsUrl === null) {
			throw new \RuntimeException('Value not set for field `contributorsUrl` (expected to be not null)');
		}

		return $this->contributorsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasContributorsUrl(): bool {
		return $this->contributorsUrl !== null;
	}

	/**
	 * @param string|null $deploymentsUrl
	 *
	 * @return $this
	 */
	public function setDeploymentsUrl(?string $deploymentsUrl) {
		$this->deploymentsUrl = $deploymentsUrl;
		$this->_touchedFields[self::FIELD_DEPLOYMENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $deploymentsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDeploymentsUrlOrFail(string $deploymentsUrl) {
		$this->deploymentsUrl = $deploymentsUrl;
		$this->_touchedFields[self::FIELD_DEPLOYMENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDeploymentsUrl(): ?string {
		return $this->deploymentsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDeploymentsUrlOrFail(): string {
		if ($this->deploymentsUrl === null) {
			throw new \RuntimeException('Value not set for field `deploymentsUrl` (expected to be not null)');
		}

		return $this->deploymentsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDeploymentsUrl(): bool {
		return $this->deploymentsUrl !== null;
	}

	/**
	 * @param string|null $downloadsUrl
	 *
	 * @return $this
	 */
	public function setDownloadsUrl(?string $downloadsUrl) {
		$this->downloadsUrl = $downloadsUrl;
		$this->_touchedFields[self::FIELD_DOWNLOADS_URL] = true;

		return $this;
	}

	/**
	 * @param string $downloadsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDownloadsUrlOrFail(string $downloadsUrl) {
		$this->downloadsUrl = $downloadsUrl;
		$this->_touchedFields[self::FIELD_DOWNLOADS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDownloadsUrl(): ?string {
		return $this->downloadsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDownloadsUrlOrFail(): string {
		if ($this->downloadsUrl === null) {
			throw new \RuntimeException('Value not set for field `downloadsUrl` (expected to be not null)');
		}

		return $this->downloadsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasDownloadsUrl(): bool {
		return $this->downloadsUrl !== null;
	}

	/**
	 * @param string|null $eventsUrl
	 *
	 * @return $this
	 */
	public function setEventsUrl(?string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $eventsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setEventsUrlOrFail(string $eventsUrl) {
		$this->eventsUrl = $eventsUrl;
		$this->_touchedFields[self::FIELD_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getEventsUrl(): ?string {
		return $this->eventsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getEventsUrlOrFail(): string {
		if ($this->eventsUrl === null) {
			throw new \RuntimeException('Value not set for field `eventsUrl` (expected to be not null)');
		}

		return $this->eventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasEventsUrl(): bool {
		return $this->eventsUrl !== null;
	}

	/**
	 * @param string|null $forksUrl
	 *
	 * @return $this
	 */
	public function setForksUrl(?string $forksUrl) {
		$this->forksUrl = $forksUrl;
		$this->_touchedFields[self::FIELD_FORKS_URL] = true;

		return $this;
	}

	/**
	 * @param string $forksUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setForksUrlOrFail(string $forksUrl) {
		$this->forksUrl = $forksUrl;
		$this->_touchedFields[self::FIELD_FORKS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getForksUrl(): ?string {
		return $this->forksUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getForksUrlOrFail(): string {
		if ($this->forksUrl === null) {
			throw new \RuntimeException('Value not set for field `forksUrl` (expected to be not null)');
		}

		return $this->forksUrl;
	}

	/**
	 * @return bool
	 */
	public function hasForksUrl(): bool {
		return $this->forksUrl !== null;
	}

	/**
	 * @param string|null $gitCommitsUrl
	 *
	 * @return $this
	 */
	public function setGitCommitsUrl(?string $gitCommitsUrl) {
		$this->gitCommitsUrl = $gitCommitsUrl;
		$this->_touchedFields[self::FIELD_GIT_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @param string $gitCommitsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGitCommitsUrlOrFail(string $gitCommitsUrl) {
		$this->gitCommitsUrl = $gitCommitsUrl;
		$this->_touchedFields[self::FIELD_GIT_COMMITS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGitCommitsUrl(): ?string {
		return $this->gitCommitsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGitCommitsUrlOrFail(): string {
		if ($this->gitCommitsUrl === null) {
			throw new \RuntimeException('Value not set for field `gitCommitsUrl` (expected to be not null)');
		}

		return $this->gitCommitsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitCommitsUrl(): bool {
		return $this->gitCommitsUrl !== null;
	}

	/**
	 * @param string|null $gitRefsUrl
	 *
	 * @return $this
	 */
	public function setGitRefsUrl(?string $gitRefsUrl) {
		$this->gitRefsUrl = $gitRefsUrl;
		$this->_touchedFields[self::FIELD_GIT_REFS_URL] = true;

		return $this;
	}

	/**
	 * @param string $gitRefsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGitRefsUrlOrFail(string $gitRefsUrl) {
		$this->gitRefsUrl = $gitRefsUrl;
		$this->_touchedFields[self::FIELD_GIT_REFS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGitRefsUrl(): ?string {
		return $this->gitRefsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGitRefsUrlOrFail(): string {
		if ($this->gitRefsUrl === null) {
			throw new \RuntimeException('Value not set for field `gitRefsUrl` (expected to be not null)');
		}

		return $this->gitRefsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitRefsUrl(): bool {
		return $this->gitRefsUrl !== null;
	}

	/**
	 * @param string|null $gitTagsUrl
	 *
	 * @return $this
	 */
	public function setGitTagsUrl(?string $gitTagsUrl) {
		$this->gitTagsUrl = $gitTagsUrl;
		$this->_touchedFields[self::FIELD_GIT_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @param string $gitTagsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGitTagsUrlOrFail(string $gitTagsUrl) {
		$this->gitTagsUrl = $gitTagsUrl;
		$this->_touchedFields[self::FIELD_GIT_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGitTagsUrl(): ?string {
		return $this->gitTagsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGitTagsUrlOrFail(): string {
		if ($this->gitTagsUrl === null) {
			throw new \RuntimeException('Value not set for field `gitTagsUrl` (expected to be not null)');
		}

		return $this->gitTagsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitTagsUrl(): bool {
		return $this->gitTagsUrl !== null;
	}

	/**
	 * @param string|null $gitUrl
	 *
	 * @return $this
	 */
	public function setGitUrl(?string $gitUrl) {
		$this->gitUrl = $gitUrl;
		$this->_touchedFields[self::FIELD_GIT_URL] = true;

		return $this;
	}

	/**
	 * @param string $gitUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setGitUrlOrFail(string $gitUrl) {
		$this->gitUrl = $gitUrl;
		$this->_touchedFields[self::FIELD_GIT_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGitUrl(): ?string {
		return $this->gitUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getGitUrlOrFail(): string {
		if ($this->gitUrl === null) {
			throw new \RuntimeException('Value not set for field `gitUrl` (expected to be not null)');
		}

		return $this->gitUrl;
	}

	/**
	 * @return bool
	 */
	public function hasGitUrl(): bool {
		return $this->gitUrl !== null;
	}

	/**
	 * @param string|null $issueCommentUrl
	 *
	 * @return $this
	 */
	public function setIssueCommentUrl(?string $issueCommentUrl) {
		$this->issueCommentUrl = $issueCommentUrl;
		$this->_touchedFields[self::FIELD_ISSUE_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @param string $issueCommentUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIssueCommentUrlOrFail(string $issueCommentUrl) {
		$this->issueCommentUrl = $issueCommentUrl;
		$this->_touchedFields[self::FIELD_ISSUE_COMMENT_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIssueCommentUrl(): ?string {
		return $this->issueCommentUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getIssueCommentUrlOrFail(): string {
		if ($this->issueCommentUrl === null) {
			throw new \RuntimeException('Value not set for field `issueCommentUrl` (expected to be not null)');
		}

		return $this->issueCommentUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueCommentUrl(): bool {
		return $this->issueCommentUrl !== null;
	}

	/**
	 * @param string|null $issueEventsUrl
	 *
	 * @return $this
	 */
	public function setIssueEventsUrl(?string $issueEventsUrl) {
		$this->issueEventsUrl = $issueEventsUrl;
		$this->_touchedFields[self::FIELD_ISSUE_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @param string $issueEventsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIssueEventsUrlOrFail(string $issueEventsUrl) {
		$this->issueEventsUrl = $issueEventsUrl;
		$this->_touchedFields[self::FIELD_ISSUE_EVENTS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIssueEventsUrl(): ?string {
		return $this->issueEventsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getIssueEventsUrlOrFail(): string {
		if ($this->issueEventsUrl === null) {
			throw new \RuntimeException('Value not set for field `issueEventsUrl` (expected to be not null)');
		}

		return $this->issueEventsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssueEventsUrl(): bool {
		return $this->issueEventsUrl !== null;
	}

	/**
	 * @param string|null $issuesUrl
	 *
	 * @return $this
	 */
	public function setIssuesUrl(?string $issuesUrl) {
		$this->issuesUrl = $issuesUrl;
		$this->_touchedFields[self::FIELD_ISSUES_URL] = true;

		return $this;
	}

	/**
	 * @param string $issuesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setIssuesUrlOrFail(string $issuesUrl) {
		$this->issuesUrl = $issuesUrl;
		$this->_touchedFields[self::FIELD_ISSUES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIssuesUrl(): ?string {
		return $this->issuesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getIssuesUrlOrFail(): string {
		if ($this->issuesUrl === null) {
			throw new \RuntimeException('Value not set for field `issuesUrl` (expected to be not null)');
		}

		return $this->issuesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasIssuesUrl(): bool {
		return $this->issuesUrl !== null;
	}

	/**
	 * @param string|null $keysUrl
	 *
	 * @return $this
	 */
	public function setKeysUrl(?string $keysUrl) {
		$this->keysUrl = $keysUrl;
		$this->_touchedFields[self::FIELD_KEYS_URL] = true;

		return $this;
	}

	/**
	 * @param string $keysUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setKeysUrlOrFail(string $keysUrl) {
		$this->keysUrl = $keysUrl;
		$this->_touchedFields[self::FIELD_KEYS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getKeysUrl(): ?string {
		return $this->keysUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getKeysUrlOrFail(): string {
		if ($this->keysUrl === null) {
			throw new \RuntimeException('Value not set for field `keysUrl` (expected to be not null)');
		}

		return $this->keysUrl;
	}

	/**
	 * @return bool
	 */
	public function hasKeysUrl(): bool {
		return $this->keysUrl !== null;
	}

	/**
	 * @param string|null $labelsUrl
	 *
	 * @return $this
	 */
	public function setLabelsUrl(?string $labelsUrl) {
		$this->labelsUrl = $labelsUrl;
		$this->_touchedFields[self::FIELD_LABELS_URL] = true;

		return $this;
	}

	/**
	 * @param string $labelsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLabelsUrlOrFail(string $labelsUrl) {
		$this->labelsUrl = $labelsUrl;
		$this->_touchedFields[self::FIELD_LABELS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLabelsUrl(): ?string {
		return $this->labelsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLabelsUrlOrFail(): string {
		if ($this->labelsUrl === null) {
			throw new \RuntimeException('Value not set for field `labelsUrl` (expected to be not null)');
		}

		return $this->labelsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasLabelsUrl(): bool {
		return $this->labelsUrl !== null;
	}

	/**
	 * @param string|null $languagesUrl
	 *
	 * @return $this
	 */
	public function setLanguagesUrl(?string $languagesUrl) {
		$this->languagesUrl = $languagesUrl;
		$this->_touchedFields[self::FIELD_LANGUAGES_URL] = true;

		return $this;
	}

	/**
	 * @param string $languagesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLanguagesUrlOrFail(string $languagesUrl) {
		$this->languagesUrl = $languagesUrl;
		$this->_touchedFields[self::FIELD_LANGUAGES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLanguagesUrl(): ?string {
		return $this->languagesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getLanguagesUrlOrFail(): string {
		if ($this->languagesUrl === null) {
			throw new \RuntimeException('Value not set for field `languagesUrl` (expected to be not null)');
		}

		return $this->languagesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasLanguagesUrl(): bool {
		return $this->languagesUrl !== null;
	}

	/**
	 * @param string|null $mergesUrl
	 *
	 * @return $this
	 */
	public function setMergesUrl(?string $mergesUrl) {
		$this->mergesUrl = $mergesUrl;
		$this->_touchedFields[self::FIELD_MERGES_URL] = true;

		return $this;
	}

	/**
	 * @param string $mergesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMergesUrlOrFail(string $mergesUrl) {
		$this->mergesUrl = $mergesUrl;
		$this->_touchedFields[self::FIELD_MERGES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMergesUrl(): ?string {
		return $this->mergesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMergesUrlOrFail(): string {
		if ($this->mergesUrl === null) {
			throw new \RuntimeException('Value not set for field `mergesUrl` (expected to be not null)');
		}

		return $this->mergesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMergesUrl(): bool {
		return $this->mergesUrl !== null;
	}

	/**
	 * @param string|null $milestonesUrl
	 *
	 * @return $this
	 */
	public function setMilestonesUrl(?string $milestonesUrl) {
		$this->milestonesUrl = $milestonesUrl;
		$this->_touchedFields[self::FIELD_MILESTONES_URL] = true;

		return $this;
	}

	/**
	 * @param string $milestonesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setMilestonesUrlOrFail(string $milestonesUrl) {
		$this->milestonesUrl = $milestonesUrl;
		$this->_touchedFields[self::FIELD_MILESTONES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMilestonesUrl(): ?string {
		return $this->milestonesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getMilestonesUrlOrFail(): string {
		if ($this->milestonesUrl === null) {
			throw new \RuntimeException('Value not set for field `milestonesUrl` (expected to be not null)');
		}

		return $this->milestonesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasMilestonesUrl(): bool {
		return $this->milestonesUrl !== null;
	}

	/**
	 * @param string|null $notificationsUrl
	 *
	 * @return $this
	 */
	public function setNotificationsUrl(?string $notificationsUrl) {
		$this->notificationsUrl = $notificationsUrl;
		$this->_touchedFields[self::FIELD_NOTIFICATIONS_URL] = true;

		return $this;
	}

	/**
	 * @param string $notificationsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setNotificationsUrlOrFail(string $notificationsUrl) {
		$this->notificationsUrl = $notificationsUrl;
		$this->_touchedFields[self::FIELD_NOTIFICATIONS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNotificationsUrl(): ?string {
		return $this->notificationsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getNotificationsUrlOrFail(): string {
		if ($this->notificationsUrl === null) {
			throw new \RuntimeException('Value not set for field `notificationsUrl` (expected to be not null)');
		}

		return $this->notificationsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasNotificationsUrl(): bool {
		return $this->notificationsUrl !== null;
	}

	/**
	 * @param string|null $pullsUrl
	 *
	 * @return $this
	 */
	public function setPullsUrl(?string $pullsUrl) {
		$this->pullsUrl = $pullsUrl;
		$this->_touchedFields[self::FIELD_PULLS_URL] = true;

		return $this;
	}

	/**
	 * @param string $pullsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPullsUrlOrFail(string $pullsUrl) {
		$this->pullsUrl = $pullsUrl;
		$this->_touchedFields[self::FIELD_PULLS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPullsUrl(): ?string {
		return $this->pullsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getPullsUrlOrFail(): string {
		if ($this->pullsUrl === null) {
			throw new \RuntimeException('Value not set for field `pullsUrl` (expected to be not null)');
		}

		return $this->pullsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasPullsUrl(): bool {
		return $this->pullsUrl !== null;
	}

	/**
	 * @param string|null $releasesUrl
	 *
	 * @return $this
	 */
	public function setReleasesUrl(?string $releasesUrl) {
		$this->releasesUrl = $releasesUrl;
		$this->_touchedFields[self::FIELD_RELEASES_URL] = true;

		return $this;
	}

	/**
	 * @param string $releasesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setReleasesUrlOrFail(string $releasesUrl) {
		$this->releasesUrl = $releasesUrl;
		$this->_touchedFields[self::FIELD_RELEASES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getReleasesUrl(): ?string {
		return $this->releasesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getReleasesUrlOrFail(): string {
		if ($this->releasesUrl === null) {
			throw new \RuntimeException('Value not set for field `releasesUrl` (expected to be not null)');
		}

		return $this->releasesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasReleasesUrl(): bool {
		return $this->releasesUrl !== null;
	}

	/**
	 * @param string|null $sshUrl
	 *
	 * @return $this
	 */
	public function setSshUrl(?string $sshUrl) {
		$this->sshUrl = $sshUrl;
		$this->_touchedFields[self::FIELD_SSH_URL] = true;

		return $this;
	}

	/**
	 * @param string $sshUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSshUrlOrFail(string $sshUrl) {
		$this->sshUrl = $sshUrl;
		$this->_touchedFields[self::FIELD_SSH_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSshUrl(): ?string {
		return $this->sshUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSshUrlOrFail(): string {
		if ($this->sshUrl === null) {
			throw new \RuntimeException('Value not set for field `sshUrl` (expected to be not null)');
		}

		return $this->sshUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSshUrl(): bool {
		return $this->sshUrl !== null;
	}

	/**
	 * @param string|null $stargazersUrl
	 *
	 * @return $this
	 */
	public function setStargazersUrl(?string $stargazersUrl) {
		$this->stargazersUrl = $stargazersUrl;
		$this->_touchedFields[self::FIELD_STARGAZERS_URL] = true;

		return $this;
	}

	/**
	 * @param string $stargazersUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setStargazersUrlOrFail(string $stargazersUrl) {
		$this->stargazersUrl = $stargazersUrl;
		$this->_touchedFields[self::FIELD_STARGAZERS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getStargazersUrl(): ?string {
		return $this->stargazersUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getStargazersUrlOrFail(): string {
		if ($this->stargazersUrl === null) {
			throw new \RuntimeException('Value not set for field `stargazersUrl` (expected to be not null)');
		}

		return $this->stargazersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasStargazersUrl(): bool {
		return $this->stargazersUrl !== null;
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
	 * @param string|null $subscribersUrl
	 *
	 * @return $this
	 */
	public function setSubscribersUrl(?string $subscribersUrl) {
		$this->subscribersUrl = $subscribersUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIBERS_URL] = true;

		return $this;
	}

	/**
	 * @param string $subscribersUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSubscribersUrlOrFail(string $subscribersUrl) {
		$this->subscribersUrl = $subscribersUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIBERS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSubscribersUrl(): ?string {
		return $this->subscribersUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSubscribersUrlOrFail(): string {
		if ($this->subscribersUrl === null) {
			throw new \RuntimeException('Value not set for field `subscribersUrl` (expected to be not null)');
		}

		return $this->subscribersUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscribersUrl(): bool {
		return $this->subscribersUrl !== null;
	}

	/**
	 * @param string|null $subscriptionUrl
	 *
	 * @return $this
	 */
	public function setSubscriptionUrl(?string $subscriptionUrl) {
		$this->subscriptionUrl = $subscriptionUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTION_URL] = true;

		return $this;
	}

	/**
	 * @param string $subscriptionUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSubscriptionUrlOrFail(string $subscriptionUrl) {
		$this->subscriptionUrl = $subscriptionUrl;
		$this->_touchedFields[self::FIELD_SUBSCRIPTION_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSubscriptionUrl(): ?string {
		return $this->subscriptionUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSubscriptionUrlOrFail(): string {
		if ($this->subscriptionUrl === null) {
			throw new \RuntimeException('Value not set for field `subscriptionUrl` (expected to be not null)');
		}

		return $this->subscriptionUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSubscriptionUrl(): bool {
		return $this->subscriptionUrl !== null;
	}

	/**
	 * @param string|null $tagsUrl
	 *
	 * @return $this
	 */
	public function setTagsUrl(?string $tagsUrl) {
		$this->tagsUrl = $tagsUrl;
		$this->_touchedFields[self::FIELD_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @param string $tagsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTagsUrlOrFail(string $tagsUrl) {
		$this->tagsUrl = $tagsUrl;
		$this->_touchedFields[self::FIELD_TAGS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTagsUrl(): ?string {
		return $this->tagsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTagsUrlOrFail(): string {
		if ($this->tagsUrl === null) {
			throw new \RuntimeException('Value not set for field `tagsUrl` (expected to be not null)');
		}

		return $this->tagsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTagsUrl(): bool {
		return $this->tagsUrl !== null;
	}

	/**
	 * @param string|null $teamsUrl
	 *
	 * @return $this
	 */
	public function setTeamsUrl(?string $teamsUrl) {
		$this->teamsUrl = $teamsUrl;
		$this->_touchedFields[self::FIELD_TEAMS_URL] = true;

		return $this;
	}

	/**
	 * @param string $teamsUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTeamsUrlOrFail(string $teamsUrl) {
		$this->teamsUrl = $teamsUrl;
		$this->_touchedFields[self::FIELD_TEAMS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTeamsUrl(): ?string {
		return $this->teamsUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTeamsUrlOrFail(): string {
		if ($this->teamsUrl === null) {
			throw new \RuntimeException('Value not set for field `teamsUrl` (expected to be not null)');
		}

		return $this->teamsUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTeamsUrl(): bool {
		return $this->teamsUrl !== null;
	}

	/**
	 * @param string|null $treesUrl
	 *
	 * @return $this
	 */
	public function setTreesUrl(?string $treesUrl) {
		$this->treesUrl = $treesUrl;
		$this->_touchedFields[self::FIELD_TREES_URL] = true;

		return $this;
	}

	/**
	 * @param string $treesUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setTreesUrlOrFail(string $treesUrl) {
		$this->treesUrl = $treesUrl;
		$this->_touchedFields[self::FIELD_TREES_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTreesUrl(): ?string {
		return $this->treesUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTreesUrlOrFail(): string {
		if ($this->treesUrl === null) {
			throw new \RuntimeException('Value not set for field `treesUrl` (expected to be not null)');
		}

		return $this->treesUrl;
	}

	/**
	 * @return bool
	 */
	public function hasTreesUrl(): bool {
		return $this->treesUrl !== null;
	}

	/**
	 * @param string|null $cloneUrl
	 *
	 * @return $this
	 */
	public function setCloneUrl(?string $cloneUrl) {
		$this->cloneUrl = $cloneUrl;
		$this->_touchedFields[self::FIELD_CLONE_URL] = true;

		return $this;
	}

	/**
	 * @param string $cloneUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setCloneUrlOrFail(string $cloneUrl) {
		$this->cloneUrl = $cloneUrl;
		$this->_touchedFields[self::FIELD_CLONE_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCloneUrl(): ?string {
		return $this->cloneUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCloneUrlOrFail(): string {
		if ($this->cloneUrl === null) {
			throw new \RuntimeException('Value not set for field `cloneUrl` (expected to be not null)');
		}

		return $this->cloneUrl;
	}

	/**
	 * @return bool
	 */
	public function hasCloneUrl(): bool {
		return $this->cloneUrl !== null;
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
	 * @param string|null $hooksUrl
	 *
	 * @return $this
	 */
	public function setHooksUrl(?string $hooksUrl) {
		$this->hooksUrl = $hooksUrl;
		$this->_touchedFields[self::FIELD_HOOKS_URL] = true;

		return $this;
	}

	/**
	 * @param string $hooksUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHooksUrlOrFail(string $hooksUrl) {
		$this->hooksUrl = $hooksUrl;
		$this->_touchedFields[self::FIELD_HOOKS_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHooksUrl(): ?string {
		return $this->hooksUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getHooksUrlOrFail(): string {
		if ($this->hooksUrl === null) {
			throw new \RuntimeException('Value not set for field `hooksUrl` (expected to be not null)');
		}

		return $this->hooksUrl;
	}

	/**
	 * @return bool
	 */
	public function hasHooksUrl(): bool {
		return $this->hooksUrl !== null;
	}

	/**
	 * @param string|null $svnUrl
	 *
	 * @return $this
	 */
	public function setSvnUrl(?string $svnUrl) {
		$this->svnUrl = $svnUrl;
		$this->_touchedFields[self::FIELD_SVN_URL] = true;

		return $this;
	}

	/**
	 * @param string $svnUrl
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSvnUrlOrFail(string $svnUrl) {
		$this->svnUrl = $svnUrl;
		$this->_touchedFields[self::FIELD_SVN_URL] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSvnUrl(): ?string {
		return $this->svnUrl;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSvnUrlOrFail(): string {
		if ($this->svnUrl === null) {
			throw new \RuntimeException('Value not set for field `svnUrl` (expected to be not null)');
		}

		return $this->svnUrl;
	}

	/**
	 * @return bool
	 */
	public function hasSvnUrl(): bool {
		return $this->svnUrl !== null;
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
	 * @param mixed|null $language
	 *
	 * @return $this
	 */
	public function setLanguage($language) {
		$this->language = $language;
		$this->_touchedFields[self::FIELD_LANGUAGE] = true;

		return $this;
	}

	/**
	 * @param mixed $language
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLanguageOrFail($language) {
		if ($language === null) {
			throw new \RuntimeException('Value not present (expected to be not null)');
		}
		$this->language = $language;
		$this->_touchedFields[self::FIELD_LANGUAGE] = true;

		return $this;
	}

	/**
	 * @return mixed|null
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return mixed
	 */
	public function getLanguageOrFail() {
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
	 * @param int|null $forksCount
	 *
	 * @return $this
	 */
	public function setForksCount(?int $forksCount) {
		$this->forksCount = $forksCount;
		$this->_touchedFields[self::FIELD_FORKS_COUNT] = true;

		return $this;
	}

	/**
	 * @param int $forksCount
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setForksCountOrFail(int $forksCount) {
		$this->forksCount = $forksCount;
		$this->_touchedFields[self::FIELD_FORKS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getForksCount(): ?int {
		return $this->forksCount;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getForksCountOrFail(): int {
		if ($this->forksCount === null) {
			throw new \RuntimeException('Value not set for field `forksCount` (expected to be not null)');
		}

		return $this->forksCount;
	}

	/**
	 * @return bool
	 */
	public function hasForksCount(): bool {
		return $this->forksCount !== null;
	}

	/**
	 * @param int|null $stargazersCount
	 *
	 * @return $this
	 */
	public function setStargazersCount(?int $stargazersCount) {
		$this->stargazersCount = $stargazersCount;
		$this->_touchedFields[self::FIELD_STARGAZERS_COUNT] = true;

		return $this;
	}

	/**
	 * @param int $stargazersCount
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setStargazersCountOrFail(int $stargazersCount) {
		$this->stargazersCount = $stargazersCount;
		$this->_touchedFields[self::FIELD_STARGAZERS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getStargazersCount(): ?int {
		return $this->stargazersCount;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getStargazersCountOrFail(): int {
		if ($this->stargazersCount === null) {
			throw new \RuntimeException('Value not set for field `stargazersCount` (expected to be not null)');
		}

		return $this->stargazersCount;
	}

	/**
	 * @return bool
	 */
	public function hasStargazersCount(): bool {
		return $this->stargazersCount !== null;
	}

	/**
	 * @param int|null $watchersCount
	 *
	 * @return $this
	 */
	public function setWatchersCount(?int $watchersCount) {
		$this->watchersCount = $watchersCount;
		$this->_touchedFields[self::FIELD_WATCHERS_COUNT] = true;

		return $this;
	}

	/**
	 * @param int $watchersCount
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setWatchersCountOrFail(int $watchersCount) {
		$this->watchersCount = $watchersCount;
		$this->_touchedFields[self::FIELD_WATCHERS_COUNT] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getWatchersCount(): ?int {
		return $this->watchersCount;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getWatchersCountOrFail(): int {
		if ($this->watchersCount === null) {
			throw new \RuntimeException('Value not set for field `watchersCount` (expected to be not null)');
		}

		return $this->watchersCount;
	}

	/**
	 * @return bool
	 */
	public function hasWatchersCount(): bool {
		return $this->watchersCount !== null;
	}

	/**
	 * @param int|null $size
	 *
	 * @return $this
	 */
	public function setSize(?int $size) {
		$this->size = $size;
		$this->_touchedFields[self::FIELD_SIZE] = true;

		return $this;
	}

	/**
	 * @param int $size
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setSizeOrFail(int $size) {
		$this->size = $size;
		$this->_touchedFields[self::FIELD_SIZE] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getSize(): ?int {
		return $this->size;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getSizeOrFail(): int {
		if ($this->size === null) {
			throw new \RuntimeException('Value not set for field `size` (expected to be not null)');
		}

		return $this->size;
	}

	/**
	 * @return bool
	 */
	public function hasSize(): bool {
		return $this->size !== null;
	}

	/**
	 * @param string|null $defaultBranch
	 *
	 * @return $this
	 */
	public function setDefaultBranch(?string $defaultBranch) {
		$this->defaultBranch = $defaultBranch;
		$this->_touchedFields[self::FIELD_DEFAULT_BRANCH] = true;

		return $this;
	}

	/**
	 * @param string $defaultBranch
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDefaultBranchOrFail(string $defaultBranch) {
		$this->defaultBranch = $defaultBranch;
		$this->_touchedFields[self::FIELD_DEFAULT_BRANCH] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDefaultBranch(): ?string {
		return $this->defaultBranch;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getDefaultBranchOrFail(): string {
		if ($this->defaultBranch === null) {
			throw new \RuntimeException('Value not set for field `defaultBranch` (expected to be not null)');
		}

		return $this->defaultBranch;
	}

	/**
	 * @return bool
	 */
	public function hasDefaultBranch(): bool {
		return $this->defaultBranch !== null;
	}

	/**
	 * @param int|null $openIssuesCount
	 *
	 * @return $this
	 */
	public function setOpenIssuesCount(?int $openIssuesCount) {
		$this->openIssuesCount = $openIssuesCount;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES_COUNT] = true;

		return $this;
	}

	/**
	 * @param int $openIssuesCount
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setOpenIssuesCountOrFail(int $openIssuesCount) {
		$this->openIssuesCount = $openIssuesCount;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES_COUNT] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getOpenIssuesCount(): ?int {
		return $this->openIssuesCount;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getOpenIssuesCountOrFail(): int {
		if ($this->openIssuesCount === null) {
			throw new \RuntimeException('Value not set for field `openIssuesCount` (expected to be not null)');
		}

		return $this->openIssuesCount;
	}

	/**
	 * @return bool
	 */
	public function hasOpenIssuesCount(): bool {
		return $this->openIssuesCount !== null;
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
	 * @param bool|null $hasIssues
	 *
	 * @return $this
	 */
	public function setHasIssues(?bool $hasIssues) {
		$this->hasIssues = $hasIssues;
		$this->_touchedFields[self::FIELD_HAS_ISSUES] = true;

		return $this;
	}

	/**
	 * @param bool $hasIssues
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasIssuesOrFail(bool $hasIssues) {
		$this->hasIssues = $hasIssues;
		$this->_touchedFields[self::FIELD_HAS_ISSUES] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasIssues(): ?bool {
		return $this->hasIssues;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasIssuesOrFail(): bool {
		if ($this->hasIssues === null) {
			throw new \RuntimeException('Value not set for field `hasIssues` (expected to be not null)');
		}

		return $this->hasIssues;
	}

	/**
	 * @return bool
	 */
	public function hasHasIssues(): bool {
		return $this->hasIssues !== null;
	}

	/**
	 * @param bool|null $hasProjects
	 *
	 * @return $this
	 */
	public function setHasProjects(?bool $hasProjects) {
		$this->hasProjects = $hasProjects;
		$this->_touchedFields[self::FIELD_HAS_PROJECTS] = true;

		return $this;
	}

	/**
	 * @param bool $hasProjects
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasProjectsOrFail(bool $hasProjects) {
		$this->hasProjects = $hasProjects;
		$this->_touchedFields[self::FIELD_HAS_PROJECTS] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasProjects(): ?bool {
		return $this->hasProjects;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasProjectsOrFail(): bool {
		if ($this->hasProjects === null) {
			throw new \RuntimeException('Value not set for field `hasProjects` (expected to be not null)');
		}

		return $this->hasProjects;
	}

	/**
	 * @return bool
	 */
	public function hasHasProjects(): bool {
		return $this->hasProjects !== null;
	}

	/**
	 * @param bool|null $hasWiki
	 *
	 * @return $this
	 */
	public function setHasWiki(?bool $hasWiki) {
		$this->hasWiki = $hasWiki;
		$this->_touchedFields[self::FIELD_HAS_WIKI] = true;

		return $this;
	}

	/**
	 * @param bool $hasWiki
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasWikiOrFail(bool $hasWiki) {
		$this->hasWiki = $hasWiki;
		$this->_touchedFields[self::FIELD_HAS_WIKI] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasWiki(): ?bool {
		return $this->hasWiki;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasWikiOrFail(): bool {
		if ($this->hasWiki === null) {
			throw new \RuntimeException('Value not set for field `hasWiki` (expected to be not null)');
		}

		return $this->hasWiki;
	}

	/**
	 * @return bool
	 */
	public function hasHasWiki(): bool {
		return $this->hasWiki !== null;
	}

	/**
	 * @param bool|null $hasPages
	 *
	 * @return $this
	 */
	public function setHasPages(?bool $hasPages) {
		$this->hasPages = $hasPages;
		$this->_touchedFields[self::FIELD_HAS_PAGES] = true;

		return $this;
	}

	/**
	 * @param bool $hasPages
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasPagesOrFail(bool $hasPages) {
		$this->hasPages = $hasPages;
		$this->_touchedFields[self::FIELD_HAS_PAGES] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasPages(): ?bool {
		return $this->hasPages;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasPagesOrFail(): bool {
		if ($this->hasPages === null) {
			throw new \RuntimeException('Value not set for field `hasPages` (expected to be not null)');
		}

		return $this->hasPages;
	}

	/**
	 * @return bool
	 */
	public function hasHasPages(): bool {
		return $this->hasPages !== null;
	}

	/**
	 * @param bool|null $hasDownloads
	 *
	 * @return $this
	 */
	public function setHasDownloads(?bool $hasDownloads) {
		$this->hasDownloads = $hasDownloads;
		$this->_touchedFields[self::FIELD_HAS_DOWNLOADS] = true;

		return $this;
	}

	/**
	 * @param bool $hasDownloads
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasDownloadsOrFail(bool $hasDownloads) {
		$this->hasDownloads = $hasDownloads;
		$this->_touchedFields[self::FIELD_HAS_DOWNLOADS] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasDownloads(): ?bool {
		return $this->hasDownloads;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasDownloadsOrFail(): bool {
		if ($this->hasDownloads === null) {
			throw new \RuntimeException('Value not set for field `hasDownloads` (expected to be not null)');
		}

		return $this->hasDownloads;
	}

	/**
	 * @return bool
	 */
	public function hasHasDownloads(): bool {
		return $this->hasDownloads !== null;
	}

	/**
	 * @param bool|null $hasDiscussions
	 *
	 * @return $this
	 */
	public function setHasDiscussions(?bool $hasDiscussions) {
		$this->hasDiscussions = $hasDiscussions;
		$this->_touchedFields[self::FIELD_HAS_DISCUSSIONS] = true;

		return $this;
	}

	/**
	 * @param bool $hasDiscussions
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setHasDiscussionsOrFail(bool $hasDiscussions) {
		$this->hasDiscussions = $hasDiscussions;
		$this->_touchedFields[self::FIELD_HAS_DISCUSSIONS] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getHasDiscussions(): ?bool {
		return $this->hasDiscussions;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getHasDiscussionsOrFail(): bool {
		if ($this->hasDiscussions === null) {
			throw new \RuntimeException('Value not set for field `hasDiscussions` (expected to be not null)');
		}

		return $this->hasDiscussions;
	}

	/**
	 * @return bool
	 */
	public function hasHasDiscussions(): bool {
		return $this->hasDiscussions !== null;
	}

	/**
	 * @param bool|null $archived
	 *
	 * @return $this
	 */
	public function setArchived(?bool $archived) {
		$this->archived = $archived;
		$this->_touchedFields[self::FIELD_ARCHIVED] = true;

		return $this;
	}

	/**
	 * @param bool $archived
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setArchivedOrFail(bool $archived) {
		$this->archived = $archived;
		$this->_touchedFields[self::FIELD_ARCHIVED] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getArchived(): ?bool {
		return $this->archived;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getArchivedOrFail(): bool {
		if ($this->archived === null) {
			throw new \RuntimeException('Value not set for field `archived` (expected to be not null)');
		}

		return $this->archived;
	}

	/**
	 * @return bool
	 */
	public function hasArchived(): bool {
		return $this->archived !== null;
	}

	/**
	 * @param bool|null $disabled
	 *
	 * @return $this
	 */
	public function setDisabled(?bool $disabled) {
		$this->disabled = $disabled;
		$this->_touchedFields[self::FIELD_DISABLED] = true;

		return $this;
	}

	/**
	 * @param bool $disabled
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setDisabledOrFail(bool $disabled) {
		$this->disabled = $disabled;
		$this->_touchedFields[self::FIELD_DISABLED] = true;

		return $this;
	}

	/**
	 * @return bool|null
	 */
	public function getDisabled(): ?bool {
		return $this->disabled;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return bool
	 */
	public function getDisabledOrFail(): bool {
		if ($this->disabled === null) {
			throw new \RuntimeException('Value not set for field `disabled` (expected to be not null)');
		}

		return $this->disabled;
	}

	/**
	 * @return bool
	 */
	public function hasDisabled(): bool {
		return $this->disabled !== null;
	}

	/**
	 * @param string|null $pushedAt
	 *
	 * @return $this
	 */
	public function setPushedAt(?string $pushedAt) {
		$this->pushedAt = $pushedAt;
		$this->_touchedFields[self::FIELD_PUSHED_AT] = true;

		return $this;
	}

	/**
	 * @param string $pushedAt
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPushedAtOrFail(string $pushedAt) {
		$this->pushedAt = $pushedAt;
		$this->_touchedFields[self::FIELD_PUSHED_AT] = true;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPushedAt(): ?string {
		return $this->pushedAt;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getPushedAtOrFail(): string {
		if ($this->pushedAt === null) {
			throw new \RuntimeException('Value not set for field `pushedAt` (expected to be not null)');
		}

		return $this->pushedAt;
	}

	/**
	 * @return bool
	 */
	public function hasPushedAt(): bool {
		return $this->pushedAt !== null;
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
	 * @param \App\Dto\Test\Data\PermissionsDto|null $permissions
	 *
	 * @return $this
	 */
	public function setPermissions(?\App\Dto\Test\Data\PermissionsDto $permissions) {
		$this->permissions = $permissions;
		$this->_touchedFields[self::FIELD_PERMISSIONS] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\PermissionsDto $permissions
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setPermissionsOrFail(\App\Dto\Test\Data\PermissionsDto $permissions) {
		$this->permissions = $permissions;
		$this->_touchedFields[self::FIELD_PERMISSIONS] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\PermissionsDto|null
	 */
	public function getPermissions(): ?\App\Dto\Test\Data\PermissionsDto {
		return $this->permissions;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\PermissionsDto
	 */
	public function getPermissionsOrFail(): \App\Dto\Test\Data\PermissionsDto {
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
	 * @param int|null $forks
	 *
	 * @return $this
	 */
	public function setForks(?int $forks) {
		$this->forks = $forks;
		$this->_touchedFields[self::FIELD_FORKS] = true;

		return $this;
	}

	/**
	 * @param int $forks
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setForksOrFail(int $forks) {
		$this->forks = $forks;
		$this->_touchedFields[self::FIELD_FORKS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getForks(): ?int {
		return $this->forks;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getForksOrFail(): int {
		if ($this->forks === null) {
			throw new \RuntimeException('Value not set for field `forks` (expected to be not null)');
		}

		return $this->forks;
	}

	/**
	 * @return bool
	 */
	public function hasForks(): bool {
		return $this->forks !== null;
	}

	/**
	 * @param int|null $openIssues
	 *
	 * @return $this
	 */
	public function setOpenIssues(?int $openIssues) {
		$this->openIssues = $openIssues;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES] = true;

		return $this;
	}

	/**
	 * @param int $openIssues
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setOpenIssuesOrFail(int $openIssues) {
		$this->openIssues = $openIssues;
		$this->_touchedFields[self::FIELD_OPEN_ISSUES] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getOpenIssues(): ?int {
		return $this->openIssues;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getOpenIssuesOrFail(): int {
		if ($this->openIssues === null) {
			throw new \RuntimeException('Value not set for field `openIssues` (expected to be not null)');
		}

		return $this->openIssues;
	}

	/**
	 * @return bool
	 */
	public function hasOpenIssues(): bool {
		return $this->openIssues !== null;
	}

	/**
	 * @param \App\Dto\Test\Data\LicenseDto|null $license
	 *
	 * @return $this
	 */
	public function setLicense(?\App\Dto\Test\Data\LicenseDto $license) {
		$this->license = $license;
		$this->_touchedFields[self::FIELD_LICENSE] = true;

		return $this;
	}

	/**
	 * @param \App\Dto\Test\Data\LicenseDto $license
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setLicenseOrFail(\App\Dto\Test\Data\LicenseDto $license) {
		$this->license = $license;
		$this->_touchedFields[self::FIELD_LICENSE] = true;

		return $this;
	}

	/**
	 * @return \App\Dto\Test\Data\LicenseDto|null
	 */
	public function getLicense(): ?\App\Dto\Test\Data\LicenseDto {
		return $this->license;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\Test\Data\LicenseDto
	 */
	public function getLicenseOrFail(): \App\Dto\Test\Data\LicenseDto {
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
	 * @param int|null $watchers
	 *
	 * @return $this
	 */
	public function setWatchers(?int $watchers) {
		$this->watchers = $watchers;
		$this->_touchedFields[self::FIELD_WATCHERS] = true;

		return $this;
	}

	/**
	 * @param int $watchers
	 *
	 * @throws \RuntimeException If value is not present.
	 *
	 * @return $this
	 */
	public function setWatchersOrFail(int $watchers) {
		$this->watchers = $watchers;
		$this->_touchedFields[self::FIELD_WATCHERS] = true;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getWatchers(): ?int {
		return $this->watchers;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getWatchersOrFail(): int {
		if ($this->watchers === null) {
			throw new \RuntimeException('Value not set for field `watchers` (expected to be not null)');
		}

		return $this->watchers;
	}

	/**
	 * @return bool
	 */
	public function hasWatchers(): bool {
		return $this->watchers !== null;
	}

}
