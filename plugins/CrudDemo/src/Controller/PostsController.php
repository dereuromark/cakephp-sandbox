<?php
declare(strict_types=1);

namespace CrudDemo\Controller;

class PostsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Crud->useModel('Sandbox.SandboxPosts');
	}

	public function index() {
		return $this->Crud->execute();
	}

	public function view() {
		return $this->Crud->execute();
	}

	public function add() {
		return $this->Crud->execute();
	}

	public function edit() {
		return $this->Crud->execute();
	}

	public function delete() {
		return $this->Crud->execute();
	}

	public function adit() {
		return $this->Crud->execute();
	}

}
