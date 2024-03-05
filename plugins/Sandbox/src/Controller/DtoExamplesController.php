<?php

namespace Sandbox\Controller;

use Cake\Core\Plugin;
use Sandbox\Dto\Github\PullRequestDto;

/**
 * @property \Data\Controller\Component\CountryStateHelperComponent $CountryStateHelper
 * @property \Data\Model\Table\CountriesTable $Countries
 * @property \Data\Model\Table\StatesTable $States
 * @property \App\Model\Table\UsersTable $Users
 */
class DtoExamplesController extends SandboxAppController {

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Using a demo PR from GitHub to show case DTOs' power.
	 *
	 * @return void
	 */
	public function github() {
		$file = Plugin::path('Sandbox') . 'files' . DS . 'Github' . DS . 'demo_pr.json';
		$simulatedDataFromGitHubApi = json_decode(file_get_contents($file) ?: '', true);

		$pullRequestDto = PullRequestDto::create($simulatedDataFromGitHubApi, true, PullRequestDto::TYPE_UNDERSCORED);

		$this->set(compact('pullRequestDto', 'file'));
	}

	/**
	 * Live demo of generator.
	 *
	 * @return void
	 */
	public function generator() {
	}

}
