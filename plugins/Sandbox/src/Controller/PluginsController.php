<?php
namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

class PluginsController extends SandboxAppController {

	/**
	 * @var array
	 */
	public $components = [
		'RequestHandler' => [
			'viewClassMap' => ['pdf' => 'CakePdf.Pdf']
		]
	];

	/**
	 * Overview
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * PDF generation examples.
	 *
	 * @see http://www.dereuromark.de/2014/04/08/generating-pdfs-with-cakephp/
	 *
	 * @return void
	 */
	public function cake_pdf() {
	}

	/**
	 * Actual PDF test action. Will only be called via .pdf extension.
	 *
	 * To test FOR WINDOWS: make sure you got
	 * - APP/files/wkhtmltopdf/ with the binary files (or any other location)
	 * - Configure::write('CakePdf.binary', APP . 'files\wkhtmltopdf\wkhtmltopdf.exe'); in your configs
	 *
	 * @param string|null $engineSlug
	 * @throws \Cake\Network\Exception\NotFoundException
	 * @return void
	 */
	public function pdfTest($engineSlug = null) {
		// This is just so save actions and use this method for all engine tests
		$engines = [
			'dom' => 'DomPdf',
			'wk' => 'WkHtmlToPdf',
			'tc' => 'Tcpdf',
			//'m' => 'Mpdf'
		];
		if (!empty($engineSlug)) {
			if (empty($engines[$engineSlug])) {
				throw new NotFoundException('Invalid engine');
			}
			$engine = $engines[$engineSlug];
			$this->_setPdfConfig($engine);
		} else {
			$this->viewBuilder()->templatePath('Plugins' . DS . 'pdf');
			$this->viewBuilder()->layoutPath('pdf');
		}

		// Setting dynamic config settings
		$this->pdfConfig = [
			'filename' => $engineSlug,
			'download' => (bool)$this->request->query('download')
		];

		// Passing some test data to the view
		$someTestArray = ['Foo' => ['bar' => 'value']];
		$this->set(compact('someTestArray'));
	}

	/**
	 * PdfTestController::_setConfig()
	 *
	 * @param string|null $engine
	 * @return void
	 */
	protected function _setPdfConfig($engine = null) {
		if ($engine === null) {
			$engine = 'WkHtmlToPdf';
		}
		$settings = [
			'engine' => 'CakePdf.' . $engine,
			'options' => [
				'print-media-type' => false,
				'outline' => true,
				'dpi' => 96
			],
			'margin' => [
				'bottom' => 15,
				'left' => 50,
				'right' => 30,
				'top' => 45
			],
			'orientation' => 'portrait',
		];
		$settings += (array)Configure::read('CakePdf');
		Configure::write('CakePdf', $settings);

		if ($engine === 'DomPdf') {
			define('DOMPDF_ENABLE_REMOTE', true);
		}
	}

}
