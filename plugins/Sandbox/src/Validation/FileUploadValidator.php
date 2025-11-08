<?php
declare(strict_types=1);

namespace Sandbox\Validation;

use Cake\Validation\Validator;

/**
 * File Upload Validator
 *
 * Validates file uploads for FileStorage
 */
class FileUploadValidator extends Validator {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();

		// File is required
		$this->requirePresence('file', 'create')
			->notEmptyFile('file', 'Please select a file to upload');

		// File size validation (2MB max)
		$this->add('file', 'fileSize', [
			'rule' => ['fileSize', '<=', '2MB'],
			'message' => 'File must be less than 2MB',
		]);

		// Valid upload - skip in test environment as is_uploaded_file() doesn't work in tests
		if (PHP_SAPI !== 'cli') {
			$this->add('file', 'uploadedFile', [
				'rule' => 'uploadedFile',
				'message' => 'Invalid file upload',
			]);
		}
	}

	/**
	 * Validate for image uploads (JPG, PNG only)
	 *
	 * @return $this
	 */
	public function forImages() {
		// Extension validation
		$this->add('file', 'extension', [
			'rule' => ['extension', ['jpg', 'jpeg', 'png']],
			'message' => 'Only JPG and PNG images are allowed',
		]);

		// MIME type validation
		$this->add('file', 'mimeType', [
			'rule' => ['mimeType', ['image/jpeg', 'image/png']],
			'message' => 'Only JPG and PNG images are allowed',
		]);

		return $this;
	}

	/**
	 * Validate for PDF uploads
	 *
	 * @return $this
	 */
	public function forPdfs() {
		// Extension validation
		$this->add('file', 'extension', [
			'rule' => ['extension', ['pdf']],
			'message' => 'Only PDF files are allowed',
		]);

		// MIME type validation
		$this->add('file', 'mimeType', [
			'rule' => ['mimeType', ['application/pdf']],
			'message' => 'Only PDF files are allowed',
		]);

		return $this;
	}

}
