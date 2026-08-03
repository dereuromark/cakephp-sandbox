<?php

use App\Plugin\MercurePlugin;

return [
	'Migrations' => ['onlyCli' => true],
	'DebugKit' => ['onlyDebug' => true],
	'TestHelper' => ['onlyDebug' => true, 'optional' => true],
	'CakephpFixtureFactories' => ['onlyDebug' => true, 'onlyCli' => true],
	'Shim' => [],
	'Tools' => [],
	'Setup' => [],
	'Data' => [],
	'Tags' => [],
	'Ajax' => [],
	'Meta' => [],
	'Cache' => [],
	'AssetCompress' => [],
	'TinyAuth' => ['bootstrap' => false],
	'Calendar' => [],
	'Search' => [],
	'Ratings' => [],
	'Comments' => [],
	'Geo' => [],
	'Templating' => [],
	'DatabaseLog' => [],
	'Queue' => [],
	'QueueScheduler' => [],
	'Captcha' => [],
	'CakeDto' => [],
	'Cake/Localized' => [],
	'BootstrapUI' => [],
	'Markup' => [],
	'Feedback' => [],
	'Menu' => [],
	'Expose' => [],
	'Translate' => [],
	'Favorites' => [],
	'Reactions' => [],
	'QrCode' => [],
	'AuditStash' => [],
	'FileStorage' => [],
	'Bouncer' => [],
	// Subclassed so the services register without a League provider, which the
	// CakePHP container (App.container) rejects. See the class docblock.
	MercurePlugin::class => [],
	'Workflow' => [],

	// inside /plugins
	'AuthSandbox' => [],
	'Sandbox' => [],
	'WorkflowSandbox' => [],
	'StateMachineSandbox' => [], // Redirects only
	'MenuSandbox' => [],
];
