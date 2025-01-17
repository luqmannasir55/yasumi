<?php
/**
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2019 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace Yasumi\tests\Portugal;

use Yasumi\Holiday;

/**
 * Class for testing holidays in Poland.
 */
class PortugalTest extends PortugalBaseTestCase
{
    /**
     * @var int year random year number used for all tests in this Test Case
     */
    protected $year;

    /**
     * Tests if all official holidays in Portugal are defined by the provider class
     * @throws \ReflectionException
     */
    public function testOfficialHolidays(): void
    {
        $this->assertDefinedHolidays([
            'newYearsDay',
            'internationalWorkersDay',
            'easter',
            'goodFriday',
            'assumptionOfMary',
            'allSaintsDay',
            'immaculateConception',
            'christmasDay',
            '25thApril',
            'portugueseRepublic',
            'restorationOfIndependence',
            'portugalDay'
        ], self::REGION, $this->year, Holiday::TYPE_OFFICIAL);
    }

    /**
     * Tests if all observed holidays in Portugal are defined by the provider class
     * @throws \ReflectionException
     */
    public function testObservedHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_OBSERVANCE);
    }

    /**
     * Tests if all seasonal holidays in Portugal are defined by the provider class
     * @throws \ReflectionException
     */
    public function testSeasonalHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_SEASON);
    }

    /**
     * Tests if all bank holidays in Portugal are defined by the provider class
     * @throws \ReflectionException
     */
    public function testBankHolidays(): void
    {
        $this->assertDefinedHolidays([], self::REGION, $this->year, Holiday::TYPE_BANK);
    }

    /**
     * Tests if all other holidays in PortugalPortugal are defined by the provider class
     * @throws \ReflectionException
     */
    public function testOtherHolidays(): void
    {
        $holidays = [];

        if ($this->year <= 2012 || $this->year >= 2016) {
            $holidays[] = 'corpusChristi';
        }

        $this->assertDefinedHolidays($holidays, self::REGION, $this->year, Holiday::TYPE_OTHER);
    }

    /**
     * Initial setup of this Test Case
     */
    protected function setUp()
    {
        $this->year = $this->generateRandomYear(1974);
    }
}
