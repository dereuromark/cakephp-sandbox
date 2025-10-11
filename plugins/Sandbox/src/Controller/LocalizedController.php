<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\NotImplementedException;
use Sandbox\Service\Localized\ValidationService;
use Throwable;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class LocalizedController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @param \Sandbox\Service\Localized\ValidationService $validationService
	 * @return void
	 */
	public function index(ValidationService $validationService) {
		$available = $validationService->getAvailable();

		$this->set(compact('available'));
	}

	/**
	 * @param \Sandbox\Service\Localized\ValidationService $validationService
	 * @return \Cake\Http\Response|null|void
	 */
	public function basic(ValidationService $validationService) {
		$available = $validationService->getAvailable();
		$methods = $validationService->getMethods();

		/** @var string|null $method */
		$method = $this->request->getQuery('method');
		if ($method && !in_array($method, $methods, true)) {
			throw new NotFoundException('This method does not exist');
		}

		$codes = $validationService->getCodes($method);
		$code = $this->request->getQuery('code');
		if ($codes && $code && !in_array($code, $codes, true)) {
			throw new NotFoundException('This country code does not exist');
		}

		$entity = null;
		if ($this->request->is('post')) {
			$table = $this->getTableLocator()->get('Sandbox.Animals');
			$validator = $table->getValidator();

			$code = $this->request->getData('code');
			$class = 'Cake\\Localized\\Validation\\' . ucfirst(strtolower($code)) . 'Validation';
			if (!class_exists($class)) {
				$this->Flash->error('This validation class does not exist');

				return $this->redirect(['?' => $this->request->getQuery()]);
			}
			$validator->setProvider($code, $class);
			$validator->add('value', 'localizedValidation', [
				'rule' => $method,
				'provider' => $code,
			]);

			$entity = $table->newEmptyEntity();
			try {
				$entity = $table->patchEntity($entity, $this->request->getData());
				if (!$entity->hasErrors()) {
					$this->Flash->success('Validation successful.');
				} else {
					$this->Flash->warning('Validation not successful.');
				}
			} catch (NotImplementedException $e) {
				$this->Flash->error($e->getMessage());
			} catch (Throwable $e) {
				$message = $e->getMessage();
				$message = str_replace(ROOT . DS, '', $message);
				$this->Flash->error('Error in code: ' . $message);
			}
		}

		$this->set(compact('available', 'method', 'code', 'methods', 'codes', 'entity'));
	}

}
