<?php

namespace Sandbox\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Laminas\Diactoros\UploadedFile;
use Sandbox\Validation\FileUploadValidator;

/**
 * FileStorage Examples Controller
 *
 * Demonstrates file storage capabilities including:
 * - Image uploads
 * - PDF uploads
 * - General file uploads
 *
 * @property \FileStorage\Model\Table\FileStorageTable $FileStorage
 */
class FileStorageExamplesController extends SandboxAppController {

	/**
	 * @var \FileStorage\Model\Table\FileStorageTable
	 */
	protected $FileStorage;

	/**
	 * Before filter callback
	 *
	 * @param \Cake\Event\EventInterface $event Event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		// Auto-cleanup old files older than 1 day on page load - for demo purposes
		$this->cleanupOldFiles();
	}

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Image upload and display demo
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function images() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->newEmptyEntity();

		if ($this->request->is('post')) {
			// Check max count limit (3 images max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'images',
				])
				->count();

			if ($currentCount >= 3) {
				$this->Flash->error('Maximum 3 images allowed. Please delete an existing image first.');

				return $this->redirect(['action' => 'images']);
			}

			$data = $this->request->getData();
			$data['model'] = 'FileStorage';
			$data['collection'] = 'images';

			// Validate using custom validator for images
			$validator = new FileUploadValidator();
			$validator->forImages();

			$errors = $validator->validate($data);
			if (!empty($errors)) {
				$fileStorage->setErrors($errors);
				$this->Flash->error('Could not upload image. Please check the errors below.');

				return $this->redirect(['action' => 'images']);
			}

			$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

			if ($this->FileStorage->save($fileStorage)) {
				$this->Flash->success('Image uploaded successfully.');

				return $this->redirect(['action' => 'images']);
			}

			$this->Flash->error('Could not upload image. Please check the errors below.');
		}

		$images = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'images',
			])
			->orderByDesc('FileStorage.created')
			->limit(20)
			->toArray();

		$this->set(compact('fileStorage', 'images'));
	}

	/**
	 * PDF upload and display demo
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function pdfs() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->newEmptyEntity();

		if ($this->request->is('post')) {
			// Check max count limit (3 PDFs max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'pdfs',
				])
				->count();

			if ($currentCount >= 3) {
				$this->Flash->error('Maximum 3 PDFs allowed. Please delete an existing PDF first.');

				return $this->redirect(['action' => 'pdfs']);
			}

			$data = $this->request->getData();
			$data['model'] = 'FileStorage';
			$data['collection'] = 'pdfs';

			// Validate using custom validator for PDFs
			$validator = new FileUploadValidator();
			$validator->forPdfs();

			$errors = $validator->validate($data);
			if (!empty($errors)) {
				$fileStorage->setErrors($errors);
				$this->Flash->error('Could not upload PDF. Please check the errors below.');

				return $this->redirect(['action' => 'pdfs']);
			}

			$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

			if ($this->FileStorage->save($fileStorage)) {
				$this->Flash->success('PDF uploaded successfully.');

				return $this->redirect(['action' => 'pdfs']);
			}

			$this->Flash->error('Could not upload PDF. Please check the errors below.');
		}

		$pdfs = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'pdfs',
			])
			->orderByDesc('FileStorage.created')
			->limit(20)
			->toArray();

		$this->set(compact('fileStorage', 'pdfs'));
	}

	/**
	 * General file upload demo
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function files() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->newEmptyEntity();

		if ($this->request->is('post')) {
			// Check max count limit (3 files max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'general',
				])
				->count();

			if ($currentCount >= 3) {
				$this->Flash->error('Maximum 3 files allowed. Please delete an existing file first.');

				return $this->redirect(['action' => 'files']);
			}

			$data = $this->request->getData();
			$data['model'] = 'FileStorage';
			$data['collection'] = 'general';

			// Validate using custom validator for general files
			$validator = new FileUploadValidator();

			$errors = $validator->validate($data);
			if (!empty($errors)) {
				$fileStorage->setErrors($errors);
				$this->Flash->error('Could not upload file. Please check the errors below.');

				return $this->redirect(['action' => 'files']);
			}

			$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

			if ($this->FileStorage->save($fileStorage)) {
				$this->Flash->success('File uploaded successfully.');

				return $this->redirect(['action' => 'files']);
			}

			$this->Flash->error('Could not upload file. Please check the errors below.');
		}

		$files = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'general',
			])
			->orderByDesc('FileStorage.created')
			->limit(20)
			->toArray();

		$this->set(compact('fileStorage', 'files'));
	}

	/**
	 * Show image variants demo
	 *
	 * @return void
	 */
	public function variants() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');

