<?php

namespace Sandbox\Controller;

use Cake\Collection\Collection;
use Cake\Database\ValueBinder;
use Cake\Datasource\Paging\SortableFieldsBuilder;
use Cake\Datasource\Paging\SortField;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\RedirectException;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Doctrine\SqlFormatter\NullHighlighter;
use Doctrine\SqlFormatter\SqlFormatter;
use Psr\Log\LoggerInterface;
use Sandbox\Controller\Paginator\CollectionPaginator;
use Sandbox\Model\Enum\UserStatus;
use Sandbox\Model\Table\ProductsTable;
use Stringable;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class CakeExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function enums() {
		if ($this->request->is(['post', 'put'])) {
			$enum = UserStatus::from((int)$this->request->getData('status'));
			$this->Flash->info('Value posted: `' . $this->request->getData('status') . '` (`' . $enum->label() . '`)');
		}

		$user = $this->fetchTable('Sandbox.SandboxUsers')->find()->first();
		if (!$user) {
			$user = $this->fetchTable('Sandbox.SandboxUsers')->newEntity([
				'username' => 'Example',
				'slug' => 'example',
				'email' => 'example@example.de',
				'password' => '',
			]);
			$this->fetchTable('Sandbox.SandboxUsers')->saveOrFail($user);

			return $this->redirect([]);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function enumValidation() {
		$table = $this->fetchTable('Sandbox.SandboxUsers');
		$table->getValidator()->add('status', 'validEnum', [
			'rule' => ['enumOnly', [UserStatus::Active, UserStatus::Inactive]],
			'message' => 'Invalid enum value.',
		]);

		$user = $table->newEmptyEntity();

		if ($this->request->is(['post', 'put'])) {
			$user = $table->patchEntity($user, $this->request->getData());
			$value = $this->request->getData('status');
			$label = UserStatus::tryFrom((int)$value)?->label();
			if (!$user->getErrors()) {
				$this->Flash->success('Value posted: `' . $value . '` (`' . $label . '`)');
			} else {
				$this->Flash->error('Value posted: `' . $value . '` (`' . $label . '`)');
			}
		}

		$this->set(compact('user'));
	}

	/**
	 * @return void
	 */
	public function queryStrings() {
	}

	/**
	 * @return void
	 */
	public function merge() {
		$array = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper2b' => 'value2b'],
				'deep2' => ['deeper1', 'deeper2'],
				'deep3' => 'stringX',
			],
		];
		$mergeArray = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper3b' => 'value3b'],
				'deep2' => ['deeper1', 'deeper3'],
				'deep3' => 'stringY',
			],
		];

		$result = null;
		$type = $this->request->getQuery('type');
		$result = null;
		if ($type) {
			switch ($type) {
				case 'hash':
					$result = Hash::merge($array, $mergeArray);

					break;
				case 'array_merge':
					$result = array_merge($array, $mergeArray);

					break;
				case 'array_merge_recursive':
					$result = array_merge_recursive($array, $mergeArray);

					break;
				default:
					throw new NotFoundException('Invalid merge type');
			}
		}

		$this->set(compact('array', 'mergeArray', 'result'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function i18n() {
		// Make sure we have defaults set to I18n if language has been switched previously
		$lang = $this->request->getSession()->read('Config.language');
		if ($lang) {
			I18n::setLocale($lang);
		} else {
			$this->request->getSession()->write('Config.language', 'en');
		}

		// Language switcher
		if ($this->request->is('post')) {
			$lang = (string)$this->request->getQuery('lang');
			$this->request->getSession()->write('Config.language', $lang);
			I18n::setLocale($lang);
			$lang = locale_get_display_name($lang) . ' [' . strtoupper($lang) . ']';
			$this->Flash->success(__('Language switched to {0}.', h($lang)), ['escape' => false]);

			return $this->redirect(['action' => 'i18n']);
		}
	}

	/**
	 * Test validation on marshal and rules on save.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function validation() {
		$Animals = $this->fetchTable('Sandbox.Animals');

		$animal = $Animals->newEmptyEntity();

		if ($this->request->is('post')) {
			$animal = $Animals->patchEntity($animal, $this->request->getData());

			// Simulate $Animals->save($animal) call as we don't want to really save here
			if (!$animal->getErrors() & $Animals->checkRules($animal)) {
				$this->Flash->success('Yeah, entry would have been saved.');

				return $this->redirect(['action' => 'validation']);
			}

			$this->Flash->error('Please correct your form content.');
		}

		$this->set(compact('animal'));
	}

	/**
	 * @return void
	 */
	public function paginateNonDatabase() {
		$items = [
			[
				'title' => 'One',
			],
			[
				'title' => 'Two',
			],
			[
				'title' => 'Three',
			],
			[
				'title' => 'Four',
			],
			[
				'title' => 'Five',
			],
			[
				'title' => 'Six',
			],
		];
		$collection = new Collection($items);

		$paginator = new CollectionPaginator($this->request->getQuery() + ['limit' => 5]);
		$results = $paginator->paginate($collection);

		/*
		$params = [
			'count' => $collection->count(),
			...
		];
		$results = new PaginatedResultSet($collection, $params);
		*/

		$this->set(compact('results'));
	}

	/**
	 * CakePHP 5.3 feature: Combined sort pagination
	 * Allows sorting with direction included in the sort key (e.g., 'title-asc' or 'created-desc')
	 *
	 * Example URL: ?sort=title-asc,created-desc
	 *
	 * @return void
	 */
	public function paginateCombinedSort() {
		$productsTable = $this->fetchTable('Sandbox.Products');

		// Ensure demo data exists with randomized prices and timestamps
		$this->_ensurePaginationDemoData($productsTable);

		// CakePHP 5.3: Use SortableFieldsBuilder via callable
		$this->paginate = [
			'sortableFields' => function (SortableFieldsBuilder $builder) {
				return $builder
					->add('title')
					// Lock price to ascending only (for demo purposes)
					->add('price', SortField::asc('price', locked: true))
					->add('stock')
					->add('created')
					->add('modified', SortField::desc('modified'))
					// Custom multi-column sort: expensive items first (DESC only, locked)
					->add('expensive', SortField::desc('price', locked: true), SortField::desc('created', locked: true))
					// Custom multi-column sort: availability (price + stock, not locked, can toggle)
					->add('availability', 'price', 'stock');
			},
			'limit' => 10,
			'maxLimit' => 10,
		];

		$query = $productsTable->find();
		$products = $this->paginate($query);

		// Extract the actual SQL ORDER BY clause from the paginated query
		$orderClause = '';
		/** @var \Cake\Database\Expression\OrderByExpression $order */
		$order = $query->clause('order');
		if ($order) {
			// Use sql() method to get the full ORDER BY clause, then strip "ORDER BY " prefix
			$binder = new ValueBinder();
			$orderSql = $order->sql($binder);
			$orderClause = preg_replace('/^ORDER BY /', '', $orderSql);
		}

		$this->set(compact('products', 'orderClause'));
	}

	/**
	 * CakePHP 5.3 feature: Rate Limit Demo
	 * Demonstrates request rate limiting
	 *
	 * @return void
	 */
	public function rateLimiter() {
		$requestCount = (int)$this->request->getSession()->read('rateLimiterRequestCount', 0);
		$requestCount++;
		$this->request->getSession()->write('rateLimiterRequestCount', $requestCount);

		$this->set(compact('requestCount'));
	}

	/**
	 * @return void
	 */
	public function translateBehavior() {
		$articlesTable = $this->fetchTable('Sandbox.DemoArticles');

		// Get current locale from query string or default to 'en'
		$locale = $this->request->getQuery('locale', 'en');

		// Ensure sample data exists
		$article = $this->_ensureDemoArticle();

		// Set up query logging to show how translations work
		$queries = [];
		$this->_enableQueryLogging($queries);

		// Set the locale before fetching - this tells TranslateBehavior which translation to use
		I18n::setLocale($locale);

		// Fetch article - TranslateBehavior will automatically return the translated version
		$translatedArticle = $articlesTable->get($article->id);

		// Process queries: filter and format
		$this->_processQueries($queries);

		$availableLocales = [
			'en' => 'English',
			'de' => 'Deutsch (German)',
			'es' => 'Español (Spanish)',
			'fr' => 'Français (French)',
		];

		$this->set(compact('article', 'translatedArticle', 'locale', 'availableLocales', 'queries'));
	}

	/**
	 * Ensure a demo article with translations exists
	 *
	 * @return \Sandbox\Model\Entity\DemoArticle
	 */
	protected function _ensureDemoArticle() {
		$articlesTable = $this->fetchTable('Sandbox.DemoArticles');

		$article = $articlesTable->find()
			->where(['DemoArticles.status' => 'published'])
			->first();

		if (!$article) {
			// Create article in English (default)
			$article = $articlesTable->newEntity([
				'title' => 'Welcome to CakePHP',
				'content' => 'CakePHP is a rapid development framework for PHP that provides an extensible architecture for developing, maintaining, and deploying applications.',
				'status' => 'published',
				'_translations' => [
					'de' => [
						'title' => 'Willkommen bei CakePHP',
						'content' => 'CakePHP ist ein Framework für die schnelle Entwicklung von PHP-Anwendungen, das eine erweiterbare Architektur für die Entwicklung, Wartung und Bereitstellung von Anwendungen bietet.',
					],
					'es' => [
						'title' => 'Bienvenido a CakePHP',
						'content' => 'CakePHP es un framework de desarrollo rápido para PHP que proporciona una arquitectura extensible para desarrollar, mantener e implementar aplicaciones.',
					],
					'fr' => [
						'title' => 'Bienvenue sur CakePHP',
						'content' => 'CakePHP est un framework de développement rapide pour PHP qui fournit une architecture extensible pour développer, maintenir et déployer des applications.',
					],
				],
			]);
			$articlesTable->saveOrFail($article);
		}

		return $article;
	}

	/**
	 * Enable query logging for demonstration purposes
	 *
	 * @param array $queries Array to store queries (passed by reference)
	 * @return void
	 */
	protected function _enableQueryLogging(array &$queries): void {
		$articlesTable = $this->fetchTable('Sandbox.DemoArticles');
		$connection = $articlesTable->getConnection();
		$logger = new class ($queries) implements LoggerInterface {
			/**
			 * @param array<array<string, mixed>> $queries
			 */
			public function __construct(
				protected array &$queries,
			) {
			}

			/**
			 * @param mixed $level
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function log(mixed $level, string|Stringable $message, array $context = []): void {
				$query = $context['query'];
				// @phpstan-ignore typePerfect.noMixedMethodCaller
				$took = $query->getContext()['took'];

				$this->queries[] = [
					'query' => (string)$message,
					'took' => $took,
				];
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function emergency(string|Stringable $message, array $context = []): void {
				$this->log('emergency', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function alert(string|Stringable $message, array $context = []): void {
				$this->log('alert', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function critical(string|Stringable $message, array $context = []): void {
				$this->log('critical', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function error(string|Stringable $message, array $context = []): void {
				$this->log('error', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function warning(string|Stringable $message, array $context = []): void {
				$this->log('warning', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function notice(string|Stringable $message, array $context = []): void {
				$this->log('notice', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function info(string|Stringable $message, array $context = []): void {
				$this->log('info', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array $context
			 * @return void
			 */
			public function debug(string|Stringable $message, array $context = []): void {
				$this->log('debug', $message, $context);
			}
		};

		$connection->getDriver()->setLogger($logger);
	}

	/**
	 * Process queries: filter out schema introspection and format SQL
	 *
	 * @param array $queries Array of queries (passed by reference)
	 * @return void
	 */
	protected function _processQueries(array &$queries): void {
		// Filter out schema introspection queries
		$queries = array_values(array_filter($queries, function ($query) {
			return stripos($query['query'], 'information_schema') === false
				&& stripos($query['query'], 'SHOW FULL COLUMNS') === false
				&& stripos($query['query'], 'SHOW INDEXES') === false
				&& stripos($query['query'], 'SHOW TABLE STATUS') === false;
		}));

		// Format SQL queries for better readability
		foreach ($queries as &$query) {
			$query['query'] = $this->_formatSql($query['query']);
		}
	}

	/**
	 * Format SQL query for better readability (using Doctrine SqlFormatter like DebugKit)
	 *
	 * @param string $sql SQL query
	 * @return string Formatted SQL
	 */
	protected function _formatSql(string $sql): string {
		$formatter = new SqlFormatter(new NullHighlighter());

		return $formatter->format($sql);
	}

	/**
	 * Ensure pagination demo data exists with randomized prices and timestamps.
	 * Creates 12 products if they don't exist, with varying prices and timestamps.
	 *
	 * @param \Sandbox\Model\Table\ProductsTable $table The Products table
	 * @return void
	 */
	protected function _ensurePaginationDemoData(ProductsTable $table): void {
		// Skip in CLI/testing mode
		if (PHP_SAPI === 'cli') {
			return;
		}

		$count = $table->find()->count();
		if ($count >= 12 && !$this->request->getQuery('force-update')) {
			return;
		}

		// Clear existing products to ensure fresh demo data
		if ($count > 0) {
			$table->deleteAll([]);
		}

		$products = [
			[
				'title' => 'Awesome Keyboard',
				'price' => mt_rand(50, 150) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-60 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-55 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Budget Mouse',
				'price' => mt_rand(10, 30) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-50 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-48 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Fun Story Collection Book',
				'price' => mt_rand(15, 40) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-45 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-40 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Premium Headphones',
				'price' => mt_rand(200, 400) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-35 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-30 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Zero Gravity Pen',
				'price' => mt_rand(5, 15) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-28 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-25 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Coffee Mug Set',
				'price' => mt_rand(20, 45) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-20 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-18 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Laptop Stand',
				'price' => mt_rand(35, 80) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-15 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-12 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'USB-C Cable',
				'price' => mt_rand(8, 25) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-10 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-8 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Desk Organizer',
				'price' => mt_rand(15, 35) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-7 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-5 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Monitor Arm',
				'price' => mt_rand(60, 150) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-5 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-3 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Webcam HD',
				'price' => mt_rand(50, 120) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-3 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-2 days -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
			],
			[
				'title' => 'Wireless Charger',
				'price' => mt_rand(18, 45) + (mt_rand(0, 99) / 100),
				'stock' => mt_rand(0, 100),
				'created' => date('Y-m-d H:i:s', (int)strtotime('-1 day -' . mt_rand(0, 23) . ' hours -' . mt_rand(0, 59) . ' minutes')),
				'modified' => date('Y-m-d H:i:s', (int)strtotime('-6 hours -' . mt_rand(0, 59) . ' minutes')),
			],
		];

		// Create entities and mark created/modified as clean to prevent Timestamp behavior from overwriting
		$entities = [];
		foreach ($products as $data) {
			$entity = $table->newEntity($data);
			// Mark the timestamp fields as clean (already set) so Timestamp behavior won't touch them
			$entity->setDirty('created', true);
			$entity->setDirty('modified', true);
			$entities[] = $entity;
		}

		$table->saveManyOrFail($entities, ['checkExisting' => false, 'associated' => false]);

		throw new RedirectException(Router::url(['?' => []]));
	}

}
