<?php
declare(strict_types=1);

namespace Sandbox\Validation;

use Cake\Validation\Validator;
use Psr\Http\Message\UploadedFileInterface;

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

		// File size validation (2MB max) - custom rule for UploadedFileInterface
		$this->add('file', 'fileSize', [
			'rule' => function ($value) {
				if ($value instanceof UploadedFileInterface) {
					$size = $value->getSize();
					$maxSize = 2 * 1024 * 1024; // 2MB in bytes

					return $size !== null && $size <= $maxSize;
				}

				// Fallback to array format
				if (is_array($value) && isset($value['size'])) {
					return $value['size'] <= 2 * 1024 * 1024;
				}

				return false;
			},
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
		// Extension validation - custom rule for UploadedFileInterface
		$this->add('file', 'extension', [
			'rule' => function ($value) {
				$allowedExtensions = ['jpg', 'jpeg', 'png'];

				if ($value instanceof UploadedFileInterface) {
					$filename = $value->getClientFilename();
					if (!$filename) {
						return false;
					}
					$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

					return in_array($extension, $allowedExtensions, true);
				}

				// Fallback to array format
				if (is_array($value) && isset($value['name'])) {
					$extension = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));

					return in_array($extension, $allowedExtensions, true);
				}

				return false;
			},
			'message' => 'Only JPG and PNG images are allowed',
		]);

		// MIME type validation - custom rule for UploadedFileInterface
		$this->add('file', 'mimeType', [
			'rule' => function ($value) {
				$allowedMimeTypes = ['image/jpeg', 'image/png'];

				if ($value instanceof UploadedFileInterface) {
					$mimeType = $value->getClientMediaType();

					return $mimeType && in_array($mimeType, $allowedMimeTypes, true);
				}

				// Fallback to array format
				if (is_array($value) && isset($value['type'])) {
					return in_array($value['type'], $allowedMimeTypes, true);
				}

				return false;
			},
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
		// Extension validation - custom rule for UploadedFileInterface
		$this->add('file', 'extension', [
			'rule' => function ($value) {
				$allowedExtensions = ['pdf'];

				if ($value instanceof UploadedFileInterface) {
					$filename = $value->getClientFilename();
					if (!$filename) {
						return false;
					}
					$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

					return in_array($extension, $allowedExtensions, true);
				}

				// Fallback to array format
				if (is_array($value) && isset($value['name'])) {
					$extension = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));

					return in_array($extension, $allowedExtensions, true);
				}

				return false;
			},
			'message' => 'Only PDF files are allowed',
		]);

		// MIME type validation - custom rule for UploadedFileInterface
		$this->add('file', 'mimeType', [
			'rule' => function ($value) {
				$allowedMimeTypes = ['application/pdf'];

				if ($value instanceof UploadedFileInterface) {
					$mimeType = $value->getClientMediaType();

					return $mimeType && in_array($mimeType, $allowedMimeTypes, true);
				}

				// Fallback to array format
				if (is_array($value) && isset($value['type'])) {
					return in_array($value['type'], $allowedMimeTypes, true);
				}

				return false;
			},
			'message' => 'Only PDF files are allowed',
		]);

		return $this;
	}

}
