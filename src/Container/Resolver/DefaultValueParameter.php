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
 * A placeholder object to indicate a constructor param is using a default
 * value.
 *
 * @property string $name
 * @property mixed  $value
 */
class DefaultValueParameter
{
    /**
     * The name of the param.
     *
     * @var string
     */
    protected $name;

    /**
     * The default value of the param.
     *
     * @var mixed
     */
    protected $value;

    /**
     *
     * Constructor.
     *
     * @param string $name  The name of the param.
     * @param mixed  $value The default value
     */
    public function __construct(string $name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
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

    /**
     * Returns the default value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
