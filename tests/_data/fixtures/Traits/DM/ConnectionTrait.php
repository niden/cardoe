<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Traits\DM;

use Cardoe\DM\Pdo\Connection;
use Cardoe\Test\Fixtures\Migrations\Setup;
use function dbGetDsn;
use function dbGetPassword;
use function dbGetUsername;
use function uniqid;

/**
 * Trait ConnectionTrait
 *
 * @property Connection $connection
 */
trait ConnectionTrait
{
    protected $connection;

    public function _before()
    {
        (new Setup())();

        $this->connection = new Connection(
            dbGetDsn(),
            dbGetUsername(),
            dbGetPassword()
        );
    }

    /**
     * @param int $id
     *
     * @return int
     */
    protected function newInvoice(int $id): int
    {
        $title = uniqid();
        $now   = date('Y-m-d H:i:s');
        $total = 100 + $id;
        $flag  = (int) ($id % 2);
        $sql   = <<<SQL
insert into co_invoices (
    inv_id, 
    inv_cst_id, 
    inv_status_flag, 
    inv_title, 
    inv_total, 
    inv_created_at 
) values (
    {$id}, 
    1, 
    {$flag}, 
    "{$title}", 
    {$total}, 
    "{$now}"
)
SQL;

        return $this->connection->exec($sql);
    }
}
