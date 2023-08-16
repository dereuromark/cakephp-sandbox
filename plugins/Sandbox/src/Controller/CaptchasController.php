<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Tools\Form\ContactForm;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 * @property \Captcha\Controller\Component\CaptchaComponent $Captcha
 */
class CaptchasController extends SandboxAppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Sandbox.Animals';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Captcha.Captcha', ['actions' => ['math']]);
		$this->viewBuilder()->addHelpers(['Captcha.Captcha' => ['ext' => 'png']]);
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function math() {
		if ($this->request->getQuery('max')) {
			Configure::write('Captcha.maxPerUser', (int)$this->request->getQuery('max'));
		}

		$animal = $this->Animals->newEmptyEntity();
		if ($this->request->is('post')) {
			$animal = $this->Animals->patchEntity($animal, $this->request->getData());
			if (!$animal->getErrors()) {
				$this->Flash->success(__('The animal has been saved.'));

				return $this->redirect(['action' => 'math']);
			}
			$this->Flash->error(__('The animal could not be saved. Please, try again.'));
		}
		$this->set(compact('animal'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function modelLess() {
		$contact = new ContactForm();

		// For this example we simplify the demo form
		$contact->getValidator()
			->remove('email')
			->remove('subject');

		if ($this->request->is('post')) {
			$this->Captcha->addValidation($contact->getValidator(), 'Passive');

			if ($contact->execute($this->request->getData())) {
				$this->Flash->success(__('All right!'));

				return $this->redirect(['action' => 'modelLess']);
			}
			$this->Flash->error(__('Oh no. Please, try again.'));
		}

		$this->set(compact('contact'));
	}

}
