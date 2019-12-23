<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by cardoe-api and AuraPHP
 *
 * @link    https://github.com/cardoe/cardoe-api
 * @license https://github.com/cardoe/cardoe-api/blob/master/LICENSE
 * @link    https://github.com/auraphp/Aura.Payload
 * @license https://github.com/auraphp/Aura.Payload/blob/3.x/LICENSE
 *
 * @see     Original inspiration for the https://github.com/cardoe/cardoe-api
 */

declare(strict_types=1);

namespace Phalcon\Domain\Payload;

use Throwable;

/**
 * Phalcon\Domain\Payload\ReadableInterface
 *
 * This interface is used for consumers (read only)
 */
interface ReadableInterface
{
    /**
     * Gets the potential exception thrown in the domain layer
     *
     * @return Throwable|null
     */
    public function getException(): ?Throwable;

    /**
     * Gets arbitrary extra values produced by the domain layer.
     *
     * @return mixed
     */
    public function getExtras();

    /**
     * Gets the input received by the domain layer.
     *
     * @return mixed
     */
    public function getInput();

    /**
     * Gets the messages produced by the domain layer.
     *
     * @return mixed
     */
    public function getMessages();

    /**
     * Gets the output produced from the domain layer.
     *
     * @return mixed
     */
    public function getOutput();

    /**
     * Gets the status of this payload.
     *
     * @return mixed
     */
    public function getStatus();
}
