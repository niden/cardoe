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
 * Returns the value of a callable with parameters supplied at calltime (thereby
 * invoking the callable).
 *
 * @property callable $callable
 * @property bool     $callableChecked
 */
class LazyCallable implements LazyInterface
{
    /**
     * The callable to invoke.
     *
     * @var callable
     */
    protected $callable;

    /**
     * Whether or not the callable has been checked for instances of
     * LazyInterface.
     *
     * @var bool
     */
    protected bool $callableChecked = false;

    /**
     * Constructor.
     *
     * @param callable $callable The callable to invoke.
     */
    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    /**
     * Invokes the closure (which may return a value).
     *
     * @return mixed The value returned by the invoked callable (if any).
     */
    public function __invoke()
    {
        if (false === $this->callableChecked) {
            // convert Lazy objects in the callable
            if (is_array($this->callable)) {
                foreach ($this->callable as $key => $val) {
                    if ($val instanceof LazyInterface) {
                        $this->callable[$key] = $val();
                    }
                }
            } elseif ($this->callable instanceof LazyInterface) {
                $this->callable = $this->callable->__invoke();
            }

            $this->callableChecked = true;
        }

        // make the call
        return call_user_func_array($this->callable, func_get_args());
    }
}
