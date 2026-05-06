<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * CountryFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Data\Model\Entity\Country>
 */
class CountryFactory extends BaseFactory {

	/**
	 * @var array<string>
	 */
	protected array $uniqueProperties = [
		'name',
	];

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Data.Countries';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'name' => $generator->country(),
			'ori_name' => $generator->country(),
			'iso2' => $generator->countryISOAlpha2(),
			'iso3' => $generator->countryISOAlpha3(),
			'eu_member' => false,
			'special' => '',
			'zip_length' => 0,
			'zip_regexp' => '',
			'sort' => 0,
			'address_format' => '',
			'status' => 1,
			'modified' => $generator->dateTime(),
		];
	}

}
