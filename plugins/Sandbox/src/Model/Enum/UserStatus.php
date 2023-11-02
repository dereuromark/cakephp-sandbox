<?php

namespace Sandbox\Model\Enum;

enum UserStatus: int
{
	case INACTIVE = 0;
	case ACTIVE = 1;

	/**
	 * @return string
	 */
	public function label(): string {
		return mb_strtolower($this->name);
	}
}
