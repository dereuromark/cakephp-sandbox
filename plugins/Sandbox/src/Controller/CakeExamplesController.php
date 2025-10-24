<?php

namespace Sandbox\Controller;

use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;
use Cake\Utility\Hash;
use Psr\Log\LoggerInterface;
use Sandbox\Controller\Paginator\CollectionPaginator;
use Sandbox\Model\Enum\UserStatus;

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
			 * @param array<string, mixed> $context
			 * @throws void
			 * @return void
			 */
			public function log($level, $message, array $context = []): void {
				$took = $context['query']->getContext()['took'];

				$this->queries[] = [
					'query' => (string)$message,
					'took' => $took,
				];
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function emergency($message, array $context = []): void {
				$this->log('emergency', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function alert($message, array $context = []): void {
				$this->log('alert', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function critical($message, array $context = []): void {
				$this->log('critical', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function error($message, array $context = []): void {
				$this->log('error', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function warning($message, array $context = []): void {
				$this->log('warning', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function notice($message, array $context = []): void {
				$this->log('notice', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function info($message, array $context = []): void {
				$this->log('info', $message, $context);
			}

			/**
			 * @param \Stringable|string $message
			 * @param array<string, mixed> $context
			 * @return void
			 */
			public function debug($message, array $context = []): void {
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
		$formatter = new \Doctrine\SqlFormatter\SqlFormatter(new \Doctrine\SqlFormatter\NullHighlighter());

		return $formatter->format($sql);
	}

}
