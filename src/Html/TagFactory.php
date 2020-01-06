<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html;

use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as ExceptionAlias;

/**
 * ServiceLocator implementation for Tag helpers
 *
 * @property Escaper $escaper
 * @property array   $services
 */
class TagFactory extends AbstractFactory
{
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var array
     */
    protected $services = [];

    /**
     * TagFactory constructor.
     */
    /**
     * TagFactory constructor.
     *
     * @param Escaper $escaper
     * @param array   $services
     */
    public function __construct(Escaper $escaper, array $services = [])
    {
        $this->escaper = $escaper;

        $this->init($services);
    }

    /**
     * Create a new instance of the object
     *
     * @param string $name
     *
     * @return mixed
     * @throws ExceptionAlias
     */
    public function newInstance(string $name)
    {
        $this->checkService($name);

        if (!isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($this->escaper);
        }

        return $this->services[$name];
    }

    /**
     * @return array|void
     */
    protected function getAdapters(): array
    {
        return [
            "a"          => "Phalcon\\Html\\Helper\\Anchor",
            "aRaw"       => "Phalcon\\Html\\Helper\\AnchorRaw",
            "base"       => "Phalcon\\Html\\Helper\\Base",
            "body"       => "Phalcon\\Html\\Helper\\Body",
            "button"     => "Phalcon\\Html\\Helper\\Button",
            "element"    => "Phalcon\\Html\\Helper\\Element",
            "elementRaw" => "Phalcon\\Html\\Helper\\ElementRaw",
            "form"       => "Phalcon\\Html\\Helper\\Form",
            "img"        => "Phalcon\\Html\\Helper\\Img",
            "label"      => "Phalcon\\Html\\Helper\\Label",
        ];
    }
}
