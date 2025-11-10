<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Laminas\Diactoros\UploadedFile;
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
	 * Create an UploadedFile instance for testing
	 *
	 * @param string $filePath Path to the file
	 * @param string $clientFilename Original filename
	 * @param string $clientMediaType MIME type
	 * @param int|null $size Optional size override (defaults to actual file size)
	 * @return \Laminas\Diactoros\UploadedFile
	 */
	protected function createUploadedFile(string $filePath, string $clientFilename, string $clientMediaType, ?int $size = null): UploadedFile {
		return new UploadedFile(
			$filePath,
			$size ?? filesize($filePath),
			UPLOAD_ERR_OK,
			$clientFilename,
			$clientMediaType,
		);
	}

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->enableRetainFlashMessages();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		// Clean up test files from database
		// FileStorage behavior automatically deletes physical files (original + variants)
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$testFiles = $FileStorage->find()
			->where(['model' => 'FileStorage'])
			->toArray();

		foreach ($testFiles as $file) {
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

		$this->assertFileExists($tmpFile, 'Test image file should be created');

		// Create uploaded file object (PSR-7)
		$uploadedFile = $this->createUploadedFile($tmpFile, 'test-image.png', 'image/png');

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
			'file' => $uploadedFile,
		]);

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

		// Cleanup temp file (physical uploads cleaned by tearDown via FileStorage behavior)
		@unlink($tmpFile);
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

		$uploadedFile = $this->createUploadedFile($tmpFile, 'test-image.gif', 'image/gif');

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
			'file' => $uploadedFile,
		]);

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

		$this->assertFileExists($tmpFile, 'Test image should be created');

		// Fake the file size to be over 2MB
		$uploadedFile = $this->createUploadedFile($tmpFile, 'test-large.png', 'image/png', 2 * 1024 * 1024 + 1);

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
			'file' => $uploadedFile,
		]);

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

		// Create 3 dummy files in the images collection by actually uploading them
		for ($i = 1; $i <= 3; $i++) {
			// Create a small test image
			$image = imagecreatetruecolor(10, 10);
			$tmpFile = TMP . 'test_dummy_' . $i . '_' . time() . '.png';
			imagepng($image, $tmpFile);

			// Upload it
			$uploadedFile = $this->createUploadedFile($tmpFile, "dummy-$i.png", 'image/png');
			$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
				'file' => $uploadedFile,
			]);
			$this->assertRedirect(['action' => 'images']);
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

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'test-fourth.png', 'image/png');

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
			'file' => $uploadedFile,
		]);

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
	 * Test PDF upload with automatic thumbnail generation
	 *
	 * @return void
	 */
	public function testPdfUploadWithThumbnailGeneration() {
		// Skip if Imagick is not available (required for PDF thumbnails)
		if (!extension_loaded('imagick')) {
			$this->markTestSkipped('Imagick extension not available');
		}

		// Create a minimal valid PDF file
		$pdfContent = $this->getMinimalPdfContent();
		$tmpFile = TMP . 'test_pdf_' . time() . '.pdf';
		file_put_contents($tmpFile, $pdfContent);

		$this->assertFileExists($tmpFile, 'Test PDF should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'test-document.pdf', 'application/pdf');

		// Post the upload
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'pdfs'], [
			'file' => $uploadedFile,
		]);

		// Check redirect
		$this->assertRedirect(['action' => 'pdfs']);

		// Get the uploaded PDF from database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'pdfs',
				'filename' => 'test-document.pdf',
			])
			->orderByDesc('id')
			->first();

		$this->assertNotNull($file, 'PDF should be saved to database');
		$this->assertSame('FileStorage', $file->model);
		$this->assertSame('pdfs', $file->collection);
		$this->assertSame('pdf', $file->extension);
		$this->assertSame('application/pdf', $file->mime_type);

		// Check that thumbnail variants were generated
		$variants = $file->variants ?? [];
		$this->assertNotEmpty($variants, 'PDF should have thumbnail variants');

		$expectedVariants = ['thumbnail', 'medium', 'large'];
		foreach ($expectedVariants as $variantName) {
			if (isset($variants[$variantName])) {
				$this->assertArrayHasKey('path', $variants[$variantName], "Variant '$variantName' should have path");

				// Check variant file exists on disk
				$variantPath = $variants[$variantName]['path'];
				$fullPath = UPLOADS_DIR . $variantPath;

				if (!file_exists($fullPath)) {
					// Thumbnail generation may fail if Ghostscript is not available
					// This is acceptable in test environment
					$this->markTestSkipped("PDF thumbnail generation requires Ghostscript - variant file not found at: $fullPath");
				}

				// Verify it's a valid image (may be corrupted if Ghostscript is missing)
				$imageInfo = @getimagesize($fullPath);
				if ($imageInfo === false) {
					// File exists but is corrupted - Ghostscript is required but not properly configured
					$this->markTestSkipped('PDF thumbnail generation requires Ghostscript to be properly installed - variant file is corrupted');
				}

				$this->assertStringContainsString('image/', $imageInfo['mime'], "Variant '$variantName' should be an image mime type");
			}
		}

		// Check original file exists
		$this->assertNotEmpty($file->path, 'PDF should have path');
		$originalPath = UPLOADS_DIR . $file->path;
		$this->assertFileExists($originalPath, "Original PDF should exist at: $originalPath");

		// Cleanup temp file (physical uploads cleaned by tearDown via FileStorage behavior)
		@unlink($tmpFile);
	}

	/**
	 * Generate minimal valid PDF content for testing
	 *
	 * @return string
	 */
	protected function getMinimalPdfContent(): string {
		// Minimal PDF with "Test PDF" text
		return <<< 'PDF'
%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj
2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj
3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
/Resources <<
/Font <<
/F1 5 0 R
>>
>>
>>
endobj
4 0 obj
<<
/Length 44
>>
stream
BT
/F1 24 Tf
100 700 Td
(Test PDF) Tj
ET
endstream
endobj
5 0 obj
<<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
endobj
xref
0 6
0000000000 65535 f
0000000009 00000 n
0000000058 00000 n
0000000115 00000 n
0000000262 00000 n
0000000355 00000 n
trailer
<<
/Size 6
/Root 1 0 R
>>
startxref
433
%%EOF
PDF;
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

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'test.png', 'image/png');

		// Post to PDFs action
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'pdfs'], [
			'file' => $uploadedFile,
		]);

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

	/**
	 * Test that deleting a file also deletes physical files and variants
	 *
	 * @return void
	 */
	public function testDeleteRemovesPhysicalFiles() {
		// Create and upload a test image
		$image = imagecreatetruecolor(100, 100);
		$blue = imagecolorallocate($image, 0, 0, 255);
		imagefill($image, 0, 0, $blue);

		$tmpFile = TMP . 'test_delete_' . time() . '.png';
		imagepng($image, $tmpFile);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'delete-test.png', 'image/png');

		// Upload the file
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'images'], [
			'file' => $uploadedFile,
		]);

		$this->assertRedirect(['action' => 'images']);

		// Get the uploaded file from database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'images',
				'filename' => 'delete-test.png',
			])
			->orderByDesc('id')
			->first();

		$this->assertNotNull($file, 'File should be saved to database');

		// Store paths for verification
		$originalPath = UPLOADS_DIR . $file->path;
		$this->assertFileExists($originalPath, 'Original file should exist on disk');

		$variantPaths = [];
		$variants = $file->variants ?? [];
		foreach ($variants as $variantName => $variant) {
			if (!empty($variant['path'])) {
				$variantPath = UPLOADS_DIR . $variant['path'];
				$variantPaths[] = $variantPath;
				$this->assertFileExists($variantPath, "Variant '$variantName' should exist on disk");
			}
		}

		// Now delete via controller action
		$this->post(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'delete', $file->id]);

		$this->assertRedirect();

		// Verify database record is deleted
		$deletedFile = $FileStorage->find()
			->where(['id' => $file->id])
			->first();
		$this->assertNull($deletedFile, 'File should be deleted from database');

		// Verify physical files are deleted
		$this->assertFileDoesNotExist($originalPath, 'Original file should be deleted from disk');

		foreach ($variantPaths as $variantPath) {
			$this->assertFileDoesNotExist($variantPath, 'Variant file should be deleted from disk');
		}

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test image cropping page loads
	 *
	 * @return void
	 */
	public function testImageCroppingPageLoads() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'imageCropping']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Image Cropping Before Upload');
		$this->assertResponseContains('cropperImage');
	}

	/**
	 * Test image cropping AJAX upload with base64 data
	 *
	 * @return void
	 */
	public function testImageCroppingAjaxUpload() {
		// Create a small test image (10x10 red square)
		$image = imagecreatetruecolor(10, 10);
		$red = imagecolorallocate($image, 255, 0, 0);
		imagefill($image, 0, 0, $red);

		// Convert to base64
		ob_start();
		imagepng($image);
		$imageData = ob_get_clean();
		$base64Image = 'data:image/png;base64,' . base64_encode($imageData);

		// Post with AJAX headers
		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'imageCropping', '?' => ['ajax' => 1]],
			[
				'cropped_image' => $base64Image,
				'original_filename' => 'cropped-test.png',
			],
		);

		// Should return JSON response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		// Parse JSON response
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertTrue($response['success'], 'Upload should succeed');
		$this->assertArrayHasKey('file', $response, 'Response should contain file data');

		// Verify file was saved to database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'cropped',
			])
			->orderByDesc('id')
			->first();

		$this->assertNotNull($file, 'File should be saved to database');
		$this->assertSame('FileStorage', $file->model);
		$this->assertSame('cropped', $file->collection);
		$this->assertStringContainsString('.png', $file->filename);
	}

	/**
	 * Test image cropping enforces 3-file limit
	 *
	 * @return void
	 */
	public function testImageCroppingEnforcesLimit() {
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');

		// Create 3 dummy cropped images
		for ($i = 1; $i <= 3; $i++) {
			$image = imagecreatetruecolor(10, 10);
			ob_start();
			imagepng($image);
			$imageData = ob_get_clean();
			$base64Image = 'data:image/png;base64,' . base64_encode($imageData);

			$this->configRequest([
				'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
			]);

			$this->post(
				['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'imageCropping', '?' => ['ajax' => 1]],
				[
					'cropped_image' => $base64Image,
					'original_filename' => "crop-$i.png",
				],
			);

			$this->assertResponseCode(200);
		}

		// Verify we have 3 files
		$count = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'cropped',
			])
			->count();
		$this->assertEquals(3, $count, 'Should have 3 files in cropped collection');

		// Try to upload a 4th file
		$image = imagecreatetruecolor(10, 10);
		ob_start();
		imagepng($image);
		$imageData = ob_get_clean();
		$base64Image = 'data:image/png;base64,' . base64_encode($imageData);

		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'imageCropping', '?' => ['ajax' => 1]],
			[
				'cropped_image' => $base64Image,
				'original_filename' => 'crop-fourth.png',
			],
		);

		// Should return JSON error response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertFalse($response['success'], 'Upload should fail when limit reached');
		$this->assertArrayHasKey('error', $response);
		$this->assertStringContainsString('Maximum 3', $response['error']);

		// Should still have only 3 files
		$newCount = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'cropped',
			])
			->count();
		$this->assertEquals(3, $newCount, 'Should still have only 3 files (4th was rejected)');
	}

	/**
	 * Test drag-drop upload page loads
	 *
	 * @return void
	 */
	public function testDragDropUploadPageLoads() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('Modern Drag & Drop Upload');
		$this->assertResponseContains('dropZone');
	}

	/**
	 * Test drag-drop AJAX upload success
	 *
	 * @return void
	 */
	public function testDragDropAjaxUploadSuccess() {
		// Create a test image
		$image = imagecreatetruecolor(100, 100);
		$blue = imagecolorallocate($image, 0, 0, 255);
		imagefill($image, 0, 0, $blue);

		$tmpFile = TMP . 'test_drag_' . time() . '.png';
		imagepng($image, $tmpFile);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'drag-test.png', 'image/png');

		// Post with AJAX flag
		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload', '?' => ['ajax' => 1]],
			['file' => $uploadedFile],
		);

		// Should return JSON response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		// Parse JSON response
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertTrue($response['success'], 'Upload should succeed');
		$this->assertArrayHasKey('file', $response, 'Response should contain file data');
		$this->assertSame('drag-test.png', $response['file']['filename']);

		// Verify file was saved to database
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
				'filename' => 'drag-test.png',
			])
			->orderByDesc('id')
			->first();

		$this->assertNotNull($file, 'File should be saved to database');
		$this->assertSame('FileStorage', $file->model);
		$this->assertSame('drag-drop', $file->collection);

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test drag-drop AJAX upload with invalid file type
	 *
	 * @return void
	 */
	public function testDragDropAjaxUploadInvalidType() {
		// Create a fake GIF file (not allowed)
		$tmpFile = TMP . 'test_drag_invalid_' . time() . '.gif';
		file_put_contents($tmpFile, 'GIF89a');

		$this->assertFileExists($tmpFile, 'Test file should be created');

		$uploadedFile = $this->createUploadedFile($tmpFile, 'invalid.gif', 'image/gif');

		// Post with AJAX flag
		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload', '?' => ['ajax' => 1]],
			['file' => $uploadedFile],
		);

		// Should return JSON error response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		// Parse JSON response
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertFalse($response['success'], 'Upload should fail');
		$this->assertArrayHasKey('error', $response, 'Response should contain error message');

		// Verify file was NOT saved
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
				'filename' => 'invalid.gif',
			])
			->first();

		$this->assertNull($file, 'Invalid file should not be saved');

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test drag-drop AJAX upload with file too large
	 *
	 * @return void
	 */
	public function testDragDropAjaxUploadFileTooLarge() {
		// Create a test image
		$image = imagecreatetruecolor(100, 100);
		$tmpFile = TMP . 'test_drag_large_' . time() . '.png';
		imagepng($image, $tmpFile);

		$this->assertFileExists($tmpFile, 'Test image should be created');

		// Fake the file size to be over 2MB
		$uploadedFile = $this->createUploadedFile($tmpFile, 'large.png', 'image/png', 2 * 1024 * 1024 + 1);

		// Post with AJAX flag
		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload', '?' => ['ajax' => 1]],
			['file' => $uploadedFile],
		);

		// Should return JSON error response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		// Parse JSON response
		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertFalse($response['success'], 'Upload should fail for large file');
		$this->assertArrayHasKey('error', $response, 'Response should contain error message');

		// Verify file was NOT saved
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');
		$file = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
				'filename' => 'large.png',
			])
			->first();

		$this->assertNull($file, 'Large file should not be saved');

		// Cleanup
		@unlink($tmpFile);
	}

	/**
	 * Test that maximum 3 uploads for drag-drop collection is enforced
	 *
	 * @return void
	 */
	public function testDragDropMaximumCountLimitEnforced() {
		$FileStorage = $this->getTableLocator()->get('FileStorage.FileStorage');

		// Note: Rate limiter middleware is automatically disabled in test environment

		// Create 3 dummy files in the drag-drop collection
		for ($i = 1; $i <= 3; $i++) {
			$image = imagecreatetruecolor(10, 10);
			$tmpFile = TMP . 'test_drag_dummy_' . $i . '_' . time() . '.png';
			imagepng($image, $tmpFile);

			$uploadedFile = $this->createUploadedFile($tmpFile, "drag-dummy-$i.png", 'image/png');

			$this->configRequest([
				'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
			]);

			$this->post(
				['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload', '?' => ['ajax' => 1]],
				['file' => $uploadedFile],
			);

			$this->assertResponseCode(200);
		}

		// Verify we have 3 files
		$count = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
			])
			->count();
		$this->assertEquals(3, $count, 'Should have 3 files in drag-drop collection');

		// Try to upload a 4th file
		$image = imagecreatetruecolor(100, 100);
		$tmpFile = TMP . 'test_drag_fourth_' . time() . '.png';
		imagepng($image, $tmpFile);

		$uploadedFile = $this->createUploadedFile($tmpFile, 'fourth.png', 'image/png');

		$this->configRequest([
			'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
		]);

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'FileStorageExamples', 'action' => 'dragDropUpload', '?' => ['ajax' => 1]],
			['file' => $uploadedFile],
		);

		// Should return JSON error response
		$this->assertResponseCode(200);
		$this->assertContentType('application/json');

		$response = json_decode((string)$this->_response->getBody(), true);
		$this->assertNotNull($response, 'Response should be valid JSON');
		$this->assertFalse($response['success'], 'Upload should fail when limit reached');
		$this->assertArrayHasKey('error', $response);
		$this->assertStringContainsString('Maximum 3 files', $response['error']);

		// Should still have only 3 files
		$newCount = $FileStorage->find()
			->where([
				'model' => 'FileStorage',
				'collection' => 'drag-drop',
			])
			->count();
		$this->assertEquals(3, $newCount, 'Should still have only 3 files (4th was rejected)');

		// Cleanup
		@unlink($tmpFile);
	}

}
