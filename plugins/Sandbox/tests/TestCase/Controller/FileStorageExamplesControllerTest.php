<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Shim\TestSuite\TestCase;

/**
 * FileStorageExamplesController Test Case
 */
class FileStorageExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var array<string>
	 */
	protected array $fixtures = [];

	/**
	 * setUpBeforeClass method
	 *
	 * @return void
	 */
	public static function setUpBeforeClass(): void {
		parent::setUpBeforeClass();

		// Ensure uploads directory exists
		if (!defined('UPLOADS_DIR')) {
			define('UPLOADS_DIR', WWW_ROOT . 'files' . DS . 'uploads' . DS);
		}

		if (!is_dir(UPLOADS_DIR)) {
			mkdir(UPLOADS_DIR, 0777, true);
		}

		// Run migrations for test database
		exec('bin/cake migrations migrate --connection=test -p FileStorage 2>&1', $output);
	}

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		// Clean up test files from database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$testFiles = $FileStorage->find()
			->where(['model' => 'FileStorage'])
			->toArray();

		foreach ($testFiles as $file) {
			// Delete physical files
			if (!empty($file->path) && file_exists(UPLOADS_DIR . $file->path)) {
				@unlink(UPLOADS_DIR . $file->path);
			}

			// Delete variants
			$variants = $file->variants ?? [];
			foreach ($variants as $variant) {
				if (!empty($variant['path']) && file_exists(UPLOADS_DIR . $variant['path'])) {
					@unlink(UPLOADS_DIR . $variant['path']);
				}
			}

			// Delete from database
			$FileStorage->delete($file);
		}

		parent::tearDown();
	}

	/**
	 * Test image upload with automatic variant generation
	 *
	 * @return void
	 */
	public function testImageUploadWithVariants() {
		// Create a test image (100x100 red square)
		$image = imagecreatetruecolor(100, 100);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefill($image, 0, 0, $red);

		// Save to temp file
		$tmpFile = TMP . 'test_image_' . time() . '.png';
		imagepng($image, $tmpFile);
		imagedestroy($image);

		$this->assertFileExists($tmpFile, 'Test image file should be created');

		// Create uploaded file data
		$uploadData = [
			'file' => [
				'tmp_name' => $tmpFile,
				'error' => UPLOAD_ERR_OK,
				'name' => 'test-image.png',
				'type' => 'image/png',
				'size' => filesize($tmpFile),
			],
		];

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], $uploadData);

		// Check redirect
		$this->assertRedirect(['action' => 'images']);

		// Get the uploaded file from database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => 'test-image.png',
			])
			->orderByDesc('id')
			->first();

		$this->assertNotNull($file, 'File should be saved to database');
		$this->assertSame('FileStorage', $file->model);
		$this->assertSame('images', $file->collection);
		$this->assertSame('png', $file->extension);
		$this->assertSame('image/png', $file->mime_type);

		// Debug: Check variants
		debug('File ID: ' . $file->id);
		debug('Variants: ' . json_encode($file->variants, JSON_PRETTY_PRINT));

		// Check that variants were generated
		$variants = $file->variants ?? [];
		$this->assertNotEmpty($variants, 'Variants should be generated');

		$expectedVariants = ['thumbnail', 'medium', 'large'];
		foreach ($expectedVariants as $variantName) {
			$this->assertArrayHasKey($variantName, $variants, "Variant '$variantName' should exist");

			// Check variant has path and URL
			$this->assertArrayHasKey('path', $variants[$variantName], "Variant '$variantName' should have path");
			$this->assertArrayHasKey('url', $variants[$variantName], "Variant '$variantName' should have url");

			// Check variant file exists on disk
			$variantPath = $variants[$variantName]['path'];
			$fullPath = UPLOADS_DIR . $variantPath;
			$this->assertFileExists($fullPath, "Variant file '$variantName' should exist at: $fullPath");

			// Check variant dimensions
			if (file_exists($fullPath)) {
				$size = getimagesize($fullPath);
				debug("$variantName dimensions: {$size[0]}x{$size[1]}");

				// Verify dimensions are within expected ranges
				switch ($variantName) {
					case 'thumbnail':
						$this->assertLessThanOrEqual(150, $size[0], 'Thumbnail width should be <= 150px');
						$this->assertLessThanOrEqual(150, $size[1], 'Thumbnail height should be <= 150px');
						break;
					case 'medium':
						$this->assertLessThanOrEqual(400, $size[0], 'Medium width should be <= 400px');
						$this->assertLessThanOrEqual(400, $size[1], 'Medium height should be <= 400px');
						break;
					case 'large':
						$this->assertLessThanOrEqual(800, $size[0], 'Large width should be <= 800px');
						$this->assertLessThanOrEqual(800, $size[1], 'Large height should be <= 800px');
						break;
				}
			}
		}

		// Check original file exists
		$this->assertNotEmpty($file->path, 'File should have path');
		$originalPath = UPLOADS_DIR . $file->path;
		$this->assertFileExists($originalPath, "Original file should exist at: $originalPath");

		// Cleanup
		@unlink($tmpFile);
		if (!empty($file->path) && file_exists(UPLOADS_DIR . $file->path)) {
			@unlink(UPLOADS_DIR . $file->path);
		}
		foreach ($variants as $variant) {
			if (!empty($variant['path']) && file_exists(UPLOADS_DIR . $variant['path'])) {
				@unlink(UPLOADS_DIR . $variant['path']);
			}
		}
	}

	/**
	 * Test configuration is correct
	 *
	 * @return void
	 */
	public function testFileStorageConfiguration() {
		$config = Configure::read('FileStorage');

		$this->assertNotEmpty($config, 'FileStorage configuration should exist');
		$this->assertArrayHasKey('imageVariants', $config, 'imageVariants should be configured');

		$variants = $config['imageVariants'];
		$this->assertArrayHasKey('FileStorage', $variants, 'FileStorage model should have variants');
		$this->assertArrayHasKey('images', $variants['FileStorage'], 'images collection should have variants');

		$imageVariants = $variants['FileStorage']['images'];
		$this->assertArrayHasKey('thumbnail', $imageVariants, 'thumbnail variant should be configured');
		$this->assertArrayHasKey('medium', $imageVariants, 'medium variant should be configured');
		$this->assertArrayHasKey('large', $imageVariants, 'large variant should be configured');

		debug('Configuration is correct!');
		debug('Variants: ' . json_encode(array_keys($imageVariants)));
	}

	/**
	 * Test that only JPG/PNG images are allowed
	 *
	 * @return void
	 */
	public function testImageValidationRejectsInvalidTypes() {
		// Create a fake GIF file (not allowed)
		$tmpFile = TMP . 'test_invalid_' . time() . '.gif';
		file_put_contents($tmpFile, 'GIF89a'); // Minimal GIF header

		$this->assertFileExists($tmpFile, 'Test file should be created');

		$uploadData = [
			'file' => [
				'tmp_name' => $tmpFile,
				'error' => UPLOAD_ERR_OK,
				'name' => 'test-image.gif',
				'type' => 'image/gif',
				'size' => filesize($tmpFile),
			],
		];

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], $uploadData);

		// Should redirect back to form
		$this->assertRedirect(['action' => 'images']);

		// File should NOT be saved
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => 'test-image.gif',
			])
			->first();

		$this->assertNull($file, 'GIF file should not be saved');

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test that files larger than 2MB are rejected
	 *
	 * @return void
	 */
	public function testImageValidationRejectsLargeFiles() {
		// Create a test image
		$image = imagecreatetruecolor(100, 100);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefill($image, 0, 0, $red);

		$tmpFile = TMP . 'test_large_' . time() . '.png';
		imagepng($image, $tmpFile);
		imagedestroy($image);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		// Fake the file size to be over 2MB
		$uploadData = [
			'file' => [
				'tmp_name' => $tmpFile,
				'error' => UPLOAD_ERR_OK,
				'name' => 'test-large.png',
				'type' => 'image/png',
				'size' => 2 * 1024 * 1024 + 1, // 2MB + 1 byte
			],
		];

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], $uploadData);

		// Should redirect back to form
		$this->assertRedirect(['action' => 'images']);

		// File should NOT be saved
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => 'test-large.png',
			])
			->first();

		$this->assertNull($file, 'Large file should not be saved');

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test that maximum 3 uploads per collection is enforced
	 *
	 * @return void
	 */
	public function testMaximumCountLimitEnforced() {
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');

		// Create 3 dummy files in the images collection
		for ($i = 1; $i <= 3; $i++) {
			$entity = $FileStorage->newEntity([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => "dummy-$i.png",
				'extension' => 'png',
				'mime_type' => 'image/png',
				'filesize' => 1000,
				'path' => "test/dummy-$i.png",
			]);
			$FileStorage->saveOrFail($entity);
		}

		// Verify we have 3 files
		$count = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
			])
			->count();
		$this->assertEquals(3, $count, 'Should have 3 files in collection');

		// Try to upload a 4th file
		$image = imagecreatetruecolor(100, 100);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefill($image, 0, 0, $red);

		$tmpFile = TMP . 'test_fourth_' . time() . '.png';
		imagepng($image, $tmpFile);
		imagedestroy($image);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadData = [
			'file' => [
				'tmp_name' => $tmpFile,
				'error' => UPLOAD_ERR_OK,
				'name' => 'test-fourth.png',
				'type' => 'image/png',
				'size' => filesize($tmpFile),
			],
		];

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], $uploadData);

		// Should redirect back
		$this->assertRedirect(['action' => 'images']);

		// Should still have only 3 files
		$newCount = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
			])
			->count();
		$this->assertEquals(3, $newCount, 'Should still have only 3 files (4th was rejected)');

		// Fourth file should NOT exist
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => 'test-fourth.png',
			])
			->first();
		$this->assertNull($file, 'Fourth file should not be saved');

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test PDF validation allows only PDF files
	 *
	 * @return void
	 */
	public function testPdfValidationRejectsNonPdfFiles() {
		// Try to upload a PNG as PDF
		$image = imagecreatetruecolor(100, 100);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefill($image, 0, 0, $red);

		$tmpFile = TMP . 'test_fake_pdf_' . time() . '.png';
		imagepng($image, $tmpFile);
		imagedestroy($image);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadData = [
			'file' => [
				'tmp_name' => $tmpFile,
				'error' => UPLOAD_ERR_OK,
				'name' => 'test.png',
				'type' => 'image/png',
				'size' => filesize($tmpFile),
			],
		];

		// Post to PDFs action
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'pdfs'], $uploadData);

		// Should redirect back
		$this->assertRedirect(['action' => 'pdfs']);

		// File should NOT be saved
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'pdfs',
				'filename' => 'test.png',
			])
			->first();

		$this->assertNull($file, 'Non-PDF file should not be saved to PDFs collection');

		// Cleanup
		@unlink($tmpFile);
	}

}
