<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use Codeception\Example;
use UnitTester;

class RandomCest
{
    /**
     * Tests Cardoe\Helper\Str :: random() - constants
     *
     * @since  2019-04-06
     */
    public function helperStrRandomConstants(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - random() - constants');

        $I->assertEquals(0, Str::RANDOM_ALNUM);
        $I->assertEquals(1, Str::RANDOM_ALPHA);
        $I->assertEquals(2, Str::RANDOM_HEXDEC);
        $I->assertEquals(3, Str::RANDOM_NUMERIC);
        $I->assertEquals(4, Str::RANDOM_NOZERO);
        $I->assertEquals(5, Str::RANDOM_DISTINCT);
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - alnum
     *
     * @since        2019-04-06
     *
     * @dataProvider oneToTenProvider
     */
    public function helperStrRandomAlnum(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - alnum');

        $i = $example[0];

        $source = Str::random(
            Str::RANDOM_ALNUM,
            $i
        );

        $I->assertEquals(
            1,
            preg_match('/[a-zA-Z0-9]+/', $source, $matches)
        );

        $I->assertEquals(
            $source,
            $matches[0]
        );

        $I->assertEquals(
            $i,
            strlen($source)
        );
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - alpha
     *
     * @since        2019-04-06
     *
     * @dataProvider oneToTenProvider
     */
    public function helperStrRandomAlpha(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - alpha');

        $i = $example[0];

        $source = Str::random(
            Str::RANDOM_ALPHA,
            $i
        );

        $I->assertEquals(
            1,
            preg_match('/[a-zA-Z]+/', $source, $matches)
        );

        $I->assertEquals(
            $source,
            $matches[0]
        );

        $I->assertEquals(
            $i,
            strlen($source)
        );
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - hexdec
     *
     * @since        2019-04-06
     *
     * @dataProvider oneToTenProvider
     */
    public function helperStrRandomHexDec(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - hexdex');

        $i = $example[0];

        $source = Str::random(
            Str::RANDOM_HEXDEC,
            $i
        );

        $I->assertEquals(
            1,
            preg_match('/[a-f0-9]+/', $source, $matches)
        );

        $I->assertEquals(
            $source,
            $matches[0]
        );

        $I->assertEquals(
            $i,
            strlen($source)
        );
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - numeric
     *
     * @since        2019-04-06
     *
     * @dataProvider oneToTenProvider
     */
    public function helperStrRandomNumeric(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - numeric');

        $i = $example[0];

        $source = Str::random(
            Str::RANDOM_NUMERIC,
            $i
        );

        $I->assertEquals(
            1,
            preg_match('/[0-9]+/', $source, $matches)
        );

        $I->assertEquals(
            $source,
            $matches[0]
        );

        $I->assertEquals(
            $i,
            strlen($source)
        );
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - non zero
     *
     * @since        2019-04-06
     *
     * @dataProvider oneToTenProvider
     */
    public function helperStrRandomNonZero(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - non zero');

        $i = $example[0];

        $source = Str::random(
            Str::RANDOM_NOZERO,
            $i
        );

        $I->assertEquals(
            1,
            preg_match('/[1-9]+/', $source, $matches)
        );

        $I->assertEquals(
            $source,
            $matches[0]
        );

        $I->assertEquals(
            $i,
            strlen($source)
        );
    }

    /**
     * Tests Cardoe\Helper\Str :: random() - distinct type
     *
     * @since        2019-04-06
     *
     * @dataProvider helperStrRandomDistinctProvider
     */
    public function helperStrRandomDistinct(UnitTester $I, Example $example)
    {
        $I->wantToTest('Helper\Str - random() - distinct');

        $source = Str::random(
            Str::RANDOM_DISTINCT,
            $example[0]
        );

        $I->assertRegExp(
            '#^[2345679ACDEFHJKLMNPRSTUVWXYZ]+$#',
            $source
        );

        $I->assertEquals(
            $example[0],
            strlen($source)
        );
    }

    private function oneToTenProvider(): array
    {
        return [
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7],
            [8],
            [9],
            [10],
        ];
    }

    private function helperStrRandomDistinctProvider(): array
    {
        return [
            [1],
            [10],
            [100],
            [200],
            [500],
            [1000],
            [2000],
            [3000],
            [4000],
            [5000],
        ];
    }
}
