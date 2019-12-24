<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by phalcon-api and AuraPHP
 * @link    https://github.com/phalcon/rest-api
 * @license https://github.com/phalcon/rest-api/blob/master/LICENSE
 * @link    https://github.com/auraphp/Aura.Payload
 * @license https://github.com/auraphp/Aura.Payload/blob/3.x/LICENSE
 *
 * @see Original inspiration for the https://github.com/phalcon/rest-api
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
