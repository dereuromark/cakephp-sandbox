<?php

namespace Sandbox\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;
use Tools\Model\Enum\EnumOptionsTrait;

enum Flag: int implements EnumLabelInterface
{
	use EnumOptionsTrait;

	case Important = 1;
	case Featured = 2;
	case Approved = 4;
	case Flagged = 8;

	/**
	 * @return string
	 */
	public function label(): string {
		return Inflector::humanize(Inflector::underscore($this->name));
	}
}
