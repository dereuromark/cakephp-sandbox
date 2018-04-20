<?php
namespace App\View;

use Cake\View\View;

/**
 * @property \AssetCompress\View\Helper\AssetCompressHelper $AssetCompress
 * @property \TinyAuth\View\Helper\AuthUserHelper $AuthUser
 * @property \Geo\View\Helper\GoogleMapHelper $GoogleMap
 * @property \Captcha\View\Helper\CaptchaHelper $Captcha
 * @property \Tools\View\Helper\FormatHelper $Format
 * @property \Tools\View\Helper\ObfuscateHelper $Obfuscate
 * @property \App\View\Helper\AppHelper $App
 * @property \App\View\Helper\NavigationHelper $Navigation
 * @property \App\View\Helper\SandboxHelper $Sandbox
 * @property \Tools\View\Helper\HtmlHelper $Html
 * @property \Tools\View\Helper\UrlHelper $Url
 * @property \BootstrapUI\View\Helper\FormHelper $Form
 * @property \Tools\View\Helper\CommonHelper $Common
 * @property \Flash\View\Helper\FlashHelper $Flash
 * @property \Tools\View\Helper\TimeHelper $Time
 * @property \Tools\View\Helper\NumberHelper $Number
 * @property \Data\View\Helper\DataHelper $Data
 * @property \Tools\View\Helper\GravatarHelper $Gravatar
 * @property \Tools\View\Helper\QrCodeHelper $QrCode
 * @property \Tools\View\Helper\TreeHelper $Tree
 * @property \Ratings\View\Helper\RatingHelper $Rating
 * @property \Shim\View\Helper\ConfigureHelper $Configure
 * @property \Calendar\View\Helper\CalendarHelper $Calendar
 * @property \Sandbox\View\Helper\MediaEmbedBbcodeHelper $MediaEmbedBbcode
 * @property \Tags\View\Helper\TagCloudHelper $TagCloud
 * @property \Tags\View\Helper\TagHelper $Tag
 * @property \Tools\View\Helper\TypographyHelper $Typography
 */
class AppView extends View {

	/**
	 * Initialization hook method.
	 *
	 * For e.g. use this method to load a helper for all views:
	 * `$this->loadHelper('Html');`
	 *
	 * @return void
	 */
	public function initialize() {
	}

}
