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

namespace Phalcon\Container\Injection;

use InvalidArgumentException;
use Phalcon\Container\Resolver\Resolver;

/**
 * Returns an arbitrary value when invoked.
 *
 * @property string   $key
 * @property Resolver $resolver
 */
class LazyValue implements LazyInterface
{
    /**
     * The value key to retrieve.
     *
     * @var string
     */
    protected $key;

    /**
     * The Resolver that holds the values.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Constructor.
     *
     * @param Resolver $resolver The Resolver that holds the values.
     * @param string   $key      The value key to retrieve.
     */
    public function __construct(Resolver $resolver, string $key)
    {
        $this->resolver = $resolver;
        $this->key      = $key;
    }

    /**
     *
     * Returns the lazy value.
     *
     * @return mixed
     *
     */
    public function __invoke()
    {
        if (!$this->resolver->values()->has($this->key)) {
            throw new InvalidArgumentException(
                'Unknown key (' . $this->key . ') in container value'
            );
        }

        $value = $this->resolver->values()->get($this->key);
        // convert Lazy objects
        if ($value instanceof LazyInterface) {
            $value = $value();
        }

        return $value;
    }
}
