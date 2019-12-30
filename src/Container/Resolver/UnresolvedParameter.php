<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AuraPHP
 *
 * @link    https://github.com/auraphp/Aura.Di
 * @license https://github.com/auraphp/Aura.Di/blob/4.x/LICENSE
 */

declare(strict_types=1);

namespace Phalcon\Container\Resolver;

/**
 * Class UnresolvedParameter
 *
 * @property string $name
 */
class UnresolvedParameter
{
    /**
     * The name of the missing param.
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param string $name The name of the missing param.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name of the missing param.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
