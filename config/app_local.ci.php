<?php

return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
];
