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
 * @property \App\View\Helper\HtmlHelper $Html
 * @property \Tools\View\Helper\UrlHelper $Url
 * @property \App\View\Helper\FormHelper $Form
 * @property \Tools\View\Helper\CommonHelper $Common
 * @property \Flash\View\Helper\FlashHelper $Flash
 * @property \Tools\View\Helper\TimeHelper $Time
 * @property \Tools\View\Helper\NumberHelper $Number
 * @property \Data\View\Helper\DataHelper $Data
 * @property \Tools\View\Helper\GravatarHelper $Gravatar
 * @property \QrCode\View\Helper\QrCodeHelper $QrCode
 * @property \Tools\View\Helper\TreeHelper $Tree
 * @property \Ratings\View\Helper\RatingHelper $Rating
 * @property \Shim\View\Helper\ConfigureHelper $Configure
 * @property \Calendar\View\Helper\CalendarHelper $Calendar
 * @property \Sandbox\View\Helper\MediaEmbedBbcodeHelper $MediaEmbedBbcode
 * @property \Tags\View\Helper\TagCloudHelper $TagCloud
 * @property \Tags\View\Helper\TagHelper $Tag
 * @property \Tools\View\Helper\TypographyHelper $Typography
 * @property \Markup\View\Helper\HighlighterHelper $Highlighter
 * @property \Tools\View\Helper\ProgressHelper $Progress
 * @property \Tools\View\Helper\MeterHelper $Meter
 * @property \Queue\View\Helper\QueueProgressHelper $QueueProgress
 * @property \Icings\Menu\View\Helper\MenuHelper $Menu
 * @property \BootstrapUI\View\Helper\PaginatorHelper $Paginator
 * @property \Markup\View\Helper\BbcodeHelper $Bbcode
 * @property \Markup\View\Helper\MarkdownHelper $Markdown
 * @property \Tools\View\Helper\TextHelper $Text
 * @property \Queue\View\Helper\QueueHelper $Queue
 * @property \Search\View\Helper\SearchHelper $Search
 * @property \Templating\View\Helper\IconHelper $Icon
 * @property \Templating\View\Helper\IconSnippetHelper $IconSnippet
 * @property \Favorites\View\Helper\StarsHelper $Stars
 * @property \Favorites\View\Helper\LikesHelper $Likes
 * @property \Favorites\View\Helper\FavoritesHelper $Favorites
 * @property \Comments\View\Helper\CommentsHelper $Comments
 * @property \Tools\View\Helper\TimelineHelper $Timeline
 */
class AppView extends View {

	use AddHelperTrait;

	/**
	 * @return void
	 */
	public function initialize(): void {
		$this->addHelpers();

		parent::initialize();
	}

}
