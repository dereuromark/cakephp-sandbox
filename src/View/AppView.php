<?php

namespace App\View;

use Cake\View\View;

/**
 * @property \App\View\Helper\AppHelper $App
 * @property \AssetCompress\View\Helper\AssetCompressHelper $AssetCompress
 * @property \TinyAuth\View\Helper\AuthUserHelper $AuthUser
 * @property \Markup\View\Helper\BbcodeHelper $Bbcode
 * @property \Calendar\View\Helper\CalendarHelper $Calendar
 * @property \Captcha\View\Helper\CaptchaHelper $Captcha
 * @property \Comments\View\Helper\CommentsHelper $Comments
 * @property \Tools\View\Helper\CommonHelper $Common
 * @property \Shim\View\Helper\ConfigureHelper $Configure
 * @property \Data\View\Helper\DataHelper $Data
 * @property \Markup\View\Helper\DjotHelper $Djot
 * @property \Favorites\View\Helper\FavoritesHelper $Favorites
 * @property \Flash\View\Helper\FlashHelper $Flash
 * @property \App\View\Helper\FormHelper $Form
 * @property \Tools\View\Helper\FormatHelper $Format
 * @property \Geo\View\Helper\GoogleMapHelper $GoogleMap
 * @property \Tools\View\Helper\GravatarHelper $Gravatar
 * @property \Markup\View\Helper\HighlighterHelper $Highlighter
 * @property \App\View\Helper\HtmlHelper $Html
 * @property \Templating\View\Helper\IconHelper $Icon
 * @property \Templating\View\Helper\IconSnippetHelper $IconSnippet
 * @property \Geo\View\Helper\LeafletHelper $Leaflet
 * @property \Favorites\View\Helper\LikesHelper $Likes
 * @property \Markup\View\Helper\MarkdownHelper $Markdown
 * @property \Sandbox\View\Helper\MediaEmbedBbcodeHelper $MediaEmbedBbcode
 * @property \Menu\View\Helper\MenuHelper $Menu
 * @property \Mercure\View\Helper\MercureHelper $Mercure
 * @property \Tools\View\Helper\MeterHelper $Meter
 * @property \App\View\Helper\NavigationHelper $Navigation
 * @property \CakeDecimal\View\Helper\NumberHelper $Number
 * @property \Tools\View\Helper\ObfuscateHelper $Obfuscate
 * @property \BootstrapUI\View\Helper\PaginatorHelper $Paginator
 * @property \Tools\View\Helper\ProgressHelper $Progress
 * @property \QrCode\View\Helper\QrCodeHelper $QrCode
 * @property \Queue\View\Helper\QueueHelper $Queue
 * @property \Queue\View\Helper\QueueProgressHelper $QueueProgress
 * @property \Ratings\View\Helper\RatingHelper $Rating
 * @property \Reactions\View\Helper\ReactionsHelper $Reactions
 * @property \App\View\Helper\SandboxHelper $Sandbox
 * @property \Search\View\Helper\SearchHelper $Search
 * @property \Favorites\View\Helper\StarsHelper $Stars
 * @property \Geo\View\Helper\StaticMapHelper $StaticMap
 * @property \Tags\View\Helper\TagHelper $Tag
 * @property \Tags\View\Helper\TagCloudHelper $TagCloud
 * @property \Tools\View\Helper\TextHelper $Text
 * @property \Tools\View\Helper\TimeHelper $Time
 * @property \Tools\View\Helper\TimelineHelper $Timeline
 * @property \Tools\View\Helper\TreeHelper $Tree
 * @property \Tools\View\Helper\TypographyHelper $Typography
 * @property \Tools\View\Helper\UrlHelper $Url
 * @property \Workflow\View\Helper\WorkflowHelper $Workflow
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
