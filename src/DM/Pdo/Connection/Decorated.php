<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Exception\CannotDisconnect;
use Cardoe\DM\Pdo\Profiler\Profiler;
use Cardoe\DM\Pdo\Profiler\ProfilerInterface;
use PDO;

/**
 * Decorates an existing PDO instance with the extended methods.
 */
class Decorated extends AbstractConnection
{
    /**
     *
     * Constructor.
     *
     * This overrides the parent so that it can take an existing PDO instance
     * and decorate it with the extended methods.
     *
     * @param PDO $pdo An existing PDO instance to decorate.
     *
     * @param ProfilerInterface $profiler Tracks and logs query profiles.
     *
     */
    public function __construct(PDO $pdo, ProfilerInterface $profiler = null)
    {
        $this->pdo = $pdo;

        if ($profiler === null) {
            $profiler = new Profiler();
        }
        $this->setProfiler($profiler);

        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $this->setParser($this->newParser($driver));
        $this->setQuoteName($driver);
    }

    /**
     * Connects to the database.
     */
    public function connect(): void
    {
        // already connected
    }

    /**
     * Disconnects from the database; disallowed with decorated PDO connections.
     *
     * @throws CannotDisconnect
     */
    public function disconnect(): void
    {
        $message = "Cannot disconnect a DecoratedPdo instance.";
        throw new CannotDisconnect($message);
    }
}
