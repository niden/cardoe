<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Ul;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Ul;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Tests Phalcon\Html\Helper\Ul :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperUlUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Ul - __invoke()');

        $escaper = new Escaper();
        $helper  = new Ul($escaper);

        $result = $helper(null, null, ['id' => 'carsList'])
            ->add("> Ferrari", ["class" => "active"])
            ->add("> Ford")
            ->add("> Dodge")
            ->add("> Toyota")
        ;

        $expected = "<ul id=\"carsList\">
    <li class=\"active\">&gt; Ferrari</li>
    <li>&gt; Ford</li>
    <li>&gt; Dodge</li>
    <li>&gt; Toyota</li>
</ul>";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Html\Helper\Ul :: __invoke() - addRaw
     *
     * @since  2020-01-06
     */
    public function htmlHelperUlUnderscoreInvokeAddRaw(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Ul - __invoke() - addRaw');

        $escaper = new Escaper();
        $helper  = new Ul($escaper);

        $result = $helper(null, null, ['id' => 'carsList'])
            ->addRaw("> Ferrari", ["class" => "active"])
            ->addRaw("> Ford")
            ->addRaw("> Dodge")
            ->addRaw("> Toyota")
        ;

        $expected = "<ul id=\"carsList\">
    <li class=\"active\">> Ferrari</li>
    <li>> Ford</li>
    <li>> Dodge</li>
    <li>> Toyota</li>
</ul>";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