		$images = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'images',
			])
			->orderByDesc('FileStorage.created')
			->limit(5)
			->toArray();

		$this->set(compact('images'));
	}

	/**
	 * Image cropping demo
	 *
	 * Demonstrates:
	 * - Client-side image cropping before upload
	 * - Multiple aspect ratio presets (free, square, 16:9, 4:3)
	 * - Zoom and rotate controls
	 * - Preview functionality
	 * - Cropper.js integration
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function imageCropping() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');

		// Handle AJAX cropped image upload
		if ($this->request->is('post')) {
			$croppedData = $this->request->getData('cropped_image');
			$originalFilename = $this->request->getData('original_filename', 'cropped-image.png');

			// Check if this is an AJAX request
			$isAjax = $this->request->is('ajax') || $this->request->getQuery('ajax');

			// Check max count limit (3 files max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'cropped',
				])
				->count();

			if ($currentCount >= 3) {
				if ($isAjax) {
					return $this->response
						->withType('application/json')
						->withStringBody((string)json_encode([
							'success' => false,
							'error' => 'Maximum 3 cropped images allowed. Please delete an existing image first.',
						]));
				}

				$this->Flash->error('Maximum 3 cropped images allowed. Please delete an existing image first.');

				return $this->redirect(['action' => 'imageCropping']);
			}

			// Decode base64 image data
			if (preg_match('/^data:image\/(\w+);base64,/', $croppedData, $matches)) {
				$imageType = $matches[1];
				$croppedData = substr($croppedData, strpos($croppedData, ',') + 1);
				$croppedData = base64_decode($croppedData, true);

				// Create temporary file
				$tmpFile = TMP . 'cropped_' . time() . '.' . $imageType;
				file_put_contents($tmpFile, $croppedData);

				// Create uploaded file object
				$fileSize = filesize($tmpFile);
				$uploadedFile = new UploadedFile(
					$tmpFile,
					$fileSize !== false ? $fileSize : 0,
					UPLOAD_ERR_OK,
					$originalFilename,
					'image/' . $imageType,
				);

				$data = [
					'file' => $uploadedFile,
					'model' => 'FileStorage',
					'collection' => 'cropped',
				];

				// Validate using custom validator for images
				$validator = new FileUploadValidator();
				$validator->forImages();

				$errors = $validator->validate($data);
				if (!empty($errors)) {
					@unlink($tmpFile);

					if ($isAjax) {
						$errorMessage = 'Validation failed';
						if (isset($errors['file'])) {
							$errorMessage = is_array($errors['file']) ? implode(', ', $errors['file']) : $errors['file'];
						}

						return $this->response
							->withType('application/json')
							->withStringBody((string)json_encode([
								'success' => false,
								'error' => $errorMessage,
							]));
					}

					$this->Flash->error('Could not upload cropped image. Please check the errors below.');

					return $this->redirect(['action' => 'imageCropping']);
				}

				$fileStorage = $this->FileStorage->newEmptyEntity();
				$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

				if ($this->FileStorage->save($fileStorage)) {
					@unlink($tmpFile);

					if ($isAjax) {
						return $this->response
							->withType('application/json')
							->withStringBody((string)json_encode([
								'success' => true,
								'file' => [
									'id' => $fileStorage->id,
									'filename' => $fileStorage->filename,
									'size' => $fileStorage->filesize,
									'mime_type' => $fileStorage->mime_type,
								],
							]));
					}

					$this->Flash->success('Cropped image uploaded successfully.');

					return $this->redirect(['action' => 'imageCropping']);
				}

				@unlink($tmpFile);
			}

			if ($isAjax) {
				return $this->response
					->withType('application/json')
					->withStringBody((string)json_encode([
						'success' => false,
						'error' => 'Could not save cropped image. Please try again.',
					]));
			}

			$this->Flash->error('Could not upload cropped image. Please try again.');
		}

		$files = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'cropped',
			])
			->orderByDesc('FileStorage.created')
			->limit(20)
			->toArray();

		$this->set(compact('files'));
	}

	/**
	 * Modern drag-and-drop upload demo
	 *
	 * Demonstrates:
	 * - HTML5 drag and drop API
	 * - AJAX file upload with progress tracking
	 * - Multiple file uploads
	 * - Client-side validation
	 * - Image previews
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function dragDropUpload() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');

		// Handle AJAX file upload
		if ($this->request->is('post')) {
			$uploadedFile = $this->request->getData('file');

			// Check if this is an AJAX request
			$isAjax = $this->request->is('ajax') || $this->request->getQuery('ajax');

			// Check max count limit (10 files max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'drag-drop',
				])
				->count();

			if ($currentCount >= 3) {
				if ($isAjax) {
					return $this->response
						->withType('application/json')
						->withStringBody((string)json_encode([
							'success' => false,
							'error' => 'Maximum 3 files allowed. Please delete an existing file first.',
						]));
				}

				$this->Flash->error('Maximum 3 files allowed. Please delete an existing file first.');

				return $this->redirect(['action' => 'dragDropUpload']);
			}

			$data = [
				'file' => $uploadedFile,
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
			];

			// Validate using custom validator for images
			$validator = new FileUploadValidator();
			$validator->forImages();

			$errors = $validator->validate($data);
			if (!empty($errors)) {
				if ($isAjax) {
					$errorMessage = 'Validation failed';
					if (isset($errors['file'])) {
						$errorMessage = is_array($errors['file']) ? implode(', ', $errors['file']) : $errors['file'];
					}

					return $this->response
						->withType('application/json')
						->withStringBody((string)json_encode([
							'success' => false,
							'error' => $errorMessage,
						]));
				}

				$this->Flash->error('Could not upload file. Please check the errors below.');

				return $this->redirect(['action' => 'dragDropUpload']);
			}

			$fileStorage = $this->FileStorage->newEmptyEntity();
			$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

			if ($this->FileStorage->save($fileStorage)) {
				if ($isAjax) {
					return $this->response
						->withType('application/json')
						->withStringBody((string)json_encode([
							'success' => true,
							'file' => [
								'id' => $fileStorage->id,
								'filename' => $fileStorage->filename,
								'size' => $fileStorage->filesize,
								'mime_type' => $fileStorage->mime_type,
							],
						]));
				}

				$this->Flash->success('File uploaded successfully.');

				return $this->redirect(['action' => 'dragDropUpload']);
			}

			if ($isAjax) {
				return $this->response
					->withType('application/json')
					->withStringBody((string)json_encode([
						'success' => false,
						'error' => 'Could not save file. Please try again.',
					]));
			}

			$this->Flash->error('Could not upload file. Please try again.');
		}

		$files = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'drag-drop',
			])
			->orderByDesc('FileStorage.created')
			->limit(20)
			->toArray();

		$this->set(compact('files'));
	}

	/**
	 * View/download a file
	 *
	 * @param string|null $id File ID
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return \Cake\Http\Response
	 */
	public function view($id = null) {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->get($id);

		if (!$fileStorage) {
			throw new NotFoundException('File not found.');
		}

		$path = $fileStorage->path;
		if (!$path) {
			throw new NotFoundException('File path not found.');
		}

		// For local storage, we need to prepend the uploads directory
		$fullPath = UPLOADS_DIR . $path;
		if (!file_exists($fullPath)) {
			throw new NotFoundException('Physical file not found.');
		}

		$mimeType = $fileStorage->mime_type ?: 'application/octet-stream';
		$filename = $fileStorage->filename ?: 'download';

		return $this->response
			->withFile($fullPath)
			->withType($mimeType)
			->withDownload($filename);
	}

	/**
	 * Delete a file
	 *
	 * @param string|null $id File ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);

		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->get($id);
		if ($this->FileStorage->delete($fileStorage)) {
			$this->Flash->success('File has been deleted.');
		} else {
			$this->Flash->error('File could not be deleted. Please try again.');
		}

		return $this->redirect($this->referer(['action' => 'index']));
	}

	/**
	 * Clean up old files older than 1 day - for demo purposes
	 *
	 * Removes both database records and physical files (including variants)
	 *
	 * @return void
	 */
	protected function cleanupOldFiles(): void {
		$oneDayAgo = new \DateTime('-1 day');

		$fileStorageTable = $this->fetchTable('FileStorage.FileStorage');

		// Find all old files across all collections
		$oldFiles = $fileStorageTable->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.created <' => $oneDayAgo,
			])
			->toArray();

		// Delete each file (this will trigger the behavior to delete physical files)
		foreach ($oldFiles as $file) {
			$fileStorageTable->delete($file);
		}
	}

}
