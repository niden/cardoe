<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\UploadedFile;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Codeception\Example;
use Cardoe\Http\Message\UploadedFile;
use function fopen;
use Psr\Http\Message\UploadedFileInterface;
use stdClass;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\UploadedFile :: __construct()
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - __construct()');

        $stream = logsDir(
            uniqid('test')
        );

        $file = new UploadedFile($stream, 100);

        $I->assertInstanceOf(
            UploadedFileInterface::class,
            $file
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: __construct() - $resource
     *
     * @since  2019-02-10
     */
    public function httpMessageUploadedFileConstructResource(UnitTester $I)
    {
        $I->wantToTest('Http\Message\UploadedFile - __construct()');

        $stream = logsDir(
            uniqid('test')
        );
        $stream = fopen($stream, 'w+b');
        $file = new UploadedFile($stream, 100);

        $I->assertInstanceOf(
            UploadedFileInterface::class,
            $file
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: __construct() - stream
     * exception
     *
     * @dataProvider getStreamExamples
     *
     * @author       Cardoe Team <team@cardoephp.com>
     * @since        2019-02-18
     */
    public function httpMessageUploadedFileConstructStreamException(UnitTester $I, Example $example)
    {
        $I->wantToTest(
            'Http\Message\UploadedFile - __construct() - stream ' . $example[0]
        );

        $I->expectThrowable(
            new InvalidArgumentException('Invalid stream or file passed'),
            function () use ($example) {
                $file = new UploadedFile($example[1], 100);
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\UploadedFile :: __construct() - error
     * exception
     *
     * @since  2019-02-18
     */
    public function httpMessageUploadedFileConstructErrorException(UnitTester $I)
    {
        $I->wantToTest(
            'Http\Message\UploadedFile - __construct() - error exception'
        );

        $I->expectThrowable(
            new InvalidArgumentException("Invalid error. Must be one of the UPLOAD_ERR_* constants"),
            function () {
                $stream = logsDir(
                    uniqid('test')
                );

                $file = new UploadedFile($stream, 100, 100);
            }
        );
    }

    private function getStreamExamples(): array
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
