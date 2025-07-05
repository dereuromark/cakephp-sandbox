<?php
declare(strict_types=1);

namespace CrudDemo\Controller;

use App\Controller\AppController as BaseController;

/**
 * @property \Tools\Controller\Component\CommonComponent $Common
 * @property \Flash\Controller\Component\FlashComponent $Flash
 * @property \TinyAuth\Controller\Component\AuthComponent $Auth
 * @property \TinyAuth\Controller\Component\AuthUserComponent $AuthUser
 */
class AppController extends BaseController {

	use \Crud\Controller\ControllerTrait;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Crud.Crud', [
			'actions' => [
				'Crud.Index',
				'Crud.View',
				'Crud.Add',
				'Crud.Edit',
				'Crud.Delete',
				'Crud.Adit',
			],
		]);

	}

}
