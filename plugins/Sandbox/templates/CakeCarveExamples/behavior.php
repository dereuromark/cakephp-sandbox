<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $data
 * @var array<string, mixed>|null $row
 */

echo $this->element('cake_carve/highlighting');

$languages = ['body' => 'carve', 'body_html' => 'html', 'body_toc' => 'json'];
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake_carve'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Behavior</h3>
	<p>
		<code>CarveBehavior</code> renders a source field into HTML, plain text and table-of-contents fields on save.
		This demo saves into a throwaway in-memory SQLite table, so nothing is kept between requests.
	</p>

	<?php echo $this->Form->create(null); ?>
	<?php echo $this->Form->control('body', ['type' => 'textarea', 'value' => $data['body'], 'rows' => 6]); ?>
	<?php echo $this->Form->button('Save', ['class' => 'btn btn-primary']); ?>
	<?php echo $this->Form->end(); ?>

	<?php if ($row !== null) { ?>
		<h4 class="mt-3">Saved row</h4>
		<?php foreach ($row as $column => $value) { ?>
			<h5 class="h6 mt-2"><code><?php echo h($column); ?></code></h5>
			<?php
			$text = is_array($value) ? (string)json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : (string)$value;
			echo $this->element('cake_carve/code', ['code' => $text, 'lang' => $languages[$column] ?? 'plaintext']);
			?>
		<?php } ?>
	<?php } ?>

	<h3 class="mt-4">Behavior config</h3>
	<?php echo $this->element('cake_carve/code', ['code' => <<<'PHP'
$this->addBehavior('MarkupCarve/CakeCarve.Carve', [
	'fields' => [
		'body' => ['target' => 'body_html', 'text' => 'body_text', 'toc' => 'body_toc'],
	],
]);
PHP, 'lang' => 'php']); ?>

</div>
</div>
