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

/**
 * Cardoe\Domain\Payload\Status
 *
 * Holds the status codes for the payload
 */
class Status
{
    public const ACCEPTED          = "ACCEPTED";
    public const AUTHENTICATED     = "AUTHENTICATED";
    public const AUTHORIZED        = "AUTHORIZED";
    public const CREATED           = "CREATED";
    public const DELETED           = "DELETED";
    public const ERROR             = "ERROR";
    public const FAILURE           = "FAILURE";
    public const FOUND             = "FOUND";
    public const NOT_ACCEPTED      = "NOT_ACCEPTED";
    public const NOT_AUTHENTICATED = "NOT_AUTHENTICATED";
    public const NOT_AUTHORIZED    = "NOT_AUTHORIZED";
    public const NOT_CREATED       = "NOT_CREATED";
    public const NOT_DELETED       = "NOT_DELETED";
    public const NOT_FOUND         = "NOT_FOUND";
    public const NOT_UPDATED       = "NOT_UPDATED";
    public const NOT_VALID         = "NOT_VALID";
    public const PROCESSING        = "PROCESSING";
    public const SUCCESS           = "SUCCESS";
    public const UPDATED           = "UPDATED";
    public const VALID             = "VALID";

    /**
     * Instantiation not allowed.
     */
    final private function __construct()
    {
    }
}
