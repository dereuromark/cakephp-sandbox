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
				'stock' => 10,
			],
			[
				'title' => 'Unicorn Tears - Limited Edition',
				'price' => '149.95',
				'stock' => 3,
			],
			[
				'title' => 'Portable Hole (Do Not Drop)',
				'price' => '75.50',
				'stock' => 25,
			],
			[
				'title' => 'Left-Handed Wrench',
				'price' => '12.34',
				'stock' => 100,
			],
			[
				'title' => 'Time Machine (Batteries Not Included)',
				'price' => '199.99',
				'stock' => 1,
			],
			[
				'title' => 'Self-Watering Cactus (Still Died)',
				'price' => '8.88',
				'stock' => 50,
			],
			[
				'title' => 'Antigravity Boots (Use at Your Own Risk)',
				'price' => '139.95',
				'stock' => 5,
			],
			[
				'title' => 'Screaming Pickle Plush Toy',
				'price' => '13.37',
				'stock' => 75,
			],
			[
				'title' => 'Coffee Mug That Screams When Empty',
				'price' => '17.76',
				'stock' => 42,
			],
			[
				'title' => 'Interdimensional Remote (Works 50% of the Time)',
				'price' => '110.00',
				'stock' => 8,
			],
			[
				'title' => 'USB-Powered Pet Rock',
				'price' => '14.99',
				'stock' => 200,
			],
			[
				'title' => 'Bluetooth Toaster (With App)',
				'price' => '59.99',
				'stock' => 15,
			],
			[
				'title' => 'WiFi-Enabled Toothbrush (Tracks Brushing Stats)',
				'price' => '39.95',
				'stock' => 30,
			],
			[
				'title' => 'Smart Spoon (Critiques Your Eating Speed)',
				'price' => '22.22',
				'stock' => 60,
			],
			[
				'title' => 'AI-Powered Plant Whisperer',
				'price' => '79.50',
				'stock' => 12,
			],
			[
				'title' => 'Voice-Controlled Paper Shredder',
				'price' => '89.00',
				'stock' => 20,
			],
			[
				'title' => 'Mood Ring That Tweets for You',
				'price' => '24.99',
				'stock' => 45,
			],
			[
				'title' => 'Laser-Guided Pizza Cutter',
				'price' => '29.99',
				'stock' => 35,
			],
			[
				'title' => 'Solar-Powered Night Light',
				'price' => '19.95',
				'stock' => 80,
			],
			[
				'title' => 'Smart Mirror That Roasts You',
				'price' => '129.00',
				'stock' => 7,
			],
		];

		$table = $this->table('sandbox_products');
		$table->insert($data)->save();
	}

}
