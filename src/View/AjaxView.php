<?php
namespace App\View;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

class AjaxView extends AppView {

	/**
	 * @var string
	 */
	public $layout = 'ajax';

	/**
	 * Constructor
	 *
	 * @param \Cake\Http\ServerRequest|null $request The request object.
	 * @param \Cake\Http\Response|null $response The response object.
	 * @param \Cake\Event\EventManager|null $eventManager Event manager object.
	 * @param array $viewOptions View options.
	 */
	public function __construct(
		ServerRequest $request = null,
		Response $response = null,
		EventManager $eventManager = null,
		array $viewOptions = []
	) {
		parent::__construct($request, $response, $eventManager, $viewOptions);

		if ($response && $response instanceof Response) {
			$response->type('ajax');
		}
	}

}
