<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/markup'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Djot to HTML</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a> |
<a href="https://github.com/php-collective/djot-php" target="_blank">[Djot-PHP]</a> |
<a href="https://djot.net" target="_blank">[Djot Spec]</a>

<p>
	<a href="https://djot.net" target="_blank">Djot</a> is a modern markup language created by John MacFarlane
	(author of CommonMark/Pandoc). It's designed to be unambiguous and easy to parse while remaining human-readable.
</p>

<h3>Using the DjotHelper</h3>
<p>Add the helper in your controller:</p>
<?php
$code = <<<'PHP'
// In your controller
public function myAction(): void
{
    $this->viewBuilder()->addHelper('Markup.Djot');
}
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<p>Then in your template:</p>
<?php
$code = <<<'PHP'
echo $this->Djot->convert($djotText);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h3>Examples</h3>

<h4>Basic Formatting</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
Some *strong* text and also some _emphasized_.
You can also use {=highlighted=} text and {-deleted-} or {+inserted+} text.
DJOT;
echo $this->Djot->convert($text);
?></div>

<h4>Links and Images</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
Visit [Djot website](https://djot.net) for more info.

![CakePHP Logo](https://cakephp.org/img/license_chiffon.svg){width=100}
DJOT;
echo $this->Djot->convert($text);
?></div>

<h4>Lists</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
Unordered list:

- First item
- Second item
  - Nested item
- Third item

Ordered list:

1. Step one
2. Step two
3. Step three

Task list:

- [x] Completed task
- [ ] Pending task
DJOT;
echo $this->Djot->convert($text);
?></div>

<h4>Code Blocks</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
Inline `code` works like this.

```php
// Code blocks with language hints
$converter = new DjotConverter();
echo $converter->convert($text);
```
DJOT;
echo $this->Djot->convert($text);
?></div>

<h4>Tables</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
{.table}
| Name   | Type   | Description         |
|--------|--------|---------------------|
| Djot   | Markup | Modern markup       |
| PHP    | Lang   | Server-side         |
| CakePHP| FW     | Rapid development   |
DJOT;
echo $this->Djot->convert($text);
?></div>

<h4>Blockquotes and Divs</h4>
<div class="code-snippet"><?php
$text = <<<'DJOT'
> This is a blockquote.
> It can span multiple lines.

::: warning
This is a custom div with the "warning" class.
:::
DJOT;
echo $this->Djot->convert($text);
?></div>

<h3>Configuration Options</h3>
<p>The helper accepts several options:</p>
<?php
$code = <<<'PHP'
// With safe mode (default: true) - filters dangerous content
echo $this->Djot->convert($text, ['safeMode' => true]);

// With a profile to restrict features
echo $this->Djot->convert($text, ['profile' => 'comment']);

// Strict mode - throws on parse errors
echo $this->Djot->convert($text, ['strict' => true]);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h3>Using DjotView</h3>
<p>
	For content-heavy pages, you can use <code>DjotView</code> to write templates directly in Djot format.
	See <?php echo $this->Html->link('DjotView demo', ['action' => 'djotView']); ?> for an example.
</p>

<?php
$code = <<<'PHP'
// In your controller
public function documentation(): void
{
    $this->viewBuilder()->setClassName('Markup.Djot');
    $this->set('version', '1.0');
}

// Create templates/MyController/documentation.djot
// Use {{version}} for variable substitution
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

</div></div>
