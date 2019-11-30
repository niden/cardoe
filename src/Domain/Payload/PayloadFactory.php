<?php

/**
 * This file is part of the Cardoe Framework.
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

namespace Cardoe\Domain\Payload;

/**
 * Cardoe\Domain\Payload\PayloadFactory
 *
 * Factory to create payload objects
 */
class PayloadFactory
{
    /**
     * Instantiate a new object
     */
    public function newInstance(): PayloadInterface
    {
        return new Payload();
    }
}
