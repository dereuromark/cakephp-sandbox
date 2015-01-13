<?php
namespace App\View\Helper;

// http://www.cakephp-forum.com/posting.php

/**
 * BBCODE Helper.
 *
 * Helper to use BBCODE for security issues with form elements (textarea)
 */
class BbcodeHelper extends AppHelper {

	public $helpers = array('Html', 'Tools.Geshi', 'Url');

	public $languages = array();

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		App::import('Vendor', 'bbcode', array('file' => 'bbcode/stringparser_bbcode.class.php'));
	}

	public function add_languages($languages) {
		if (!empty($languages) && is_array($languages)) {
			foreach ($languages as $language) {
				$this->languages[strtolower($language['CodesnippetType']['name'])] = $language['CodesnippetType']['name'];
			}
		}
	}

	/** INPUT (Form Element And Buttons) **/

	/**
	 * Has to be called right at the top of the Page where you want to use it (needs the language array from the controller!)
	 *
	 * @param form name, text name, languages array, (options)
	 */
	public function init($formName, $textName, $languages = array(), $options = null) {
		$this->Html->script('bbcode.js', false);

		// $languages = $this->Common->readFile('bbcode');
		$this->add_languages($languages);

		$output = "<script type=\"text/javascript\">
// <![CDATA[
	var form_name = '" . $formName . "';
	var text_name = '" . $textName . "';

	// Define the bbCode tags
	var bbcode = new Array();

	var bbtags = new Array('[b]','[/b] ','[i]','[/i] ','[u]','[/u] ','[quote]','[/quote] ','[code=text]\\n','\\n[/code]\\n','[list]','[/list]\\n','[list=]\\n','[/list]\\n','[img]','[/img]\\n','[url]','[/url] ','[nobb]', '[/nobb] ', '[h=]', '[/h]\\n', '[code=]', '[/code] ');

// ]]>
</script>";

		return $output;
	}

	/**
	 * Add Buttons and Select Menus
	 * NOTE: have to be INSIDE the <form></form> (as long its still "this.form")
	 */
	public function buttons() {
		if (sizeof($this->languages) > 0) {
			$codedropdown = '
<select name="addbbcode23" onchange="bbfontstyle(\'[code=\' + this.form.addbbcode23.options[this.form.addbbcode23.selectedIndex].value + \']\', \'[/code]\');this.form.addbbcode23.selectedIndex = 0;" title="Special Code: [code=xx]Code Text[/code]">
	<option value="" selected="selected">- [ Special Codes ] -</option>';
			foreach ($this->languages as $value => $language) {
				$codedropdown .= '<option value="' . $value . '">' . $language . '</option>';
			}

			$codedropdown .= '</select>';

			$codebutton = '<div class="bbcode_button" id="addbbcode8" style="width: 40px" onclick="bbstyle(8)" title="Code Box: [code=text]Code[/code]">Code</div>';
		} else {
			$codedropdown = '';
			$codebutton = '';
		}

		$output = '
		<div class="highslide-html-content" id="highslide-html-bbcode">
<h2>BB-Code Help</h2>
<table class="list">
<tr>
<td>[img] / [url]</td><td>For external images/urls, please start with the full url (http:// etc.)<br />For internal ones, use a / at the beginning. Cake will automatically attach the root <b><?php echo HTTP_BASE.HTTP_REL?></b> to it.<br />
Internal Example: [img]/images/123.jpg[url] becomes <?php echo HTTP_REL?>images/123.jpg<br />
External Example: [img]http://site.yz/images/123.jpg[url] becomes http://site.yz/images/123.jpg</td>
</tr>
<tr>
<td>[url=]</td><td>Some as above, only that the url is now inside the square brackets, and you can use anything you want for the description<br />Example: [url=http://google.de]This is a search engine[url]</td>
</tr>
<tr>
<td>[nobb]</td><td>Content in this tag will stay completely untouched. Useful if you have some BB-Code in your text (which would be transformed otherwise)</td>
</tr>

</table><br/>
Note: If there is some BB-Code left (on preview or after saving it) - you probably used it in an invalid way (like [code] inside of [h1] etc).
</div>
<div id="format-buttons" class="bbcode_buttons">
	<div style="float:right"><a href="javascript:void(0)" onclick="return hs.htmlExpand(this, { contentId: \'highslide-html-bbcode\', preserveContent: true, width: 800 } ); return false;">Help</a></div>
	<div class="bbcode_button" id="addbbcode0" style="font-weight:bold; width: 30px" onclick="bbstyle(0)" title="Bold: [b]Text[/b]">b</div>

	<div class="bbcode_button" id="addbbcode2" style="font-style:italic; width: 30px" onclick="bbstyle(2)" title="Italic: [i]Text[/i]">i</div>
	<div class="bbcode_button" id="addbbcode4" style="text-decoration: underline; width: 30px" onclick="bbstyle(4)" title="Underlined: [u]Text[/u]">u</div>
			<div class="bbcode_button" id="addbbcode6" style="width: 50px" onclick="bbstyle(6)" title="Quote: [quote]Text[/quote]">Quote</div>
		' . $codebutton . '
	<div class="bbcode_button" id="addbbcode10" style="width: 40px" onclick="bbstyle(10)" title="Unordnered List: [list]Text[/list]">List</div>
	<div class="bbcode_button" id="addbbcode12" style="width: 40px" onclick="bbstyle(12)" title="Ordnered List: [list=]Text[/list]">List=</div>
	<div class="bbcode_button" id="addlitsitem" style="width: 40px" onclick="bbstyle(-1)" title="List Element: [*]Text">[*]</div>
			<div class="bbcode_button" id="addbbcode14" style="width: 40px" onclick="bbstyle(14)" title="External Image: [img]http://img_url[/img] | Internal Image: [img]/img_url[/img]">IMG</div>
			<div class="bbcode_button" id="addbbcode16" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" title="External Link: [url]http://url[/url] or: [url=http://url]LinkText[/url] | ' . PHP_EOL . 'Internal Link: [url]/internal_url[/url] or: [url=/internal_url]LinkText[/url]">URL</div>
			<div class="bbcode_button" id="addbbcode18" style="width: 40px" onclick="bbstyle(18)" title="No BB-Replacing: [nobb]Some [b]-[i]-Text not to be replaced[/nobb]">NoBB</div>
<br class="clear"/>

	<select name="addbbcode21" onchange="bbfontstyle(\'[h\' + this.form.addbbcode21.options[this.form.addbbcode21.selectedIndex].value + \']\', \'[/h\' + this.form.addbbcode21.options[this.form.addbbcode21.selectedIndex].value + \']\');this.form.addbbcode21.selectedIndex = 0;" title="Header 1: [h1]Some Text[/h1]">
		<option value="" selected="selected">- [ Headers ] -</option>
		<option value="1">Main Header (1)</option>
		<option value="2">Sub Header (2)</option>
	</select> ' . $codedropdown . '
</div>';

		return $output;
	}

	/** OUTPUT (Tansforming into html + highlighting) **/

	/**
	 *
	 * @param string content
	 * @param array options: highlight=>TRUE/FALSE (default TRUE), smiley=>TRUE/FALSE (default FALSE)
	 */
	public function parse($content, $options = array()) {
		$out = '' . h($content) . '';
		$out = preg_replace("/\015\012|\015|\012/", "\n", $out);	// new lines on different systems

		$this->Bbcode = new StringParser_BBCode();
		$this->Bbcode->setGlobalCaseSensitive(false);	// [b]=[B]

		//$this->Bbcode->addParser (array ('header','block', 'inline', 'link', 'listitem'), 'htmlspecialchars');
		$this->Bbcode->addParser(array('block', 'inline', 'link', 'listitem', 'nobb'), 'nl2br');
		$this->Bbcode->addParser('list', 'bbcode_stripcontents');
		$this->Bbcode->addParser('header', 'bbcode_stripnewlines');

		$this->Bbcode->addCode('h1', 'simple_replace', null, array('start_tag' => '<h2>', 'end_tag' => '</h2>'),
		 'header', array('block', 'inline'), array());
		$this->Bbcode->addCode('h2', 'simple_replace', null, array('start_tag' => '<h4>', 'end_tag' => '</h4>'),
		 'header', array('block', 'inline'), array());

		$this->Bbcode->addCode('b', 'simple_replace', null, array('start_tag' => '<b>', 'end_tag' => '</b>'),
		 'inline', array('listitem', 'block', 'inline', 'link'), array());
		$this->Bbcode->addCode('i', 'simple_replace', null, array('start_tag' => '<i>', 'end_tag' => '</i>'),
		 'inline', array('listitem', 'block', 'inline', 'link'), array());
		$this->Bbcode->addCode('u', 'simple_replace', null, array('start_tag' => '<u>', 'end_tag' => '</u>'),
		 'inline', array('listitem', 'block', 'inline', 'link'), array());

		$this->Bbcode->addCode('email', 'usecontent', 'do_bbcode_email', array(),
		 'link', array('listitem', 'block', 'inline', 'link'), array());

		$this->Bbcode->addCode('url', 'usecontent?', 'do_bbcode_url', array('usecontent_param' => 'default'),
		 'link', array('listitem', 'block', 'inline'), array('link'));
		$this->Bbcode->addCode('link', 'callback_replace_single', 'do_bbcode_url', array(),
		 'link', array('listitem', 'block', 'inline'), array('link'));
		$this->Bbcode->addCode('img', 'usecontent', 'do_bbcode_img', array(),
		 'image', array('listitem', 'block', 'inline', 'link'), array());

		$this->Bbcode->addCode('quote', 'simple_replace', null, array('start_tag' => '<quote>', 'end_tag' => '</quote>'),
		 'quote', array('block', 'inline'), array());

		$this->Bbcode->addCode('code', 'usecontent', 'do_bbcode_code', array(),
		 'code', array('block', 'inline'), array());

		$this->Bbcode->addCode('nobb', 'usecontent', 'do_bbcode_nobb', array(),
		 'nobb', array('block', 'listitem', 'link', 'inline'), array());

		//$this->Bbcode->setOccurrenceType ('img', 'image');
		//$this->Bbcode->setMaxOccurrences ('image', 2);

		$this->Bbcode->addCode('list', 'simple_replace', null, array('start_tag' => '<ul>', 'end_tag' => '</ul>'),
		 'list', array('block', 'listitem'), array());
		$this->Bbcode->addCode('*', 'simple_replace', null, array('start_tag' => '<li>', 'end_tag' => '</li>'),
		 'listitem', array('list'), array());

		//$this->Bbcode->addCode ('br', 'simple_replace', null, array ('start_tag' => '<br/>', 'end_tag' => ''),
		// 'linefeed', array ('block','inline','listitem'), array ());

		//$this->Bbcode->setCodeFlag ('br', 'closetag', BBCODE_CLOSETAG_FORBIDDEN);

		$this->Bbcode->setCodeFlag('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
		$this->Bbcode->setCodeFlag('*', 'paragraphs', false); // inside the <li> tags - <p> tags allowed?
		$this->Bbcode->setCodeFlag('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
		$this->Bbcode->setCodeFlag('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
		$this->Bbcode->setCodeFlag('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);

		# Does not work for HEADER and CODE:
		$this->Bbcode->setCodeFlag('code', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
		$this->Bbcode->setCodeFlag('code', 'closetag.after.newline', BBCODE_NEWLINE_DROP);
		$this->Bbcode->setCodeFlag('code', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
		$this->Bbcode->setCodeFlag('code', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
		$this->Bbcode->setCodeFlag('code', 'opentag.after.newline', BBCODE_NEWLINE_DROP);

		# Not good for us:
		//$this->Bbcode->setRootParagraphHandling (true);	// <br> into <p>

		$out = $this->Bbcode->parse($out);

		# Fixing Links (target="_blank" for external) + Img (internal/external)
		//$out = $this->parseImagesRecursive($out);	// not important

		# Highlighting
		if (!empty($options['highlight']) && $options['highlight'] === false) {
		} else {
			$out = $this->Geshi->parseTagsRecursive(($out));
		}

		#Smileys
		if (!empty($options['smiley']) && $options['smiley'] === true) {
		} else {
			//$out = $this->Common->parseSmileys($out);
}

		//$out = nl2br($out);
		return $out;
	}

	public function parseImagesRecursive($input) {
		$regex = '/<link\s+.*href\s*="(.*)">(.*)<\/link>/siU';
		//$regex = '/[code]\s+.*class\s*="(.*)">(.*)<[/code]/siU';
		//$regex = '/<pre\s+.*lang\s*="(.*)">(.*)<\/pre>/siU'; WORKS! for <pre></pre>

		// mit lang="": $regex = "/<pre\s+.*lang\s*=\"(.*)\">(.*)<\/pre>/siU";
 	// geht nicht: $regex = '#\<pre>((?:[^[]|\<(?!/?pre>)|(?R))+)\</pre>#';

 	if (is_array($input)) {
 		pr($input);
 		$input = '<a href="' . $link . '" ' . $target . '>' . $input[2] . '</a>';
			//$this->highlight(trim(html_entity_decode($this->entodec($input[2]),ENT_QUOTES)), $input[1], $flag);
 	//$input = '<div style="margin-left: 20px">'.$input[1].'</div>';
}

		return preg_replace_callback($regex, array(&$this, 'parseImagesRecursive'), $input);
	}

}

/** !!! Functions for BBCODE are set OUTSIDE of the class BbcodeHelper !!! **/

/*
// Alles bis auf Neuezeile-Zeichen entfernen
function bbcode_stripnewlines($text) {
 return str_replace ("\n", '\n\n', $text);
}
*/

// Neuezeile-Zeichen entfernen

function bbcode_stripcontents($text) {
	return preg_replace("/[^\n]/", '', $text);
}

/** TODO: action=validate for visitors */
function do_bbcode_url($action, $attributes, $content, $params, $nodeObject) {
	if (!isset($attributes['default'])) {
		$url = trim($content);
		$text = $content;
	} else {
		$url = trim($attributes['default']);
		$text = $content;
	}
	if ($action === 'validate') {
		if (substr($url, 0, 5) === 'data:' || substr($url, 0, 5) === 'file:'
 || substr($url, 0, 11) === 'javascript:' || substr($url, 0, 4) === 'jar:') {
			return false;
		}
		return true;
	}
	if (substr($url, 0, 1) === '/') {
		$url = Router::url($url); //substr($this->Url->build('/'),0,-1).$url;
		$target = '';
	} else {
		$url = (@substr($url) === 'http://' ? $url : 'http://' . $url);
		$target = ' target="_blank"';
	}
	return '<a href="' . h($url) . '"' . $target . '>' . h($text) . '</a>';
}

// Funktion zum Einbinden von Bildern

function do_bbcode_img($action, $attributes, $content, $params, $nodeObject) {
	if ($action === 'validate') {
		if (substr($content, 0, 5) === 'data:' || substr($content, 0, 5) === 'file:'
 || substr($content, 0, 11) === 'javascript:' || substr($content, 0, 4) === 'jar:') {
			return false;
		}
		return true;
	}
	return '<img src="' . h($content) . '" alt="">';
}

// Funktion zum Einbinden von Bildern

function do_bbcode_code($action, $attributes, $content, $params, $nodeObject) {
	if (!isset($attributes['default'])) {
		$class = 'text';
		$text = h($content);
	} else {
		$class = $attributes['default'];
		$text = $content;
	}
	return '<code class="' . $class . '">' . h($content) . '</code>';
}

function do_bbcode_email($action, $attributes, $content, $params, $nodeObject) {
	return 'vv';
}

function do_bbcode_nobb($action, $attributes, $content, $params, $nodeObject) {
	return h($content);
}

/*
function do_bbcode_br($action, $attributes, $content, $params, $nodeObject) {
 return '<br />';
}
*/
