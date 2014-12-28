<?php
namespace App\View\Helper;
use App\View\Helper\AppHelper;

/**
 * Custom helper
 * 2009-12-22 ms
 */
class CustomHelper extends AppHelper {

	/**
	 * Other helpers used by FormHelper
	 *
	 * @var array
	 */
	public $helpers = array('Common', 'Html');

	/**
	 * Cups (places: gold, silver, bronze)
	 *
	 * @param int $place: 0,1,2 or anything else for "no cup"
	 * @param bool $consolationPrize: TRUE or image url (defaults to FALSE)
	 * @return string cupImage
	 */
	public function place($place = null, $consolationPrize = false) {
		if ($place === 0) {
			$i = 1;
			$title = __('Gold');
		} elseif ($place == 1) {
			$i = 2;
			$title = __('Silver');
		} elseif ($place == 2) {
			$i = 3;
			$title = __('Bronze');
		} else {
			$i = 'none';
			$title = __('Kein Treppchenplatz');
			# consolation prize
			if ($consolationPrize === true) {
				$i = 'consolation_prize';
				$title = __('consolationPrize');
			} /* elseif (!empty($consolationPrize)) {
				return $this->Html->image($consolationPrize);
			} */
		}
		return $this->Html->image('places/cup_' . $i . '.gif', array('title' => $title));
	}

}

