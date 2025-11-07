<?php
declare(strict_types=1);

namespace Sandbox\FileStorage\Processor;

use PhpCollective\Infrastructure\Storage\FileInterface;
use PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface;

/**
 * Unified File Processor
 *
 * Routes processing to the appropriate processor based on file type:
 * - Images -> ImageProcessor
 * - PDFs -> PdfThumbnailProcessor
 * - Others -> No processing
 */
class UnifiedFileProcessor implements ProcessorInterface {

	protected ?ProcessorInterface $imageProcessor;

	protected ?ProcessorInterface $pdfProcessor;

	/**
	 * Constructor
	 *
	 * @param \PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface|null $imageProcessor
	 * @param \PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface|null $pdfProcessor
	 */
	public function __construct(
		?ProcessorInterface $imageProcessor = null,
		?ProcessorInterface $pdfProcessor = null,
	) {
		$this->imageProcessor = $imageProcessor;
		$this->pdfProcessor = $pdfProcessor;
	}

	/**
	 * Process file based on type
	 *
	 * @param \PhpCollective\Infrastructure\Storage\FileInterface $file
	 * @return \PhpCollective\Infrastructure\Storage\FileInterface
	 */
	public function process(FileInterface $file): FileInterface {
		$mimeType = $file->mimeType();

		// Handle images
		if ($this->isImage($mimeType) && $this->imageProcessor && $file->variants()) {
			return $this->imageProcessor->process($file);
		}

		// Handle PDFs
		if ($mimeType === 'application/pdf' && $this->pdfProcessor && $file->variants()) {
			return $this->pdfProcessor->process($file);
		}

		// No processing for other file types
		return $file;
	}

	/**
	 * Check if mime type is an image
	 *
	 * @param string|null $mimeType
	 * @return bool
	 */
	protected function isImage(?string $mimeType): bool {
		if (!$mimeType) {
			return false;
		}

		return str_starts_with($mimeType, 'image/');
	}

}
