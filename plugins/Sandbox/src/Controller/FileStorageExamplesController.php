<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
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
			} else {
				$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

				if ($this->FileStorage->save($fileStorage)) {
					$this->Flash->success('Image uploaded successfully.');

					return $this->redirect(['action' => 'images']);
				}

				$this->Flash->error('Could not upload image. Please check the errors below.');
			}
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
			} else {
				$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

				if ($this->FileStorage->save($fileStorage)) {
					$this->Flash->success('PDF uploaded successfully.');

					return $this->redirect(['action' => 'pdfs']);
				}

				$this->Flash->error('Could not upload PDF. Please check the errors below.');
			}
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
			} else {
				$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

				if ($this->FileStorage->save($fileStorage)) {
					$this->Flash->success('File uploaded successfully.');

					return $this->redirect(['action' => 'files']);
				}

				$this->Flash->error('Could not upload file. Please check the errors below.');
			}
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

}
