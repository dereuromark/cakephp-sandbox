<?php
/**
 * @var \App\View\AppView $this
 */
use Ciconia\Ciconia;
use Ciconia\Extension\Gfm\FencedCodeBlockExtension;
use Ciconia\Extension\Gfm\InlineStyleExtension;
use Ciconia\Extension\Gfm\TableExtension;
use Ciconia\Extension\Gfm\TaskListExtension;
use Ciconia\Extension\Gfm\UrlAutoLinkExtension;
use Ciconia\Extension\Gfm\WhiteSpaceExtension;
?>

<h2>Markdown</h2>

<h3>Basics</h3>
<?php
$code = <<<PHP
\$ciconia = new Ciconia();
\$html = \$ciconia->render('Markdown is **awesome**');
PHP;
echo pre(h($code));
?>
Result:
<?php
$ciconia = new Ciconia();
$html = $ciconia->render('Markdown is **awesome**');
echo pre(h($html));

?>


<h3>More</h3>
<?php
$markdown = <<<MD
# Header
Paragraph *foo bar* x

1. foo

	```
	Code?
	```

2. bar

Another one

**Article**: description
**Another one**: something-something

(*My italic text*)

( *My italic text*)

- foo

	```
	Code?
	```
- bar
	dd
	dd
	- sec
		- third
			- forth
				- fith
					- sixth
						- seventh
- zzz

## Subheader
```php
<?php phpinfo(); ?>
```
Some [link](http://www.xyz.de).

MD;

echo pre(h($markdown));

echo 'And adding several extensions:';

$ciconia = new Ciconia();
$ciconia->addExtension(new FencedCodeBlockExtension());
$ciconia->addExtension(new TaskListExtension());
$ciconia->addExtension(new InlineStyleExtension());
$ciconia->addExtension(new WhiteSpaceExtension());
$ciconia->addExtension(new TableExtension());
$ciconia->addExtension(new UrlAutoLinkExtension());
$ciconia->removeExtension('paragraph');
$ciconia->addExtension(new \Ciconia\Extension\Core\ParagraphExtension());
$ciconia->removeExtension('header');
$ciconia->addExtension(new \Ciconia\Extension\Core\HeaderExtension());

$html = $ciconia->render($markdown, ['geshi' => true, 'nestedTagLevel' => 5]);
echo pre(h($html));

//echo $html;
