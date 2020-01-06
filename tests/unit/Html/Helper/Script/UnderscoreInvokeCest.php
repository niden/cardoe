<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Script;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Script;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Html\Helper\Script :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperScriptUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Script - __invoke()');

        $escaper = new Escaper();
        $helper  = new Script($escaper);

        $result = $helper()
            ->add("/js/custom.js")
            ->add("/js/print.js", ["ie" => "active"])
        ;
        $expected = "    <script type=\"text/javascript\" src=\"/js/custom.js\"></script>" . PHP_EOL
            . "    <script type=\"text/javascript\" src=\"/js/print.js\" ie=\"active\"></script>" . PHP_EOL;
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Html\Helper\Script :: __invoke() - ident and delimiter
     *
     * @since  2020-01-06
     */
    public function htmlHelperScriptUnderscoreInvokeIndentDelimiter(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Script - __invoke() - indent and delimiter');

        $escaper = new Escaper();
        $helper  = new Script($escaper);

        $result = $helper("--", "+")
            ->add("/js/custom.js")
            ->add("/js/print.js", ["ie" => "active"])
        ;
        $expected = "--<script type=\"text/javascript\" src=\"/js/custom.js\"></script>+"
            . "--<script type=\"text/javascript\" src=\"/js/print.js\" ie=\"active\"></script>+";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
