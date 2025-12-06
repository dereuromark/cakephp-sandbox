<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Djot\DjotConverter;
use Djot\Exception\ParseException;
use Djot\Exception\ProfileViolationException;
use Djot\Profile;
use Djot\Renderer\SoftBreakMode;
use HTMLPurifier;
use HTMLPurifier_Config;
use LengthException;

class DjotController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$this->set('debugMode', Configure::read('debug'));
	}

	/**
	 * AJAX endpoint for live conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convert(): Response {
		$this->request->allowMethod(['post']);

		$djot = (string)$this->request->getData('djot');
		$collectWarnings = (bool)$this->request->getData('warnings');
		$strict = (bool)$this->request->getData('strict');
		$raw = (bool)$this->request->getData('raw') && Configure::read('debug');
		$profileName = (string)$this->request->getData('profile');
		$filterMode = (string)$this->request->getData('filter_mode');
		$significantNewlines = (bool)$this->request->getData('significant_newlines');
		$softBreakAsBr = (bool)$this->request->getData('soft_break_br');

		$result = [
			'html' => '',
			'warnings' => [],
			'violations' => [],
			'error' => null,
		];

		if ($djot) {
			try {
				$profile = $this->getProfile($profileName, $filterMode);
				if ($significantNewlines) {
					$converter = DjotConverter::withSignificantNewlines(true, $collectWarnings, $strict, null, $profile);
				} else {
					$converter = new DjotConverter(true, $collectWarnings, $strict, null, $profile);
					// Soft break as <br> only applies when not using significantNewlines
					// (significantNewlines already renders soft breaks as <br>)
					if ($softBreakAsBr) {
						$converter->getRenderer()->setSoftBreakMode(SoftBreakMode::Break);
					}
				}
				$html = $converter->convert($djot);
				$result['html'] = $raw ? $html : $this->sanitizeHtml($html);
				if ($collectWarnings) {
					foreach ($converter->getWarnings() as $warning) {
						$result['warnings'][] = [
							'message' => $warning->getMessage(),
							'line' => $warning->getLine(),
						];
					}
				}
				if ($profile) {
					foreach ($converter->getProfileViolations() as $violation) {
						$result['violations'][] = [
							'nodeType' => $violation->nodeType,
							'reason' => $violation->reason,
							'message' => $violation->getMessage(),
						];
					}
				}
			} catch (ParseException $e) {
				$result['error'] = $e->getMessage();
			} catch (LengthException $e) {
				$result['error'] = $e->getMessage();
			} catch (ProfileViolationException $e) {
				$result['error'] = 'Profile violation: ' . $e->getMessage();
				foreach ($e->violations as $violation) {
					$result['violations'][] = [
						'nodeType' => $violation->nodeType,
						'reason' => $violation->reason,
						'message' => $violation->getMessage(),
					];
				}
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
	}

	/**
	 * Get profile instance from name.
	 *
	 * @param string $name
	 * @param string $filterMode
	 * @return \Djot\Profile|null
	 */
	protected function getProfile(string $name, string $filterMode): ?Profile {
		$profile = match ($name) {
			'full' => Profile::full(),
			'article' => Profile::article(),
			'comment' => Profile::comment(),
			'minimal' => Profile::minimal(),
			default => null,
		};

		if ($profile !== null && $filterMode) {
			$action = match ($filterMode) {
				'strip' => Profile::ACTION_STRIP,
				'error' => Profile::ACTION_ERROR,
				default => Profile::ACTION_TO_TEXT,
			};
			$profile->onDisallowed($action);
		}

		return $profile;
	}

	/**
	 * Sanitize HTML output to prevent XSS attacks. Needed when input comes from outside.
	 *
	 * @param string $html
	 * @return string
	 */
	protected function sanitizeHtml(string $html): string {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Cache.DefinitionImpl', null);
		$config->set('HTML.DefinitionID', 'djot-sandbox');
		$config->set('HTML.DefinitionRev', 4);
		$config->set('HTML.Allowed', 'p,br,strong,em,u,s,del,ins,mark,sub[id],sup[id],a[href|title|class|id],img[src|alt|title],ul[class],ol[start|type],li,dl,dt,dd,blockquote,pre,code[class],h1[id],h2[id],h3[id],h4[id],h5[id],h6[id],table[class|id],thead,tbody,tr,th[align|colspan|rowspan|style],td[align|colspan|rowspan|style],hr,div[class|id],span[class|id],section[id],input[type|checked|disabled]');
		$config->set('CSS.AllowedProperties', 'text-align');
		$config->set('Attr.EnableID', true);
		$config->set('HTML.TargetBlank', true);
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
		$config->set('AutoFormat.RemoveEmpty', false);

		$def = $config->maybeGetRawHTMLDefinition();
		if ($def !== null) {
			$def->addElement('mark', 'Inline', 'Inline', 'Common');
			$def->addElement('section', 'Block', 'Flow', 'Common');
			$def->addElement('input', 'Inline', 'Empty', 'Common', [
				'type' => 'Enum#checkbox',
				'checked' => 'Bool',
				'disabled' => 'Bool',
			]);
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

}
