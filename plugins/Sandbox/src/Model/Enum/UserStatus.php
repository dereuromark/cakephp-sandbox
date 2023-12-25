<?php

namespace Sandbox\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;
use Tools\Model\Enum\EnumOptionsTrait;

enum UserStatus: int implements EnumLabelInterface
{
	use EnumOptionsTrait;

	case INACTIVE = 0;
	case ACTIVE = 1;
	case DELETED = 2;

	/**
	 * @return string
	 */
	public function label(): string {
		return Inflector::humanize(mb_strtolower($this->name));
	}
}
