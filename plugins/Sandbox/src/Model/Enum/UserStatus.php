<?php

namespace Sandbox\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;
use Tools\Model\Enum\EnumOptionsTrait;

enum UserStatus: int implements EnumLabelInterface
{
	use EnumOptionsTrait;

	case Inactive = 0;
	case Active = 1;
	case Deleted = 2;

	/**
	 * @return string
	 */
	public function label(): string {
		return Inflector::humanize(Inflector::underscore($this->name));
	}
}
