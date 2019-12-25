<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Migrations;

use Phalcon\DM\Pdo\Connection;
use function ucfirst;

class Invoices
{
    public function __invoke(Connection $connection)
    {
        $driver = $connection->getDriverName();
        $method = "populate" . ucfirst($driver);

        $this->$method($connection);
    }

    /**
     * Populates Mysql tables
     *
     * @param Connection $connection
     */
    private function populateMysql(Connection $connection)
    {
        $sql = <<<SQL
drop table if exists co_invoices
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create table co_invoices
    (
    inv_id          int(10) auto_increment  primary key,
    inv_cst_id      int(10)      null,
    inv_status_flag tinyint(1)   null,
    inv_title       varchar(100) null,
    inv_total       float(10, 2) null,
    inv_created_at  datetime     null
)
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_created_at_index
    on co_invoices (inv_created_at);
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_cst_id_index
    on co_invoices (inv_cst_id);
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_status_flag_index
    on co_invoices (inv_status_flag);
SQL;
        $connection->exec($sql);
    }

    /**
     * Populates Mysql tables
     *
     * @param Connection $connection
     */
    private function populateSqlite(Connection $connection)
    {
        $sql = <<<SQL
drop table if exists co_invoices
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create table co_invoices
(
    inv_id          integer  constraint co_invoices_pk primary key autoincrement,
    inv_cst_id      integer,
    inv_status_flag integer,
    inv_title       text,
    inv_total       real,
    inv_created_at  text
)
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_created_at_index
    on co_invoices (inv_created_at);
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_cst_id_index
    on co_invoices (inv_cst_id);
SQL;
        $connection->exec($sql);

        $sql = <<<SQL
create index co_invoices_inv_status_flag_index
    on co_invoices (inv_status_flag);
SQL;
        $connection->exec($sql);
    }
}
