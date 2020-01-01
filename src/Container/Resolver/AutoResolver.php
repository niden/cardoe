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

use Phalcon\Container\Exception\NoSuchProperty;
use Phalcon\Container\Injection\LazyNew;
use ReflectionException;
use ReflectionParameter;

/**
 * This extension of the Resolver additionally auto-resolves unspecified
 * constructor params according to their typehints; use with caution as it can
 * be very difficult to debug.
 *
 * @property ValueObject    $types
 */
class AutoResolver extends Resolver
{
    /**
     * Auto-resolve these typehints to these values.
     *
     * @var ValueObject
     */
    protected $types;

    /**
     * AutoResolver constructor.
     *
     * @param Reflector $reflector
     */
    public function __construct(Reflector $reflector)
    {
        parent::__construct($reflector);

        $this->types = new ValueObject();
    }

    /**
     * Auto-resolves params typehinted to classes.
     *
     * @param ReflectionParameter $rparam A parameter reflection.
     * @param string              $class  The class name to return values for.
     * @param array               $parent The parent unified params.
     *
     * @return LazyNew|mixed|DefaultValueParameter|UnresolvedParameter
     * @throws ReflectionException
     * @throws NoSuchProperty
     */
    protected function getUnifiedParameter(ReflectionParameter $rparam, string $class, array $parent)
    {
        $unified = parent::getUnifiedParameter($rparam, $class, $parent);

        // already resolved?
        if (!$unified instanceof UnresolvedParameter && !$unified instanceof DefaultValueParameter) {
            return $unified;
        }

        // use an explicit auto-resolution?
        $rtype = $rparam->getClass();
        if ($rtype && $this->types->has($rtype->name)) {
            return $this->types->get($rtype->name);
        }

        if ($unified instanceof DefaultValueParameter) {
            return $unified;
        }

        // use a lazy-new-instance of the typehinted class?
        if ($rtype && $rtype->isInstantiable()) {
            return new LazyNew($this, new Blueprint($rtype->name));
        }

        // $unified is still an UnresolvedParam
        return $unified;
    }

    /**
     * @return ValueObject
     */
    public function types(): ValueObject
    {
        return $this->types;
    }

}
