<?php
declare(strict_types=1);

return [
	'CarveSnippets' => [
		'library/intro.crv' => [
			'title' => 'Stored introduction',
			'source' => "::: note \"From the snippet library\"\nThis callout is stored in configuration and included at render time.\n:::\n",
		],
		'library/features.crv' => [
			'title' => 'Feature list',
			'source' => "- exact catalog lookup, without filesystem access\n- normal Carve parsing, profiles, and HTML sanitizing\n- cycle, depth, call, and byte-budget protection\n",
		],
		'library/chapter.crv' => [
			'title' => 'Nested chapter',
			'source' => "## Reused chapter\n\nA stored snippet can include another stored snippet:\n\n{{ sign-off.crv }}\n",
		],
		'library/sign-off.crv' => [
			'title' => 'Nested sign-off',
			'source' => "*Resolved relative to the including catalog snippet.*\n",
		],
		'library/inline.crv' => [
			'title' => 'Inline phrase',
			'source' => "a config-backed inline snippet\n",
		],
		'library/setup.crv' => [
			'title' => 'Named region (@region:requirements)',
			'source' => "## Setup\n\nOnly the marked region below is included.\n\n%% #region requirements\n- PHP 8.2 or newer\n- Composer 2\n%% #endregion requirements\n\nText after the region is skipped.\n",
		],
		'library/server.js' => [
			'title' => 'Source file included as code (@code:js)',
			'source' => "import { createServer } from 'node:http'\n\n// #region start\nconst server = createServer((request, response) => {\n  response.end('hello')\n})\nserver.listen(8080)\n// #endregion start\n\nexport default server\n",
		],
		'library/plans.csv' => [
			'title' => 'CSV data rendered as a table ({table} + @code:csv)',
			'source' => "Plan,Seats,Price\nStarter,1,0\nTeam,10,49\n\"Enterprise, annual\",unlimited,\"on request\"\n",
		],
		'library/cycle.crv' => [
			'title' => 'Cycle guard',
			'source' => "{{ cycle.crv }}\n",
		],
	],
];
