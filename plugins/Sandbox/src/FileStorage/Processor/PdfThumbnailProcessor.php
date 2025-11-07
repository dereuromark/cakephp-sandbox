<?php
declare(strict_types=1);

namespace Sandbox\FileStorage\Processor;

use Intervention\Image\ImageManager;
use PhpCollective\Infrastructure\Storage\FileInterface;
use PhpCollective\Infrastructure\Storage\Processor\Image\Operations;
use PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\PdfToImage\Pdf;

/**
 * PDF Thumbnail Processor
 *
 * Generates preview thumbnails for PDF files by converting the first page to an image
 */
class PdfThumbnailProcessor implements ProcessorInterface {

	protected ?ProcessorInterface $imageProcessor;

	/**
	 * Constructor
	 *
	 * @param \PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface|null $imageProcessor
	 */
	public function __construct(?ProcessorInterface $imageProcessor = null) {
		$this->imageProcessor = $imageProcessor;
	}

	/**
	 * Process PDF file to generate thumbnail preview
	 *
	 * @param \PhpCollective\Infrastructure\Storage\FileInterface $file
	 * @return \PhpCollective\Infrastructure\Storage\FileInterface
	 */
	public function process(FileInterface $file): FileInterface {
		// Only process PDFs
		if ($file->mimeType() !== 'application/pdf') {
			return $file;
		}

		// Only process if we have variants configured and an image processor
		if (empty($file->variants()) || !$this->imageProcessor) {
			return $file;
		}

		$pdfPath = UPLOADS_DIR . $file->path();
		if (!file_exists($pdfPath)) {
			return $file;
		}

		// Create temporary image from first page of PDF
		$tempImage = TMP . 'pdf_preview_' . uniqid() . '.jpg';

		try {
			$pdf = new Pdf($pdfPath);
			$pdf->setOutputFormat('jpg')
				->setPage(1)
				->saveImage($tempImage);

			// Now we need to process this temporary image through the image processor
			// to generate the configured variants
			if (file_exists($tempImage)) {
				$variants = $this->generateVariants($file, $tempImage);
				if ($variants) {
					// File objects are immutable - return new instance with variants
					$file = $file->withVariants($variants, false);
				}

				@unlink($tempImage);
			}
		} catch (\Exception $e) {
			// PDF conversion failed, continue without thumbnail
			// Could log this error if needed
			@unlink($tempImage);
		}

		return $file;
	}

	/**
	 * Generate image variants from the PDF preview image
	 *
	 * @param \PhpCollective\Infrastructure\Storage\FileInterface $file
	 * @param string $imagePath
	 * @return array<string, array<string, mixed>>
	 */
	protected function generateVariants(FileInterface $file, string $imagePath): array {
		$variants = [];
		$configuredVariants = $file->variants() ?: [];

		// Get the image manager (GD in our case)
		$imageManager = ImageManager::gd();

		foreach ($configuredVariants as $variantName => $variantConfig) {
			try {
				// Load the temporary image
				$image = $imageManager->read($imagePath);

				// Apply the variant operations
				$operations = new Operations($image);

				if (isset($variantConfig['operations'])) {
					foreach ($variantConfig['operations'] as $operation => $args) {
						if (method_exists($operations, $operation)) {
							$operations->$operation($args);
						}
					}
				}

				// Generate variant filename
				$variantPath = $this->generateVariantPath($file, $variantName);
				$fullVariantPath = UPLOADS_DIR . $variantPath;

				// Ensure directory exists
				$variantDir = dirname($fullVariantPath);
				if (!is_dir($variantDir)) {
					mkdir($variantDir, 0777, true);
				}

				// Save the variant
				$image->save($fullVariantPath, quality: 85);

				// Store variant information
				$variants[$variantName] = [
					'path' => $variantPath,
					'url' => '', // Local storage doesn't use URLs
				];

				// Optimize if configured
				if (!empty($variantConfig['optimize'])) {
					$this->optimizeImage($fullVariantPath);
				}
			} catch (\Exception $e) {
				// Skip this variant if it fails
				continue;
			}
		}

		return $variants;
	}

	/**
	 * Generate variant path using the same pattern as original file
	 *
	 * @param \PhpCollective\Infrastructure\Storage\FileInterface $file
	 * @param string $variantName
	 * @return string
	 */
	protected function generateVariantPath(FileInterface $file, string $variantName): string {
		$originalPath = $file->path();
		$pathInfo = pathinfo($originalPath);

		// Generate a hash for the variant name (similar to how image processor does it)
		$hashedVariant = substr(md5($variantName), 0, 6);

		// Ensure dirname exists (pathinfo may not have it for root paths)
		$dirname = $pathInfo['dirname'] ?? '';
		if ($dirname && $dirname !== '.') {
			$dirname .= '/';
		} else {
			$dirname = '';
		}

		// Create variant path: path/filename.hash.jpg (always jpg for PDF previews)
		return $dirname . $pathInfo['filename'] . '.' . $hashedVariant . '.jpg';
	}

	/**
	 * Optimize image file size if optimizer is available
	 *
	 * @param string $imagePath
	 * @return void
	 */
	protected function optimizeImage(string $imagePath): void {
		// Check if image optimizer is available
		if (!class_exists('Spatie\ImageOptimizer\OptimizerChainFactory')) {
			return;
		}

		try {
			$optimizerChain = OptimizerChainFactory::create();
			$optimizerChain->optimize($imagePath);
		} catch (\Exception $e) {
			// Optimization failed, continue without it
		}
	}

}
