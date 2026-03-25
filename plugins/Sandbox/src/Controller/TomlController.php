<?php

namespace Sandbox\Controller;

use Cake\Http\Response;
use Composer\InstalledVersions;
use PhpCollective\Toml\Toml;
use Throwable;

class TomlController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index(): void {
		$tomlVersion = InstalledVersions::getPrettyVersion('php-collective/toml');
		$reference = InstalledVersions::getReference('php-collective/toml');
		if ($tomlVersion === 'dev-master' && $reference) {
			$tomlVersion = 'dev-master@' . substr($reference, 0, 7);
		}

		$this->set('tomlVersion', $tomlVersion);
	}

	/**
	 * AJAX endpoint for TOML to PHP array conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convert(): Response {
		$this->request->allowMethod(['post']);

		$toml = (string)$this->request->getData('toml');

		$result = [
			'success' => false,
			'data' => null,
			'error' => null,
		];

		if ($toml) {
			try {
				$data = Toml::decode($toml);
				$result['success'] = true;
				$result['data'] = $data;
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}

	/**
	 * AJAX endpoint for PHP array to TOML conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function encode(): Response {
		$this->request->allowMethod(['post']);

		$json = (string)$this->request->getData('json');

		$result = [
			'success' => false,
			'data' => null,
			'error' => null,
		];

		if ($json) {
			try {
				$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
				$toml = Toml::encode($data);
				$result['success'] = true;
				$result['data'] = $toml;
			} catch (Throwable $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}

	/**
	 * TOML syntax examples page.
	 *
	 * @return void
	 */
	public function examples(): void {
	}

	/**
	 * Validation/linting demo page.
	 *
	 * @return void
	 */
	public function validation(): void {
	}

	/**
	 * AJAX endpoint for TOML validation with error recovery.
	 *
	 * @return \Cake\Http\Response
	 */
	public function validate(): Response {
		$this->request->allowMethod(['post']);

		$toml = (string)$this->request->getData('toml');

		$result = [
			'valid' => false,
			'errors' => [],
			'data' => null,
		];

		if ($toml) {
			try {
				$parseResult = Toml::tryParse($toml);
				$errors = $parseResult->getErrors();
				if ($errors) {
					foreach ($errors as $error) {
						$result['errors'][] = [
							'message' => $error->message,
							'line' => $error->span->line,
							'column' => $error->span->column,
						];
					}
				} else {
					$result['valid'] = true;
					$result['data'] = Toml::decode($toml);
				}
			} catch (Throwable $e) {
				$result['errors'][] = [
					'message' => $e->getMessage(),
					'line' => null,
					'column' => null,
				];
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}

}
