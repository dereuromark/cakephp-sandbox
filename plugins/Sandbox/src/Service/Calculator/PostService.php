<?php

namespace Sandbox\Service\Calculator;

class PostService {

	/**
	 * Counts an array as example of some business logic.
	 *
	 * @param array<mixed> $array
	 *
	 * @return int
	 */
	public function calculate(array $array): int {
		return count($array);
	}

}
