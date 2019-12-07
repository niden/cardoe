<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream;

use Codeception\Example;
use Cardoe\Http\Message\Exception;
use Cardoe\Http\Message\Stream;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use stdClass;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Stream :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpMessageStreamConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream - __construct()');

        $request = new Stream('php://temp');

        $I->assertInstanceOf(
            StreamInterface::class,
            $request
        );
    }

    /**
     * Tests Cardoe\Http\Message\Stream :: __construct() - exception
     *
     * @dataProvider getExceptionExamples
     *
     * @since        2019-02-08
     */
    public function httpMessageStreamConstructException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Stream - __construct() ' . $example[0]);
        $I->expectThrowable(
            new RuntimeException(
                'The stream provided is not valid ' .
                '(string/resource) or could not be opened.'
            ),
            function () use ($example) {
                $request = new Stream($example[1]);
            }
        );
    }

    private function getExceptionExamples(): array
    {
        return [
            ['array', ['array']],
            ['boolean', true],
            ['float', 123.45],
            ['integer', 123],
            ['null', null],
            ['object', new stdClass()],
        ];
    }
}
