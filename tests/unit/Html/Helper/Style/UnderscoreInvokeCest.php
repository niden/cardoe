<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Style;

use Phalcon\Html\Escaper;
use Phalcon\Html\Helper\Style;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Html\Helper\Style :: __invoke()
     *
     * @since  2020-01-06
     */
    public function htmlHelperStyleUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Style - __invoke()');

        $escaper = new Escaper();
        $helper  = new Style($escaper);

        $result = $helper()
            ->add("custom.css")
            ->add("print.css", ["media" => "print"])
        ;

        $expected = "    <style rel=\"stylesheet\" type=\"text/css\" "
            . "href=\"custom.css\" media=\"screen\"></style>" . PHP_EOL
            . "    <style rel=\"stylesheet\" type=\"text/css\" "
            . "href=\"print.css\" media=\"print\"></style>" . PHP_EOL;
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Unit Tests Phalcon\Html\Helper\Style :: __invoke() - ident and delimiter
     *
     * @since  2020-01-06
     */
    public function htmlHelperStyleUnderscoreInvokeIndentDelimiter(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Style - __invoke() - indent and delimiter');

        $escaper = new Escaper();
        $helper  = new Style($escaper);

        $result = $helper("--", "+")
            ->add("custom.css")
            ->add("print.css", ["media" => "print"])
        ;

        $expected = "--<style rel=\"stylesheet\" type=\"text/css\" "
            . "href=\"custom.css\" media=\"screen\"></style>+"
            . "--<style rel=\"stylesheet\" type=\"text/css\" "
            . "href=\"print.css\" media=\"print\"></style>+";
        $actual   = (string) $result;
        $I->assertEquals($expected, $actual);
    }
}
