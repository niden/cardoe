<?php

/**
* This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Migrations;

use Phalcon\DM\Pdo\Connection;

class Setup
{
    /**
     * @param Connection $connection
     */
    public function __invoke(Connection $connection)
    {

        (new Invoices())($connection);
    }
}
