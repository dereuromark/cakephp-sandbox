<?php

namespace Sandbox\Controller;

use Burzum\CakeServiceLayer\Service\ServiceAwareTrait;
use Cake\Http\Exception\NotImplementedException;
use League\Container\Exception\NotFoundException;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Sandbox\Service\Localized\ValidationService $Validation
 */
class LocalizedController extends SandboxAppController {

	use ServiceAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @return void
	 */
	public function index() {
		$this->loadService('Sandbox.Localized/Validation');
		$available = $this->Validation->getAvailable();

		$this->set(compact('available'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function basic() {
		$this->loadService('Sandbox.Localized/Validation');
		$available = $this->Validation->getAvailable();
		$methods = $this->Validation->getMethods();

		/** @var string|null $method */
		$method = $this->request->getQuery('method');
		if ($method && !in_array($method, $methods, true)) {
			throw new NotFoundException('This method does not exist');
		}

		$codes = $this->Validation->getCodes($method);
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
			}
		}

		$this->set(compact('available', 'method', 'code', 'methods', 'codes', 'entity'));
	}

}
