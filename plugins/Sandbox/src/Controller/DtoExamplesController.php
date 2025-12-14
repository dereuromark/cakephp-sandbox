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
		$demoFiles = [
			'simple-product' => [
				'label' => 'Simple Product (Example Data)',
				'file' => 'Demo' . DS . 'simple_product.json',
				'namespace' => 'Shop',
				'type' => 'data',
			],
			'user-schema' => [
				'label' => 'User (JSON Schema)',
				'file' => 'Demo' . DS . 'user_schema.json',
				'namespace' => 'Account',
				'type' => 'schema',
			],
			'github-pr' => [
				'label' => 'GitHub Pull Request API (Complex)',
				'file' => 'Github' . DS . 'demo_pr.json',
				'namespace' => 'Github',
				'type' => 'data',
			],
		];

		$demos = [];
		foreach ($demoFiles as $key => $demo) {
			$file = Plugin::path('Sandbox') . 'files' . DS . $demo['file'];
			$data = file_get_contents($file) ?: '';
			$demos[$key] = [
				'label' => $demo['label'],
				'data' => base64_encode((string)gzcompress($data)),
				'namespace' => $demo['namespace'],
				'type' => $demo['type'],
			];
		}

		$this->set(compact('demos'));
	}

}
