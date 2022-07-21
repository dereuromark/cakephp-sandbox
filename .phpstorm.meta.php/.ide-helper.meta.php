<?php
// @link https://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
namespace PHPSTORM_META {

	expectedArguments(
		\App\Model\Entity\Role::get(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::getError(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::getInvalidField(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::getOriginal(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::has(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::hasValue(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::isDirty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::isEmpty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::setDirty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\Role::setError(),
		0,
		argumentsSet('entityFields:App\Model\Entity\Role')
	);

	expectedArguments(
		\App\Model\Entity\User::get(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::getError(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::getInvalidField(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::getOriginal(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::has(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::hasValue(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::isDirty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::isEmpty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::setDirty(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	expectedArguments(
		\App\Model\Entity\User::setError(),
		0,
		argumentsSet('entityFields:App\Model\Entity\User')
	);

	override(
		\Burzum\CakeServiceLayer\Service\ServiceAwareTrait::loadService(0),
		map([
			'Sandbox.Calculator/Post' => \Sandbox\Service\Calculator\PostService::class,
			'Sandbox.Localized/Validation' => \Sandbox\Service\Localized\ValidationService::class,
		])
	);

	expectedArguments(
		\Cake\Cache\Cache::add(),
		2,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::clear(),
		0,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::clearGroup(),
		1,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::decrement(),
		2,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::delete(),
		1,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::deleteMany(),
		1,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::increment(),
		2,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::read(),
		1,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::readMany(),
		1,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::remember(),
		2,
		argumentsSet('cacheEngines')
	);

	expectedArguments(
		\Cake\Cache\Cache::write(),
		2,
		argumentsSet('cacheEngines')
	);

	exitPoint(\Cake\Console\ConsoleIo::abort());

	override(
		\Cake\Console\ConsoleIo::helper(0),
		map([
			'Progress' => \Cake\Shell\Helper\ProgressHelper::class,
			'Table' => \Cake\Shell\Helper\TableHelper::class,
		])
	);

	expectedArguments(
		\Cake\Controller\ComponentRegistry::unload(),
		0,
		'Ajax',
		'Auth',
		'AuthUser',
		'Cache',
		'Calendar',
		'Captcha',
		'CheckHttpCache',
		'Common',
		'CountryStateHelper',
		'Flash',
		'FormProtection',
		'Mobile',
		'Paginator',
		'Preparer',
		'Rating',
		'RefererRedirect',
		'RequestHandler',
		'Search',
		'Security',
		'Setup',
		'Superimpose',
		'Url'
	);

	override(
		\Cake\Controller\Controller::loadComponent(0),
		map([
			'Ajax.Ajax' => \Ajax\Controller\Component\AjaxComponent::class,
			'Auth' => \Cake\Controller\Component\AuthComponent::class,
			'Cache.Cache' => \Cache\Controller\Component\CacheComponent::class,
			'Calendar.Calendar' => \Calendar\Controller\Component\CalendarComponent::class,
			'Captcha.Captcha' => \Captcha\Controller\Component\CaptchaComponent::class,
			'Captcha.Preparer' => \Captcha\Controller\Component\PreparerComponent::class,
			'CheckHttpCache' => \Cake\Controller\Component\CheckHttpCacheComponent::class,
			'Data.CountryStateHelper' => \Data\Controller\Component\CountryStateHelperComponent::class,
			'Expose.Superimpose' => \Expose\Controller\Component\SuperimposeComponent::class,
			'Flash' => \Cake\Controller\Component\FlashComponent::class,
			'FormProtection' => \Cake\Controller\Component\FormProtectionComponent::class,
			'Paginator' => \App\Controller\Component\PaginatorComponent::class,
			'Ratings.Rating' => \Ratings\Controller\Component\RatingComponent::class,
			'RequestHandler' => \Cake\Controller\Component\RequestHandlerComponent::class,
			'Search.Search' => \Search\Controller\Component\SearchComponent::class,
			'Security' => \Cake\Controller\Component\SecurityComponent::class,
			'Setup.Setup' => \Setup\Controller\Component\SetupComponent::class,
			'TinyAuth.Auth' => \TinyAuth\Controller\Component\AuthComponent::class,
			'TinyAuth.AuthUser' => \TinyAuth\Controller\Component\AuthUserComponent::class,
			'Tools.Common' => \Tools\Controller\Component\CommonComponent::class,
			'Tools.Mobile' => \Tools\Controller\Component\MobileComponent::class,
			'Tools.RefererRedirect' => \Tools\Controller\Component\RefererRedirectComponent::class,
			'Tools.Url' => \Tools\Controller\Component\UrlComponent::class,
		])
	);

	expectedArguments(
		\Cake\Core\Configure::check(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::consume(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::consumeOrFail(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::delete(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::read(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::readOrFail(),
		0,
		argumentsSet('configureKeys')
	);

	expectedArguments(
		\Cake\Core\Configure::write(),
		0,
		argumentsSet('configureKeys')
	);

	override(
		\Cake\Core\PluginApplicationInterface::addPlugin(0),
		map([
			'Ajax' => \Cake\Http\BaseApplication::class,
			'AssetCompress' => \Cake\Http\BaseApplication::class,
			'AuthSandbox' => \Cake\Http\BaseApplication::class,
			'Bake' => \Cake\Http\BaseApplication::class,
			'BootstrapUI' => \Cake\Http\BaseApplication::class,
			'Burzum/CakeServiceLayer' => \Cake\Http\BaseApplication::class,
			'Cache' => \Cake\Http\BaseApplication::class,
			'Cake/Localized' => \Cake\Http\BaseApplication::class,
			'Cake/TwigView' => \Cake\Http\BaseApplication::class,
			'CakeDto' => \Cake\Http\BaseApplication::class,
			'Calendar' => \Cake\Http\BaseApplication::class,
			'Captcha' => \Cake\Http\BaseApplication::class,
			'CsvView' => \Cake\Http\BaseApplication::class,
			'Data' => \Cake\Http\BaseApplication::class,
			'DatabaseLog' => \Cake\Http\BaseApplication::class,
			'DebugKit' => \Cake\Http\BaseApplication::class,
			'Expose' => \Cake\Http\BaseApplication::class,
			'Feed' => \Cake\Http\BaseApplication::class,
			'Feedback' => \Cake\Http\BaseApplication::class,
			'Flash' => \Cake\Http\BaseApplication::class,
			'Geo' => \Cake\Http\BaseApplication::class,
			'Icings/Menu' => \Cake\Http\BaseApplication::class,
			'IdeHelper' => \Cake\Http\BaseApplication::class,
			'IdeHelperExtra' => \Cake\Http\BaseApplication::class,
			'Markup' => \Cake\Http\BaseApplication::class,
			'Menu' => \Cake\Http\BaseApplication::class,
			'Meta' => \Cake\Http\BaseApplication::class,
			'Migrations' => \Cake\Http\BaseApplication::class,
			'ModelGraph' => \Cake\Http\BaseApplication::class,
			'Queue' => \Cake\Http\BaseApplication::class,
			'Ratings' => \Cake\Http\BaseApplication::class,
			'Sandbox' => \Cake\Http\BaseApplication::class,
			'Search' => \Cake\Http\BaseApplication::class,
			'Setup' => \Cake\Http\BaseApplication::class,
			'Shim' => \Cake\Http\BaseApplication::class,
			'StateMachine' => \Cake\Http\BaseApplication::class,
			'StateMachineSandbox' => \Cake\Http\BaseApplication::class,
			'Tags' => \Cake\Http\BaseApplication::class,
			'TestHelper' => \Cake\Http\BaseApplication::class,
			'TinyAuth' => \Cake\Http\BaseApplication::class,
			'Tools' => \Cake\Http\BaseApplication::class,
			'Translate' => \Cake\Http\BaseApplication::class,
		])
	);

	override(
		\Cake\Database\TypeFactory::build(0),
		map([
			'biginteger' => \Cake\Database\Type\IntegerType::class,
			'binary' => \Cake\Database\Type\BinaryType::class,
			'binaryuuid' => \Cake\Database\Type\BinaryUuidType::class,
			'boolean' => \Cake\Database\Type\BoolType::class,
			'char' => \Cake\Database\Type\StringType::class,
			'date' => \Cake\Database\Type\DateType::class,
			'datetime' => \Cake\Database\Type\DateTimeType::class,
			'datetimefractional' => \Cake\Database\Type\DateTimeFractionalType::class,
			'decimal' => \Cake\Database\Type\DecimalType::class,
			'float' => \Cake\Database\Type\FloatType::class,
			'image' => \Captcha\Database\Type\ImageType::class,
			'integer' => \Cake\Database\Type\IntegerType::class,
			'json' => \Cake\Database\Type\JsonType::class,
			'object' => \Geo\Database\Type\ObjectType::class,
			'smallinteger' => \Cake\Database\Type\IntegerType::class,
			'string' => \Cake\Database\Type\StringType::class,
			'text' => \Cake\Database\Type\StringType::class,
			'time' => \Cake\Database\Type\TimeType::class,
			'timestamp' => \Cake\Database\Type\DateTimeType::class,
			'timestampfractional' => \Cake\Database\Type\DateTimeFractionalType::class,
			'timestamptimezone' => \Cake\Database\Type\DateTimeTimezoneType::class,
			'tinyinteger' => \Cake\Database\Type\IntegerType::class,
			'uuid' => \Cake\Database\Type\UuidType::class,
		])
	);

	expectedArguments(
		\Cake\Database\TypeFactory::map(),
		0,
		'biginteger',
		'binary',
		'binaryuuid',
		'boolean',
		'char',
		'date',
		'datetime',
		'datetimefractional',
		'decimal',
		'float',
		'image',
		'integer',
		'json',
		'object',
		'smallinteger',
		'string',
		'text',
		'time',
		'timestamp',
		'timestampfractional',
		'timestamptimezone',
		'tinyinteger',
		'uuid'
	);

	expectedArguments(
		\Cake\Datasource\ConnectionManager::get(),
		0,
		'default',
		'test'
	);

	override(
		\Cake\Datasource\ModelAwareTrait::loadModel(0),
		map([
			'Captcha.Captchas' => \Captcha\Model\Table\CaptchasTable::class,
			'Data.Addresses' => \Data\Model\Table\AddressesTable::class,
			'Data.Cities' => \Data\Model\Table\CitiesTable::class,
			'Data.Continents' => \Data\Model\Table\ContinentsTable::class,
			'Data.Counties' => \Data\Model\Table\CountiesTable::class,
			'Data.Countries' => \Data\Model\Table\CountriesTable::class,
			'Data.Currencies' => \Data\Model\Table\CurrenciesTable::class,
			'Data.Districts' => \Data\Model\Table\DistrictsTable::class,
			'Data.Languages' => \Data\Model\Table\LanguagesTable::class,
			'Data.Locations' => \Data\Model\Table\LocationsTable::class,
			'Data.MimeTypeImages' => \Data\Model\Table\MimeTypeImagesTable::class,
			'Data.MimeTypes' => \Data\Model\Table\MimeTypesTable::class,
			'Data.PostalCodes' => \Data\Model\Table\PostalCodesTable::class,
			'Data.States' => \Data\Model\Table\StatesTable::class,
			'Data.Timezones' => \Data\Model\Table\TimezonesTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'Feedback.FeedbackItems' => \Feedback\Model\Table\FeedbackItemsTable::class,
			'Feedback.Feedbackstore' => \Feedback\Model\Table\FeedbackstoreTable::class,
			'Geo.GeocodedAddresses' => \Geo\Model\Table\GeocodedAddressesTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'Ratings.Ratings' => \Ratings\Model\Table\RatingsTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'Sandbox.Animals' => \Sandbox\Model\Table\AnimalsTable::class,
			'Sandbox.BitmaskedRecords' => \Sandbox\Model\Table\BitmaskedRecordsTable::class,
			'Sandbox.CountryRecords' => \Sandbox\Model\Table\CountryRecordsTable::class,
			'Sandbox.Events' => \Sandbox\Model\Table\EventsTable::class,
			'Sandbox.ExampleRecords' => \Sandbox\Model\Table\ExampleRecordsTable::class,
			'Sandbox.ExposedUsers' => \Sandbox\Model\Table\ExposedUsersTable::class,
			'Sandbox.SandboxCategories' => \Sandbox\Model\Table\SandboxCategoriesTable::class,
			'Sandbox.SandboxPosts' => \Sandbox\Model\Table\SandboxPostsTable::class,
			'Sandbox.SandboxRatings' => \Sandbox\Model\Table\SandboxRatingsTable::class,
			'Sandbox.SandboxUsers' => \Sandbox\Model\Table\SandboxUsersTable::class,
			'StateMachine.StateMachineItemStateLogs' => \StateMachine\Model\Table\StateMachineItemStateLogsTable::class,
			'StateMachine.StateMachineItemStates' => \StateMachine\Model\Table\StateMachineItemStatesTable::class,
			'StateMachine.StateMachineItems' => \StateMachine\Model\Table\StateMachineItemsTable::class,
			'StateMachine.StateMachineLocks' => \StateMachine\Model\Table\StateMachineLocksTable::class,
			'StateMachine.StateMachineProcesses' => \StateMachine\Model\Table\StateMachineProcessesTable::class,
			'StateMachine.StateMachineTimeouts' => \StateMachine\Model\Table\StateMachineTimeoutsTable::class,
			'StateMachine.StateMachineTransitionLogs' => \StateMachine\Model\Table\StateMachineTransitionLogsTable::class,
			'StateMachineSandbox.Registrations' => \StateMachineSandbox\Model\Table\RegistrationsTable::class,
			'Tags.Tagged' => \Tags\Model\Table\TaggedTable::class,
			'Tags.Tags' => \Tags\Model\Table\TagsTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	override(
		\Cake\Datasource\QueryInterface::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'calendar' => \Cake\ORM\Query::class,
			'children' => \Cake\ORM\Query::class,
			'cloud' => \Cake\ORM\Query::class,
			'distance' => \Cake\ORM\Query::class,
			'exposed' => \Cake\ORM\Query::class,
			'exposedList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'path' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'slugged' => \Cake\ORM\Query::class,
			'tagged' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'treeList' => \Cake\ORM\Query::class,
			'untagged' => \Cake\ORM\Query::class,
		])
	);

	expectedArguments(
		\Cake\Http\ServerRequest::getParam(),
		0,
		'_ext',
		'_matchedRoute',
		'action',
		'controller',
		'pass',
		'plugin',
		'prefix'
	);

	override(
		\Cake\ORM\Association::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'calendar' => \Cake\ORM\Query::class,
			'children' => \Cake\ORM\Query::class,
			'cloud' => \Cake\ORM\Query::class,
			'distance' => \Cake\ORM\Query::class,
			'exposed' => \Cake\ORM\Query::class,
			'exposedList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'path' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'slugged' => \Cake\ORM\Query::class,
			'tagged' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'treeList' => \Cake\ORM\Query::class,
			'untagged' => \Cake\ORM\Query::class,
		])
	);

	expectedArguments(
		\Cake\ORM\Entity::get(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::getError(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::getInvalidField(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::getOriginal(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::has(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::hasValue(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::isDirty(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::isEmpty(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::setDirty(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	expectedArguments(
		\Cake\ORM\Entity::setError(),
		0,
		argumentsSet('entityFields:Cake\ORM\Entity')
	);

	override(
		\Cake\ORM\Locator\LocatorAwareTrait::fetchTable(0),
		map([
			'Captcha.Captchas' => \Captcha\Model\Table\CaptchasTable::class,
			'Data.Addresses' => \Data\Model\Table\AddressesTable::class,
			'Data.Cities' => \Data\Model\Table\CitiesTable::class,
			'Data.Continents' => \Data\Model\Table\ContinentsTable::class,
			'Data.Counties' => \Data\Model\Table\CountiesTable::class,
			'Data.Countries' => \Data\Model\Table\CountriesTable::class,
			'Data.Currencies' => \Data\Model\Table\CurrenciesTable::class,
			'Data.Districts' => \Data\Model\Table\DistrictsTable::class,
			'Data.Languages' => \Data\Model\Table\LanguagesTable::class,
			'Data.Locations' => \Data\Model\Table\LocationsTable::class,
			'Data.MimeTypeImages' => \Data\Model\Table\MimeTypeImagesTable::class,
			'Data.MimeTypes' => \Data\Model\Table\MimeTypesTable::class,
			'Data.PostalCodes' => \Data\Model\Table\PostalCodesTable::class,
			'Data.States' => \Data\Model\Table\StatesTable::class,
			'Data.Timezones' => \Data\Model\Table\TimezonesTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'Feedback.FeedbackItems' => \Feedback\Model\Table\FeedbackItemsTable::class,
			'Feedback.Feedbackstore' => \Feedback\Model\Table\FeedbackstoreTable::class,
			'Geo.GeocodedAddresses' => \Geo\Model\Table\GeocodedAddressesTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'Ratings.Ratings' => \Ratings\Model\Table\RatingsTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'Sandbox.Animals' => \Sandbox\Model\Table\AnimalsTable::class,
			'Sandbox.BitmaskedRecords' => \Sandbox\Model\Table\BitmaskedRecordsTable::class,
			'Sandbox.CountryRecords' => \Sandbox\Model\Table\CountryRecordsTable::class,
			'Sandbox.Events' => \Sandbox\Model\Table\EventsTable::class,
			'Sandbox.ExampleRecords' => \Sandbox\Model\Table\ExampleRecordsTable::class,
			'Sandbox.ExposedUsers' => \Sandbox\Model\Table\ExposedUsersTable::class,
			'Sandbox.SandboxCategories' => \Sandbox\Model\Table\SandboxCategoriesTable::class,
			'Sandbox.SandboxPosts' => \Sandbox\Model\Table\SandboxPostsTable::class,
			'Sandbox.SandboxRatings' => \Sandbox\Model\Table\SandboxRatingsTable::class,
			'Sandbox.SandboxUsers' => \Sandbox\Model\Table\SandboxUsersTable::class,
			'StateMachine.StateMachineItemStateLogs' => \StateMachine\Model\Table\StateMachineItemStateLogsTable::class,
			'StateMachine.StateMachineItemStates' => \StateMachine\Model\Table\StateMachineItemStatesTable::class,
			'StateMachine.StateMachineItems' => \StateMachine\Model\Table\StateMachineItemsTable::class,
			'StateMachine.StateMachineLocks' => \StateMachine\Model\Table\StateMachineLocksTable::class,
			'StateMachine.StateMachineProcesses' => \StateMachine\Model\Table\StateMachineProcessesTable::class,
			'StateMachine.StateMachineTimeouts' => \StateMachine\Model\Table\StateMachineTimeoutsTable::class,
			'StateMachine.StateMachineTransitionLogs' => \StateMachine\Model\Table\StateMachineTransitionLogsTable::class,
			'StateMachineSandbox.Registrations' => \StateMachineSandbox\Model\Table\RegistrationsTable::class,
			'Tags.Tagged' => \Tags\Model\Table\TaggedTable::class,
			'Tags.Tags' => \Tags\Model\Table\TagsTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	override(
		\Cake\ORM\Locator\LocatorInterface::get(0),
		map([
			'Captcha.Captchas' => \Captcha\Model\Table\CaptchasTable::class,
			'Data.Addresses' => \Data\Model\Table\AddressesTable::class,
			'Data.Cities' => \Data\Model\Table\CitiesTable::class,
			'Data.Continents' => \Data\Model\Table\ContinentsTable::class,
			'Data.Counties' => \Data\Model\Table\CountiesTable::class,
			'Data.Countries' => \Data\Model\Table\CountriesTable::class,
			'Data.Currencies' => \Data\Model\Table\CurrenciesTable::class,
			'Data.Districts' => \Data\Model\Table\DistrictsTable::class,
			'Data.Languages' => \Data\Model\Table\LanguagesTable::class,
			'Data.Locations' => \Data\Model\Table\LocationsTable::class,
			'Data.MimeTypeImages' => \Data\Model\Table\MimeTypeImagesTable::class,
			'Data.MimeTypes' => \Data\Model\Table\MimeTypesTable::class,
			'Data.PostalCodes' => \Data\Model\Table\PostalCodesTable::class,
			'Data.States' => \Data\Model\Table\StatesTable::class,
			'Data.Timezones' => \Data\Model\Table\TimezonesTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'Feedback.FeedbackItems' => \Feedback\Model\Table\FeedbackItemsTable::class,
			'Feedback.Feedbackstore' => \Feedback\Model\Table\FeedbackstoreTable::class,
			'Geo.GeocodedAddresses' => \Geo\Model\Table\GeocodedAddressesTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'Ratings.Ratings' => \Ratings\Model\Table\RatingsTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'Sandbox.Animals' => \Sandbox\Model\Table\AnimalsTable::class,
			'Sandbox.BitmaskedRecords' => \Sandbox\Model\Table\BitmaskedRecordsTable::class,
			'Sandbox.CountryRecords' => \Sandbox\Model\Table\CountryRecordsTable::class,
			'Sandbox.Events' => \Sandbox\Model\Table\EventsTable::class,
			'Sandbox.ExampleRecords' => \Sandbox\Model\Table\ExampleRecordsTable::class,
			'Sandbox.ExposedUsers' => \Sandbox\Model\Table\ExposedUsersTable::class,
			'Sandbox.SandboxCategories' => \Sandbox\Model\Table\SandboxCategoriesTable::class,
			'Sandbox.SandboxPosts' => \Sandbox\Model\Table\SandboxPostsTable::class,
			'Sandbox.SandboxRatings' => \Sandbox\Model\Table\SandboxRatingsTable::class,
			'Sandbox.SandboxUsers' => \Sandbox\Model\Table\SandboxUsersTable::class,
			'StateMachine.StateMachineItemStateLogs' => \StateMachine\Model\Table\StateMachineItemStateLogsTable::class,
			'StateMachine.StateMachineItemStates' => \StateMachine\Model\Table\StateMachineItemStatesTable::class,
			'StateMachine.StateMachineItems' => \StateMachine\Model\Table\StateMachineItemsTable::class,
			'StateMachine.StateMachineLocks' => \StateMachine\Model\Table\StateMachineLocksTable::class,
			'StateMachine.StateMachineProcesses' => \StateMachine\Model\Table\StateMachineProcessesTable::class,
			'StateMachine.StateMachineTimeouts' => \StateMachine\Model\Table\StateMachineTimeoutsTable::class,
			'StateMachine.StateMachineTransitionLogs' => \StateMachine\Model\Table\StateMachineTransitionLogsTable::class,
			'StateMachineSandbox.Registrations' => \StateMachineSandbox\Model\Table\RegistrationsTable::class,
			'Tags.Tagged' => \Tags\Model\Table\TaggedTable::class,
			'Tags.Tags' => \Tags\Model\Table\TagsTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	expectedArguments(
		\Cake\ORM\Table::addBehavior(),
		0,
		'Calendar.Calendar',
		'Captcha.Captcha',
		'Captcha.PassiveCaptcha',
		'CounterCache',
		'Expose.Expose',
		'Expose.Superimpose',
		'Geo.Geocoder',
		'Ratings.Ratable',
		'Search.Search',
		'Tags.Tag',
		'Timestamp',
		'Tools.AfterSave',
		'Tools.Bitmasked',
		'Tools.Confirmable',
		'Tools.Jsonable',
		'Tools.Neighbor',
		'Tools.Passwordable',
		'Tools.Reset',
		'Tools.Slugged',
		'Tools.String',
		'Tools.Toggle',
		'Tools.TypeMap',
		'Tools.Typographic',
		'Translate',
		'Tree'
	);

	override(
		\Cake\ORM\Table::belongToMany(0),
		map([
			'Captcha.Captchas' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Addresses' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Cities' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Continents' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Counties' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Countries' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Currencies' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Districts' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Languages' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Locations' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.MimeTypeImages' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.MimeTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.PostalCodes' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.States' => \Cake\ORM\Association\BelongsToMany::class,
			'Data.Timezones' => \Cake\ORM\Association\BelongsToMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsToMany::class,
			'Feedback.FeedbackItems' => \Cake\ORM\Association\BelongsToMany::class,
			'Feedback.Feedbackstore' => \Cake\ORM\Association\BelongsToMany::class,
			'Geo.GeocodedAddresses' => \Cake\ORM\Association\BelongsToMany::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\BelongsToMany::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\BelongsToMany::class,
			'Ratings.Ratings' => \Cake\ORM\Association\BelongsToMany::class,
			'Roles' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.Animals' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.BitmaskedRecords' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.CountryRecords' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.Events' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.ExampleRecords' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.ExposedUsers' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.SandboxCategories' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.SandboxPosts' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.SandboxRatings' => \Cake\ORM\Association\BelongsToMany::class,
			'Sandbox.SandboxUsers' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineItemStateLogs' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineItemStates' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineItems' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineLocks' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineProcesses' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineTimeouts' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachine.StateMachineTransitionLogs' => \Cake\ORM\Association\BelongsToMany::class,
			'StateMachineSandbox.Registrations' => \Cake\ORM\Association\BelongsToMany::class,
			'Tags.Tagged' => \Cake\ORM\Association\BelongsToMany::class,
			'Tags.Tags' => \Cake\ORM\Association\BelongsToMany::class,
			'Tools.Tokens' => \Cake\ORM\Association\BelongsToMany::class,
			'Users' => \Cake\ORM\Association\BelongsToMany::class,
		])
	);

	override(
		\Cake\ORM\Table::belongsTo(0),
		map([
			'Captcha.Captchas' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Addresses' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Cities' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Continents' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Counties' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Countries' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Currencies' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Districts' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Languages' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Locations' => \Cake\ORM\Association\BelongsTo::class,
			'Data.MimeTypeImages' => \Cake\ORM\Association\BelongsTo::class,
			'Data.MimeTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Data.PostalCodes' => \Cake\ORM\Association\BelongsTo::class,
			'Data.States' => \Cake\ORM\Association\BelongsTo::class,
			'Data.Timezones' => \Cake\ORM\Association\BelongsTo::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsTo::class,
			'Feedback.FeedbackItems' => \Cake\ORM\Association\BelongsTo::class,
			'Feedback.Feedbackstore' => \Cake\ORM\Association\BelongsTo::class,
			'Geo.GeocodedAddresses' => \Cake\ORM\Association\BelongsTo::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\BelongsTo::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\BelongsTo::class,
			'Ratings.Ratings' => \Cake\ORM\Association\BelongsTo::class,
			'Roles' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.Animals' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.BitmaskedRecords' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.CountryRecords' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.Events' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.ExampleRecords' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.ExposedUsers' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.SandboxCategories' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.SandboxPosts' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.SandboxRatings' => \Cake\ORM\Association\BelongsTo::class,
			'Sandbox.SandboxUsers' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineItemStateLogs' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineItemStates' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineItems' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineLocks' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineProcesses' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineTimeouts' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachine.StateMachineTransitionLogs' => \Cake\ORM\Association\BelongsTo::class,
			'StateMachineSandbox.Registrations' => \Cake\ORM\Association\BelongsTo::class,
			'Tags.Tagged' => \Cake\ORM\Association\BelongsTo::class,
			'Tags.Tags' => \Cake\ORM\Association\BelongsTo::class,
			'Tools.Tokens' => \Cake\ORM\Association\BelongsTo::class,
			'Users' => \Cake\ORM\Association\BelongsTo::class,
		])
	);

	override(
		\Cake\ORM\Table::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'calendar' => \Cake\ORM\Query::class,
			'children' => \Cake\ORM\Query::class,
			'cloud' => \Cake\ORM\Query::class,
			'distance' => \Cake\ORM\Query::class,
			'exposed' => \Cake\ORM\Query::class,
			'exposedList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'path' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'slugged' => \Cake\ORM\Query::class,
			'tagged' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'treeList' => \Cake\ORM\Query::class,
			'untagged' => \Cake\ORM\Query::class,
		])
	);

	override(
		\Cake\ORM\Table::hasMany(0),
		map([
			'Captcha.Captchas' => \Cake\ORM\Association\HasMany::class,
			'Data.Addresses' => \Cake\ORM\Association\HasMany::class,
			'Data.Cities' => \Cake\ORM\Association\HasMany::class,
			'Data.Continents' => \Cake\ORM\Association\HasMany::class,
			'Data.Counties' => \Cake\ORM\Association\HasMany::class,
			'Data.Countries' => \Cake\ORM\Association\HasMany::class,
			'Data.Currencies' => \Cake\ORM\Association\HasMany::class,
			'Data.Districts' => \Cake\ORM\Association\HasMany::class,
			'Data.Languages' => \Cake\ORM\Association\HasMany::class,
			'Data.Locations' => \Cake\ORM\Association\HasMany::class,
			'Data.MimeTypeImages' => \Cake\ORM\Association\HasMany::class,
			'Data.MimeTypes' => \Cake\ORM\Association\HasMany::class,
			'Data.PostalCodes' => \Cake\ORM\Association\HasMany::class,
			'Data.States' => \Cake\ORM\Association\HasMany::class,
			'Data.Timezones' => \Cake\ORM\Association\HasMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasMany::class,
			'Feedback.FeedbackItems' => \Cake\ORM\Association\HasMany::class,
			'Feedback.Feedbackstore' => \Cake\ORM\Association\HasMany::class,
			'Geo.GeocodedAddresses' => \Cake\ORM\Association\HasMany::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\HasMany::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\HasMany::class,
			'Ratings.Ratings' => \Cake\ORM\Association\HasMany::class,
			'Roles' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.Animals' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.BitmaskedRecords' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.CountryRecords' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.Events' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.ExampleRecords' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.ExposedUsers' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.SandboxCategories' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.SandboxPosts' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.SandboxRatings' => \Cake\ORM\Association\HasMany::class,
			'Sandbox.SandboxUsers' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineItemStateLogs' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineItemStates' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineItems' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineLocks' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineProcesses' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineTimeouts' => \Cake\ORM\Association\HasMany::class,
			'StateMachine.StateMachineTransitionLogs' => \Cake\ORM\Association\HasMany::class,
			'StateMachineSandbox.Registrations' => \Cake\ORM\Association\HasMany::class,
			'Tags.Tagged' => \Cake\ORM\Association\HasMany::class,
			'Tags.Tags' => \Cake\ORM\Association\HasMany::class,
			'Tools.Tokens' => \Cake\ORM\Association\HasMany::class,
			'Users' => \Cake\ORM\Association\HasMany::class,
		])
	);

	override(
		\Cake\ORM\Table::hasOne(0),
		map([
			'Captcha.Captchas' => \Cake\ORM\Association\HasOne::class,
			'Data.Addresses' => \Cake\ORM\Association\HasOne::class,
			'Data.Cities' => \Cake\ORM\Association\HasOne::class,
			'Data.Continents' => \Cake\ORM\Association\HasOne::class,
			'Data.Counties' => \Cake\ORM\Association\HasOne::class,
			'Data.Countries' => \Cake\ORM\Association\HasOne::class,
			'Data.Currencies' => \Cake\ORM\Association\HasOne::class,
			'Data.Districts' => \Cake\ORM\Association\HasOne::class,
			'Data.Languages' => \Cake\ORM\Association\HasOne::class,
			'Data.Locations' => \Cake\ORM\Association\HasOne::class,
			'Data.MimeTypeImages' => \Cake\ORM\Association\HasOne::class,
			'Data.MimeTypes' => \Cake\ORM\Association\HasOne::class,
			'Data.PostalCodes' => \Cake\ORM\Association\HasOne::class,
			'Data.States' => \Cake\ORM\Association\HasOne::class,
			'Data.Timezones' => \Cake\ORM\Association\HasOne::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasOne::class,
			'Feedback.FeedbackItems' => \Cake\ORM\Association\HasOne::class,
			'Feedback.Feedbackstore' => \Cake\ORM\Association\HasOne::class,
			'Geo.GeocodedAddresses' => \Cake\ORM\Association\HasOne::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\HasOne::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\HasOne::class,
			'Ratings.Ratings' => \Cake\ORM\Association\HasOne::class,
			'Roles' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.Animals' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.BitmaskedRecords' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.CountryRecords' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.Events' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.ExampleRecords' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.ExposedUsers' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.SandboxCategories' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.SandboxPosts' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.SandboxRatings' => \Cake\ORM\Association\HasOne::class,
			'Sandbox.SandboxUsers' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineItemStateLogs' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineItemStates' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineItems' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineLocks' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineProcesses' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineTimeouts' => \Cake\ORM\Association\HasOne::class,
			'StateMachine.StateMachineTransitionLogs' => \Cake\ORM\Association\HasOne::class,
			'StateMachineSandbox.Registrations' => \Cake\ORM\Association\HasOne::class,
			'Tags.Tagged' => \Cake\ORM\Association\HasOne::class,
			'Tags.Tags' => \Cake\ORM\Association\HasOne::class,
			'Tools.Tokens' => \Cake\ORM\Association\HasOne::class,
			'Users' => \Cake\ORM\Association\HasOne::class,
		])
	);

	expectedArguments(
		\Cake\ORM\Table::removeBehavior(),
		0,
		'AfterSave',
		'Bitmasked',
		'Calendar',
		'Captcha',
		'Confirmable',
		'CounterCache',
		'Expose',
		'Geocoder',
		'Jsonable',
		'Neighbor',
		'PassiveCaptcha',
		'Passwordable',
		'Ratable',
		'Reset',
		'Search',
		'Slugged',
		'String',
		'Superimpose',
		'Tag',
		'Timestamp',
		'Toggle',
		'Translate',
		'Tree',
		'TypeMap',
		'Typographic'
	);

	override(
		\Cake\ORM\TableRegistry::get(0),
		map([
			'Captcha.Captchas' => \Captcha\Model\Table\CaptchasTable::class,
			'Data.Addresses' => \Data\Model\Table\AddressesTable::class,
			'Data.Cities' => \Data\Model\Table\CitiesTable::class,
			'Data.Continents' => \Data\Model\Table\ContinentsTable::class,
			'Data.Counties' => \Data\Model\Table\CountiesTable::class,
			'Data.Countries' => \Data\Model\Table\CountriesTable::class,
			'Data.Currencies' => \Data\Model\Table\CurrenciesTable::class,
			'Data.Districts' => \Data\Model\Table\DistrictsTable::class,
			'Data.Languages' => \Data\Model\Table\LanguagesTable::class,
			'Data.Locations' => \Data\Model\Table\LocationsTable::class,
			'Data.MimeTypeImages' => \Data\Model\Table\MimeTypeImagesTable::class,
			'Data.MimeTypes' => \Data\Model\Table\MimeTypesTable::class,
			'Data.PostalCodes' => \Data\Model\Table\PostalCodesTable::class,
			'Data.States' => \Data\Model\Table\StatesTable::class,
			'Data.Timezones' => \Data\Model\Table\TimezonesTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'Feedback.FeedbackItems' => \Feedback\Model\Table\FeedbackItemsTable::class,
			'Feedback.Feedbackstore' => \Feedback\Model\Table\FeedbackstoreTable::class,
			'Geo.GeocodedAddresses' => \Geo\Model\Table\GeocodedAddressesTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'Ratings.Ratings' => \Ratings\Model\Table\RatingsTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'Sandbox.Animals' => \Sandbox\Model\Table\AnimalsTable::class,
			'Sandbox.BitmaskedRecords' => \Sandbox\Model\Table\BitmaskedRecordsTable::class,
			'Sandbox.CountryRecords' => \Sandbox\Model\Table\CountryRecordsTable::class,
			'Sandbox.Events' => \Sandbox\Model\Table\EventsTable::class,
			'Sandbox.ExampleRecords' => \Sandbox\Model\Table\ExampleRecordsTable::class,
			'Sandbox.ExposedUsers' => \Sandbox\Model\Table\ExposedUsersTable::class,
			'Sandbox.SandboxCategories' => \Sandbox\Model\Table\SandboxCategoriesTable::class,
			'Sandbox.SandboxPosts' => \Sandbox\Model\Table\SandboxPostsTable::class,
			'Sandbox.SandboxRatings' => \Sandbox\Model\Table\SandboxRatingsTable::class,
			'Sandbox.SandboxUsers' => \Sandbox\Model\Table\SandboxUsersTable::class,
			'StateMachine.StateMachineItemStateLogs' => \StateMachine\Model\Table\StateMachineItemStateLogsTable::class,
			'StateMachine.StateMachineItemStates' => \StateMachine\Model\Table\StateMachineItemStatesTable::class,
			'StateMachine.StateMachineItems' => \StateMachine\Model\Table\StateMachineItemsTable::class,
			'StateMachine.StateMachineLocks' => \StateMachine\Model\Table\StateMachineLocksTable::class,
			'StateMachine.StateMachineProcesses' => \StateMachine\Model\Table\StateMachineProcessesTable::class,
			'StateMachine.StateMachineTimeouts' => \StateMachine\Model\Table\StateMachineTimeoutsTable::class,
			'StateMachine.StateMachineTransitionLogs' => \StateMachine\Model\Table\StateMachineTransitionLogsTable::class,
			'StateMachineSandbox.Registrations' => \StateMachineSandbox\Model\Table\RegistrationsTable::class,
			'Tags.Tagged' => \Tags\Model\Table\TaggedTable::class,
			'Tags.Tags' => \Tags\Model\Table\TagsTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	expectedArguments(
		\Cake\Routing\Router::pathUrl(),
		0,
		argumentsSet('routePaths')
	);

	expectedArguments(
		\Cake\TestSuite\TestCase::addFixture(),
		0,
		'app.Roles',
		'app.Users',
		'core.Articles',
		'core.ArticlesMoreTranslations',
		'core.ArticlesTags',
		'core.ArticlesTagsBindingKeys',
		'core.ArticlesTranslations',
		'core.Attachments',
		'core.AuthUsers',
		'core.Authors',
		'core.AuthorsTags',
		'core.AuthorsTranslations',
		'core.BinaryUuidItems',
		'core.BinaryUuidItemsBinaryUuidTags',
		'core.BinaryUuidTags',
		'core.CakeSessions',
		'core.Categories',
		'core.ColumnSchemaAwareTypeValues',
		'core.Comments',
		'core.CommentsTranslations',
		'core.CompositeIncrements',
		'core.CompositeKeyArticles',
		'core.CompositeKeyArticlesTags',
		'core.CounterCacheCategories',
		'core.CounterCacheComments',
		'core.CounterCachePosts',
		'core.CounterCacheUserCategoryPosts',
		'core.CounterCacheUsers',
		'core.Datatypes',
		'core.DateKeys',
		'core.FeaturedTags',
		'core.Members',
		'core.MenuLinkTrees',
		'core.NullableAuthors',
		'core.NumberTrees',
		'core.NumberTreesArticles',
		'core.OrderedUuidItems',
		'core.Orders',
		'core.OtherArticles',
		'core.PolymorphicTagged',
		'core.Posts',
		'core.Products',
		'core.Profiles',
		'core.Sections',
		'core.SectionsMembers',
		'core.SectionsTranslations',
		'core.Sessions',
		'core.SiteArticles',
		'core.SiteArticlesTags',
		'core.SiteAuthors',
		'core.SiteTags',
		'core.SpecialTags',
		'core.SpecialTagsTranslations',
		'core.Tags',
		'core.TagsShadowTranslations',
		'core.TagsTranslations',
		'core.TestPluginComments',
		'core.Things',
		'core.Translates',
		'core.UniqueAuthors',
		'core.Users',
		'core.UuidItems',
		'plugin.Bake.Articles',
		'plugin.Bake.ArticlesTags',
		'plugin.Bake.Authors',
		'plugin.Bake.BakeArticles',
		'plugin.Bake.BakeArticlesBakeTags',
		'plugin.Bake.BakeCar',
		'plugin.Bake.BakeComments',
		'plugin.Bake.BakeTags',
		'plugin.Bake.BakeTemplateAuthors',
		'plugin.Bake.BakeTemplateProfiles',
		'plugin.Bake.BakeTemplateRoles',
		'plugin.Bake.BinaryTests',
		'plugin.Bake.Categories',
		'plugin.Bake.CategoriesProducts',
		'plugin.Bake.CategoryThreads',
		'plugin.Bake.Comments',
		'plugin.Bake.Datatypes',
		'plugin.Bake.HiddenFields',
		'plugin.Bake.Invitations',
		'plugin.Bake.NumberTrees',
		'plugin.Bake.OldProducts',
		'plugin.Bake.Posts',
		'plugin.Bake.ProductVersions',
		'plugin.Bake.Products',
		'plugin.Bake.Tags',
		'plugin.Bake.TodoItems',
		'plugin.Bake.TodoItemsTodoLabels',
		'plugin.Bake.TodoLabels',
		'plugin.Bake.TodoTasks',
		'plugin.Bake.UniqueFields',
		'plugin.Bake.Users',
		'plugin.BootstrapUI.Articles',
		'plugin.BootstrapUI.Authors',
		'plugin.Cake/TwigView.Authors',
		'plugin.Calendar.Events',
		'plugin.Captcha.Captchas',
		'plugin.Captcha.Comments',
		'plugin.Data.Addresses',
		'plugin.Data.Cities',
		'plugin.Data.Continents',
		'plugin.Data.Counties',
		'plugin.Data.Countries',
		'plugin.Data.Currencies',
		'plugin.Data.Districts',
		'plugin.Data.Languages',
		'plugin.Data.Locations',
		'plugin.Data.MimeTypeImages',
		'plugin.Data.MimeTypes',
		'plugin.Data.PostalCodes',
		'plugin.Data.States',
		'plugin.Data.Timezones',
		'plugin.DatabaseLog.DatabaseLogs',
		'plugin.Expose.BinaryFieldRecords',
		'plugin.Expose.CustomFieldRecords',
		'plugin.Expose.ExistingRecords',
		'plugin.Expose.Posts',
		'plugin.Expose.Users',
		'plugin.Feedback.FeedbackItems',
		'plugin.Geo.Addresses',
		'plugin.Geo.GeocodedAddresses',
		'plugin.IdeHelper.BarBars',
		'plugin.IdeHelper.Cars',
		'plugin.IdeHelper.Foo',
		'plugin.IdeHelper.Houses',
		'plugin.IdeHelper.Wheels',
		'plugin.IdeHelper.Windows',
		'plugin.Migrations.Articles',
		'plugin.Migrations.Categories',
		'plugin.Migrations.CompositePk',
		'plugin.Migrations.Events',
		'plugin.Migrations.Orders',
		'plugin.Migrations.Parts',
		'plugin.Migrations.Products',
		'plugin.Migrations.SpecialPk',
		'plugin.Migrations.SpecialTags',
		'plugin.Migrations.Texts',
		'plugin.Migrations.Users',
		'plugin.Queue.QueueProcesses',
		'plugin.Queue.QueuedJobs',
		'plugin.Ratings.Articles',
		'plugin.Ratings.Posts',
		'plugin.Ratings.Ratings',
		'plugin.Ratings.Users',
		'plugin.Sandbox.BitmaskedRecords',
		'plugin.Sandbox.Events',
		'plugin.Sandbox.ExposedUsers',
		'plugin.Sandbox.SandboxAnimals',
		'plugin.Sandbox.SandboxCategories',
		'plugin.Sandbox.SandboxPosts',
		'plugin.Sandbox.SandboxRatings',
		'plugin.Sandbox.SandboxUsers',
		'plugin.Search.Articles',
		'plugin.Search.Sections',
		'plugin.Setup.Users',
		'plugin.StateMachine.StateMachineItemStateLogs',
		'plugin.StateMachine.StateMachineItemStates',
		'plugin.StateMachine.StateMachineItems',
		'plugin.StateMachine.StateMachineLocks',
		'plugin.StateMachine.StateMachineProcesses',
		'plugin.StateMachine.StateMachineTimeouts',
		'plugin.StateMachine.StateMachineTransitionLogs',
		'plugin.StateMachineSandbox.Registrations',
		'plugin.Tags.Buns',
		'plugin.Tags.CounterlessMuffins',
		'plugin.Tags.Muffins',
		'plugin.Tags.MultiTagsRecords',
		'plugin.Tags.Tagged',
		'plugin.Tags.Tags',
		'plugin.Tags.UuidPosts',
		'plugin.Tags.UuidTagged',
		'plugin.Tags.UuidTags',
		'plugin.TinyAuth.DatabaseRoles',
		'plugin.TinyAuth.DatabaseRolesUsers',
		'plugin.TinyAuth.DatabaseUserRoles',
		'plugin.TinyAuth.EmptyRoles',
		'plugin.TinyAuth.RolesUsers',
		'plugin.TinyAuth.Users',
		'plugin.Tools.AfterTrees',
		'plugin.Tools.BitmaskedComments',
		'plugin.Tools.Data',
		'plugin.Tools.JsonableComments',
		'plugin.Tools.MultiColumnUsers',
		'plugin.Tools.ResetComments',
		'plugin.Tools.Roles',
		'plugin.Tools.SluggedArticles',
		'plugin.Tools.Stories',
		'plugin.Tools.StringComments',
		'plugin.Tools.ToggleAddresses',
		'plugin.Tools.Tokens',
		'plugin.Tools.ToolsUsers'
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyArray(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyDate(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyDateTime(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyFile(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyFor(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyString(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::allowEmptyTime(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyArray(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyDate(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyDateTime(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyFile(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyString(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::notEmptyTime(),
		2,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\Validation\Validator::requirePresence(),
		1,
		argumentsSet('validationWhen')
	);

	expectedArguments(
		\Cake\View\Helper\FormHelper::control(),
		0,
		'active',
		'address_format',
		'alias',
		'base',
		'beginning',
		'code',
		'command',
		'completed',
		'condition',
		'content',
		'context',
		'count',
		'counter',
		'country_code',
		'country_id',
		'covered',
		'created',
		'data',
		'decimal_places',
		'description',
		'email',
		'end',
		'error_message',
		'eu_member',
		'event',
		'expires',
		'failed',
		'failure_message',
		'fetched',
		'fk_id',
		'fk_model',
		'flag_optional',
		'flag_required',
		'foreign_key',
		'hostname',
		'id',
		'identifier',
		'image',
		'ip',
		'is_error',
		'iso2',
		'iso3',
		'job_group',
		'job_task',
		'label',
		'last_login',
		'lat',
		'lft',
		'linked_id',
		'lng',
		'locale',
		'locale_fallback',
		'location',
		'locked',
		'logins',
		'message',
		'model',
		'modified',
		'name',
		'namespace',
		'notbefore',
		'notes',
		'offset',
		'offset_dst',
		'ori_name',
		'params',
		'parent_id',
		'password',
		'phone_code',
		'pid',
		'priority',
		'process',
		'progress',
		'rating_count',
		'rating_sum',
		'refer',
		'reference',
		'result',
		'rght',
		'role_id',
		'server',
		'session_id',
		'slug',
		'sort',
		'source_state',
		'special',
		'state',
		'state_machine',
		'state_machine_item_id',
		'state_machine_item_state_id',
		'state_machine_process_id',
		'state_machine_transition_log_id',
		'status',
		'summary',
		'symbol_left',
		'symbol_right',
		'tag_id',
		'target_state',
		'terminate',
		'timeout',
		'timezone',
		'title',
		'type',
		'uri',
		'used',
		'user_agent',
		'user_id',
		'username',
		'uuid',
		'value',
		'workerkey',
		'zip_length',
		'zip_regexp'
	);

	expectedArguments(
		\Cake\View\Helper\HtmlHelper::linkFromPath(),
		1,
		argumentsSet('routePaths')
	);

	expectedArguments(
		\Cake\View\Helper\UrlHelper::buildFromPath(),
		0,
		argumentsSet('routePaths')
	);

	expectedArguments(
		\Cake\View\View::element(),
		0,
		'BootstrapUI.flash/default',
		'Cake/TwigView.twig_panel',
		'Data.States/search',
		'DatabaseLog.paging',
		'DatabaseLog.search',
		'Feedback.pagination',
		'Feedback.sidebar',
		'Feedback.sidebar_modal',
		'Geo.pagination',
		'Queue.search',
		'Sandbox.actions',
		'Sandbox.feed/element',
		'Sandbox.inflector/result-row',
		'Sandbox.inflector/results',
		'Sandbox.navigation/ajax',
		'Sandbox.navigation/dto',
		'Sandbox.navigation/localized',
		'Sandbox.navigation/media_embed',
		'Sandbox.navigation/queue',
		'Sandbox.navigation/search',
		'Sandbox.navigation/service',
		'Sandbox.navigation/tags',
		'Sandbox.navigation/tools',
		'StateMachineSandbox.navigation/registration',
		'TinyAuth.auth_panel',
		'Tools.pagination',
		'flash/default',
		'flash/error',
		'flash/info',
		'flash/success',
		'flash/warning',
		'navigation',
		'stats'
	);

	override(
		\Cake\View\View::loadHelper(0),
		map([
			'App' => \App\View\Helper\AppHelper::class,
			'AssetCompress.AssetCompress' => \AssetCompress\View\Helper\AssetCompressHelper::class,
			'Bake.Bake' => \Bake\View\Helper\BakeHelper::class,
			'Bake.DocBlock' => \Bake\View\Helper\DocBlockHelper::class,
			'BootstrapUI.Breadcrumbs' => \BootstrapUI\View\Helper\BreadcrumbsHelper::class,
			'BootstrapUI.Flash' => \BootstrapUI\View\Helper\FlashHelper::class,
			'BootstrapUI.Form' => \BootstrapUI\View\Helper\FormHelper::class,
			'BootstrapUI.Html' => \BootstrapUI\View\Helper\HtmlHelper::class,
			'BootstrapUI.Paginator' => \BootstrapUI\View\Helper\PaginatorHelper::class,
			'Breadcrumbs' => \Cake\View\Helper\BreadcrumbsHelper::class,
			'CakeDto.Template' => \CakeDto\View\Helper\TemplateHelper::class,
			'Calendar.Calendar' => \Calendar\View\Helper\CalendarHelper::class,
			'Captcha.Captcha' => \Captcha\View\Helper\CaptchaHelper::class,
			'Data.Continent' => \Data\View\Helper\ContinentHelper::class,
			'Data.Data' => \Data\View\Helper\DataHelper::class,
			'Data.MimeType' => \Data\View\Helper\MimeTypeHelper::class,
			'DatabaseLog.Log' => \DatabaseLog\View\Helper\LogHelper::class,
			'Flash' => \Cake\View\Helper\FlashHelper::class,
			'Form' => \App\View\Helper\FormHelper::class,
			'Geo.GoogleMap' => \Geo\View\Helper\GoogleMapHelper::class,
			'Html' => \Cake\View\Helper\HtmlHelper::class,
			'Icings/Menu.Menu' => \Icings\Menu\View\Helper\MenuHelper::class,
			'IdeHelper.DocBlock' => \IdeHelper\View\Helper\DocBlockHelper::class,
			'Markup.Bbcode' => \Markup\View\Helper\BbcodeHelper::class,
			'Markup.Highlighter' => \Markup\View\Helper\HighlighterHelper::class,
			'Markup.Markdown' => \Markup\View\Helper\MarkdownHelper::class,
			'Menu.Menu' => \Menu\View\Helper\MenuHelper::class,
			'Meta.Meta' => \Meta\View\Helper\MetaHelper::class,
			'Migrations.Migration' => \Migrations\View\Helper\MigrationHelper::class,
			'Navigation' => \App\View\Helper\NavigationHelper::class,
			'Number' => \Cake\View\Helper\NumberHelper::class,
			'Paginator' => \Cake\View\Helper\PaginatorHelper::class,
			'Queue.Queue' => \Queue\View\Helper\QueueHelper::class,
			'Queue.QueueProgress' => \Queue\View\Helper\QueueProgressHelper::class,
			'Ratings.Rating' => \Ratings\View\Helper\RatingHelper::class,
			'Sandbox' => \App\View\Helper\SandboxHelper::class,
			'Sandbox.MediaEmbedBbcode' => \Sandbox\View\Helper\MediaEmbedBbcodeHelper::class,
			'Search.Search' => \Search\View\Helper\SearchHelper::class,
			'Setup.SetupBake' => \Setup\View\Helper\SetupBakeHelper::class,
			'StateMachine.StateMachine' => \StateMachine\View\Helper\StateMachineHelper::class,
			'Tags.Tag' => \Tags\View\Helper\TagHelper::class,
			'Tags.TagCloud' => \Tags\View\Helper\TagCloudHelper::class,
			'Text' => \Cake\View\Helper\TextHelper::class,
			'Time' => \Cake\View\Helper\TimeHelper::class,
			'TinyAuth.AuthUser' => \TinyAuth\View\Helper\AuthUserHelper::class,
			'TinyAuth.Authentication' => \TinyAuth\View\Helper\AuthenticationHelper::class,
			'Tools.Common' => \Tools\View\Helper\CommonHelper::class,
			'Tools.Form' => \Tools\View\Helper\FormHelper::class,
			'Tools.Format' => \Tools\View\Helper\FormatHelper::class,
			'Tools.Gravatar' => \Tools\View\Helper\GravatarHelper::class,
			'Tools.Html' => \Tools\View\Helper\HtmlHelper::class,
			'Tools.Meter' => \Tools\View\Helper\MeterHelper::class,
			'Tools.Number' => \Tools\View\Helper\NumberHelper::class,
			'Tools.Obfuscate' => \Tools\View\Helper\ObfuscateHelper::class,
			'Tools.Progress' => \Tools\View\Helper\ProgressHelper::class,
			'Tools.QrCode' => \Tools\View\Helper\QrCodeHelper::class,
			'Tools.Text' => \Tools\View\Helper\TextHelper::class,
			'Tools.Time' => \Tools\View\Helper\TimeHelper::class,
			'Tools.Timeline' => \Tools\View\Helper\TimelineHelper::class,
			'Tools.Tree' => \Tools\View\Helper\TreeHelper::class,
			'Tools.Typography' => \Tools\View\Helper\TypographyHelper::class,
			'Tools.Url' => \Tools\View\Helper\UrlHelper::class,
			'Url' => \Cake\View\Helper\UrlHelper::class,
		])
	);

	expectedArguments(
		\Cake\View\ViewBuilder::addHelper(),
		0,
		'App',
		'AssetCompress.AssetCompress',
		'Bake.Bake',
		'Bake.DocBlock',
		'BootstrapUI.Breadcrumbs',
		'BootstrapUI.Flash',
		'BootstrapUI.Form',
		'BootstrapUI.Html',
		'BootstrapUI.Paginator',
		'Breadcrumbs',
		'CakeDto.Template',
		'Calendar.Calendar',
		'Captcha.Captcha',
		'Data.Continent',
		'Data.Data',
		'Data.MimeType',
		'DatabaseLog.Log',
		'Flash',
		'Form',
		'Geo.GoogleMap',
		'Html',
		'Icings/Menu.Menu',
		'IdeHelper.DocBlock',
		'Markup.Bbcode',
		'Markup.Highlighter',
		'Markup.Markdown',
		'Menu.Menu',
		'Meta.Meta',
		'Migrations.Migration',
		'Navigation',
		'Number',
		'Paginator',
		'Queue.Queue',
		'Queue.QueueProgress',
		'Ratings.Rating',
		'Sandbox',
		'Sandbox.MediaEmbedBbcode',
		'Search.Search',
		'Setup.SetupBake',
		'StateMachine.StateMachine',
		'Tags.Tag',
		'Tags.TagCloud',
		'Text',
		'Time',
		'TinyAuth.AuthUser',
		'TinyAuth.Authentication',
		'Tools.Common',
		'Tools.Form',
		'Tools.Format',
		'Tools.Gravatar',
		'Tools.Html',
		'Tools.Meter',
		'Tools.Number',
		'Tools.Obfuscate',
		'Tools.Progress',
		'Tools.QrCode',
		'Tools.Text',
		'Tools.Time',
		'Tools.Timeline',
		'Tools.Tree',
		'Tools.Typography',
		'Tools.Url',
		'Url'
	);

	expectedArguments(
		\Cake\View\ViewBuilder::setLayout(),
		0,
		'BootstrapUI.default',
		'ajax',
		'default',
		'error'
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::get(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::getError(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::getInvalidField(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::getOriginal(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::has(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::hasValue(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::isDirty(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::isEmpty(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::setDirty(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Captcha\Model\Entity\Captcha::setError(),
		0,
		argumentsSet('entityFields:Captcha\Model\Entity\Captcha')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Continent::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Continent')
	);

	expectedArguments(
		\Data\Model\Entity\Country::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Country::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Country')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Currency::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Currency')
	);

	expectedArguments(
		\Data\Model\Entity\Language::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\Language::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Language')
	);

	expectedArguments(
		\Data\Model\Entity\State::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\State::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\State')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::get(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::getError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::getInvalidField(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::getOriginal(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::has(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::hasValue(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::isDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::isEmpty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::setDirty(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\Data\Model\Entity\Timezone::setError(),
		0,
		argumentsSet('entityFields:Data\Model\Entity\Timezone')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::get(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::getError(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::getInvalidField(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::getOriginal(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::has(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::hasValue(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::isDirty(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::isEmpty(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::setDirty(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\DatabaseLog\Model\Entity\DatabaseLog::setError(),
		0,
		argumentsSet('entityFields:DatabaseLog\Model\Entity\DatabaseLog')
	);

	expectedArguments(
		\Migrations\AbstractMigration::table(),
		0,
		argumentsSet('tableNames')
	);

	expectedArguments(
		\Migrations\AbstractSeed::table(),
		0,
		argumentsSet('tableNames')
	);

	expectedArguments(
		\Migrations\Table::addColumn(),
		0,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Migrations\Table::addColumn(),
		1,
		argumentsSet('columnTypes')
	);

	expectedArguments(
		\Migrations\Table::changeColumn(),
		0,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Migrations\Table::changeColumn(),
		1,
		argumentsSet('columnTypes')
	);

	expectedArguments(
		\Migrations\Table::hasColumn(),
		0,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Migrations\Table::removeColumn(),
		0,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Migrations\Table::renameColumn(),
		0,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Migrations\Table::renameColumn(),
		1,
		argumentsSet('columnNames')
	);

	expectedArguments(
		\Phinx\Seed\AbstractSeed::table(),
		0,
		argumentsSet('tableNames')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::get(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::getError(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::getInvalidField(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::getOriginal(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::has(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::hasValue(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::isDirty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::isEmpty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::setDirty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueueProcess::setError(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueueProcess')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::get(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::getError(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::getInvalidField(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::getOriginal(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::has(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::hasValue(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::isDirty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::isEmpty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::setDirty(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Entity\QueuedJob::setError(),
		0,
		argumentsSet('entityFields:Queue\Model\Entity\QueuedJob')
	);

	expectedArguments(
		\Queue\Model\Table\QueuedJobsTable::createJob(),
		0,
		'MyTaskName',
		'Queue.CostsExample',
		'Queue.Email',
		'Queue.Example',
		'Queue.ExceptionExample',
		'Queue.Execute',
		'Queue.MonitorExample',
		'Queue.ProgressExample',
		'Queue.RetryExample',
		'Queue.SuperExample',
		'Queue.UniqueExample',
		'StateMachineSandbox.SimulatePaymentResult'
	);

	expectedArguments(
		\Queue\Model\Table\QueuedJobsTable::isQueued(),
		1,
		'MyTaskName',
		'Queue.CostsExample',
		'Queue.Email',
		'Queue.Example',
		'Queue.ExceptionExample',
		'Queue.Execute',
		'Queue.MonitorExample',
		'Queue.ProgressExample',
		'Queue.RetryExample',
		'Queue.SuperExample',
		'Queue.UniqueExample',
		'StateMachineSandbox.SimulatePaymentResult'
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::get(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::getError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::getInvalidField(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::getOriginal(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::has(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::hasValue(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::isDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::isEmpty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::setDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\BitmaskedRecord::setError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\BitmaskedRecord')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::get(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::getError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::getInvalidField(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::getOriginal(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::has(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::hasValue(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::isDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::isEmpty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::setDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\Event::setError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\Event')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::get(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::getError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::getInvalidField(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::getOriginal(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::has(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::hasValue(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::isDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::isEmpty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::setDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\ExposedUser::setError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\ExposedUser')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::get(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::getError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::getInvalidField(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::getOriginal(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::has(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::hasValue(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::isDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::isEmpty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::setDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxCategory::setError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxCategory')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::get(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::getError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::getInvalidField(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::getOriginal(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::has(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::hasValue(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::isDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::isEmpty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::setDirty(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\Sandbox\Model\Entity\SandboxPost::setError(),
		0,
		argumentsSet('entityFields:Sandbox\Model\Entity\SandboxPost')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::get(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::getError(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::has(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::hasValue(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::isDirty(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::setDirty(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachineSandbox\Model\Entity\Registration::setError(),
		0,
		argumentsSet('entityFields:StateMachineSandbox\Model\Entity\Registration')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItem::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItem')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemState::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemState')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineItemStateLog::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineItemStateLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineLock::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineLock')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineProcess::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineProcess')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTimeout::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTimeout')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::get(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::getError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::getInvalidField(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::getOriginal(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::has(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::hasValue(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::isDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::isEmpty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::setDirty(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\StateMachine\Model\Entity\StateMachineTransitionLog::setError(),
		0,
		argumentsSet('entityFields:StateMachine\Model\Entity\StateMachineTransitionLog')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::get(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::getError(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::getInvalidField(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::getOriginal(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::has(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::hasValue(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::isDirty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::isEmpty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::setDirty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tag::setError(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tag')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::get(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::getError(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::getInvalidField(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::getOriginal(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::has(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::hasValue(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::isDirty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::isEmpty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::setDirty(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tags\Model\Entity\Tagged::setError(),
		0,
		argumentsSet('entityFields:Tags\Model\Entity\Tagged')
	);

	expectedArguments(
		\Tools\View\Helper\FormatHelper::icon(),
		0,
		argumentsSet('fontawesomeIcons')
	);

	expectedArguments(
		\__(),
		0,
		'%s could not be found.',
		'(HtmlHelper::formTag) Deprecated: Use FormHelper::create instead',
		'(HtmlHelper::linkEmail) Deprecated: Use HtmlHelper::link instead',
		'(JavascriptHelper::linkOut) Deprecated: Use JavascriptHelper::link instead',
		'(View::setLayout) Deprecated: Use $this->layout = "..." instead',
		': Confirm you have created the %1$s::%2$s in file : %3$s.',
		'A simple string.',
		'ACO permissions key %s does not exist in DB_ACL::check()',
		'Actions',
		'Add',
		'Add ',
		'Add %s',
		'Are you sure you want to delete id %s?',
		'Blogä@$€ posts',
		'Book Store',
		'Cake %s connect to the database.',
		'Cake Software Foundation',
		'CakeForge',
		'CakePHP',
		'CakePHP API',
		'CakePHP Google Group',
		'CakePHP Manual',
		'CakePHP Rapid Development',
		'CakePHP Trac',
		'CakePHP Wiki',
		'CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.',
		'CakePHP release information is on CakeForge',
		'CakeSchwag',
		'Change Language',
		'Comment',
		'Community mailing list',
		'Configure::load() - %s.php not found',
		'Configure::load() - no variable $config found in %s.php',
		'Confirm you have created the file : %s.',
		'Confirm you have created the file: %s',
		'ConnectionManager::getDataSource - Non-existent data source %s',
		'Contact Owner',
		'Contact Us',
		'Controller dump:',
		'Controller::__construct() : Can not get or parse my own class name, exiting.',
		'Create the class below in file: %s',
		'DB_ACL::allow() - Invalid ACO action',
		'DB_ACL::allow() - Invalid node',
		'Delete',
		'Delete  ',
		'Delete %s',
		'Deprecated: Use Controller::set("title", "...") instead',
		'Deprecated: Use DboSource::fetchRow($sql) instead',
		'Deprecated: Use DboSource::fetchRow() instead',
		'Deprecated: Use FormHelper::input() instead',
		'Deprecated: Use FormHelper::input() or FormHelper::checkbox() instead',
		'Deprecated: Use FormHelper::input() or FormHelper::select() instead',
		'Deprecated: Use FormHelper::input() or FormHelper::text() instead',
		'Deprecated: Use FormHelper::label() instead',
		'Deprecated: Use FormHelper::submit() instead',
		'Deprecated: Use Set::countDim instead',
		'Docblock Your Best Friend',
		'Don\'t use me yet',
		'Driven km',
		'Edit',
		'Edit %s',
		'Editing this Page',
		'Email',
		'Error in layout %s, got: <blockquote>%s</blockquote>',
		'Error in view %s, got: <blockquote>%s</blockquote>',
		'Error! Could not write to',
		'Everything CakePHP',
		'Fatal',
		'File exists, overwrite?',
		'For the Development of CakePHP (Tickets, SVN browser, Roadmap, Changelogs)',
		'Get your own CakePHP gear - Doughnate to Cake',
		'Hello, my name is {0}, I\'m {1} years old.',
		'If you want to customize this error message, create %s',
		'If you want to customize this error message, create %s.',
		'Implement in DBO',
		'Language',
		'Language switched to {0}.',
		'List  ',
		'List %s',
		'Live chat about CakePHP',
		'Magic method handler __call__ not defined in %s',
		'Message',
		'Method %1$s::%2$s does not exist',
		'Milage',
		'Missing Component Class',
		'Missing Component File',
		'Missing Database Connection: %s requires a database connection',
		'Missing Database Connection: Scaffold Does not work without a database connection',
		'Missing Database Table',
		'Missing Helper Class',
		'Missing Helper File',
		'Missing Layout',
		'Missing Method in %s',
		'Missing Model',
		'Missing controller',
		'Missing view',
		'Model %s does not exist',
		'More about Cake',
		'New ',
		'New %s',
		'No Database table for model %1$s (expected %2$s), create it first.',
		'No class found for the <em>%s</em> model.',
		'No id set for %s::delete()',
		'No id set for %s::edit()',
		'No id set for %s::view()',
		'Notice',
		'Null id provided in DB_ACL::get',
		'Null parent in %s::create()',
		'Open Development for CakePHP',
		'Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.',
		'Own Subject',
		'Please correct errors below.',
		'Please implement DBO::disconnect() first.',
		'Please implement DBO_Pear::tablesList() for your database driver.',
		'Plugins must have a class named %s',
		'Private Method in %s',
		'Promoting development related to CakePHP',
		'Quitting.',
		'Read the release notes and get the latest version',
		'Receipt Date',
		'Recommended Software Books',
		'Related %s',
		'Requires a Database Connection',
		'Save',
		'Scaffold :: ',
		'Scaffold Error',
		'Scaffold Requires a Database Connection',
		'SecurityComponent::loginCredentials() - Server does not support digest authentication',
		'See the views section of the manual for more info.',
		'Skip',
		'Subject',
		'The %1$s has been %2$s',
		'The %1$s with id: %2$d has been deleted.',
		'The Bakery',
		'The Community for CakePHP',
		'The Rapid Development Framework',
		'The requested address %s was not found on this server.',
		'There was an error deleting the %1$s with id: %2$d',
		'To change its layout, create: /app/views/layouts/default.thtml.',
		'To change the content of this page, create: /app/views/pages/home.thtml.',
		'Total Cost',
		'Total Fuel',
		'Unable to find /app/config/database.php.  Please create it before continuing.

',
		'Unable to load DataSource file %s.php',
		'Vielen Dank',
		'View',
		'View ',
		'View %s',
		'Wrong file name.',
		'Wrote',
		'You are seeing this error because controller <em>%s</em> could not be found.',
		'You are seeing this error because the action <em>%1$s</em> is not defined in controller <em>%2$s</em>',
		'You are seeing this error because the component class <em>%1$s</em> you have set in <em>%2$s</em> can\'t be found or doesn\'t exist.',
		'You are seeing this error because the component file can not be found or does not exist.',
		'You are seeing this error because the layout file %s can not be found or does not exist.',
		'You are seeing this error because the private class method <em>%s</em> should not be accessed directly.',
		'You are seeing this error because the view for <em>%1$s::%2$s()</em>, could not be found.',
		'You are seeing this error because the view helper class <em>%s</em> can not be found or does not exist.',
		'You are seeing this error because the view helper file %s can not be found or does not exist.',
		'You can also add some CSS styles for your pages at: app/webroot/css/.',
		'You have traveled {0,number} kilometers in {1,number,integer} weeks.',
		'You must define a regular expression for Validation::custom()',
		'You must define the $operator parameter for Validation::comparison()',
		'Your Rapid Development Cookbook',
		'Your balance on the {0,date} is {1,number,currency}.',
		'Your database configuration file is %s.',
		'Your must implement the following method in your controller',
		'[acl_base] The AclBase class constructor has been called, or the class was instantiated. This class must remain abstract. Please refer to the Cake docs for ACL configuration.',
		'active',
		'chmodr() File exists',
		'contactChoseSubject',
		'contactHeader',
		'contactLegend',
		'contactMessage',
		'contactOwnSubject',
		'contactSubject',
		'contactSuccessfullySent',
		'contactSuccessfullySent {0}',
		'formContainsErrors',
		'is able to',
		'is not able to',
		'lipsum',
		'messageAnswered',
		'messageNew',
		'messageRead',
		'mkdirr() File exists',
		'noOptionAvailable',
		'not present',
		'pleaseSelect',
		'present',
		'saved',
		'updated',
		'valErrInvalidEmail',
		'valErrMandatoryField'
	);

	expectedArguments(
		\__d(),
		0,
		'ajax',
		'asset_compress',
		'auth_sandbox',
		'bake',
		'bootstrap_u_i',
		'cache',
		'cake',
		'cake/localized',
		'cake/twig_view',
		'cake_dto',
		'calendar',
		'captcha',
		'data',
		'database_log',
		'expose',
		'feedback',
		'geo',
		'icings/menu',
		'ide_helper',
		'markup',
		'menu',
		'meta',
		'migrations',
		'model_graph',
		'queue',
		'ratings',
		'ratings_sie',
		'sandbox',
		'search',
		'setup',
		'state_machine',
		'state_machine_sandbox',
		'tags',
		'tiny_auth',
		'tools'
	);

	expectedArguments(
		\__d(),
		1,
		' - no priority - ',
		' of ',
		'%.2f GB',
		'%.2f MB',
		'%.2f TB',
		'%d Byte',
		'%d KB',
		'%d day',
		'%d hour',
		'%d minute',
		'%d month',
		'%d second',
		'%d week',
		'%d year',
		'%s GB',
		'%s KB',
		'%s MB',
		'%s TB',
		'%s ago',
		'A copy of your submitted feedback:',
		'Aborted after too many trials with \'{0}\'',
		'Account deleted',
		'Account not active yet',
		'Account temporarily locked',
		'Accuracy not good enough ({0} instead of at least {1})',
		'Actions',
		'Active',
		'Add {0}',
		'Address \'{0}\' has been geocoded',
		'All',
		'An Internal Error Has Occurred',
		'An Internal Error Has Occurred.',
		'Anonymous',
		'Approved',
		'April',
		'Are you sure you want to delete',
		'Are you sure you want to delete # %s?',
		'August',
		'CSRF token from either the request body or request headers did not match or is missing.',
		'CSRF token mismatch.',
		'Cancel',
		'Cannot modify row: a constraint for the `{0}` association fails.',
		'Captcha',
		'Captcha incorrect',
		'Click anywhere on website',
		'Close',
		'Comma',
		'Could not create directory to save feedbacks in. Please provide write rights to webserver user on directory: ',
		'Could not create directory to save screenshots in. Please provide write rights to webserver user on directory: ',
		'Could not find that file',
		'Could not geocode \'\'{0}\'\'',
		'Could not retrieve url with \'{0}\'',
		'Could not save tmp file for attachment in mail',
		'Custom action',
		'Day',
		'Days',
		'December',
		'Delay necessary for \'{0}\'',
		'Delay necessary for address \'{0}\'',
		'Delete',
		'Delete %s',
		'Dictionary {0} not found',
		'Donate',
		'Done',
		'E-mail me a copy',
		'Edit',
		'Edit %s',
		'Edit {0}',
		'Email not active yet',
		'Engine {0} not available',
		'Engine {0} not found',
		'Enter your address',
		'Error',
		'Error in field %s',
		'Error saving feedback.',
		'Expectation not reached (we have {0} instead of at least one of {1})',
		'Failed geocode parsing of \'{0}\'',
		'Failed reverseGeocode parsing of \'{0}\'',
		'Feb',
		'February',
		'Feedback location not found: ',
		'Feedback or suggestion',
		'Feedback submitted',
		'Flagged',
		'Friday',
		'Generated Link',
		'Get directions',
		'Hide this tab completely.',
		'Highlight something',
		'Home',
		'Hour',
		'Hours',
		'House',
		'Houses',
		'I am okay with',
		'I am okay with {0}.',
		'Illegal call',
		'Illegal content',
		'In {0}',
		'Inconclusive result (total of {0})',
		'Inter',
		'Invalid %s',
		'Invalid Key',
		'Invalid Rating',
		'Invalid Record',
		'Invalid Unit',
		'Invalid Unit: {0}',
		'Invalid level \'{0}\'',
		'Invalid rate.',
		'Invalid rating mode %s.',
		'January',
		'July',
		'June',
		'Language',
		'List',
		'List %s',
		'List {0}',
		'Map',
		'Map cannot be displayed!',
		'March',
		'Master Password',
		'May',
		'Meta Type invalid',
		'Method not found in Feedbackstore model:',
		'Minute',
		'Minutes',
		'Missing CSRF token cookie',
		'Missing or incorrect CSRF cookie type.',
		'Missing or invalid CSRF cookie.',
		'Module {0} not installed',
		'Monday',
		'Month',
		'Months',
		'New %s',
		'New Line',
		'New {0}',
		'No',
		'No config file found. Please create one: ',
		'No save method found in config file',
		'No screenshot found',
		'No way',
		'None',
		'Not Found',
		'November',
		'October',
		'On %s %s',
		'Page %page% of %pages%, showing {0}urrent% records out of {1}ount% total',
		'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}',
		'Password',
		'Percent',
		'Please correct errors below.',
		'Please enable cookies',
		'Published',
		'Qlogin',
		'Qlogins',
		'Rate!',
		'Reason',
		'Related %s',
		'Reset {0}',
		'Revert',
		'Saturday',
		'Scaffold :: ',
		'Second',
		'Seconds',
		'Selection',
		'Semicolon',
		'Send your feedback or bugreport!',
		'September',
		'Space',
		'Subject',
		'Submit',
		'Subscribe to this feed',
		'Success',
		'Sunday',
		'Sure?',
		'Tabulator',
		'Thank you. Your feedback was saved.',
		'The %1$s has been %2$s',
		'The %1$s with id: %2$s has been deleted.',
		'The behavior "Containable", if used together with "CustomFinds" needs to be loaded before.',
		'The count does not match {0}{1}',
		'The day after tomorrow',
		'The day before yesterday',
		'The prefix {0} is not specified.',
		'The provided value is invalid',
		'The requested address %s was not found on this server.',
		'The requested address {0} was not found on this server.',
		'The requested file contains `..` and will not be read.',
		'The requested file was not found',
		'There was an error deleting the %1$s with id: %2$s',
		'This field cannot be left blank',
		'This field cannot be left empty',
		'This field is required',
		'This function is only available with filesystem save method',
		'This value does not exist',
		'This value is already in use',
		'Thursday',
		'Today',
		'Today, %s',
		'Tomorrow',
		'Tomorrow, %s',
		'Too many trials - abort',
		'Tue',
		'Tuesday',
		'Unknown Error',
		'View',
		'View %s',
		'View your feedback on:',
		'Wednesday',
		'When you submit, a screenshot (of only this website) will be taken to aid us in processing your feedback or bugreport.',
		'Yes',
		'Yesterday',
		'Yesterday, %s',
		'You are not authorized to access that location.',
		'You can not vote on your own records',
		'You have already rated this record',
		'You have already rated.',
		'You must set the id of the item you want to rate.',
		'You successfully logged in via qlogin',
		'Your e-mail',
		'Your feedback was saved successfully.',
		'Your name',
		'Your rate was successful.',
		'a {0} b {1} c {0} {1} {0} {1} {2} h {3}',
		'a {0} b {1} c {2} {3} {4} {5} {6} h {7}',
		'abday',
		'abmon',
		'about a day ago',
		'about a minute ago',
		'about a month ago',
		'about a second ago',
		'about a week ago',
		'about a year ago',
		'about an hour ago',
		'active',
		'added',
		'alreadyVoted',
		'am_pm',
		'and',
		'by',
		'by System',
		'calcMinus',
		'calcPlus',
		'calcTimes',
		'captchaContentMissing',
		'captchaExplained',
		'captchaIllegalContent',
		'captchaResultIncorrect',
		'captchaResultTooFast',
		'captchaResultTooLate',
		'captchaTip',
		'color',
		'consentThis',
		'd_fmt',
		'd_t_fmt',
		'day',
		'days',
		'deleted',
		'dissentThis',
		'e {0} f',
		'e {0} f {1} g',
		'e {0} f {1} g {2}',
		'eight',
		'empty',
		'first',
		'five',
		'for use in an external mail client',
		'four',
		'high',
		'in %s',
		'in about a day',
		'in about a minute',
		'in about a month',
		'in about a second',
		'in about a week',
		'in about a year',
		'in about an hour',
		'in {0}',
		'invalid date',
		'invalidLoginCredentials',
		'just now',
		'justNow',
		'last',
		'low',
		'medium',
		'mon',
		'next',
		'nine',
		'noNext',
		'noPrev',
		'notAvailable',
		'o\'clock',
		'of',
		'on %s',
		'one',
		'p:%d Bytes',
		'p:%d days',
		'p:%d hours',
		'p:%d minutes',
		'p:%d months',
		'p:%d seconds',
		'p:%d weeks',
		'p:%d years',
		'p:{0,number,integer} Bytes',
		'p:{0} days',
		'p:{0} hours',
		'p:{0} minutes',
		'p:{0} months',
		'p:{0} seconds',
		'p:{0} weeks',
		'p:{0} years',
		'prev',
		'previous',
		'prio',
		'publishedAlready',
		'publishedNotYet',
		'publishedToday',
		'saved',
		'seven',
		'six',
		't_fmt',
		't_fmt_ampm',
		'ten',
		'this',
		'three',
		'today',
		'two',
		'until',
		'updated',
		'valErrBetweenCharacters {0} {1}',
		'valErrCurrentPwdIncorrect',
		'valErrProvideCurrentPwd',
		'valErrPwdNotMatch',
		'valid ones',
		'validateLongitudeError',
		'zero',
		'zodiacAquarius',
		'zodiacAries',
		'zodiacCancer',
		'zodiacCapricorn',
		'zodiacGemini',
		'zodiacLeo',
		'zodiacLibra',
		'zodiacPisces',
		'zodiacSagittarius',
		'zodiacScorpio',
		'zodiacTaurus',
		'zodiacVirgo',
		'{0,number,#,###.##} GB',
		'{0,number,#,###.##} KB',
		'{0,number,#,###.##} MB',
		'{0,number,#,###.##} TB',
		'{0,number,integer} Byte',
		'{0} NOT removed',
		'{0} after',
		'{0} ago',
		'{0} before',
		'{0} day',
		'{0} from now',
		'{0} hour',
		'{0} minute',
		'{0} month',
		'{0} removed',
		'{0} second',
		'{0} week',
		'{0} year'
	);

	expectedArguments(
		\env(),
		0,
		'BASH_PROFILE',
		'BIND_DNSSEC_VALIDATE',
		'BIND_DNS_RESOLVER',
		'BIND_EXPIRY_TIME',
		'BIND_LOG_DNS_QUERIES',
		'BIND_MAX_CACHE_TIME',
		'BIND_REFRESH_TIME',
		'BIND_RETRY_TIME',
		'BIND_TTL_TIME',
		'CGI_MODE',
		'COMPOSER_BINARY',
		'COMPOSER_MEMORY_LIMIT',
		'CONTENT_LENGTH',
		'CONTENT_TYPE',
		'DEBUG_COMPOSE_ENTRYPOINT',
		'DEBUG_ENTRYPOINT',
		'DEVILBOX_PATH',
		'DEVILBOX_UI_ENABLE',
		'DEVILBOX_UI_PASSWORD',
		'DEVILBOX_UI_PROTECT',
		'DEVILBOX_UI_SSL_CN',
		'DEVILBOX_VENDOR_PHPMYADMIN_AUTOLOGIN',
		'DEVILBOX_VENDOR_PHPPGADMIN_AUTOLOGIN',
		'DISABLE_MODULES',
		'DNS_CHECK_TIMEOUT',
		'DOCKER_LOGS',
		'DOCUMENT_ROOT',
		'DOCUMENT_URI',
		'ENABLE_MAIL',
		'ENABLE_MODULES',
		'EXTRA_HOSTS',
		'FORWARD_PORTS_TO_LOCALHOST',
		'GATEWAY_INTERFACE',
		'GIT_ASKPASS',
		'HOME',
		'HOSTNAME',
		'HOST_PATH_BACKUPDIR',
		'HOST_PATH_HTTPD_DATADIR',
		'HOST_PATH_SSH_DIR',
		'HOST_PORT_BIND',
		'HOST_PORT_HTTPD',
		'HOST_PORT_HTTPD_SSL',
		'HOST_PORT_MEMCD',
		'HOST_PORT_MONGO',
		'HOST_PORT_MYSQL',
		'HOST_PORT_PGSQL',
		'HOST_PORT_REDIS',
		'HTTPD_DOCROOT_DIR',
		'HTTPD_FLAVOUR',
		'HTTPD_HTTP2_ENABLE',
		'HTTPD_NGINX_WORKER_CONNECTIONS',
		'HTTPD_NGINX_WORKER_PROCESSES',
		'HTTPD_SERVER',
		'HTTPD_TEMPLATE_DIR',
		'HTTPD_TIMEOUT_TO_PHP_FPM',
		'HTTPD_VHOST_SSL_TYPE',
		'HTTPS',
		'HTTP_ACCEPT',
		'HTTP_ACCEPT_ENCODING',
		'HTTP_ACCEPT_LANGUAGE',
		'HTTP_CONNECTION',
		'HTTP_COOKIE',
		'HTTP_HOST',
		'HTTP_USER_AGENT',
		'LANGUAGE',
		'LC_ALL',
		'LOCAL_LISTEN_ADDR',
		'LS_COLORS',
		'MEMCD_SERVER',
		'MONGO_SERVER',
		'MOUNT_OPTIONS',
		'MYSQL_BACKUP_HOST',
		'MYSQL_BACKUP_PASS',
		'MYSQL_BACKUP_USER',
		'MYSQL_ROOT_PASSWORD',
		'MYSQL_SERVER',
		'MY_GID',
		'MY_GROUP',
		'MY_UID',
		'MY_USER',
		'NEW_GID',
		'NEW_UID',
		'NVM_BIN',
		'NVM_CD_FLAGS',
		'NVM_DIR',
		'NVM_INC',
		'OLDPWD',
		'ORACLE_HOME',
		'PATH',
		'PATH_TRANSLATED',
		'PGSQL_HOST_AUTH_METHOD',
		'PGSQL_ROOT_PASSWORD',
		'PGSQL_ROOT_USER',
		'PGSQL_SERVER',
		'PHPIZE_DEPS',
		'PHP_BINARY',
		'PHP_CFLAGS',
		'PHP_CPPFLAGS',
		'PHP_EXTRA_CONFIGURE_ARGS',
		'PHP_INI_DIR',
		'PHP_LDFLAGS',
		'PHP_MAIL_CATCH_ALL',
		'PHP_MODULES_DISABLE',
		'PHP_MODULES_ENABLE',
		'PHP_SELF',
		'PHP_SERVER',
		'PHP_VERSION',
		'PWD',
		'QUERY_STRING',
		'REDIRECT_STATUS',
		'REDIS_ARGS',
		'REDIS_SERVER',
		'REMOTE_ADDR',
		'REMOTE_PORT',
		'REQUEST_METHOD',
		'REQUEST_SCHEME',
		'REQUEST_TIME',
		'REQUEST_TIME_FLOAT',
		'REQUEST_URI',
		'SCRIPT_FILENAME',
		'SCRIPT_NAME',
		'SERVER_NAME',
		'SERVER_PORT',
		'SERVER_PROTOCOL',
		'SHELL_VERBOSITY',
		'SHLVL',
		'TERM',
		'TIMEZONE',
		'TLD_SUFFIX',
		'VIPSHOME',
		'argc',
		'argv'
	);

	expectedArguments(
		\urlArray(),
		0,
		argumentsSet('routePaths')
	);

	registerArgumentsSet(
		'cacheEngines',
		'_cake_core_',
		'_cake_model_',
		'default'
	);

	registerArgumentsSet(
		'columnNames',
		'active',
		'address_format',
		'alias',
		'base',
		'beginning',
		'code',
		'command',
		'completed',
		'condition',
		'content',
		'context',
		'count',
		'counter',
		'country_code',
		'country_id',
		'covered',
		'created',
		'data',
		'decimal_places',
		'description',
		'email',
		'end',
		'error_message',
		'eu_member',
		'event',
		'expires',
		'failed',
		'failure_message',
		'fetched',
		'fk_id',
		'fk_model',
		'flag_optional',
		'flag_required',
		'foreign_key',
		'hostname',
		'id',
		'identifier',
		'image',
		'ip',
		'is_error',
		'iso2',
		'iso3',
		'job_group',
		'job_task',
		'label',
		'last_login',
		'lat',
		'lft',
		'linked_id',
		'lng',
		'locale',
		'locale_fallback',
		'location',
		'locked',
		'logins',
		'message',
		'model',
		'modified',
		'name',
		'namespace',
		'notbefore',
		'notes',
		'offset',
		'offset_dst',
		'ori_name',
		'params',
		'parent_id',
		'password',
		'phone_code',
		'pid',
		'priority',
		'process',
		'progress',
		'rating_count',
		'rating_sum',
		'refer',
		'reference',
		'result',
		'rght',
		'role_id',
		'server',
		'session_id',
		'slug',
		'sort',
		'source_state',
		'special',
		'state',
		'state_machine',
		'state_machine_item_id',
		'state_machine_item_state_id',
		'state_machine_process_id',
		'state_machine_transition_log_id',
		'status',
		'summary',
		'symbol_left',
		'symbol_right',
		'tag_id',
		'target_state',
		'terminate',
		'timeout',
		'timezone',
		'title',
		'type',
		'uri',
		'used',
		'user_agent',
		'user_id',
		'username',
		'uuid',
		'value',
		'workerkey',
		'zip_length',
		'zip_regexp'
	);

	registerArgumentsSet(
		'columnTypes',
		'biginteger',
		'binary',
		'binaryuuid',
		'bit',
		'blob',
		'boolean',
		'char',
		'date',
		'datetime',
		'decimal',
		'double',
		'enum',
		'float',
		'geometry',
		'integer',
		'json',
		'linestring',
		'longblob',
		'mediumblob',
		'mediuminteger',
		'point',
		'polygon',
		'set',
		'smallinteger',
		'string',
		'text',
		'time',
		'timestamp',
		'tinyblob',
		'tinyinteger',
		'uuid',
		'varbinary',
		'year'
	);

	registerArgumentsSet(
		'configureKeys',
		'App',
		'App.base',
		'App.cssBaseUrl',
		'App.defaultOutputTimezone',
		'App.dir',
		'App.encoding',
		'App.fullBaseUrl',
		'App.imageBaseUrl',
		'App.jsBaseUrl',
		'App.monitorHeaders',
		'App.namespace',
		'App.paths',
		'App.paths.locales',
		'App.paths.plugins',
		'App.paths.templates',
		'App.stats',
		'App.webroot',
		'App.wwwRoot',
		'Asset',
		'CacheConfig',
		'CacheConfig.check',
		'CacheConfig.engine',
		'CakeDto',
		'CakeDto.strictTypes',
		'Config',
		'Config.adminEmail',
		'DatabaseLog',
		'DatabaseLog.datasource',
		'DatabaseLog.limit',
		'DatabaseLog.maxLength',
		'DatabaseLog.monitor',
		'DatabaseLog.monitorCallback',
		'DebugKit',
		'DebugKit.panels',
		'DebugKit.panels.DebugKit.Mail',
		'DebugKit.panels.DebugKit.Packages',
		'DebugKit.panels.TinyAuth.Auth',
		'Error',
		'Error.errorLevel',
		'Error.exceptionRenderer',
		'Error.log',
		'Error.logger',
		'Error.skipLog',
		'Error.trace',
		'Feedback',
		'Feedback.configuration',
		'Feedback.configuration.Filesystem',
		'Feedback.configuration.Filesystem.location',
		'Feedback.enableacceptterms',
		'Feedback.enablecopybyemail',
		'Feedback.returnlink',
		'Feedback.stores',
		'Feedback.termstext',
		'FormConfig',
		'FormConfig.align',
		'FormConfig.novalidate',
		'FormConfig.templates',
		'FormConfig.templates.dateWidget',
		'Format',
		'Format.fontIcons',
		'Format.fontIcons.admin',
		'Format.fontIcons.details',
		'Format.fontIcons.login',
		'Format.fontIcons.logout',
		'Format.fontIcons.next',
		'Format.fontIcons.prev',
		'Format.fontIcons.see',
		'Format.fontIcons.translate',
		'Format.fontPath',
		'Format.iconNamespaces',
		'Geocoder',
		'Geocoder.apiKey',
		'GoogleMap',
		'GoogleMap.key',
		'Highlighter',
		'Highlighter.highlighter',
		'IdeHelper',
		'IdeHelper.annotators',
		'IdeHelper.annotators.IdeHelper\Annotator\EntityAnnotator',
		'IdeHelper.arrayAsGenerics',
		'IdeHelper.classAnnotatorTasks',
		'IdeHelper.generatorTasks',
		'IdeHelper.illuminatorTasks',
		'IdeHelper.includedPlugins',
		'IdeHelper.plugins',
		'IdeHelper.typeMap',
		'Queue',
		'Queue.cleanuptimeout',
		'Queue.defaultworkerretries',
		'Queue.defaultworkertimeout',
		'Queue.exitwhennothingtodo',
		'Queue.gcprob',
		'Queue.maxworkers',
		'Queue.sleeptime',
		'Queue.workermaxruntime',
		'Security',
		'Session',
		'Session.defaults',
		'Session.ini',
		'Session.ini.session.cookie_lifetime',
		'Session.timeout',
		'Shim',
		'Shim.deprecationType',
		'Shim.deprecations',
		'StateMachine',
		'StateMachine.graphAdapter',
		'StateMachine.handlers',
		'StateMachine.map',
		'StateMachine.pathToXml',
		'Whoops',
		'Whoops.editor',
		'Whoops.serverBasePath',
		'Whoops.userBasePath',
		'debug',
		'plugins',
		'plugins.Ajax',
		'plugins.AssetCompress',
		'plugins.AuthSandbox',
		'plugins.Bake',
		'plugins.BootstrapUI',
		'plugins.Burzum/CakeServiceLayer',
		'plugins.Cache',
		'plugins.Cake/Localized',
		'plugins.Cake/TwigView',
		'plugins.CakeDto',
		'plugins.Calendar',
		'plugins.Captcha',
		'plugins.CsvView',
		'plugins.Data',
		'plugins.DatabaseLog',
		'plugins.DebugKit',
		'plugins.Expose',
		'plugins.Feed',
		'plugins.Feedback',
		'plugins.Flash',
		'plugins.Geo',
		'plugins.Icings/Menu',
		'plugins.IdeHelper',
		'plugins.IdeHelperExtra',
		'plugins.Markup',
		'plugins.Menu',
		'plugins.Meta',
		'plugins.Migrations',
		'plugins.ModelGraph',
		'plugins.Queue',
		'plugins.Ratings',
		'plugins.Sandbox',
		'plugins.Search',
		'plugins.Setup',
		'plugins.Shim',
		'plugins.StateMachine',
		'plugins.StateMachineSandbox',
		'plugins.Tags',
		'plugins.TestHelper',
		'plugins.TinyAuth',
		'plugins.Tools',
		'plugins.Translate'
	);

	registerArgumentsSet(
		'entityFields:App\Model\Entity\Role',
		'alias',
		'created',
		'id',
		'modified',
		'name',
		'users'
	);

	registerArgumentsSet(
		'entityFields:App\Model\Entity\User',
		'active',
		'created',
		'email',
		'id',
		'last_login',
		'logins',
		'modified',
		'password',
		'role',
		'role_id',
		'username'
	);

	registerArgumentsSet(
		'entityFields:Cake\ORM\Entity',
		'created',
		'email',
		'id',
		'modified',
		'password',
		'role_id',
		'slug',
		'username'
	);

	registerArgumentsSet(
		'entityFields:Captcha\Model\Entity\Captcha',
		'created',
		'id',
		'image',
		'ip',
		'result',
		'session_id',
		'used'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\Continent',
		'child_continents',
		'code',
		'countries',
		'id',
		'lft',
		'modified',
		'name',
		'ori_name',
		'parent_continent',
		'parent_id',
		'rght',
		'status'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\Country',
		'address_format',
		'continent',
		'eu_member',
		'id',
		'iso2',
		'iso3',
		'lat',
		'lng',
		'modified',
		'name',
		'ori_name',
		'phone_code',
		'sort',
		'special',
		'states',
		'status',
		'timezone',
		'timezone_offset_string',
		'timezones',
		'zip_length',
		'zip_regexp'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\Currency',
		'active',
		'base',
		'code',
		'decimal_places',
		'id',
		'modified',
		'name',
		'symbol_left',
		'symbol_right',
		'value'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\Language',
		'code',
		'id',
		'iso2',
		'iso3',
		'locale',
		'locale_fallback',
		'modified',
		'name',
		'ori_name',
		'sort',
		'status'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\State',
		'code',
		'counties',
		'country',
		'country_id',
		'id',
		'lat',
		'lng',
		'modified',
		'name'
	);

	registerArgumentsSet(
		'entityFields:Data\Model\Entity\Timezone',
		'active',
		'canonical_timezone',
		'country',
		'country_code',
		'covered',
		'created',
		'id',
		'lat',
		'linked_id',
		'lng',
		'modified',
		'name',
		'notes',
		'offset',
		'offset_dst',
		'offset_dst_string',
		'offset_string',
		'type'
	);

	registerArgumentsSet(
		'entityFields:DatabaseLog\Model\Entity\DatabaseLog',
		'context',
		'count',
		'created',
		'hostname',
		'id',
		'ip',
		'message',
		'refer',
		'summary',
		'type',
		'uri',
		'user_agent'
	);

	registerArgumentsSet(
		'entityFields:Queue\Model\Entity\QueueProcess',
		'active_job',
		'created',
		'id',
		'modified',
		'pid',
		'server',
		'terminate',
		'workerkey'
	);

	registerArgumentsSet(
		'entityFields:Queue\Model\Entity\QueuedJob',
		'completed',
		'created',
		'data',
		'failed',
		'failure_message',
		'fetched',
		'id',
		'job_group',
		'job_task',
		'notbefore',
		'priority',
		'progress',
		'reference',
		'status',
		'worker_process',
		'workerkey'
	);

	registerArgumentsSet(
		'entityFields:Sandbox\Model\Entity\BitmaskedRecord',
		'created',
		'flag_optional',
		'flag_required',
		'id',
		'modified',
		'name'
	);

	registerArgumentsSet(
		'entityFields:Sandbox\Model\Entity\Event',
		'beginning',
		'coordinates',
		'description',
		'end',
		'id',
		'lat',
		'lng',
		'location',
		'title'
	);

	registerArgumentsSet(
		'entityFields:Sandbox\Model\Entity\ExposedUser',
		'created',
		'id',
		'modified',
		'name',
		'uuid'
	);

	registerArgumentsSet(
		'entityFields:Sandbox\Model\Entity\SandboxCategory',
		'created',
		'description',
		'id',
		'lft',
		'modified',
		'name',
		'parent_id',
		'rght',
		'status'
	);

	registerArgumentsSet(
		'entityFields:Sandbox\Model\Entity\SandboxPost',
		'content',
		'created',
		'id',
		'modified',
		'rating_count',
		'rating_sum',
		'tagged',
		'tags',
		'title'
	);

	registerArgumentsSet(
		'entityFields:StateMachineSandbox\Model\Entity\Registration',
		'created',
		'id',
		'modified',
		'registration_state',
		'session_id',
		'status',
		'user',
		'user_id'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineItem',
		'id',
		'identifier',
		'process',
		'state',
		'state_machine',
		'state_machine_transition_log',
		'state_machine_transition_log_id'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineItemState',
		'description',
		'id',
		'name',
		'state_machine_item_state_logs',
		'state_machine_process',
		'state_machine_process_id',
		'state_machine_timeouts'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineItemStateLog',
		'created',
		'id',
		'identifier',
		'state_machine_item_state',
		'state_machine_item_state_id'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineLock',
		'created',
		'expires',
		'id',
		'identifier'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineProcess',
		'created',
		'id',
		'modified',
		'name',
		'state_machine',
		'state_machine_item_states',
		'state_machine_timeouts',
		'state_machine_transition_logs'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineTimeout',
		'event',
		'id',
		'identifier',
		'state_machine_item_state',
		'state_machine_item_state_id',
		'state_machine_process',
		'state_machine_process_id',
		'timeout'
	);

	registerArgumentsSet(
		'entityFields:StateMachine\Model\Entity\StateMachineTransitionLog',
		'command',
		'condition',
		'created',
		'error_message',
		'event',
		'id',
		'identifier',
		'is_error',
		'locked',
		'params',
		'source_state',
		'state_machine_item_id',
		'state_machine_process',
		'state_machine_process_id',
		'target_state'
	);

	registerArgumentsSet(
		'entityFields:Tags\Model\Entity\Tag',
		'counter',
		'created',
		'id',
		'label',
		'modified',
		'namespace',
		'slug'
	);

	registerArgumentsSet(
		'entityFields:Tags\Model\Entity\Tagged',
		'created',
		'fk_id',
		'fk_model',
		'id',
		'modified',
		'tag',
		'tag_id'
	);

	registerArgumentsSet(
		'fontawesomeIcons',
		'500px',
		'add',
		'address-book',
		'address-book-o',
		'address-card',
		'address-card-o',
		'adjust',
		'admin',
		'adn',
		'align-center',
		'align-justify',
		'align-left',
		'align-right',
		'amazon',
		'ambulance',
		'american-sign-language-interpreting',
		'anchor',
		'android',
		'angellist',
		'angle-double-down',
		'angle-double-left',
		'angle-double-right',
		'angle-double-up',
		'angle-down',
		'angle-left',
		'angle-right',
		'angle-up',
		'apple',
		'archive',
		'area-chart',
		'arrow-circle-down',
		'arrow-circle-left',
		'arrow-circle-o-down',
		'arrow-circle-o-left',
		'arrow-circle-o-right',
		'arrow-circle-o-up',
		'arrow-circle-right',
		'arrow-circle-up',
		'arrow-down',
		'arrow-left',
		'arrow-right',
		'arrow-up',
		'arrows',
		'arrows-alt',
		'arrows-h',
		'arrows-v',
		'asl-interpreting',
		'assistive-listening-systems',
		'asterisk',
		'at',
		'audio-description',
		'automobile',
		'backward',
		'balance-scale',
		'ban',
		'bandcamp',
		'bank',
		'bar-chart',
		'bar-chart-o',
		'barcode',
		'bars',
		'bath',
		'bathtub',
		'battery',
		'battery-0',
		'battery-1',
		'battery-2',
		'battery-3',
		'battery-4',
		'battery-empty',
		'battery-full',
		'battery-half',
		'battery-quarter',
		'battery-three-quarters',
		'bed',
		'beer',
		'behance',
		'behance-square',
		'bell',
		'bell-o',
		'bell-slash',
		'bell-slash-o',
		'bicycle',
		'binoculars',
		'birthday-cake',
		'bitbucket',
		'bitbucket-square',
		'bitcoin',
		'black-tie',
		'blind',
		'bluetooth',
		'bluetooth-b',
		'bold',
		'bolt',
		'bomb',
		'book',
		'bookmark',
		'bookmark-o',
		'braille',
		'briefcase',
		'btc',
		'bug',
		'building',
		'building-o',
		'bullhorn',
		'bullseye',
		'bus',
		'buysellads',
		'cab',
		'calculator',
		'calendar',
		'calendar-check-o',
		'calendar-minus-o',
		'calendar-o',
		'calendar-plus-o',
		'calendar-times-o',
		'camera',
		'camera-retro',
		'car',
		'caret-down',
		'caret-left',
		'caret-right',
		'caret-square-o-down',
		'caret-square-o-left',
		'caret-square-o-right',
		'caret-square-o-up',
		'caret-up',
		'cart-arrow-down',
		'cart-plus',
		'cc',
		'cc-amex',
		'cc-diners-club',
		'cc-discover',
		'cc-jcb',
		'cc-mastercard',
		'cc-paypal',
		'cc-stripe',
		'cc-visa',
		'certificate',
		'chain',
		'chain-broken',
		'check',
		'check-circle',
		'check-circle-o',
		'check-square',
		'check-square-o',
		'chevron-circle-down',
		'chevron-circle-left',
		'chevron-circle-right',
		'chevron-circle-up',
		'chevron-down',
		'chevron-left',
		'chevron-right',
		'chevron-up',
		'child',
		'chrome',
		'circle',
		'circle-o',
		'circle-o-notch',
		'circle-thin',
		'clipboard',
		'clock-o',
		'clone',
		'close',
		'cloud',
		'cloud-download',
		'cloud-upload',
		'cny',
		'code',
		'code-fork',
		'codepen',
		'codiepie',
		'coffee',
		'cog',
		'cogs',
		'columns',
		'comment',
		'comment-o',
		'commenting',
		'commenting-o',
		'comments',
		'comments-o',
		'compass',
		'compress',
		'config',
		'connectdevelop',
		'contao',
		'contra',
		'copy',
		'copyright',
		'creative-commons',
		'credit-card',
		'credit-card-alt',
		'crop',
		'crosshairs',
		'css3',
		'cube',
		'cubes',
		'cut',
		'cutlery',
		'dashboard',
		'dashcube',
		'database',
		'deaf',
		'deafness',
		'dedent',
		'delete',
		'delicious',
		'desktop',
		'details',
		'deviantart',
		'diamond',
		'digg',
		'dollar',
		'dot-circle-o',
		'download',
		'dribbble',
		'drivers-license',
		'drivers-license-o',
		'dropbox',
		'drupal',
		'edge',
		'edit',
		'eercast',
		'eject',
		'ellipsis-h',
		'ellipsis-v',
		'empire',
		'envelope',
		'envelope-o',
		'envelope-open',
		'envelope-open-o',
		'envelope-square',
		'envira',
		'eraser',
		'etsy',
		'eur',
		'euro',
		'exchange',
		'exclamation',
		'exclamation-circle',
		'exclamation-triangle',
		'expand',
		'expeditedssl',
		'external-link',
		'external-link-square',
		'eye',
		'eye-slash',
		'eyedropper',
		'fa',
		'facebook',
		'facebook-f',
		'facebook-official',
		'facebook-square',
		'fast-backward',
		'fast-forward',
		'fax',
		'feed',
		'female',
		'fighter-jet',
		'file',
		'file-archive-o',
		'file-audio-o',
		'file-code-o',
		'file-excel-o',
		'file-image-o',
		'file-movie-o',
		'file-o',
		'file-pdf-o',
		'file-photo-o',
		'file-picture-o',
		'file-powerpoint-o',
		'file-sound-o',
		'file-text',
		'file-text-o',
		'file-video-o',
		'file-word-o',
		'file-zip-o',
		'files-o',
		'film',
		'filter',
		'fire',
		'fire-extinguisher',
		'firefox',
		'first-order',
		'flag',
		'flag-checkered',
		'flag-o',
		'flash',
		'flask',
		'flickr',
		'floppy-o',
		'folder',
		'folder-o',
		'folder-open',
		'folder-open-o',
		'font',
		'font-awesome',
		'fonticons',
		'fort-awesome',
		'forumbee',
		'forward',
		'foursquare',
		'free-code-camp',
		'frown-o',
		'futbol-o',
		'gamepad',
		'gavel',
		'gbp',
		'ge',
		'gear',
		'gears',
		'genderless',
		'get-pocket',
		'gg',
		'gg-circle',
		'gift',
		'git',
		'git-square',
		'github',
		'github-alt',
		'github-square',
		'gitlab',
		'gittip',
		'glass',
		'glide',
		'glide-g',
		'globe',
		'google',
		'google-plus',
		'google-plus-circle',
		'google-plus-official',
		'google-plus-square',
		'google-wallet',
		'graduation-cap',
		'gratipay',
		'grav',
		'group',
		'h-square',
		'hacker-news',
		'hand-grab-o',
		'hand-lizard-o',
		'hand-o-down',
		'hand-o-left',
		'hand-o-right',
		'hand-o-up',
		'hand-paper-o',
		'hand-peace-o',
		'hand-pointer-o',
		'hand-rock-o',
		'hand-scissors-o',
		'hand-spock-o',
		'hand-stop-o',
		'handshake-o',
		'hard-of-hearing',
		'hashtag',
		'hdd-o',
		'header',
		'headphones',
		'heart',
		'heart-o',
		'heartbeat',
		'history',
		'home',
		'hospital-o',
		'hotel',
		'hourglass',
		'hourglass-1',
		'hourglass-2',
		'hourglass-3',
		'hourglass-end',
		'hourglass-half',
		'hourglass-o',
		'hourglass-start',
		'houzz',
		'html5',
		'i-cursor',
		'id-badge',
		'id-card',
		'id-card-o',
		'ils',
		'image',
		'imdb',
		'inbox',
		'indent',
		'industry',
		'info',
		'info-circle',
		'inr',
		'instagram',
		'institution',
		'internet-explorer',
		'intersex',
		'ioxhost',
		'italic',
		'joomla',
		'jpy',
		'jsfiddle',
		'key',
		'keyboard-o',
		'krw',
		'language',
		'laptop',
		'lastfm',
		'lastfm-square',
		'leaf',
		'leanpub',
		'legal',
		'lemon-o',
		'level-down',
		'level-up',
		'life-bouy',
		'life-buoy',
		'life-ring',
		'life-saver',
		'lightbulb-o',
		'line-chart',
		'link',
		'linkedin',
		'linkedin-square',
		'linode',
		'linux',
		'list',
		'list-alt',
		'list-ol',
		'list-ul',
		'location-arrow',
		'lock',
		'login',
		'logout',
		'long-arrow-down',
		'long-arrow-left',
		'long-arrow-right',
		'long-arrow-up',
		'low-vision',
		'magic',
		'magnet',
		'mail-forward',
		'mail-reply',
		'mail-reply-all',
		'male',
		'map',
		'map-marker',
		'map-o',
		'map-pin',
		'map-signs',
		'mars',
		'mars-double',
		'mars-stroke',
		'mars-stroke-h',
		'mars-stroke-v',
		'maxcdn',
		'meanpath',
		'medium',
		'medkit',
		'meetup',
		'meh-o',
		'mercury',
		'microchip',
		'microphone',
		'microphone-slash',
		'minus',
		'minus-circle',
		'minus-square',
		'minus-square-o',
		'mixcloud',
		'mobile',
		'mobile-phone',
		'modx',
		'money',
		'moon-o',
		'mortar-board',
		'motorcycle',
		'mouse-pointer',
		'music',
		'navicon',
		'neuter',
		'newspaper-o',
		'next',
		'no',
		'object-group',
		'object-ungroup',
		'odnoklassniki',
		'odnoklassniki-square',
		'opencart',
		'openid',
		'opera',
		'optin-monster',
		'outdent',
		'pagelines',
		'paint-brush',
		'paper-plane',
		'paper-plane-o',
		'paperclip',
		'paragraph',
		'paste',
		'pause',
		'pause-circle',
		'pause-circle-o',
		'paw',
		'paypal',
		'pencil',
		'pencil-square',
		'pencil-square-o',
		'percent',
		'phone',
		'phone-square',
		'photo',
		'picture-o',
		'pie-chart',
		'pied-piper',
		'pied-piper-alt',
		'pied-piper-pp',
		'pinterest',
		'pinterest-p',
		'pinterest-square',
		'plane',
		'play',
		'play-circle',
		'play-circle-o',
		'plug',
		'plus',
		'plus-circle',
		'plus-square',
		'plus-square-o',
		'podcast',
		'power-off',
		'prev',
		'print',
		'pro',
		'product-hunt',
		'puzzle-piece',
		'qq',
		'qrcode',
		'question',
		'question-circle',
		'question-circle-o',
		'quora',
		'quote-left',
		'quote-right',
		'ra',
		'random',
		'ravelry',
		'rebel',
		'recycle',
		'reddit',
		'reddit-alien',
		'reddit-square',
		'refresh',
		'registered',
		'remove',
		'renren',
		'reorder',
		'repeat',
		'reply',
		'reply-all',
		'resistance',
		'retweet',
		'rmb',
		'road',
		'rocket',
		'rotate-left',
		'rotate-right',
		'rouble',
		'rss',
		'rss-square',
		'rub',
		'ruble',
		'rupee',
		's15',
		'safari',
		'save',
		'scissors',
		'scribd',
		'search',
		'search-minus',
		'search-plus',
		'see',
		'sellsy',
		'send',
		'send-o',
		'server',
		'share',
		'share-alt',
		'share-alt-square',
		'share-square',
		'share-square-o',
		'shekel',
		'sheqel',
		'shield',
		'ship',
		'shirtsinbulk',
		'shopping-bag',
		'shopping-basket',
		'shopping-cart',
		'shower',
		'sign-in',
		'sign-language',
		'sign-out',
		'signal',
		'signing',
		'simplybuilt',
		'sitemap',
		'skyatlas',
		'skype',
		'slack',
		'sliders',
		'slideshare',
		'smile-o',
		'snapchat',
		'snapchat-ghost',
		'snapchat-square',
		'snowflake-o',
		'soccer-ball-o',
		'sort',
		'sort-alpha-asc',
		'sort-alpha-desc',
		'sort-amount-asc',
		'sort-amount-desc',
		'sort-asc',
		'sort-desc',
		'sort-down',
		'sort-numeric-asc',
		'sort-numeric-desc',
		'sort-up',
		'soundcloud',
		'space-shuttle',
		'spinner',
		'spoon',
		'spotify',
		'square',
		'square-o',
		'stack-exchange',
		'stack-overflow',
		'star',
		'star-half',
		'star-half-empty',
		'star-half-full',
		'star-half-o',
		'star-o',
		'steam',
		'steam-square',
		'step-backward',
		'step-forward',
		'stethoscope',
		'sticky-note',
		'sticky-note-o',
		'stop',
		'stop-circle',
		'stop-circle-o',
		'street-view',
		'strikethrough',
		'stumbleupon',
		'stumbleupon-circle',
		'subscript',
		'subway',
		'suitcase',
		'sun-o',
		'superpowers',
		'superscript',
		'support',
		'table',
		'tablet',
		'tachometer',
		'tag',
		'tags',
		'tasks',
		'taxi',
		'telegram',
		'television',
		'tencent-weibo',
		'terminal',
		'text-height',
		'text-width',
		'th',
		'th-large',
		'th-list',
		'themeisle',
		'thermometer',
		'thermometer-0',
		'thermometer-1',
		'thermometer-2',
		'thermometer-3',
		'thermometer-4',
		'thermometer-empty',
		'thermometer-full',
		'thermometer-half',
		'thermometer-quarter',
		'thermometer-three-quarters',
		'thumb-tack',
		'thumbs-down',
		'thumbs-o-down',
		'thumbs-o-up',
		'thumbs-up',
		'ticket',
		'times',
		'times-circle',
		'times-circle-o',
		'times-rectangle',
		'times-rectangle-o',
		'tint',
		'toggle-down',
		'toggle-left',
		'toggle-off',
		'toggle-on',
		'toggle-right',
		'toggle-up',
		'trademark',
		'train',
		'transgender',
		'transgender-alt',
		'translate',
		'trash',
		'trash-o',
		'tree',
		'trello',
		'tripadvisor',
		'trophy',
		'truck',
		'try',
		'tty',
		'tumblr',
		'tumblr-square',
		'turkish-lira',
		'tv',
		'twitch',
		'twitter',
		'twitter-square',
		'umbrella',
		'underline',
		'undo',
		'universal-access',
		'university',
		'unlink',
		'unlock',
		'unlock-alt',
		'unsorted',
		'upload',
		'usb',
		'usd',
		'user',
		'user-circle',
		'user-circle-o',
		'user-md',
		'user-o',
		'user-plus',
		'user-secret',
		'user-times',
		'users',
		'vcard',
		'vcard-o',
		'venus',
		'venus-double',
		'venus-mars',
		'viacoin',
		'viadeo',
		'viadeo-square',
		'video-camera',
		'view',
		'vimeo',
		'vimeo-square',
		'vine',
		'vk',
		'volume-control-phone',
		'volume-down',
		'volume-off',
		'volume-up',
		'warning',
		'wechat',
		'weibo',
		'weixin',
		'whatsapp',
		'wheelchair',
		'wheelchair-alt',
		'wifi',
		'wikipedia-w',
		'window-close',
		'window-close-o',
		'window-maximize',
		'window-minimize',
		'window-restore',
		'windows',
		'won',
		'wordpress',
		'wpbeginner',
		'wpexplorer',
		'wpforms',
		'wrench',
		'xing',
		'xing-square',
		'y-combinator',
		'y-combinator-square',
		'yahoo',
		'yc',
		'yc-square',
		'yelp',
		'yen',
		'yes',
		'yoast',
		'youtube',
		'youtube-play',
		'youtube-square'
	);

	registerArgumentsSet(
		'routePaths',
		'Account::changePassword',
		'Account::delete',
		'Account::edit',
		'Account::index',
		'Account::login',
		'Account::logout',
		'Account::lostPassword',
		'Account::register',
		'Admin/Overview::index',
		'Admin/Users::add',
		'Admin/Users::delete',
		'Admin/Users::edit',
		'Admin/Users::index',
		'AuthSandbox.Admin/AuthSandbox::index',
		'AuthSandbox.Admin/AuthSandbox::myPublicOne',
		'AuthSandbox.AuthSandbox::forAll',
		'AuthSandbox.AuthSandbox::forMods',
		'AuthSandbox.AuthSandbox::index',
		'AuthSandbox.AuthSandbox::login',
		'AuthSandbox.AuthSandbox::logout',
		'AuthSandbox.AuthSandbox::register',
		'Captcha.Captcha::display',
		'Contact::index',
		'Data.Admin/Addresses::add',
		'Data.Admin/Addresses::delete',
		'Data.Admin/Addresses::edit',
		'Data.Admin/Addresses::index',
		'Data.Admin/Addresses::markAsUsed',
		'Data.Admin/Addresses::view',
		'Data.Admin/Cities::add',
		'Data.Admin/Cities::delete',
		'Data.Admin/Cities::edit',
		'Data.Admin/Cities::index',
		'Data.Admin/Cities::view',
		'Data.Admin/Continents::add',
		'Data.Admin/Continents::delete',
		'Data.Admin/Continents::edit',
		'Data.Admin/Continents::index',
		'Data.Admin/Continents::tree',
		'Data.Admin/Continents::view',
		'Data.Admin/Countries::add',
		'Data.Admin/Countries::delete',
		'Data.Admin/Countries::down',
		'Data.Admin/Countries::edit',
		'Data.Admin/Countries::icons',
		'Data.Admin/Countries::index',
		'Data.Admin/Countries::sync',
		'Data.Admin/Countries::up',
		'Data.Admin/Countries::validate',
		'Data.Admin/Countries::view',
		'Data.Admin/Currencies::_setAsPrimary',
		'Data.Admin/Currencies::add',
		'Data.Admin/Currencies::base',
		'Data.Admin/Currencies::delete',
		'Data.Admin/Currencies::edit',
		'Data.Admin/Currencies::index',
		'Data.Admin/Currencies::table',
		'Data.Admin/Currencies::toggle',
		'Data.Admin/Currencies::update',
		'Data.Admin/Currencies::view',
		'Data.Admin/Languages::add',
		'Data.Admin/Languages::compareIsoListToCore',
		'Data.Admin/Languages::compareToIsoList',
		'Data.Admin/Languages::delete',
		'Data.Admin/Languages::edit',
		'Data.Admin/Languages::importFromCore',
		'Data.Admin/Languages::index',
		'Data.Admin/Languages::setPrimaryLanguagesActive',
		'Data.Admin/Languages::view',
		'Data.Admin/MimeTypeImages::add',
		'Data.Admin/MimeTypeImages::allocate',
		'Data.Admin/MimeTypeImages::delete',
		'Data.Admin/MimeTypeImages::edit',
		'Data.Admin/MimeTypeImages::import',
		'Data.Admin/MimeTypeImages::index',
		'Data.Admin/MimeTypeImages::manualInput',
		'Data.Admin/MimeTypeImages::toggleActive',
		'Data.Admin/MimeTypeImages::view',
		'Data.Admin/MimeTypes::add',
		'Data.Admin/MimeTypes::allocate',
		'Data.Admin/MimeTypes::allocateByType',
		'Data.Admin/MimeTypes::delete',
		'Data.Admin/MimeTypes::detectByExtension',
		'Data.Admin/MimeTypes::edit',
		'Data.Admin/MimeTypes::fromCore',
		'Data.Admin/MimeTypes::fromFile',
		'Data.Admin/MimeTypes::index',
		'Data.Admin/MimeTypes::toggleActive',
		'Data.Admin/MimeTypes::view',
		'Data.Admin/PostalCodes::add',
		'Data.Admin/PostalCodes::delete',
		'Data.Admin/PostalCodes::edit',
		'Data.Admin/PostalCodes::geolocate',
		'Data.Admin/PostalCodes::index',
		'Data.Admin/PostalCodes::view',
		'Data.Admin/States::add',
		'Data.Admin/States::delete',
		'Data.Admin/States::edit',
		'Data.Admin/States::index',
		'Data.Admin/States::updateSelect',
		'Data.Admin/Timezones::add',
		'Data.Admin/Timezones::delete',
		'Data.Admin/Timezones::edit',
		'Data.Admin/Timezones::index',
		'Data.Admin/Timezones::link',
		'Data.Admin/Timezones::sync',
		'Data.Admin/Timezones::view',
		'Data.Continents::index',
		'Data.Countries::index',
		'Data.Currencies::index',
		'Data.PostalCodes::map',
		'Data.States::index',
		'Data.States::updateSelect',
		'Data.Timezones::index',
		'DatabaseLog.Admin/DatabaseLog::index',
		'DatabaseLog.Admin/Logs::delete',
		'DatabaseLog.Admin/Logs::index',
		'DatabaseLog.Admin/Logs::removeDuplicates',
		'DatabaseLog.Admin/Logs::reset',
		'DatabaseLog.Admin/Logs::view',
		'Export::continents',
		'Export::countries',
		'Export::currencies',
		'Export::index',
		'Export::languages',
		'Export::mimeTypes',
		'Export::postalCodes',
		'Export::states',
		'Export::timezones',
		'Expose.Admin/Expose::index',
		'Feedback.Admin/Feedback::index',
		'Feedback.Admin/Feedback::listing',
		'Feedback.Admin/Feedback::remove',
		'Feedback.Admin/Feedback::viewimage',
		'Feedback.Admin/FeedbackItems::delete',
		'Feedback.Admin/FeedbackItems::edit',
		'Feedback.Admin/FeedbackItems::importFiles',
		'Feedback.Admin/FeedbackItems::index',
		'Feedback.Admin/FeedbackItems::view',
		'Feedback.Admin/FeedbackItems::viewimage',
		'Feedback.Feedback::index',
		'Feedback.Feedback::save',
		'Feedback.Feedback::viewimage',
		'Geo.Admin/Geo::index',
		'Geo.Admin/GeocodedAddresses::clearAll',
		'Geo.Admin/GeocodedAddresses::clearEmpty',
		'Geo.Admin/GeocodedAddresses::delete',
		'Geo.Admin/GeocodedAddresses::edit',
		'Geo.Admin/GeocodedAddresses::index',
		'Geo.Admin/GeocodedAddresses::view',
		'Misc::convertText',
		'Misc::index',
		'Overview::index',
		'Pages::display',
		'Queue.Admin/Queue::addJob',
		'Queue.Admin/Queue::flush',
		'Queue.Admin/Queue::hardReset',
		'Queue.Admin/Queue::index',
		'Queue.Admin/Queue::processes',
		'Queue.Admin/Queue::removeJob',
		'Queue.Admin/Queue::reset',
		'Queue.Admin/Queue::resetJob',
		'Queue.Admin/QueueProcesses::cleanup',
		'Queue.Admin/QueueProcesses::delete',
		'Queue.Admin/QueueProcesses::edit',
		'Queue.Admin/QueueProcesses::index',
		'Queue.Admin/QueueProcesses::terminate',
		'Queue.Admin/QueueProcesses::view',
		'Queue.Admin/QueuedJobs::data',
		'Queue.Admin/QueuedJobs::delete',
		'Queue.Admin/QueuedJobs::edit',
		'Queue.Admin/QueuedJobs::execute',
		'Queue.Admin/QueuedJobs::import',
		'Queue.Admin/QueuedJobs::index',
		'Queue.Admin/QueuedJobs::migrate',
		'Queue.Admin/QueuedJobs::stats',
		'Queue.Admin/QueuedJobs::test',
		'Queue.Admin/QueuedJobs::view',
		'Sandbox.AjaxExamples::chainedDropdowns',
		'Sandbox.AjaxExamples::countryStates',
		'Sandbox.AjaxExamples::editInPlace',
		'Sandbox.AjaxExamples::editInPlaceEmail',
		'Sandbox.AjaxExamples::endlessScroll',
		'Sandbox.AjaxExamples::form',
		'Sandbox.AjaxExamples::index',
		'Sandbox.AjaxExamples::pagination',
		'Sandbox.AjaxExamples::redirecting',
		'Sandbox.AjaxExamples::redirectingPrevented',
		'Sandbox.AjaxExamples::simple',
		'Sandbox.AjaxExamples::table',
		'Sandbox.AjaxExamples::tableDelete',
		'Sandbox.AjaxExamples::toggle',
		'Sandbox.AssetCompressExamples::index',
		'Sandbox.AssetCompressExamples::sass',
		'Sandbox.Bootstrap::flash',
		'Sandbox.Bootstrap::form',
		'Sandbox.Bootstrap::formPost',
		'Sandbox.Bootstrap::index',
		'Sandbox.Bootstrap::localized',
		'Sandbox.Bootstrap::postLink',
		'Sandbox.Bootstrap::time',
		'Sandbox.CacheExamples::hour',
		'Sandbox.CacheExamples::index',
		'Sandbox.CacheExamples::minute',
		'Sandbox.CacheExamples::someJson',
		'Sandbox.CakeExamples::i18n',
		'Sandbox.CakeExamples::index',
		'Sandbox.CakeExamples::merge',
		'Sandbox.CakeExamples::queryStrings',
		'Sandbox.CakeExamples::validation',
		'Sandbox.Calendar::index',
		'Sandbox.Calendar::view',
		'Sandbox.Captchas::index',
		'Sandbox.Captchas::math',
		'Sandbox.Captchas::modelLess',
		'Sandbox.ChronosExamples::index',
		'Sandbox.Conventions::index',
		'Sandbox.Csv::index',
		'Sandbox.Csv::pagination',
		'Sandbox.Csv::simple',
		'Sandbox.DtoExamples::github',
		'Sandbox.DtoExamples::index',
		'Sandbox.Examples::index',
		'Sandbox.Examples::messages',
		'Sandbox.Examples::params',
		'Sandbox.Examples::phpBasicfunctions',
		'Sandbox.Examples::phpValidationfunctions',
		'Sandbox.ExposeExamples::index',
		'Sandbox.ExposeExamples::superimposedEdit',
		'Sandbox.ExposeExamples::superimposedIndex',
		'Sandbox.ExposeExamples::superimposedView',
		'Sandbox.ExposeExamples::users',
		'Sandbox.ExposeExamples::view',
		'Sandbox.FeedExamples::feed',
		'Sandbox.FeedExamples::feedview',
		'Sandbox.FeedExamples::index',
		'Sandbox.FeedbackExamples::index',
		'Sandbox.FlashExamples::ajax',
		'Sandbox.FlashExamples::ajaxPlugin',
		'Sandbox.FlashExamples::index',
		'Sandbox.FlashExamples::messageGroups',
		'Sandbox.FlashExamples::messages',
		'Sandbox.GeoExamples::index',
		'Sandbox.GeoExamples::query',
		'Sandbox.Inflector::index',
		'Sandbox.JqueryExamples::autocomplete',
		'Sandbox.JqueryExamples::autopreview',
		'Sandbox.JqueryExamples::index',
		'Sandbox.JqueryExamples::maxlength',
		'Sandbox.JsExamples::datepicker',
		'Sandbox.JsExamples::index',
		'Sandbox.Localized::basic',
		'Sandbox.Localized::index',
		'Sandbox.MarkupExamples::bbcode',
		'Sandbox.MarkupExamples::index',
		'Sandbox.MarkupExamples::markdown',
		'Sandbox.MarkupExamples::markup',
		'Sandbox.MediaEmbed::bbcode',
		'Sandbox.MediaEmbed::hosts',
		'Sandbox.MediaEmbed::index',
		'Sandbox.Menu::index',
		'Sandbox.PluginExamples::index',
		'Sandbox.Plugins::cakePdf',
		'Sandbox.Plugins::index',
		'Sandbox.Plugins::pdfTest',
		'Sandbox.QueueExamples::cancelJob',
		'Sandbox.QueueExamples::config',
		'Sandbox.QueueExamples::index',
		'Sandbox.QueueExamples::scheduleDemo',
		'Sandbox.QueueExamples::scheduling',
		'Sandbox.Ratings::index',
		'Sandbox.Ratings::unrate',
		'Sandbox.Sandbox::index',
		'Sandbox.SearchExamples::index',
		'Sandbox.SearchExamples::table',
		'Sandbox.ServiceExamples::index',
		'Sandbox.ServiceExamples::posts',
		'Sandbox.SocialShare::index',
		'Sandbox.Tags::cloud',
		'Sandbox.Tags::index',
		'Sandbox.Tags::search',
		'Sandbox.Tags::select',
		'Sandbox.ToolsExamples::_diff',
		'Sandbox.ToolsExamples::bitmaskSearch',
		'Sandbox.ToolsExamples::bitmasks',
		'Sandbox.ToolsExamples::confirmable',
		'Sandbox.ToolsExamples::datetime',
		'Sandbox.ToolsExamples::fakeEdit',
		'Sandbox.ToolsExamples::formatHelper',
		'Sandbox.ToolsExamples::gravatar',
		'Sandbox.ToolsExamples::index',
		'Sandbox.ToolsExamples::meter',
		'Sandbox.ToolsExamples::password',
		'Sandbox.ToolsExamples::passwordEdit',
		'Sandbox.ToolsExamples::passwordEditCurrent',
		'Sandbox.ToolsExamples::progress',
		'Sandbox.ToolsExamples::qr',
		'Sandbox.ToolsExamples::redirectTest',
		'Sandbox.ToolsExamples::slug',
		'Sandbox.ToolsExamples::timeline',
		'Sandbox.ToolsExamples::tree',
		'Sandbox.ToolsExamples::typography',
		'Sandbox.Tryouts::fontawesome',
		'Sandbox.Tryouts::fontello',
		'Sandbox.Tryouts::index',
		'Sandbox.TwigExamples::basic',
		'Sandbox.TwigExamples::index',
		'Setup.Admin/Backend::cache',
		'Setup.Admin/Backend::database',
		'Setup.Admin/Backend::env',
		'Setup.Admin/Backend::phpinfo',
		'Setup.Admin/Backend::session',
		'Setup.Admin/Database::foreignKeys',
		'Setup.Admin/Setup::index',
		'StateMachine.Admin/Graph::draw',
		'StateMachine.Admin/StateMachine::index',
		'StateMachine.Admin/StateMachine::overview',
		'StateMachine.Admin/StateMachine::process',
		'StateMachine.Admin/StateMachine::reset',
		'StateMachine.Admin/StateMachineItemStateLogs::delete',
		'StateMachine.Admin/StateMachineItemStateLogs::index',
		'StateMachine.Admin/StateMachineItemStateLogs::view',
		'StateMachine.Admin/StateMachineItemStates::delete',
		'StateMachine.Admin/StateMachineItemStates::index',
		'StateMachine.Admin/StateMachineItemStates::view',
		'StateMachine.Admin/StateMachineItems::delete',
		'StateMachine.Admin/StateMachineItems::index',
		'StateMachine.Admin/StateMachineItems::view',
		'StateMachine.Admin/StateMachineLocks::delete',
		'StateMachine.Admin/StateMachineLocks::index',
		'StateMachine.Admin/StateMachineLocks::view',
		'StateMachine.Admin/StateMachineProcesses::delete',
		'StateMachine.Admin/StateMachineProcesses::index',
		'StateMachine.Admin/StateMachineProcesses::view',
		'StateMachine.Admin/StateMachineTimeouts::delete',
		'StateMachine.Admin/StateMachineTimeouts::index',
		'StateMachine.Admin/StateMachineTimeouts::view',
		'StateMachine.Admin/StateMachineTransitionLogs::delete',
		'StateMachine.Admin/StateMachineTransitionLogs::index',
		'StateMachine.Admin/StateMachineTransitionLogs::view',
		'StateMachine.Admin/Trigger::event',
		'StateMachine.Admin/Trigger::eventForNewItem',
		'StateMachineSandbox.RegistrationDemo::adminPanel',
		'StateMachineSandbox.RegistrationDemo::index',
		'StateMachineSandbox.RegistrationDemo::moderatorPanel',
		'StateMachineSandbox.RegistrationDemo::process',
		'StateMachineSandbox.RegistrationDemo::register',
		'StateMachineSandbox.Registrations::delete',
		'StateMachineSandbox.Registrations::index',
		'StateMachineSandbox.Registrations::view',
		'StateMachineSandbox.StateMachineSandbox::index',
		'Tools.Admin/Format::icons',
		'Tools.Admin/Tools::index',
		'Tools.ShuntRequest::language'
	);

	registerArgumentsSet(
		'tableNames',
		'bitmasked_records',
		'captchas',
		'continents',
		'countries',
		'currencies',
		'database_logs',
		'events',
		'exposed_users',
		'languages',
		'queue_processes',
		'queued_jobs',
		'registrations',
		'roles',
		'sandbox_animals',
		'sandbox_categories',
		'sandbox_posts',
		'sandbox_ratings',
		'sandbox_users',
		'state_machine_item_state_logs',
		'state_machine_item_states',
		'state_machine_items',
		'state_machine_locks',
		'state_machine_processes',
		'state_machine_timeouts',
		'state_machine_transition_logs',
		'states',
		'tags_tagged',
		'tags_tags',
		'timezones',
		'users'
	);

	registerArgumentsSet(
		'validationWhen',
		'create',
		'update'
	);

}
