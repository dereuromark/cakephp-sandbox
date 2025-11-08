<?php
declare(strict_types=1);

namespace Sandbox\FileStorage\Processor;

use PhpCollective\Infrastructure\Storage\FileInterface;
use PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface;

/**
 * Conditional Image Processor
 *
 * Only processes files that have image variants configured.
 * Non-image files are passed through unchanged.
 */
class ConditionalImageProcessor implements ProcessorInterface {

	/**
	 * @var \PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface|null
	 */
	protected $imageProcessor;

	/**
	 * @param \PhpCollective\Infrastructure\Storage\Processor\ProcessorInterface|null $imageProcessor Image processor
	 */
	public function __construct(?ProcessorInterface $imageProcessor = null) {
		$this->imageProcessor = $imageProcessor;
	}

	/**
	 * @inheritDoc
	 */
	public function process(FileInterface $file): FileInterface {
		// Only process if we have an image processor and the file has variants
		if ($this->imageProcessor && $file->variants()) {
			return $this->imageProcessor->process($file);
		}

		// For non-images or files without variants, just return as-is
		return $file;
	}

}
