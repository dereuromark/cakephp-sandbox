<?php
declare(strict_types=1);

namespace Sandbox\Controller;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\Form\Form;
use Cake\Http\Response;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use MarkupCarve\CakeCarve\Validation\CarveValidation;
use RuntimeException;

class CarveCakephpController extends SandboxAppController {

	public function index(): void {
		$this->viewBuilder()->addHelper('MarkupCarve/CakeCarve.Carve');
	}

	public function validation(): void {
		$this->viewBuilder()->addHelper('MarkupCarve/CakeCarve.Carve');
		$data = ['body' => "# Comment\n\nThis heading is disallowed by the comment profile.", 'preset' => 'comment', 'maxLength' => 200, 'lint' => false];
		$errors = [];
		$form = new Form();
		$renderedBody = null;
		$renderedPreset = null;
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$preset = in_array($data['preset'] ?? null, ['default', 'comment'], true) ? $data['preset'] : 'comment';
			$maxLength = filter_var($data['maxLength'] ?? 200, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 100000]]);
			if ($maxLength === false) {
				$errors['maxLength'] = ['valid' => 'Enter a length from 1 to 100000.'];
				$maxLength = 200;
			}
			$lint = !empty($data['lint']);
			$body = is_string($data['body'] ?? null) ? $data['body'] : '';
			$validator = new Validator();
			$validator->setProvider('carve', CarveValidation::class)
				->add('body', 'carve', ['rule' => ['valid', ['preset' => $preset, 'maxLength' => $maxLength, 'lint' => $lint]], 'provider' => 'carve']);
			$errors += $validator->validate(['body' => $body]);
			$form->setErrors($errors);
			if (!$errors) {
				$renderedBody = $body;
				$renderedPreset = $preset;
			}
			$data = compact('body', 'preset', 'maxLength', 'lint');
		}
		$this->set(compact('data', 'form', 'renderedBody', 'renderedPreset'));
	}

	public function behavior(): void {
		$data = ['body' => "# Saved post\n\nSome *bold* text.\n\n## Details\n\nMore text."];
		$row = null;
		if ($this->request->is('post')) {
			$data['body'] = is_string($this->request->getData('body')) ? $this->request->getData('body') : '';
			$name = 'sandbox_carve_demo';
			if (!in_array($name, ConnectionManager::configured(), true)) {
				ConnectionManager::setConfig($name, ['className' => 'Cake\\Database\\Connection', 'driver' => 'Cake\\Database\\Driver\\Sqlite', 'database' => ':memory:']);
			}
			$connection = ConnectionManager::get($name);
			if (!$connection instanceof Connection) {
				throw new RuntimeException('The demo requires a database connection.');
			}
			$connection->execute('CREATE TABLE IF NOT EXISTS carve_posts (id INTEGER PRIMARY KEY, body TEXT, body_html TEXT, body_text TEXT, body_toc TEXT)');
			$posts = new Table(['table' => 'carve_posts', 'connection' => $connection]);
			$posts->getSchema()->setColumnType('body_toc', 'json');
			$posts->addBehavior('MarkupCarve/CakeCarve.Carve', [
				'fields' => ['body' => ['target' => 'body_html', 'text' => 'body_text', 'toc' => 'body_toc']],
			]);
			$entity = $posts->newEntity(['body' => $data['body']]);
			$posts->saveOrFail($entity);
			$row = $posts->get($entity->get('id'))->toArray();
		}
		$this->set(compact('data', 'row'));
	}

	public function view(): Response {
		$this->viewBuilder()
			->setClassName('MarkupCarve/CakeCarve.Carve')
			->setLayout('Sandbox.carve_document')
			->setOption('extensions', ['frontmatter']);
		$this->set('name', 'CakePHP sandbox');

		return $this->render('document');
	}

}
