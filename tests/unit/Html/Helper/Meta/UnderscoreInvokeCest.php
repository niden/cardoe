<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Meta;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Meta;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Html\Helper\Meta :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperMetaUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Meta - __invoke()');

        $escaper = new Escaper();
        $helper  = new Meta($escaper);

        $result = $helper()
            ->add(
                [
                    "charset" => 'utf-8'
                ]
            )
            ->addHttp("X-UA-Compatible", "IE=edge")
            ->addName("generator", "Phalcon")
            ->addProperty("org:url", "https://phalcon.io")
        ;

        $expected = "    <meta charset=\"utf-8\">" . PHP_EOL
            . "    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">" . PHP_EOL
            . "    <meta name=\"generator\" content=\"Phalcon\">" . PHP_EOL
            . "    <meta property=\"org:url\" content=\"https://phalcon.io\">" . PHP_EOL;
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Html\Helper\Meta :: __invoke() - ident and delimiter
     *
     * @since  2020-01-06
     */
    public function htmlHelperMetaUnderscoreInvokeIndentDelimiter(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Meta - __invoke() - indent and delimiter');

        $escaper = new Escaper();
        $helper  = new Meta($escaper);

        $result = $helper("--", "+")
            ->add(
                [
                    "charset" => 'utf-8'
                ]
            )
            ->addHttp("X-UA-Compatible", "IE=edge")
            ->addName("generator", "Phalcon")
            ->addProperty("org:url", "https://phalcon.io")
        ;

        $expected = "--<meta charset=\"utf-8\">+"
            . "--<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">+"
            . "--<meta name=\"generator\" content=\"Phalcon\">+"
            . "--<meta property=\"org:url\" content=\"https://phalcon.io\">+";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
