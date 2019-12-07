<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by cardoe-api and AuraPHP
 * @link    https://github.com/cardoe/cardoe-api
 * @license https://github.com/cardoe/cardoe-api/blob/master/LICENSE
 * @link    https://github.com/auraphp/Aura.Payload
 * @license https://github.com/auraphp/Aura.Payload/blob/3.x/LICENSE
 *
 * @see Original inspiration for the https://github.com/cardoe/cardoe-api
 */

declare(strict_types=1);

namespace Cardoe\Domain\Payload;

use Throwable;

/**
 * Cardoe\Domain\Payload\WriteableInterface
 *
 * This interface is used for consumers (write)
 */
interface WriteableInterface
{
    /**
     * Sets an exception produced by the domain layer.
     *
     * @param Throwable $exception The exception thrown in the domain layer
     *
     * @return PayloadInterface
     */
    public function setException(Throwable $exception): PayloadInterface;

    /**
     * Sets arbitrary extra values produced by the domain layer.
     *
     * @param mixed $extras Arbitrary extra values produced by the domain layer.
     *
     * @return PayloadInterface
     */
    public function setExtras($extras): PayloadInterface;

    /**
     *
     * Sets the input received by the domain layer.
     *
     * @param mixed $input The input received by the domain layer.
     *
     * @return PayloadInterface
     */
    public function setInput($input): PayloadInterface;

    /**
     * Sets the messages produced by the domain layer.
     *
     * @param mixed $messages The messages produced by the domain layer.
     *
     * @return PayloadInterface
     */
    public function setMessages($messages): PayloadInterface;

    /**
     * Sets the output produced from the domain layer.
     *
     * @param mixed $output The output produced from the domain layer.
     *
     * @return PayloadInterface
     */
    public function setOutput($output): PayloadInterface;

    /**
     * Sets the status of this payload.
     *
     * @param mixed $status The status for this payload.
     *
     * @return PayloadInterface
     */
    public function setStatus($status): PayloadInterface;
}
