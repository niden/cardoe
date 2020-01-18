<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Query
 * @license https://github.com/atlasphp/Atlas.Query/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Query;

use PDOStatement;
use Phalcon\DM\Pdo\Connection;
use Phalcon\DM\Pdo\Exception\CannotBindValue;
use Phalcon\DM\Query\Clause\Component\Flags;

/**
 * Class AbstractQuery
 *
 * @property Bind       $bind
 * @property Connection $connection
 * @property Flags      $flags
 */
abstract class AbstractQuery
{
    /**
     * @var Bind
     */
    protected $bind;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Flags
     */
    protected $flags;

    /**
     * AbstractQuery constructor.
     *
     * @param Connection $connection
     * @param Bind       $bind
     */
    public function __construct(Connection $connection, Bind $bind)
    {
        $this->connection = $connection;
        $this->bind       = $bind;

        $this->reset();
    }

    /**
     * @return PDOStatement
     * @throws CannotBindValue
     */
    public function perform(): PDOStatement
    {
        return $this->connection->perform(
            $this->getStatement(),
            $this->getBindValues()
        );
    }

    /**
     * @param mixed $value
     * @param int   $type
     *
     * @return string
     */
    public function bindInline($value, int $type = -1): string
    {
        return $this->bind->inline($value, $type);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $type
     *
     * @return $this
     */
    public function bindValue(string $key, $value, int $type = -1): AbstractQuery
    {
        $this->bind->value($key, $value, $type);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return AbstractQuery
     */
    public function bindValues(array $values): AbstractQuery
    {
        $this->bind->values($values);

        return $this;
    }

    /**
     * @return array
     */
    public function getBindValues(): array
    {
        return $this->bind->toArray();
    }

    /**
     * @param string $flag
     * @param bool   $enable
     *
     * @return AbstractQuery
     */
    public function setFlag(string $flag, bool $enable = true): AbstractQuery
    {
        $this->flags->set($flag, $enable);

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        foreach (get_class_methods($this) as $method) {
            if (substr($method, 0, 5) == 'reset' && $method != 'reset') {
                $this->$method();
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function resetFlags(): AbstractQuery
    {
        $this->flags = new Flags();

        return $this;
    }

    public function quoteIdentifier(string $name): string
    {
        return $this->quoter->quoteIdentifier($name);
    }

    /**
     * @return string
     */
    abstract public function getStatement(): string;
}
