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

/**
 * Returns the value of a callable when invoked (thereby invoking the callable).
 *
 * @property callable $callable
 * @property array    $parameters
 */
class Lazy implements LazyInterface
{
    /**
     * The callable to invoke.
     *
     * @var callable
     */
    protected $callable;

    /**
     * Arguments for the callable.
     *
     * @var array
     */
    protected array $parameters;

    /**
     * Constructor.
     *
     * @param callable $callable   The callable to invoke.
     * @param array    $parameters Arguments for the callable.
     */
    public function __construct($callable, array $parameters = [])
    {
        $this->callable   = $callable;
        $this->parameters = $parameters;
    }

    /**
     * Invokes the closure to create the instance.
     *
     * @return object The object created by the closure.
     */
    public function __invoke()
    {
        // convert Lazy objects in the callable
        if (is_array($this->callable)) {
            $this->processArray();
        } elseif ($this->callable instanceof LazyInterface) {
            $this->callable = $this->callable->__invoke();
        }

        $this->processParameters();

        // make the call
        return call_user_func_array($this->callable, $this->parameters);
    }

    /**
     * Converts Lazy objects in the callable if array
     */
    private function processArray(): void
    {
        foreach ($this->callable as $key => $val) {
            if ($val instanceof LazyInterface) {
                $this->callable[$key] = $val();
            }
        }
    }

    /**
     * Converts Lazy objects in the parameters
     */
    private function processParameters(): void
    {
        // convert Lazy objects in the parameters
        foreach ($this->parameters as $key => $val) {
            if ($val instanceof LazyInterface) {
                $this->parameters[$key] = $val();
            }
        }
    }
}
