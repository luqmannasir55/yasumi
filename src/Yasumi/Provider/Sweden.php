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

namespace Yasumi\Provider;

use DateTime;
use DateTimeZone;
use Yasumi\Holiday;

/**
 * Provider for all holidays in Sweden.
 */
class Sweden extends AbstractProvider
{
    use CommonHolidays, ChristianHolidays;

    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region.
     */
    public const ID = 'SE';

    /**
     * Initialize holidays for Sweden.
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    public function initialize(): void
    {
        $this->timezone = 'Europe/Stockholm';

        // Add common holidays
        $this->addHoliday($this->newYearsDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->internationalWorkersDay($this->year, $this->timezone, $this->locale));

        // Add common Christian holidays (common in Sweden)
        $this->addHoliday($this->epiphany($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->goodFriday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->easter($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->easterMonday($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->ascensionDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->pentecost($this->year, $this->timezone, $this->locale));
        $this->calculateStJohnsDay(); // aka Midsummer's Day
        $this->calculateAllSaintsDay();
        $this->addHoliday($this->christmasEve($this->year, $this->timezone, $this->locale, Holiday::TYPE_OFFICIAL));
        $this->addHoliday($this->christmasDay($this->year, $this->timezone, $this->locale));
        $this->addHoliday($this->secondChristmasDay($this->year, $this->timezone, $this->locale));

        // Calculate other holidays
        $this->calculateNationalDay();
    }

    /**
     * St. John's Day / Midsummer.
     *
     * Midsummer, also known as St John's Day, is the period of time centred upon the summer solstice, and more
     * specifically the Northern European celebrations that accompany the actual solstice or take place on a day
     * between June 19 and June 25 and the preceding evening. The exact dates vary between different cultures.
     * The Christian Church designated June 24 as the feast day of the early Christian martyr St John the Baptist, and
     * the observance of St John's Day begins the evening before, known as St John's Eve.
     *
     * In Sweden the holiday has always been on a Saturday (between June 20 and June 26). Many of the celebrations of
     * midsummer take place on midsummer eve, when many workplaces are closed and shops must close their doors at noon.
     *
     * @link https://en.wikipedia.org/wiki/Midsummer#Sweden
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateStJohnsDay(): void
    {
        $this->addHoliday(new Holiday(
            'stJohnsDay',
            [],
            new DateTime("$this->year-6-20 this saturday", new DateTimeZone($this->timezone)),
            $this->locale
        ));
    }

    /**
     * All Saints Day.
     *
     * All Saints' Day is a celebration of all Christian saints, particularly those who have no special feast days of
     * their own, in many Roman Catholic, Anglican and Protestant churches. In many western churches it is annually held
     * November 1 and in many eastern churches it is celebrated on the first Sunday after Pentecost. It is also known
     * as All Hallows Tide, All-Hallomas, or All Hallows' Day.
     *
     * The festival was retained after the Reformation in the calendar of the Anglican Church and in many Lutheran
     * churches. In the Lutheran churches, such as the Church of Sweden, it assumes a role of general commemoration of
     * the dead. In the Swedish calendar, the observance takes place on the Saturday between 31 October and 6 November.
     * In many Lutheran Churches, it is moved to the first Sunday of November.
     *
     * @link https://en.wikipedia.org/wiki/All_Saints%27_Day
     * @link http://www.timeanddate.com/holidays/sweden/all-saints-day
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateAllSaintsDay(): void
    {
        $this->addHoliday(new Holiday(
            'allSaintsDay',
            [],
            new DateTime("$this->year-10-31 this saturday", new DateTimeZone($this->timezone)),
            $this->locale
        ));
    }

    /**
     * National Day
     *
     * National Day of Sweden (Sveriges nationaldag) is a national holiday observed in Sweden on 6 June every year.
     * Prior to 1983, the day was celebrated as Svenska flaggans dag (Swedish flag day). At that time, the day was
     * renamed to the national day by the Riksdag. The tradition of celebrating this date began 1916 at the Stockholm
     * Olympic Stadium, in honour of the election of King Gustav Vasa in 1523, as this was considered the foundation of
     * modern Sweden.
     *
     * @throws \Yasumi\Exception\InvalidDateException
     * @throws \InvalidArgumentException
     * @throws \Yasumi\Exception\UnknownLocaleException
     * @throws \Exception
     */
    private function calculateNationalDay(): void
    {
        if ($this->year < 1916) {
            return;
        }

        $holiday_name = 'Svenska flaggans dag';

        // Since 1983 this day was named 'Sveriges nationaldag'
        if ($this->year >= 1983) {
            $holiday_name = 'Sveriges nationaldag';
        }

        $this->addHoliday(new Holiday(
            'nationalDay',
            ['sv_SE' => $holiday_name],
            new DateTime("$this->year-6-6", new DateTimeZone($this->timezone)),
            $this->locale
        ));
    }
}
