<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Http\Response;
use Exception;
use Nette\Neon\Entity;
use Nette\Neon\Neon;
use Throwable;
use Workflow\Engine\Definition\Definition;
use Workflow\Engine\Definition\State;
use Workflow\Engine\Definition\Transition;
use Workflow\Renderer\MermaidRenderer;

/**
 * Builder Controller
 *
 * Interactive workflow builder with live preview.
 */
class BuilderController extends AppController {

	/**
	 * Index - Interactive workflow builder.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		// Load example workflow for the editor
		$examplePath = Plugin::path('WorkflowSandbox') . 'config' . DS . 'workflows' . DS . 'order.neon';
		$exampleNeon = file_get_contents($examplePath);

		$this->set(compact('exampleNeon'));

		return null;
	}

	/**
	 * Parse NEON and return Mermaid diagram.
	 *
	 * @return \Cake\Http\Response
	 */
	public function preview(): Response {
		$this->request->allowMethod(['post']);
		$neon = $this->request->getData('neon', '');

		try {
			$data = Neon::decode($neon);

			if (!$data || !is_array($data)) {
				throw new Exception('Invalid NEON structure');
			}

			// Get the first workflow name
			$workflowName = array_key_first($data);
			if (!$workflowName) {
				throw new Exception('No workflow defined');
			}

			$workflowData = $data[$workflowName];

			// Build definition manually
			$states = [];
			foreach ($workflowData['states'] ?? [] as $stateName => $stateData) {
				$stateData = $stateData ?? [];
				$states[] = new State(
					name: $stateName,
					label: $this->neonToString($stateData['label'] ?? null),
					color: $this->neonToString($stateData['color'] ?? null),
					initial: (bool)($stateData['initial'] ?? false),
					final: (bool)($stateData['final'] ?? false),
					failed: (bool)($stateData['failed'] ?? false),
					flags: $stateData['flags'] ?? [],
				);
			}

			$transitions = [];
			foreach ($workflowData['transitions'] ?? [] as $transitionName => $transitionData) {
				$from = $transitionData['from'] ?? [];
				if (is_string($from)) {
					$from = [$from];
				}

				$transitions[] = new Transition(
					name: $transitionName,
					from: $from,
					to: $transitionData['to'] ?? '',
					happy: $transitionData['happy'] ?? false,
					guards: isset($transitionData['guard']) ? [$transitionData['guard']] : [],
					commands: isset($transitionData['command']) ? [$transitionData['command']] : [],
				);
			}

			$definition = new Definition(
				name: $workflowName,
				table: $this->neonToString($workflowData['table'] ?? 'Unknown') ?? 'Unknown',
				field: $this->neonToString($workflowData['field'] ?? 'status') ?? 'status',
				states: $states,
				transitions: $transitions,
				label: $this->neonToString($workflowData['metadata']['label'] ?? null),
				description: $this->neonToString($workflowData['metadata']['description'] ?? null),
			);

			$renderer = new MermaidRenderer();
			$mermaid = $renderer->render($definition);

			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode([
					'success' => true,
					'mermaid' => $mermaid,
					'info' => [
						'name' => $workflowName,
						'states' => count($states),
						'transitions' => count($transitions),
					],
				]));
		} catch (Throwable $e) {
			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode([
					'success' => false,
					'error' => $e->getMessage(),
				]));
		}
	}

	/**
	 * Load an example workflow.
	 *
	 * @param string|null $name Workflow name
	 * @return \Cake\Http\Response
	 */
	public function loadExample(?string $name = null): Response {
		$validExamples = ['registration', 'order', 'content', 'ticket', 'document'];

		if (!$name || !in_array($name, $validExamples, true)) {
			$name = 'order';
		}

		$path = Plugin::path('WorkflowSandbox') . 'config' . DS . 'workflows' . DS . $name . '.neon';

		if (!file_exists($path)) {
			return $this->response
				->withType('application/json')
				->withStringBody((string)json_encode(['success' => false, 'error' => 'Example not found']));
		}

		$neon = file_get_contents($path);

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode(['success' => true, 'neon' => $neon, 'name' => $name]));
	}

	/**
	 * Convert NEON value to string, handling Entity objects.
	 *
	 * @param mixed $value
	 * @return string|null
	 */
	protected function neonToString(mixed $value): ?string {
		if ($value === null) {
			return null;
		}

		if ($value instanceof Entity) {
			// Entity has value and attributes - convert to string representation
			return (string)$value->value;
		}

		if (is_array($value)) {
			return implode(' ', array_map(fn ($v) => $this->neonToString($v), $value));
		}

		return (string)$value;
	}

}
