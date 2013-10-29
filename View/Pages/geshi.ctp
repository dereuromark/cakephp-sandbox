<?php // geshi.ctp ?>
<h1>Sweet, "Myapp" got Baked by CakePHP!</h1>



<br/><br/>
ssss:
<?php

$text='$foo = 45;
for ( $i = 1; $i < $foo; $i++ )
{
 echo "$foo<br />\n";
 --$foo;
 echo \'sss\';
}
for ( $i = 1; $i < $foo; $i++ )
{
 echo "$foo<br />\n";
 --$foo;
 echo \'sss\';
}
for ( $i = 1; $i < $foo; $i++ )
{
 echo "$foo<br />\n";
 --$foo;
 echo \'sss\';
}';

$language='php-brief';
$flag='fancy';

echo $this->Geshi->geshi_highlight($text, $language, $flag);




$text='<div id="container">sdl fhsodf dsf sdif sdpif hsdoöfhosdf oösdf sdf ds fdsf dsf dsf ods fdsf dsf dsf ds fosd f
		<div id="header">
			<h1><a href="http://cakephp.org">CakePHP: the rapid development php framework</a></h1>
		</div>
		<div id="content">';

$language='html4strict';
$flag='fancy';

echo 'oder so:'.$this->Geshi->geshi_highlight($text, $language, $flag)


?>