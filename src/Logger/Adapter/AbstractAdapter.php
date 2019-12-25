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

namespace Phalcon\Logger\Adapter;

use Phalcon\Logger\Exception;
use Phalcon\Logger\Formatter\FormatterInterface;
use Phalcon\Logger\Item;

/**
 * Class AbstractAdapter
 *
 * @package Phalcon\Logger\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * Name of the default formatter class
     *
     * @var string
     */
    protected $defaultFormatter = "Line";

    /**
     * Formatter
     *
     * @var FormatterInterface
     */
    protected $formatter = null;

    /**
     * Tells if there is an active transaction or not
     *
     * @var bool
     */
    protected $inTransaction = false;

    /**
     * Array with messages queued in the transaction
     *
     * @var array
     */
    protected $queue = [];

    /**
     * Destructor cleanup
     *
     * @throws Exception
     */
    public function __destruct()
    {
        if ($this->inTransaction) {
            $this->commit();
        }

        $this->close();
    }

    /**
     * Adds a message to the queue
     */
    /**
     * @param Item $item
     *
     * @return AdapterInterface
     */
    public function add(Item $item): AdapterInterface
    {
        $this->queue[] = $item;

        return $this;
    }

    /**
     * Starts a transaction
     */
    public function begin(): AdapterInterface
    {
        $this->inTransaction = true;

        return $this;
    }

    /**
     * Commits the internal transaction
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public function commit(): AdapterInterface
    {
        if (true !== $this->inTransaction) {
            throw new Exception("There is no active transaction");
        }

        /**
         * Check if the queue has something to log
         */
        foreach ($this->queue as $item) {
            $this->process($item);
        }

        // Clear logger queue at commit
        $this->inTransaction = false;
        $this->queue         = [];

        return $this;
    }

    /**
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        if (null === $this->formatter) {
            $className = "Phalcon\\Logger\\Formatter\\" . $this->defaultFormatter;

            $this->formatter = new $className();
        }

        return $this->formatter;
    }

    /**
     * Returns the whether the logger is currently in an active transaction or
     * not
     */
    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * Processes the message in the adapter
     *
     * @param Item $item
     */
    abstract public function process(Item $item): void;

    /**
     * Rollbacks the internal transaction
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public function rollback(): AdapterInterface
    {
        if (true !== $this->inTransaction) {
            throw new Exception("There is no active transaction");
        }

        $this->queue         = [];
        $this->inTransaction = false;

        return $this;
    }

    /**
     * Sets the message formatter
     */
    /**
     * @param FormatterInterface $formatter
     *
     * @return AdapterInterface
     */
    public function setFormatter(FormatterInterface $formatter): AdapterInterface
    {
        $this->formatter = $formatter;

        return $this;
    }
}
