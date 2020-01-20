<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Pdo\Parser;

use Phalcon\DM\Pdo\Exception\MissingParameter;
use function is_array;

/**
 * Parsing/rebuilding functionality for all drivers.
 *
 * Note that this does not validate the syntax; it only replaces/rebuilds
 * placeholders in the query.
 *
 * @property array  $count
 * @property array  $finalValues
 * @property int    $num
 * @property string $skip
 * @property array  $split
 * @property array  $values
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var array
     */
    protected $count = [
        "__" => null,
    ];

    /**
     * @var array
     */
    protected $finalValues = [];

    /**
     * @var int
     */
    protected $num = 0;

    /**
     * @var string
     */
    protected $skip = "/^(\'|\"|\:[^a-zA-Z_])/um";

    /**
     * @var array
     */
    protected $split = [
        // single-quoted string
        "'(?:[^'\\\\]|\\\\'?)*'",
        // double-quoted string
        '"(?:[^"\\\\]|\\\\"?)*"',
    ];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * Rebuilds a statement with placeholders and bound values.
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array
     * @throws MissingParameter
     */
    public function rebuild(string $statement, array $values = []): array
    {
        // match standard PDO execute() behavior of zero-indexed arrays
        if (array_key_exists(0, $values)) {
            array_unshift($values, null);
        }

        $this->values = $values;
        $statement    = $this->rebuildStatement($statement);

        return [$statement, $this->finalValues];
    }

    /**
     *
     * Given a statement, rebuilds it with array values embedded.
     *
     * @param string $statement
     *
     * @return string
     * @throws MissingParameter
     */
    protected function rebuildStatement(string $statement): string
    {
        $parts = $this->getParts($statement);

        return $this->rebuildParts($parts);
    }

    /**
     * Given an array of statement parts, rebuilds each part.
     *
     * @param array $parts
     *
     * @return string
     * @throws MissingParameter
     */
    protected function rebuildParts(array $parts): string
    {
        $statement = "";
        foreach ($parts as $part) {
            $statement .= $this->rebuildPart($part);
        }

        return $statement;
    }

    /**
     * Rebuilds a single statement part.
     *
     * @param string $part The statement part.
     *
     * @return string The rebuilt statement.
     * @throws MissingParameter
     */
    protected function rebuildPart(string $part): string
    {
        if (preg_match($this->skip, $part)) {
            return $part;
        }

        // split into sub-parts by ":name" and "?"
        $subs = preg_split(
            "/(?<!:)(:[a-zA-Z_][a-zA-Z0-9_]*)|(\?)/um",
            $part,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $subs = is_array($subs) ? $subs : [];

        // check sub-parts to expand placeholders for bound arrays
        return $this->prepareValuePlaceholders($subs);
    }

    /**
     * Prepares the sub-parts of a query with placeholders.
     *
     * @param array $parts
     *
     * @return string
     * @throws MissingParameter
     */
    protected function prepareValuePlaceholders(array $parts): string
    {
        $result = '';
        foreach ($parts as $key => $value) {
            $character = substr($value, 0, 1);
            if ($character == '?') {
                $result .= $this->prepareNumberedPlaceholder($value);
            } elseif ($character == ':') {
                $result .= $this->prepareNamedPlaceholder($value);
            } else {
                $result .= $value;
            }
        }

        return $result;
    }

    /**
     * Bind or quote a numbered placeholder in a query sub-part.
     *
     * @param string $part
     *
     * @return string
     * @throws MissingParameter
     */
    protected function prepareNumberedPlaceholder($part): string
    {
        $this->num++;
        if (array_key_exists($this->num, $this->values) === false) {
            throw new MissingParameter(
                "Parameter '" . $this->num . "' is missing from the bound values",
            );
        }

        $expanded = [];
        $values   = (array) $this->values[$this->num];
        if (is_null($this->values[$this->num])) {
            $values[] = null;
        }
        foreach ($values as $value) {
            $count                    = ++$this->count["__"];
            $name                     = "__" . $count;
            $expanded[]               = ":" . $name;
            $this->finalValues[$name] = $value;
        }

        return implode(", ", $expanded);
    }

    /**
     * Bind or quote a named placeholder in a query sub-part.
     *
     * @param string $part
     *
     * @return string
     * @throws MissingParameter
     */
    protected function prepareNamedPlaceholder($part): string
    {
        $original = substr($part, 1);
        if (array_key_exists($original, $this->values) === false) {
            throw new MissingParameter(
                "Parameter '" . $original . "' is missing from the bound values",
            );
        }

        $name = $this->getPlaceholderName($original);

        // is the corresponding data element an array?
        $bind = is_array($this->values[$original]);
        if ($bind) {
            // expand to multiple placeholders
            return $this->expandNamedPlaceholder(
                $name,
                $this->values[$original]
            );
        }

        // not an array, retain the placeholder for later
        $this->finalValues[$name] = $this->values[$original];

        return ":" . $name;
    }

    /**
     * Given an original placeholder name, return a replacement name.
     *
     * @param string $placeholder
     *
     * @return string
     */
    protected function getPlaceholderName(string $placeholder): string
    {
        if (!isset($this->count[$placeholder])) {
            $this->count[$placeholder] = 0;
            return $placeholder;
        }

        $count = ++$this->count[$placeholder];

        return $placeholder . "__" . $count;
    }

    /**
     * Given a named placeholder for an array, expand it for the array values,
     * and bind those values to the expanded names.
     *
     * @param string $prefix
     * @param array  $values
     *
     * @return string
     */
    protected function expandNamedPlaceholder(
        string $prefix,
        array $values
    ): string {
        $counter  = 0;
        $expanded = [];
        foreach ($values as $value) {
            $name                     = $prefix . "_" . $counter;
            $expanded[]               = ":" . $name;
            $this->finalValues[$name] = $value;
            $counter++;
        }

        return implode(", ", $expanded);
    }

    /**
     * Given a query string, split it into parts.
     *
     * @param string $statement
     *
     * @return array
     */
    protected function getParts(string $statement): array
    {
        $split  = implode("|", $this->split);
        $result = preg_split(
            "/(" . $split . ")/um",
            $statement,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );

        return (is_array($result)) ? $result : [];
    }
}
