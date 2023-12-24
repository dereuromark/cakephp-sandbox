<?php

namespace Sandbox\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

enum UserStatus: int implements EnumLabelInterface
{
	case INACTIVE = 0;
	case ACTIVE = 1;

	/**
	 * @return string
	 */
	public function label(): string {
		return Inflector::humanize(mb_strtolower($this->name));
	}
}
