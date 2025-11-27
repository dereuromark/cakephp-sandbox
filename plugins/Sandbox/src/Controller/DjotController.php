<?php

namespace Sandbox\Controller;

use Cake\Http\Response;
use Djot\DjotConverter;
use Djot\Exception\ParseException;
use HTMLPurifier;
use HTMLPurifier_Config;

class DjotController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * AJAX endpoint for live conversion.
	 *
	 * @return \Cake\Http\Response
	 */
	public function convert(): Response {
		$this->request->allowMethod(['post']);

		$djot = (string)$this->request->getData('djot');
		$xhtml = (bool)$this->request->getData('xhtml');
		$collectWarnings = (bool)$this->request->getData('warnings');
		$strict = (bool)$this->request->getData('strict');

		$result = [
			'html' => '',
			'warnings' => [],
			'error' => null,
		];

		if ($djot) {
			try {
				$converter = new DjotConverter($xhtml, $collectWarnings, $strict);
				$html = $converter->convert($djot);
				$result['html'] = $this->sanitizeHtml($html);
				if ($collectWarnings) {
					foreach ($converter->getWarnings() as $warning) {
						$result['warnings'][] = [
							'message' => $warning->getMessage(),
							'line' => $warning->getLine(),
						];
					}
				}
			} catch (ParseException $e) {
				$result['error'] = $e->getMessage();
			}
		}

		return $this->response
			->withType('application/json')
			->withStringBody((string)json_encode($result));
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
		$config->set('HTML.DefinitionRev', 1);
		$config->set('HTML.Allowed', 'p,br,strong,em,u,s,del,ins,mark,sub,sup,a[href|title],img[src|alt|title],ul,ol,li,dl,dt,dd,blockquote,pre,code[class],h1,h2,h3,h4,h5,h6,table,thead,tbody,tr,th[align],td[align],hr,div[class|id],span[class|id],section[id]');
		$config->set('HTML.TargetBlank', true);
		$config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);

		$def = $config->maybeGetRawHTMLDefinition();
		if ($def !== null) {
			$def->addElement('mark', 'Inline', 'Inline', 'Common');
			$def->addElement('section', 'Block', 'Flow', 'Common');
		}

		$purifier = new HTMLPurifier($config);

		return $purifier->purify($html);
	}

}
