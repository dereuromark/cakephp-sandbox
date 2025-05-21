<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Sandbox\Model\Enum\UserStatus;
use Templating\View\Html;

/**
 * FooBar command.
 */
class FooBarCommand extends Command {

	/**
	 * The name of this command.
	 *
	 * @var string
	 */
	protected string $name = 'foo_bar';

	/**
	 * Get the default command name.
	 *
	 * @return string
	 */
	public static function defaultName(): string {
		return 'foo_bar';
	}

	/**
	 * Get the command description.
	 *
	 * @return string
	 */
	public static function getDescription(): string {
		return 'Command description here.';
	}

	/**
	 * Hook method for defining this command's option parser.
	 *
	 * @see https://book.cakephp.org/5/en/console-commands/commands.html#defining-arguments-and-options
	 * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
	 * @return \Cake\Console\ConsoleOptionParser The built parser.
	 */
	public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser {
		return parent::buildOptionParser($parser)
			->setDescription(static::getDescription());
	}

	/**
	 * Implement this method with your command's logic.
	 *
	 * @param \Cake\Console\Arguments $args The command arguments.
	 * @param \Cake\Console\ConsoleIo $io The console io
	 * @return int|null|void The exit code or null for success
	 */
	public function execute(Arguments $args, ConsoleIo $io) {
		$data = [
			'src/' => [
				'Command/',
				'Controller/' => [
					'DefaultController.php',
				],
				'Kernel.php',
				(string)Html::create('<b>x</b>'),
				UserStatus::Active->label(),
			],
			'templates/' => [
				'base.html.twig',
			],
		];

		$io->helper('Tree')->output($data);
	}

}
