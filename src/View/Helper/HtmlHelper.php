<?php

namespace App\View\Helper;

use BootstrapUI\View\Helper\HtmlHelper as BootstrapHtmlHelper;
use Templating\View\Helper\HtmlHelperTrait;
use Tools\View\Helper\HtmlTrait;

/**
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class HtmlHelper extends BootstrapHtmlHelper {

	use HtmlHelperTrait;
	use HtmlTrait;

}
