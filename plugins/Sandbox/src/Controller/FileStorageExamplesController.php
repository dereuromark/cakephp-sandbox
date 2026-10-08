<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Utility\Text;
use DateTime;
use Exception;
use FileStorage\Exception\BlobAttachDeniedException;
use FileStorage\Exception\BlobNotAvailableException;
use FileStorage\Exception\UploadException;
use FileStorage\Service\BlobAttacher;
use FileStorage\Service\CleanupService;
use FileStorage\Service\ResumableUploads;
use InvalidArgumentException;
use Laminas\Diactoros\UploadedFile;
use Sandbox\Validation\FileUploadValidator;
use Throwable;

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
	 * @var int
	 */
	protected const MAX_FILE_SIZE = 2 * 1024 * 1024;

	/**
	 * Seconds between automatic blob cleanups.
	 *
	 * @var int
	 */
	protected const BLOB_CLEANUP_INTERVAL = 600;

	/**
	 * Seconds until the next attempt after a failed blob cleanup.
	 *
	 * @var int
	 */
	protected const BLOB_CLEANUP_RETRY = 60;

	/**
	 * @var \FileStorage\Model\Table\FileStorageTable
	 */
	protected $FileStorage;

	/**
	 * Before filter callback
	 *
	 * @param \Cake\Event\EventInterface<\Cake\Controller\Controller> $event Event
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
	 * Upload deduplication demo
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function deduplication() {
		$this->FileStorage = $this->fetchTable('FileStorage.FileStorage');
		$fileStorage = $this->FileStorage->newEmptyEntity();

		if ($this->request->is('post')) {
			// Check max count limit (6 files max)
			$currentCount = $this->FileStorage->find()
				->where([
					'FileStorage.model' => 'FileStorage',
					'FileStorage.collection' => 'documents',
				])
				->count();

			if ($currentCount >= 6) {
				$this->Flash->error('Maximum 6 files allowed. Please delete an existing file first.');

				return $this->redirect(['action' => 'deduplication']);
			}

			$data = $this->request->getData();
			$data['model'] = 'FileStorage';
			$data['collection'] = 'documents';

			// Validate using custom validator for general files
			$validator = new FileUploadValidator();

			$errors = $validator->validate($data);
			if (!empty($errors)) {
				$fileStorage->setErrors($errors);
				$this->Flash->error('Could not upload file. Please check the errors below.');

				return $this->redirect(['action' => 'deduplication']);
			}

			$fileStorage = $this->FileStorage->patchEntity($fileStorage, $data);

			if ($this->FileStorage->save($fileStorage)) {
				$referenceCount = $this->FileStorage->find()
					->where(['FileStorage.blob_id' => $fileStorage->blob_id])
					->count();
				$this->Flash->success($referenceCount > 1
					? 'File uploaded successfully. Existing stored content was reused.'
					: 'File uploaded successfully. New content was stored.');

				return $this->redirect(['action' => 'deduplication']);
			}

			$this->Flash->error('Could not upload file. Please check the errors below.');
		}

		$files = $this->FileStorage->find()
			->where([
				'FileStorage.model' => 'FileStorage',
				'FileStorage.collection' => 'documents',
			])
			->orderByDesc('FileStorage.created')
			->toArray();

		$blobIds = [];
		$logicalBytes = 0;
		$storedBytes = 0;
		foreach ($files as $file) {
			$logicalBytes += (int)$file->filesize;
			if ($file->blob_id !== null && !isset($blobIds[$file->blob_id])) {
				$blobIds[$file->blob_id] = true;
				$storedBytes += (int)$file->filesize;
			}
		}

		$blobTable = $this->fetchTable('FileStorage.FileStorageBlobs');
		$blobs = $blobTable->find()
			->where(function (QueryExpression $exp) use ($blobIds): QueryExpression {
				$localBlobs = $exp->and([
					'FileStorageBlobs.adapter' => 'Local',
					'FileStorageBlobs.path LIKE' => 'blobs/%',
				]);
				if (!$blobIds) {
					return $localBlobs;
				}

				return $exp->or([
					$localBlobs,
					$exp->in('FileStorageBlobs.id', array_keys($blobIds), 'integer'),
				]);
			})
			->orderByDesc('FileStorageBlobs.created')
			->disableHydration()
			->toArray();

		$referenceCounts = [];
		foreach ($this->FileStorage->find()->select(['blob_id'])->where(['FileStorage.blob_id IS NOT' => null])->disableHydration()->toArray() as $row) {
			$blobId = (int)$row['blob_id'];
			$referenceCounts[$blobId] = ($referenceCounts[$blobId] ?? 0) + 1;
		}
		$blobs = array_map(function (array $blob) use ($referenceCounts): array {
			$blob['reference_count'] = $referenceCounts[(int)$blob['id']] ?? 0;

			return $blob;
		}, $blobs);

		$rowCount = count($files);
		$blobCount = count($blobs);
		$this->set(compact('fileStorage', 'files', 'blobs', 'rowCount', 'blobCount', 'logicalBytes', 'storedBytes'));
	}

	/**
	 * @return void
	 */
	public function resumableUpload(): void {
		$this->request->allowMethod(['get']);
		$session = $this->request->getSession();
		$owner = $session->read('FileStorageDemo.uploadOwner');
		if (!$owner) {
			$owner = Text::uuid();
			$session->write('FileStorageDemo.uploadOwner', $owner);
		}
		$files = $this->fetchTable('FileStorage.FileStorage')->find()
			->select(['id', 'filename', 'filesize', 'hash'])
			->where(['model' => 'FileStorage', 'collection' => 'large'])
			->orderByDesc('created')
			->disableHydration()
			->toArray();
		// Uploads are a local-only demo: the live sandbox would otherwise host arbitrary large files.
		$uploadsEnabled = (bool)Configure::read('debug');
		$this->set(compact('files', 'owner', 'uploadsEnabled'));
	}

	/**
	 * @return \Cake\Http\Response
	 */
	public function resumableUploadConsume() {
		$this->request->allowMethod(['post']);
		$response = $this->response->withType('application/json');
		if (!Configure::read('debug')) {
			return $response->withStatus(403)->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => 'Uploads are only enabled when the sandbox runs locally in debug mode.',
			]));
		}
		$lock = fopen(TMP . 'file_storage_demo_large.lock', 'c');
		if ($lock === false || !flock($lock, LOCK_EX | LOCK_NB)) {
			if (is_resource($lock)) {
				fclose($lock);
			}

			return $response->withStatus(409)->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => 'Another file is being saved. Please try again.',
			]));
		}
		try {
			$table = $this->fetchTable('FileStorage.FileStorage');
			if ($table->find()->where(['model' => 'FileStorage', 'collection' => 'large'])->count() >= 3) {
				return $response->withStatus(409)->withStringBody((string)json_encode([
					'status' => 'error',
					'error' => 'Maximum 3 files allowed. Please delete an existing file first.',
				]));
			}
			$file = (new ResumableUploads())->consume(
				(string)$this->request->getData('uploadId'),
				[],
				['userId' => $this->request->getSession()->read('FileStorageDemo.uploadOwner')],
			);

			return $response->withStringBody((string)json_encode([
				'status' => 'saved',
				'id' => $file->get('id'),
				'filename' => $file->get('filename'),
				'filesize' => $file->get('filesize'),
				'hash' => $file->get('hash'),
			]));
		} catch (UploadException $exception) {
			return $response->withStatus($exception->status)->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => $exception->status >= 500 ? 'Could not save the upload. Please try again.' : $exception->getMessage(),
			]));
		} finally {
			fclose($lock);
		}
	}

	/**
	 * @return void
	 */
	public function instantUpload(): void {
		$this->request->allowMethod(['get']);
		$table = $this->fetchTable('FileStorage.FileStorage');
		$files = $table->find()
			->select(['id', 'filename', 'filesize', 'hash'])
			->where(['model' => 'FileStorage', 'collection' => 'documents'])
			->orderByDesc('created')
			->disableHydration()
			->toArray();
		$files = array_map(static function (array $file): array {
			$file['hash'] = substr((string)$file['hash'], 0, 12);

			return $file;
		}, $files);
		$ownedHashesCount = count($this->request->getSession()->read('FileStorageDemo.ownedHashes') ?? []);
		$maxFiles = 6;
		$maxFileSize = static::MAX_FILE_SIZE;
		$this->set(compact('files', 'ownedHashesCount', 'maxFiles', 'maxFileSize'));
	}

	/**
	 * @return \Cake\Http\Response
	 */
	public function instantUploadCheck() {
		$this->request->allowMethod(['post']);
		$table = $this->fetchTable('FileStorage.FileStorage');
		if ($table->find()->where(['model' => 'FileStorage', 'collection' => 'documents'])->count() >= 6) {
			return $this->response->withType('application/json')->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => 'Maximum 6 files allowed. Please delete an existing file first.',
			]));
		}

		$ownedHashes = $this->request->getSession()->read('FileStorageDemo.ownedHashes') ?? [];
		$filename = mb_substr(basename((string)$this->request->getData('filename')), 0, 190);
		try {
			$file = (new BlobAttacher())->attach(
				(string)$this->request->getData('hash'),
				['model' => 'FileStorage', 'collection' => 'documents', 'filename' => $filename],
				['ownedHashes' => $ownedHashes],
			);
		} catch (BlobAttachDeniedException | BlobNotAvailableException | InvalidArgumentException) {
			return $this->response->withType('application/json')->withStringBody((string)json_encode(['status' => 'upload']));
		}

		return $this->response->withType('application/json')->withStringBody((string)json_encode([
			'status' => 'attached',
			'id' => $file->get('id'),
			'filename' => $file->get('filename'),
			'filesize' => $file->get('filesize'),
		]));
	}

	/**
	 * @return \Cake\Http\Response
	 */
	public function instantUploadStore() {
		$this->request->allowMethod(['post']);
		$table = $this->fetchTable('FileStorage.FileStorage');
		if ($table->find()->where(['model' => 'FileStorage', 'collection' => 'documents'])->count() >= 6) {
			return $this->response->withType('application/json')->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => 'Maximum 6 files allowed. Please delete an existing file first.',
			]));
		}

		$data = ['file' => $this->request->getData('file'), 'model' => 'FileStorage', 'collection' => 'documents'];
		$errors = (new FileUploadValidator())->validate($data);
		if ($errors) {
			$errorMessage = 'Validation failed';
			if (isset($errors['file'])) {
				$errorMessage = is_array($errors['file']) ? implode(', ', array_filter($errors['file'], 'is_string')) : $errors['file'];
			}

			return $this->response->withType('application/json')->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => $errorMessage,
			]));
		}

		$file = $table->newEntity($data);
		if (!$table->save($file)) {
			return $this->response->withType('application/json')->withStringBody((string)json_encode([
				'status' => 'error',
				'error' => 'Could not save file. Please try again.',
			]));
		}

		$session = $this->request->getSession();
		$ownedHashes = $session->read('FileStorageDemo.ownedHashes') ?? [];
		$ownedHashes[] = $file->get('hash');
		$session->write('FileStorageDemo.ownedHashes', array_values(array_unique($ownedHashes)));
		$reused = $file->get('blob_id') !== null
			&& $table->find()->where(['blob_id' => $file->get('blob_id')])->count() > 1;

		return $this->response->withType('application/json')->withStringBody((string)json_encode([
			'status' => 'uploaded',
			'id' => $file->get('id'),
			'filename' => $file->get('filename'),
			'filesize' => $file->get('filesize'),
			'reused' => $reused,
		]));
	}

	/**
	 * Remove unreferenced stored files after the grace period.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function deduplicationCleanup() {
		$this->request->allowMethod(['post']);

		// Only the blob passes: a full run would also delete every demo row, since none has a foreign key.
		$report = (new CleanupService())->runBlobs(false);
		$message = sprintf(
			'Cleanup: %d blobs removed, %d stray files removed, %d blobs skipped.',
			count($report->deletedBlobs),
			count($report->deletedStrayBlobs),
			$report->skippedBlobs,
		);
		if ($report->warnings) {
			$this->Flash->warning($message . ' Warning: ' . $report->warnings[0]);
		} else {
			$this->Flash->success($message);
		}

		return $this->redirect(['action' => 'deduplication']);
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
			// Check if this is an AJAX request
			$isAjax = $this->request->is('ajax') || $this->request->getQuery('ajax');

			try {
				$croppedData = $this->request->getData('cropped_image');
				$originalFilename = $this->request->getData('original_filename', 'cropped-image.png');

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
								$errorMessage = is_array($errors['file']) ? implode(', ', array_filter($errors['file'], 'is_string')) : $errors['file'];
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
			} catch (Exception $e) {
				if ($isAjax) {
					return $this->response
						->withType('application/json')
						->withStringBody((string)json_encode([
							'success' => false,
							'error' => 'An error occurred: ' . $e->getMessage(),
						]));
				}

				throw $e;
			}
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
						$errorMessage = is_array($errors['file']) ? implode(', ', array_filter($errors['file'], 'is_string')) : $errors['file'];
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
		$oneDayAgo = new DateTime('-1 day');

		$fileStorageTable = $this->fetchTable('FileStorage.FileStorage');

		// Find all old files across all collections
		/** @var list<\FileStorage\Model\Entity\FileStorage> $oldFiles */
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

		$this->cleanupUnreferencedBlobs();
		$this->cleanupExpiredUploads();
	}

	/**
	 * @return void
	 */
	protected function cleanupExpiredUploads(): void {
		if ($this->fetchTable('FileStorage.FileStorage')->getConnection()->inTransaction()) {
			return;
		}
		$marker = TMP . 'file_storage_demo_upload_cleanup';
		if (is_file($marker) && filemtime($marker) > time() - static::BLOB_CLEANUP_INTERVAL) {
			return;
		}
		if (!touch($marker)) {
			return;
		}
		try {
			(new ResumableUploads())->cleanup();
		} catch (Throwable $exception) {
			touch($marker, time() - static::BLOB_CLEANUP_INTERVAL + static::BLOB_CLEANUP_RETRY);
			Log::warning('File storage demo upload cleanup failed: ' . $exception->getMessage());
		}
	}

	/**
	 * Deleting a deduplicated row leaves its stored file for the blob cleanup.
	 * Nothing schedules that here, so without this the demo would keep every
	 * file ever uploaded. Throttled, because it lists the blob directory.
	 *
	 * @return void
	 */
	protected function cleanupUnreferencedBlobs(): void {
		// The cleanup refuses to run inside a transaction, which is the case in tests.
		if ($this->fetchTable('FileStorage.FileStorage')->getConnection()->inTransaction()) {
			return;
		}
		$marker = TMP . 'file_storage_demo_blob_cleanup';
		if (is_file($marker) && filemtime($marker) > time() - static::BLOB_CLEANUP_INTERVAL) {
			return;
		}
		// Without a marker the cleanup would run on every request.
		if (!touch($marker)) {
			return;
		}

		try {
			(new CleanupService())->runBlobs(false);
		} catch (Throwable $exception) {
			// A demo page must not fail over housekeeping. Try again in a minute.
			touch($marker, time() - static::BLOB_CLEANUP_INTERVAL + static::BLOB_CLEANUP_RETRY);
			Log::warning('File storage demo blob cleanup failed: ' . $exception->getMessage());
		}
	}

}
