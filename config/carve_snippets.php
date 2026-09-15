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
		'library/cycle.crv' => [
			'title' => 'Cycle guard',
			'source' => "{{ cycle.crv }}\n",
		],
	],
];
