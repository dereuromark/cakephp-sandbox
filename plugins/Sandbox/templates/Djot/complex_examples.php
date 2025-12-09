<?php
/**
 * @var \App\View\AppView $this
 * @var string $djot
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-djot.js');
$this->end();

$examples = [
	'Image with Caption' => [
		'description' => 'Images can have captions using the ^ syntax.',
		'code' => <<<'DJOT'
![RSS Logo](/img/statics/logo_rss.png)

^ The logo used for this website
DJOT,
	],
	'Attributed Quotes' => [
		'description' => 'Blockquotes with author attribution using figure/figcaption.',
		'code' => <<<'DJOT'
> To be or not to be,
> that is the question.
>
> Whether 'tis nobler in the mind to suffer
> the slings and arrows of outrageous fortune...

^ William Shakespeare, *Hamlet*
DJOT,
	],
	'Table with Caption' => [
		'description' => 'Tables support captions and column alignment.',
		'code' => <<<'DJOT'
| Feature | Markdown | Djot |
|:--------|:--------:|-----:|
| Emphasis | `*text*` | `_text_` |
| Strong | `**text**` | `*text*` |
| Strikethrough | `~~text~~` | `{-text-}` |
| Highlight | N/A | `{=text=}` |

^ Syntax comparison between Markdown and Djot
DJOT,
	],
	'Definition List (Multiple Terms)' => [
		'description' => 'Multiple terms can share a single definition.',
		'code' => <<<'DJOT'
: Djot

  A lightweight markup language designed by John MacFarlane,
  creator of Pandoc and CommonMark.

: Markdown
: CommonMark
: GFM

  Earlier markup languages that inspired Djot's design,
  but with less consistent parsing rules.
DJOT,
	],
	'Nested Lists' => [
		'description' => 'Complex nested lists with mixed markers and content blocks.',
		'code' => <<<'DJOT'
1. First level item

   - Nested bullet point
   - Another bullet

     1. Third level numbered
     2. With continuation

        Paragraph inside list item.

   - Back to second level

2. Continue first level

   > Blockquote inside list
DJOT,
	],
	'Divs with Attributes' => [
		'description' => 'Custom divs with classes and IDs for styling.',
		'code' => <<<'DJOT'
{.warning #important-notice}
:::
## Warning

This is an important notice with custom styling.

- Point one
- Point two
:::

::: note
A simple note div.
:::
DJOT,
	],
	'Spans with Attributes' => [
		'description' => 'Inline spans for custom styling and IDs.',
		'code' => <<<'DJOT'
This has [highlighted text]{.highlight} and
[a specific term]{#glossary-term .term} that can be styled.

You can also use [multiple classes]{.class1 .class2} on spans.
DJOT,
	],
	'Footnotes' => [
		'description' => 'Footnotes with references.',
		'code' => <<<'DJOT'
Here is a sentence with a footnote[^1] and another[^note2].

Regular paragraph continues here.

[^1]: Simple footnote content.

[^note2]: A longer footnote with more detail about the topic.
DJOT,
	],
	'Task Lists' => [
		'description' => 'Interactive task/checkbox lists.',
		'code' => <<<'DJOT'
- [ ] Uncompleted task
- [x] Completed task
- [ ] Another pending item

  With additional content under the task.

- [x] Final completed item
DJOT,
	],
	'Superscript & Subscript' => [
		'description' => 'Scientific notation and chemical formulas.',
		'code' => <<<'DJOT'
Einstein's famous equation: E = mc^2^

Water molecule: H~2~O

The 10^th^ power of 2 is 2^10^ = 1024

Carbon dioxide: CO~2~
DJOT,
	],
	'All Inline Formatting' => [
		'description' => 'Complete inline formatting showcase.',
		'code' => <<<'DJOT'
- *strong text* (bold)
- _emphasized text_ (italic)
- *_strong and emphasized_*
- {+inserted text+} (underline)
- {-deleted text-} (strikethrough)
- {=highlighted text=} (mark)
- `inline code`
- H~2~O (subscript)
- x^2^ (superscript)
- [Link text](https://djot.net)
- ![Alt text](/img/cake.icon.png)
DJOT,
	],
	'Line Blocks' => [
		'description' => 'Preserve line breaks for poetry or addresses.',
		'code' => <<<'DJOT'
| The road not taken
| Two roads diverged in a yellow wood,
| And sorry I could not travel both
| And be one traveler, long I stood
| And looked down one as far as I could
| To where it bent in the undergrowth;
|
| --- _Robert Frost_
DJOT,
	],
	'Code Blocks with Info' => [
		'description' => 'Fenced code blocks with language hints.',
		'code' => <<<'DJOT'
``` php
<?php
declare(strict_types=1);

namespace App\Controller;

class ArticlesController extends AppController
{
    public function index(): void
    {
        $articles = $this->Articles->find()
            ->orderBy(['created' => 'DESC'])
            ->limit(10)
            ->toArray();

        $this->set(compact('articles'));
    }
}
```

``` sql
SELECT users.name, COUNT(posts.id) as post_count
FROM users
LEFT JOIN posts ON posts.user_id = users.id
GROUP BY users.id
ORDER BY post_count DESC;
```
DJOT,
	],
	'Thematic Breaks' => [
		'description' => 'Section dividers with different styles.',
		'code' => <<<'DJOT'
First section content.

---

Second section after thematic break.

***

Third section with asterisk break.
DJOT,
	],
	'Reference Links' => [
		'description' => 'Links and images using reference-style definitions.',
		'code' => <<<'DJOT'
Check out [Djot's homepage][djot] or the [PHP implementation][php-djot].

You can also use [implicit][] references.

[djot]: https://djot.net "Djot Markup Language"
[php-djot]: https://github.com/php-collective/djot-php
[implicit]: https://example.com
DJOT,
	],
	'Hard Line Breaks' => [
		'description' => 'Force line breaks within paragraphs.',
		'code' => <<<'DJOT'
This is line one\
This is line two\
This is line three

All in the same paragraph but on separate lines.
DJOT,
	],
	'Nested Blockquotes' => [
		'description' => 'Blockquotes can be nested multiple levels deep.',
		'code' => <<<'DJOT'
> Level 1 quote
>
> > Level 2 nested quote
> >
> > > Level 3 deeply nested
>
> Back to level 1
DJOT,
	],
	'Auto-links & Email' => [
		'description' => 'URLs and emails in angle brackets become clickable links.',
		'code' => <<<'DJOT'
Visit <https://djot.net> for the official spec.

Contact us at <info@example.com> for support.

Or use regular [link syntax](https://example.com).
DJOT,
	],
	'Smart Typography' => [
		'description' => 'Automatic smart quotes, dashes, and ellipsis.',
		'code' => <<<'DJOT'
"Smart quotes" and 'apostrophes' are automatic.

En-dash for ranges: 1--10, pages 5--20.

Em-dash for breaks---like this one.

Ellipsis... becomes a single character.
DJOT,
	],
	'Escaped Characters' => [
		'description' => 'Use backslash to show literal special characters.',
		'code' => <<<'DJOT'
Show literal \*asterisks\* without emphasis.

And \_underscores\_ without formatting.

Also \`backticks\` and \[brackets\].
DJOT,
	],
	'Comments (Hidden)' => [
		'description' => 'Comments that do not appear in the output.',
		'code' => <<<'DJOT'
This text is visible.

{% This comment will not appear in the output %}

This text is also visible.
DJOT,
	],
	'Link with Attributes' => [
		'description' => 'Links can have classes, IDs, and other attributes.',
		'code' => <<<'DJOT'
Click [this styled link](https://example.com){.btn .btn-primary}.

Open [in new tab](https://djot.net){target=_blank}.

A [special link](https://example.com){#my-link .highlight title="Hover me"}.
DJOT,
	],
	'Heading with ID' => [
		'description' => 'Custom IDs and classes on headings for linking.',
		'code' => <<<'DJOT'
{#intro .chapter}
## Introduction

This section can be linked with [jump to intro](#intro).

{#conclusion}
## Conclusion

And this with [jump to conclusion](#conclusion).
DJOT,
	],
];

/**
 * Encode djot for URL sharing (matches JS compress function)
 */
function encodeDjot(string $djot): string {
	return base64_encode($djot);
}
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Complex Djot Examples</h2>
<p>
	Advanced examples showcasing Djot's powerful features.
	Click "Try it" to open each example in the playground.
</p>

<div class="row">
<?php foreach ($examples as $title => $example) { ?>
<div class="col-md-6 mb-3">
	<div class="card h-100">
		<div class="card-header d-flex justify-content-between align-items-center py-2">
			<strong><?= h($title) ?></strong>
			<?= $this->Html->link(
				'<i class="bi bi-play-circle"></i> Try',
				['action' => 'index', '?' => ['d' => encodeDjot($example['code'])]],
				['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
			) ?>
		</div>
		<div class="card-body py-2">
			<p class="text-muted small mb-2"><?= h($example['description']) ?></p>
			<pre class="bg-light p-2 border rounded mb-0" style="max-height: 200px; overflow-y: auto;"><code class="language-djot"><?= h($example['code']) ?></code></pre>
		</div>
	</div>
</div>
<?php } ?>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
document.querySelectorAll('pre code.language-djot').forEach(el => {
	hljs.highlightElement(el);
});
<?php $this->Html->scriptEnd(); ?>
