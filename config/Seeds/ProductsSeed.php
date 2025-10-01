<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Init seed.
 */
class ProductsSeed extends BaseSeed {

	/**
	 * Run Method.
	 *
	 * Write your database seeder using this method.
	 *
	 * More information on writing seeds is available here:
	 * https://book.cakephp.org/phinx/0/en/seeding.html
	 *
	 * @return void
	 */
	public function run(): void {
		$data = [
			[
				'title' => 'Invisibility Cloak (One Size Fits All)',
				'price' => '99.99',
			],
			[
				'title' => 'Unicorn Tears - Limited Edition',
				'price' => '149.95',
			],
			[
				'title' => 'Portable Hole (Do Not Drop)',
				'price' => '75.50',
			],
			[
				'title' => 'Left-Handed Wrench',
				'price' => '12.34',
			],
			[
				'title' => 'Time Machine (Batteries Not Included)',
				'price' => '199.99',
			],
			[
				'title' => 'Self-Watering Cactus (Still Died)',
				'price' => '8.88',
			],
			[
				'title' => 'Antigravity Boots (Use at Your Own Risk)',
				'price' => '139.95',
			],
			[
				'title' => 'Screaming Pickle Plush Toy',
				'price' => '13.37',
			],
			[
				'title' => 'Coffee Mug That Screams When Empty',
				'price' => '17.76',
			],
			[
				'title' => 'Interdimensional Remote (Works 50% of the Time)',
				'price' => '110.00',
			],
			[
				'title' => 'USB-Powered Pet Rock',
				'price' => '14.99',
			],
			[
				'title' => 'Bluetooth Toaster (With App)',
				'price' => '59.99',
			],
			[
				'title' => 'WiFi-Enabled Toothbrush (Tracks Brushing Stats)',
				'price' => '39.95',
			],
			[
				'title' => 'Smart Spoon (Critiques Your Eating Speed)',
				'price' => '22.22',
			],
			[
				'title' => 'AI-Powered Plant Whisperer',
				'price' => '79.50',
			],
			[
				'title' => 'Voice-Controlled Paper Shredder',
				'price' => '89.00',
			],
			[
				'title' => 'Mood Ring That Tweets for You',
				'price' => '24.99',
			],
			[
				'title' => 'Laser-Guided Pizza Cutter',
				'price' => '29.99',
			],
			[
				'title' => 'Solar-Powered Night Light',
				'price' => '19.95',
			],
			[
				'title' => 'Smart Mirror That Roasts You',
				'price' => '129.00',
			],
		];

		$table = $this->table('sandbox_products');
		$table->insert($data)->save();
	}

}
