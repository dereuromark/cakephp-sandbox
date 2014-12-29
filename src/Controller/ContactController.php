<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class ContactController extends AppController {

	public $uses = array('Tools.ContactForm');

	public function beforeFilter(Event $event) {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * @return void
	 */
	public function index() {
		if ($this->Common->isPosted()) {

			$name = $this->request->data['ContactForm']['name'];
			$email = $this->request->data['ContactForm']['email'];
			$message = $this->request->data['ContactForm']['message'];
			$subject = $this->request->data['ContactForm']['subject'];

			if (!$this->AuthUser->id()) {
				$this->ContactForm->Behaviors->attach('Tools.Captcha', array('type' => 'passive'));
			}
			$this->ContactForm->set($this->request->data);
			if ($this->ContactForm->validates()) {
				$this->_send($name, $email, $subject, $message);
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}

		} else {
			// prepopulate form
			$this->request->data['ContactForm'] = $this->request->query;

			# try to autofill fields
			$user = (array)$this->Session->read('Auth.User');
			if (!empty($user['email'])) {
				$this->request->data['ContactForm']['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$this->request->data['ContactForm']['name'] = $user['username'];
			}
		}

		$this->set(compact('dropdowns'));
		$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
	}

	/**
	 * @return void
	 */
	protected function _send($fromName, $fromEmail, $subject, $message) {
		$adminEmail = Configure::read('Config.adminEmail');
		$adminEmailname = Configure::read('Config.adminName');

		// Send email to Admin
		Configure::write('Email.live', true);
		
		$this->Email = new EmailLib();
		$this->Email->to($adminEmail, $adminEmailname);

		$this->Email->subject(Configure::read('Settings.title') . ' - ' . __('contact via form'));
		$this->Email->template('contact', 'default');
		$this->Email->viewVars(compact('message', 'subject', 'fromEmail', 'fromName'));
		if ($this->Email->send()) {
			$this->Flash->message(__('contactSuccessfullySent {0}', $fromEmail), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Flash->message(__('Contact Email could not be sent'), 'error');
	}

}
