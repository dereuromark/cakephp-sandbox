<?php
namespace App\Controller;

use Cake\Core\Configure;
use Tools\Form\ContactForm;
use Tools\Mailer\Email;

/**
 * @property \Captcha\Controller\Component\CaptchaComponent $Captcha
 */
class ContactController extends AppController {

	/**
	 * @var array
	 */
	public $components = [
		'Captcha.Captcha',
	];

	/**
	 * @var array
	 */
	public $helpers = [
		'Tools.Obfuscate', 'Captcha.Captcha',
	];

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		if (Configure::read('debug')) {
			return;
		}
		$this->loadComponent('Csrf');
		$this->loadComponent('Security');
	}

	/**
	 * @return void
	 */
	public function index() {
		$contact = new ContactForm();

		if ($this->Common->isPosted()) {
			$name = $this->request->data['name'];
			$email = $this->request->data['email'];
			$subject = $this->request->data['subject'];
			$message = $this->request->data['body'];

			if (Configure::read('debug')) {
				$this->Flash->info('In debug mode there is no captcha validation necessary.');
			} else {
				$this->Captcha->addValidation($contact->validator());
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
			$user = (array)$this->request->session()->read('Auth.User');
			if (!empty($user['email'])) {
				$this->request->data['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$this->request->data['name'] = $user['username'];
			}
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
