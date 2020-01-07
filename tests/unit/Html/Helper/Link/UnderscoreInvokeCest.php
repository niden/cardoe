<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Link;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Link;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Tests Phalcon\Html\Helper\Link :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperLinkUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Link - __invoke()');

        $escaper = new Escaper();
        $helper  = new Link($escaper);

        $result = $helper()
            ->add('prev', 'https://phalcon.io/page/1')
            ->add('next', 'https://phalcon.io/page/2')
        ;

        $expected = "    <link rel=\"prev\" href=\"https://phalcon.io/page/1\" />" . PHP_EOL
            . "    <link rel=\"next\" href=\"https://phalcon.io/page/2\" />" . PHP_EOL;
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Html\Helper\Link :: __invoke() - ident and delimiter
     *
     * @since  2020-01-06
     */
    public function htmlHelperLinkUnderscoreInvokeIndentDelimiter(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Link - __invoke() - indent and delimiter');

        $escaper = new Escaper();
        $helper  = new Link($escaper);

        $result = $helper("--", "+")
            ->add('prev', 'https://phalcon.io/page/1')
            ->add('next', 'https://phalcon.io/page/2')
        ;

        $expected = "--<link rel=\"prev\" href=\"https://phalcon.io/page/1\" />+"
            . "--<link rel=\"next\" href=\"https://phalcon.io/page/2\" />+";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
