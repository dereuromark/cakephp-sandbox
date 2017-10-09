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
