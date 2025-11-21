<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\DemoArticle $translatedArticle
 * @var string $locale
 * @var array<string, string> $availableLocales
 * @var array<array<string, mixed>> $queries
 */
?>

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Translate Behavior</h2>
<p>
	The Translate Behavior allows you to create and retrieve translated versions of your entities
	in multiple languages. Perfect for building multilingual applications.
</p>

<h3>Live Translation Demo</h3>
<p>Select a language to see the same article content in different translations:</p>

<div class="card mb-4">
	<div class="card-header bg-primary text-white">
		<h4 class="mb-0">Language Selector</h4>
	</div>
	<div class="card-body">
		<div class="btn-group" role="group">
			<?php foreach ($availableLocales as $localeCode => $localeName) { ?>
				<?php
				$buttonClass = $locale === $localeCode ? 'btn-primary' : 'btn-outline-primary';
				?>
				<?= $this->Html->link(
					$localeName,
					['action' => 'translateBehavior', '?' => ['locale' => $localeCode]],
					['class' => 'btn ' . $buttonClass]
				) ?>
			<?php } ?>
		</div>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header bg-success text-white">
		<h4 class="mb-0">
			<?= $this->Html->icon('translate') ?>
			Translated Content - <?= h($availableLocales[$locale]) ?>
		</h4>
	</div>
	<div class="card-body">
		<h3><?= h($translatedArticle->title) ?></h3>
		<p class="lead"><?= h($translatedArticle->content) ?></p>
		<hr>
		<small class="text-muted">
			<strong>Current Locale:</strong> <code><?= h($locale) ?></code>
		</small>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header bg-info text-white">
		<h4 class="mb-0">
			<?= $this->Html->icon('code') ?>
			SQL Queries Executed
		</h4>
	</div>
	<div class="card-body">
		<p class="text-muted">These queries show how TranslateBehavior retrieves translated content using the shadow table:</p>
		<?php foreach ($queries as $index => $query) { ?>
			<div class="mb-3">
				<strong>Query <?= $index + 1 ?>:</strong>
				<small class="text-muted">(<?= number_format($query['took'], 1) ?> ms)</small>
				<pre class="bg-light p-3 rounded"><code class="language-sql"><?= h($query['query']) ?></code></pre>
			</div>
		<?php } ?>
	</div>
</div>

<h3>Setup Instructions</h3>

<div class="alert alert-info mb-4">
	<strong>Translation Strategies:</strong> CakePHP's TranslateBehavior supports two main approaches:
	<ul class="mb-0">
		<li><strong>Shadow Table</strong> (shown here): Parallel table with same structure as main table plus locale</li>
		<li><strong>EAV/I18n Table</strong> (default): Shared table using Entity-Attribute-Value pattern</li>
	</ul>
	This example demonstrates the shadow table strategy for better query performance and clarity.
</div>

<h4>1. Create Database Tables</h4>
<p>Create your main table and a shadow translation table with matching structure:</p>

<?php
$code = <<<'PHP'
// Migration: demo_articles table
$table = $this->table('demo_articles');
$table->addColumn('title', 'string', ['limit' => 255, 'null' => false]);
$table->addColumn('content', 'text', ['null' => false]);
$table->addColumn('status', 'string', ['limit' => 255, 'null' => false]);
$table->addColumn('created', 'datetime', ['null' => false]);
$table->addColumn('modified', 'datetime', ['null' => false]);
$table->create();

// Migration: demo_articles_translations (shadow table with matching fields + locale)
$translationsTable = $this->table('demo_articles_translations', [
    'id' => false,
    'primary_key' => ['id', 'locale'],
]);
$translationsTable->addColumn('id', 'integer', ['null' => false]);
$translationsTable->addColumn('locale', 'string', ['limit' => 6, 'null' => false]);
$translationsTable->addColumn('title', 'string', ['limit' => 255, 'null' => true]);
$translationsTable->addColumn('content', 'text', ['null' => true]);
$translationsTable->create();
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h4>2. Add Translate Behavior to Your Table</h4>
<p>In your Table class <code>initialize()</code> method, configure the shadow table:</p>

<?php
$code = <<<'PHP'
public function initialize(array $config): void {
    parent::initialize($config);

    // TranslateBehavior will automatically detect and use the shadow table
    // if a table named {table_name}_translations exists with the right structure
    $this->addBehavior('Translate', [
        'fields' => ['title', 'content'],  // Fields to translate
    ]);
}
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h4>3. Save Translations</h4>
<p>When creating or updating an entity, provide translations using <code>_translations</code>:</p>

