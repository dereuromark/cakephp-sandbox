<?php

namespace App\Controller;

use Cake\Core\Configure;
use Tools\Form\ContactForm;
use Tools\Mailer\Mailer;

/**
 * @property \Captcha\Controller\Component\CaptchaComponent $Captcha
 */
class ContactController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Captcha.Captcha');
		$this->viewBuilder()->setHelpers(['Tools.Obfuscate', 'Captcha.Captcha']);

		if (Configure::read('debug')) {
			return;
		}

		$this->loadComponent('Security');
	}

	/**
	 * @return void
	 */
	public function index() {
		$contact = new ContactForm();

		if ($this->Common->isPosted()) {
			$name = $this->request->getData('name');
			$email = $this->request->getData('email');
			$subject = $this->request->getData('subject');
			$message = $this->request->getData('body');

			if (Configure::read('debug')) {
				$this->Flash->info('In debug mode there is no captcha validation necessary.');
			} else {
				$this->Captcha->addValidation($contact->getValidator());
			}

			if ($contact->execute($this->request->getData())) {
				$this->_send($name, $email, $subject, $message);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			// prepopulate form
			$data = (array)$this->request->getQuery();

			# try to autofill fields
			$user = (array)$this->request->getSession()->read('Auth.User');
			if (!empty($user['email'])) {
				$data['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$data['name'] = $user['username'];
			}

			$this->request = $this->request->withParsedBody($data);
		}

		$this->set(compact('contact'));
	}

	/**
	 * @param string $fromName
	 * @param string $fromEmail
	 * @param string $subject
	 * @param string $message
	 *
	 * @return \Cake\Http\Response|null
	 */
	protected function _send($fromName, $fromEmail, $subject, $message) {
		$adminEmail = Configure::read('Config.adminEmail');
		$adminName = Configure::read('Config.adminName');

		// Send email to Admin
		//Configure::write('Email.live', true);
		$email = new Mailer();
		$email->setTo($adminEmail, $adminName);

		$email->setSubject(Configure::read('Config.pageName') . ' - ' . __('contact via form'));
		$email->viewBuilder()->setTemplate('contact');
		$email->setViewVars(compact('message', 'subject', 'fromEmail', 'fromName'));
		$email->send();

		$this->Flash->success(__('contactSuccessfullySent {0}', $fromEmail));
		//$this->Flash->error(__('Contact Email could not be sent'));

		return $this->redirect(['action' => 'index']);
	}

}
