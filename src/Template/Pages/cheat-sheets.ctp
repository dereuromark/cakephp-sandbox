<h2>Cheat-Sheets</h2>
Updated 2011/01

<?php
	$url = $this->Url->build('/cheat_sheets', true);
?>

<style type="text/css">
ul.files {
	list-style: none;
}
ul.files li {
	float: left;
	margin: 5px;
	padding: 5px;
	border: 1px solid gray;
}

</style>

Main:
<ul class="files">
<li>PHP <a href="<?php echo $url; ?>/php-cheat-sheet-v2.pdf"><?php echo $this->Html->image('statics/file_types/php.png');?></a></li>
<li>MYSQL <a href="<?php echo $url; ?>/mysql-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/mysql.png');?></a></li>
<li>CSS <a href="<?php echo $url; ?>/css-cheat-sheet-v2.pdf"><?php echo $this->Html->image('statics/file_types/css.png');?></a></li>
<li>JS <a href="<?php echo $url; ?>/javascript-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/js.png');?></a></li>
<li>HTML <a href="<?php echo $url; ?>/html-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/html.png');?></a></li>
<li>SVN <a href="<?php echo $url; ?>/subversion-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/subversion.png');?></a></li>
</ul>
<br class="clear"/>

Other:
<ul class="files">
<li>Entities <a href="<?php echo $url; ?>/html-character-entities-cheat-sheet.pdf"><?php echo $this->Html->image('statics/file_types/character-entities.png');?></a></li>
<li>RegExp <a href="<?php echo $url; ?>/regular-expressions-cheat-sheet-v2.pdf"><?php echo $this->Html->image('statics/file_types/reg-exp.png');?></a></li>
<li>ModRewrite <a href="<?php echo $url; ?>/mod_rewrite-cheat-sheet-v2.pdf"><?php echo $this->Html->image('statics/file_types/mod-rewrite.gif');?></a></li>
<li>RGB/Hex <a href="<?php echo $url; ?>/rgb-hex-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/rgb-hex.png');?></a></li>
<li>RnR <a href="<?php echo $url; ?>/ruby-on-rails-cheat-sheet-v1.pdf"><?php echo $this->Html->image('statics/file_types/rb.png', ['title' => 'Ruby on Rails']);?></a></li>

</ul>

<br class="clear"/>

<h2>Powered by</h2>
<a href="http://www.addedbytes.com/cheat-sheets/" target="_blank">addedbytes.com</a>