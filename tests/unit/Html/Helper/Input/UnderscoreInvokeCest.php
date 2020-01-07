<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Input;

use Codeception\Example;
use Phalcon\Html\Escaper;
use Phalcon\Html\Exception;
use Phalcon\Html\Helper\Input\Input;
use Phalcon\Html\Helper\Input\Textarea;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Tests Phalcon\Html\Helper\Input :: __invoke()
     *
     * @since  2020-01-07
     * @param UnitTester $I
     * @param Example    $example
     *
     * @dataProvider getExamples
     */
    public function htmlHelperInputUnderscoreInvoke(UnitTester $I, Example $example)
    {
        $I->wantToTest('Html\Helper\Input - __invoke() - ' . $example['message']);
        $classes = $this->getClasses();

        foreach ($classes as $name => $class) {
            $escaper = new Escaper();
            $helper  = new $class($escaper);

            $result = $helper($example['name'], $example['value'], $example['attributes']);

            if (isset($example["newValue"])) {
                $result->setValue($example['newValue']);
            }

            $I->assertEquals(
                sprintf($example['render'], $name),
                (string) $result
            );
        }
    }

    /**
     * Tests Phalcon\Html\Helper\Input :: __invoke() - input
     *
     * @since  2020-01-07
     * @param UnitTester $I
     */
    public function htmlHelperInputUnderscoreInvokeInput(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Input - __invoke() - input week');

        $escaper = new Escaper();
        $helper  = new Input($escaper);

        $helper->setType('week');
        $result = $helper('x_name');

        $I->assertEquals(
            '<input type="week" id="x_name" name="x_name" />',
            (string) $result
        );
    }

    /**
     * Tests Phalcon\Html\Helper\Input :: __invoke() - textarea
     *
     * @since  2020-01-07
     * @param UnitTester $I
     */
    public function htmlHelperInputUnderscoreInvokeTextarea(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Input - __invoke() - textarea');

        $escaper = new Escaper();
        $helper  = new Textarea($escaper);

        $result = $helper(
            'x_name',
            'test text area',
            [
                'cols' => "10",
                'rows' => "5",
            ]
        );

        $I->assertEquals(
            '<textarea id="x_name" name="x_name" cols="10" rows="5">' .
            'test text area</textarea>',
            (string) $result
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                'message'    => 'only name',
                'name'       => 'x_name',
                'value'      => null,
                'attributes' => [],
                'newValue'   => null,
                'render'     => '<input type="%s" id="x_name" name="x_name" />',
            ],
            [
                'message'    => 'name and id',
                'name'       => 'x_name',
                'value'      => null,
                'attributes' => [
                    'id' => 'x_new_id'
                ],
                'newValue'   => null,
                'render'     => '<input type="%s" id="x_new_id" name="x_name" />',
            ],
            [
                'message'    => 'name and id initial value',
                'name'       => 'x_name',
                'value'      => "24",
                'attributes' => [
                    'id' => 'x_new_id'
                ],
                'newValue'   => null,
                'render'     => '<input type="%s" id="x_new_id" name="x_name" value="24" />',
            ],
            [
                'message'    => 'name and id initial value set value',
                'name'       => 'x_name',
                'value'      => "24",
                'attributes' => [
                    'id' => 'x_new_id'
                ],
                'newValue'   => "48",
                'render'     => '<input type="%s" id="x_new_id" name="x_name" value="48" />',
            ],
        ];
    }

    /**
     * @return array
     */
    private function getClasses(): array
    {
        return [
            'color'          => 'Phalcon\\Html\\Helper\\Input\\Color',
            'date'           => 'Phalcon\\Html\\Helper\\Input\\Date',
            'datetime'       => 'Phalcon\\Html\\Helper\\Input\\DateTime',
            'datetime-local' => 'Phalcon\\Html\\Helper\\Input\\DateTimeLocal',
            'email'          => 'Phalcon\\Html\\Helper\\Input\\Email',
            'file'           => 'Phalcon\\Html\\Helper\\Input\\File',
            'hidden'         => 'Phalcon\\Html\\Helper\\Input\\Hidden',
            'image'          => 'Phalcon\\Html\\Helper\\Input\\Image',
            'month'          => 'Phalcon\\Html\\Helper\\Input\\Month',
            'numeric'        => 'Phalcon\\Html\\Helper\\Input\\Numeric',
            'password'       => 'Phalcon\\Html\\Helper\\Input\\Password',
            'range'          => 'Phalcon\\Html\\Helper\\Input\\Range',
            'search'         => 'Phalcon\\Html\\Helper\\Input\\Search',
            'submit'         => 'Phalcon\\Html\\Helper\\Input\\Submit',
            'tel'            => 'Phalcon\\Html\\Helper\\Input\\Tel',
            'text'           => 'Phalcon\\Html\\Helper\\Input\\Text',
            'time'           => 'Phalcon\\Html\\Helper\\Input\\Time',
            'url'            => 'Phalcon\\Html\\Helper\\Input\\Url',
            'week'           => 'Phalcon\\Html\\Helper\\Input\\Week',
        ];
    }
}
