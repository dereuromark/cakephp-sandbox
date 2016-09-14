<?php
namespace App\Controller;

use Cake\Core\Configure;
use Tools\Form\ContactForm;
use Tools\Mailer\Email;

class ContactController extends AppController {

	/**
	 * @var array
	 */
	public $helpers = ['Tools.Obfuscate'];

	/**
	 * @return void
	 */
	public function index() {
		$contact = new ContactForm();

		if ($this->Common->isPosted()) {
			$name = $this->request->data['name'];
			$email = $this->request->data['email'];
			$message = $this->request->data['message'];
			$subject = $this->request->data['subject'];

			if (!$this->AuthUser->id()) {
				//$this->ContactForm->addBehavior('Tools.Captcha');
}
			if ($contact->execute($this->request->data)) {
				$this->_send($name, $email, $subject, $message);
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			// prepopulate form
			$this->request->data = $this->request->query;

			# try to autofill fields
			$user = (array)$this->Session->read('Auth.User');
			if (!empty($user['email'])) {
				$this->request->data['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$this->request->data['name'] = $user['username'];
			}
		}

		//$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
		$this->set(compact('contact'));
	}

	/**
	 * @param string $fromName
	 * @param string $fromEmail
	 * @param string $subject
	 * @param string $message
	 *
	 * @return \Cake\Network\Response|null
	 */
	protected function _send($fromName, $fromEmail, $subject, $message) {
		$adminEmail = Configure::read('Config.adminEmail');
		$adminName = Configure::read('Config.adminName');

		// Send email to Admin
		Configure::write('Email.live', true);
		$this->Email = new Email();
		$this->Email->to($adminEmail, $adminName);

		$this->Email->subject(Configure::read('Config.pageName') . ' - ' . __('contact via form'));
		$this->Email->template('contact');
		$this->Email->viewVars(compact('message', 'subject', 'fromEmail', 'fromName'));
		if ($this->Email->send()) {
			$this->Flash->success(__('contactSuccessfullySent {0}', $fromEmail));
			return $this->redirect(['action' => 'index']);
		}
		if (Configure::read('debug')) {
			$this->Flash->warning($this->Email->getError());
		}
		$this->log($this->Email->getError());
		$this->Flash->error(__('Contact Email could not be sent'));
	}

}
