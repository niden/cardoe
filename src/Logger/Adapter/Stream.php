<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Logger\Adapter;

use Cardoe\Helper\Arr;
use Cardoe\Logger\Exception;
use Cardoe\Logger\Item;
use UnexpectedValueException;

use function fclose;
use function fopen;
use function fwrite;
use function is_resource;
use function sprintf;
use function strpos;

/**
 * Class Stream
 *
 * @package Cardoe\Logger\Adapter
 */
class Stream extends AbstractAdapter
{
    /**
     * Stream handler resource
     *
     * @var resource|null
     */
    protected $handler = null;

    /**
     * The file open mode. Defaults to "ab"
     *
     * @var string
     */
    protected $mode = "ab";

    /**
     * Stream name
     *
     * @var string
     */
    protected $name;

    /**
     * Path options
     *
     * @var array
     */
    protected $options;

    /**
     * Stream constructor.
     *
     * @param string $name
     * @param array  $options
     *
     * @throws Exception
     */
    public function __construct(string $name, array $options = [])
    {
        $mode = Arr::get($options, "mode", "ab");
        if (false !== strpos($mode, "r")) {
            throw new Exception("Adapter cannot be opened in read mode");
        }

        $this->name = $name;
        $this->mode = $mode;
    }

    /**
     * Closes the stream
     */
    public function close(): bool
    {
        $result = true;

        if (is_resource($this->handler)) {
            $result = fclose($this->handler);
        }

        $this->handler = null;

        return $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Processes the message i.e. writes it to the file
     *
     * @param Item $item
     */
    public function process(Item $item): void
    {
        if (!is_resource($this->handler)) {
            $handler = fopen($this->name, $this->mode);

            if (!is_resource($handler)) {
                $this->handler = null;

                throw new UnexpectedValueException(
                    sprintf(
                        "The file '%s' cannot be opened with mode '%s'",
                        $this->name,
                        $this->mode
                    )
                );
            }

            $this->handler = $handler;
        }

        $formatter        = $this->getFormatter();
        $formattedMessage = (string) $formatter->format($item);

        fwrite($this->handler, $formattedMessage);
    }
}
