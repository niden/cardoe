<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Fixtures\Traits;

use Phalcon\Crypt;
use Phalcon\Db\Adapter\PdoFactory;
use Phalcon\Di;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Escaper;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple;
use Phalcon\Test\Fixtures\Migrations\InvoicesMigration;
use Phalcon\Url;

use function uniqid;

trait RecordsTrait
{
    /**
     * @param int $number
     *
     * @return false|float
     */
    private function getFibonacci(int $number)
    {
        return round(pow((sqrt(5) + 1) / 2, $number) / sqrt(5));
    }

    /**
     * @param InvoicesMigration $migration
     * @param int               $count
     * @param int               $custId
     * @param string            $prefix
     * @param int               $pad
     */
    private function insertDataInvoices(
        InvoicesMigration $migration,
        int $count,
        int $custId,
        string $prefix,
        int $pad = 0
    ) {
        $title = uniqid($prefix . '-');
        for ($counter = 1; $counter <= $count; $counter++) {
            $migration->insert(
                null,
                $custId,
                1,
                $title,
                $this->getFibonacci($pad + $counter)
            );
        }
    }
}
