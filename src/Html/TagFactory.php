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
            "a"                   => "Phalcon\\Html\\Helper\\Anchor",
            "base"                => "Phalcon\\Html\\Helper\\Base",
            "body"                => "Phalcon\\Html\\Helper\\Body",
            "button"              => "Phalcon\\Html\\Helper\\Button",
            "close"               => "Phalcon\\Html\\Helper\\Close",
            "element"             => "Phalcon\\Html\\Helper\\Element",
            "form"                => "Phalcon\\Html\\Helper\\Form",
            "img"                 => "Phalcon\\Html\\Helper\\Img",
            "inputColor"          => "Phalcon\\Html\\Helper\\Input\\Color",
            "inputDate"           => "Phalcon\\Html\\Helper\\Input\\Date",
            "inputDateTime"       => "Phalcon\\Html\\Helper\\Input\\DateTime",
            "inputDateTimeLocal"  => "Phalcon\\Html\\Helper\\Input\\DateTimeLocal",
            "inputEmail"          => "Phalcon\\Html\\Helper\\Input\\Email",
            "inputFile"           => "Phalcon\\Html\\Helper\\Input\\File",
            "inputHidden"         => "Phalcon\\Html\\Helper\\Input\\Hidden",
            "inputImage"          => "Phalcon\\Html\\Helper\\Input\\Image",
            "inputInput"          => "Phalcon\\Html\\Helper\\Input\\Input",
            "inputMonth"          => "Phalcon\\Html\\Helper\\Input\\Month",
            "inputNumeric"        => "Phalcon\\Html\\Helper\\Input\\Numeric",
            "inputPassword"       => "Phalcon\\Html\\Helper\\Input\\Password",
            "inputRange"          => "Phalcon\\Html\\Helper\\Input\\Range",
            "inputSelect"         => "Phalcon\\Html\\Helper\\Input\\Select",
            "inputSearch"         => "Phalcon\\Html\\Helper\\Input\\Search",
            "inputSubmit"         => "Phalcon\\Html\\Helper\\Input\\Submit",
            "inputTel"            => "Phalcon\\Html\\Helper\\Input\\Tel",
            "inputText"           => "Phalcon\\Html\\Helper\\Input\\Text",
            "inputTextarea"       => "Phalcon\\Html\\Helper\\Input\\Textarea",
            "inputTime"           => "Phalcon\\Html\\Helper\\Input\\Time",
            "inputUrl"            => "Phalcon\\Html\\Helper\\Input\\Url",
            "inputWeek"           => "Phalcon\\Html\\Helper\\Input\\Week",
            "label"               => "Phalcon\\Html\\Helper\\Label",
            "link"                => "Phalcon\\Html\\Helper\\Link",
            "meta"                => "Phalcon\\Html\\Helper\\Meta",
            "ol"                  => "Phalcon\\Html\\Helper\\Ol",
            "script"              => "Phalcon\\Html\\Helper\\Script",
            "style"               => "Phalcon\\Html\\Helper\\Style",
            "title"               => "Phalcon\\Html\\Helper\\Title",
            "ul"                  => "Phalcon\\Html\\Helper\\Ul",
        ];
    }
}