<?php
$code = <<<'PHP'
$article = $articlesTable->newEntity([
    'title' => 'Welcome',  // Default language (en)
    'content' => 'This is the content in English.',
    'status' => 'published',
    '_translations' => [
        'de' => [
            'title' => 'Willkommen',
            'content' => 'Dies ist der Inhalt auf Deutsch.',
        ],
        'es' => [
            'title' => 'Bienvenido',
            'content' => 'Este es el contenido en español.',
        ],
    ],
]);

$articlesTable->save($article);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h4>4. Retrieve Translated Content</h4>
<p>Use the <code>translations</code> finder with the desired locale:</p>

<?php
$code = <<<'PHP'
// Set application locale
I18n::setLocale('de');

// Find article - automatically returns German translation
$article = $articlesTable->get($id);
echo $article->title; // Output: "Willkommen"

// Or use the finder explicitly
$article = $articlesTable->find('translations', [
    'locales' => 'de'  // Locale as string
])->where(['id' => $id])->first();
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h4>5. Update Existing Translations</h4>
<p>Patch the entity with new translation data:</p>

<?php
$code = <<<'PHP'
$article = $articlesTable->get($id);

$article = $articlesTable->patchEntity($article, [
    '_translations' => [
        'fr' => [
            'title' => 'Bienvenue',
            'content' => 'Ceci est le contenu en français.',
        ],
    ],
]);

$articlesTable->save($article);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h3>Advanced Features</h3>

<div class="accordion mb-4" id="advancedFeatures">
	<div class="accordion-item">
		<h2 class="accordion-header">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#referenceName">
				Alternative: Using Shared I18n Table
			</button>
		</h2>
		<div id="referenceName" class="accordion-collapse collapse" data-bs-parent="#advancedFeatures">
			<div class="accordion-body">
				<p>Instead of a dedicated table, you can use the shared <code>i18n</code> table (default):</p>
<?php
$code = <<<'PHP'
// First, run migration: bin/cake migrations migrate -p CakeDC/I18n
$this->addBehavior('Translate', [
    'fields' => ['title', 'content'],
    // 'translationTable' => 'I18n',  // This is the default if omitted
]);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>
				<p class="text-muted mb-0">
					<small>The shared i18n table is simpler to set up but dedicated tables offer better organization.</small>
				</p>
			</div>
		</div>
	</div>

	<div class="accordion-item">
		<h2 class="accordion-header">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#strategy">
				Translation Strategy
			</button>
		</h2>
		<div id="strategy" class="accordion-collapse collapse" data-bs-parent="#advancedFeatures">
			<div class="accordion-body">
				<p>Choose between <code>subquery</code> (default), <code>join</code>, or <code>select</code> strategy:</p>
<?php
$code = <<<'PHP'
$this->addBehavior('Translate', [
    'fields' => ['title', 'content'],
    'strategy' => 'join',  // More efficient for single locale
]);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>
			</div>
		</div>
	</div>

	<div class="accordion-item">
		<h2 class="accordion-header">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#allowEmpty">
				Allow Empty Translations
			</button>
		</h2>
		<div id="allowEmpty" class="accordion-collapse collapse" data-bs-parent="#advancedFeatures">
			<div class="accordion-body">
				<p>Control whether to allow empty translation fields:</p>
<?php
$code = <<<'PHP'
$this->addBehavior('Translate', [
    'fields' => ['title', 'content'],
    'allowEmptyTranslations' => false,  // Don't save empty values
]);
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>
			</div>
		</div>
	</div>
</div>

<div class="alert alert-info">
	<h5><?= $this->Html->icon('info-circle') ?> Tips</h5>
	<ul class="mb-0">
		<li>Default locale translations (text in original language) are still stored in the main table (nothing changes)</li>
		<li>Non-default locales are stored in the shadow table (same structure + locale)</li>
		<li>Shadow tables provide better query performance than EAV/i18n tables</li>
		<li>Use <code>I18n::setLocale()</code> to set the application-wide locale</li>
		<li>The behavior automatically filters results based on the current locale</li>
		<li>Translations are loaded lazily - only when needed</li>
		<li>CakePHP auto-detects shadow tables if named <code>{table}_translations</code></li>
	</ul>
</div>

</div>
</div>
