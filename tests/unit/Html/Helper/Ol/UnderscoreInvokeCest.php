<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Ol;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Ol;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Html\Helper\Ol :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperOlUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Ol - __invoke()');

        $escaper = new Escaper();
        $helper  = new Ol($escaper);

        $result = $helper(null, null, ['id' => 'carsList'])
            ->add("> Ferrari", ["class" => "active"])
            ->add("> Ford")
            ->add("> Dodge")
            ->add("> Toyota")
        ;

        $expected = "<ol id=\"carsList\">
    <li class=\"active\">&gt; Ferrari</li>
    <li>&gt; Ford</li>
    <li>&gt; Dodge</li>
    <li>&gt; Toyota</li>
</ol>";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Html\Helper\Ol :: __invoke() - addRaw
     *
     * @since  2020-01-06
     */
    public function htmlHelperOlUnderscoreInvokeAddRaw(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Ol - __invoke() - addRaw');

        $escaper = new Escaper();
        $helper  = new Ol($escaper);

        $result = $helper(null, null, ['id' => 'carsList'])
            ->addRaw("> Ferrari", ["class" => "active"])
            ->addRaw("> Ford")
            ->addRaw("> Dodge")
            ->addRaw("> Toyota")
        ;

        $expected = "<ol id=\"carsList\">
    <li class=\"active\">> Ferrari</li>
    <li>> Ford</li>
    <li>> Dodge</li>
    <li>> Toyota</li>
</ol>";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Html\Helper\Ol :: __invoke() - indent and delimiter
     *
     * @since  2020-01-06
     */
    public function htmlHelperOlUnderscoreInvokeIndentDelimiter(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Ol - __invoke() - indent and delimiter');

        $escaper = new Escaper();
        $helper  = new Ol($escaper);

        $result = $helper("--", "+", ['id' => 'carsList'])
            ->add("> Ferrari", ["class" => "active"])
            ->add("> Ford")
        ;

        $expected = "<ol id=\"carsList\">+"
            . "--<li class=\"active\">&gt; Ferrari</li>+"
            . "--<li>&gt; Ford</li>+"
            . "</ol>";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
