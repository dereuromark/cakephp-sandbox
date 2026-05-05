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
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Data.Countries';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
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
		});
	}

}
