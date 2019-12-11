<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo\Parser;

use Cardoe\DM\Pdo\Exception\MissingParameter;

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
        '__' => null,
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
    protected $skip = '/^(\'|\"|\:[^a-zA-Z_])/um';

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
     * @param string $statement The statement to rebuild.
     * @param array  $values    The values to bind and/or replace into a
     *                          statement.
     *
     * @return array An array where element 0 is the rebuilt statement and
     * element 1 is the rebuilt array of values.
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
     * @param string $statement The SQL statement.
     *
     * @return string The rebuilt statement.
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
     * @param array $parts The statement parts.
     *
     * @return string The rebuilt statement.
     * @throws MissingParameter
     */
    protected function rebuildParts(array $parts): string
    {
        $statement = '';
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

        // split into subparts by ":name" and "?"
        $subs = preg_split(
            "/(?<!:)(:[a-zA-Z_][a-zA-Z0-9_]*)|(\?)/um",
            $part,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        // check subparts to expand placeholders for bound arrays
        return $this->prepareValuePlaceholders($subs);
    }

    /**
     * Prepares the sub-parts of a query with placeholders.
     *
     * @param array $subs The query subparts.
     *
     * @return string The prepared subparts.
     * @throws MissingParameter
     */
    protected function prepareValuePlaceholders(array $subs): string
    {
        $str = '';
        foreach ($subs as $i => $sub) {
            $char = substr($sub, 0, 1);
            if ($char == '?') {
                $str .= $this->prepareNumberedPlaceholder($sub);
            } elseif ($char == ':') {
                $str .= $this->prepareNamedPlaceholder($sub);
            } else {
                $str .= $sub;
            }
        }

        return $str;
    }

    /**
     * Bind or quote a numbered placeholder in a query subpart.
     *
     * @param string $sub The query subpart.
     *
     * @return string The prepared query subpart.
     * @throws MissingParameter
     */
    protected function prepareNumberedPlaceholder($sub): string
    {
        $this->num++;
        if (array_key_exists($this->num, $this->values) === false) {
            throw new MissingParameter(
                "Parameter {$this->num} is missing from the bound values"
            );
        }

        $expanded = [];
        $values   = (array) $this->values[$this->num];
        if (is_null($this->values[$this->num])) {
            $values[] = null;
        }
        foreach ($values as $value) {
            $count                    = ++$this->count['__'];
            $name                     = "__{$count}";
            $expanded[]               = ":{$name}";
            $this->finalValues[$name] = $value;
        }

        return implode(', ', $expanded);
    }

    /**
     * Bind or quote a named placeholder in a query subpart.
     *
     * @param string $sub The query subpart.
     *
     * @return string The prepared query subpart.
     * @throws MissingParameter
     */
    protected function prepareNamedPlaceholder($sub): string
    {
        $orig = substr($sub, 1);
        if (array_key_exists($orig, $this->values) === false) {
            throw new MissingParameter("Parameter '{$orig}' is missing from the bound values");
        }

        $name = $this->getPlaceholderName($orig);

        // is the corresponding data element an array?
        $bind_array = is_array($this->values[$orig]);
        if ($bind_array) {
            // expand to multiple placeholders
            return $this->expandNamedPlaceholder($name, $this->values[$orig]);
        }

        // not an array, retain the placeholder for later
        $this->finalValues[$name] = $this->values[$orig];

        return ":$name";
    }

    /**
     * Given an original placeholder name, return a replacement name.
     *
     * @param string $orig The original placeholder name.
     *
     * @return string
     */
    protected function getPlaceholderName(string $orig): string
    {
        if (!isset($this->count[$orig])) {
            $this->count[$orig] = 0;
            return $orig;
        }

        $count = ++$this->count[$orig];

        return "{$orig}__{$count}";
    }

    /**
     * Given a named placeholder for an array, expand it for the array values,
     * and bind those values to the expanded names.
     *
     * @param string $prefix The named placeholder.
     * @param array  $values The array values to be bound.
     *
     * @return string
     */
    protected function expandNamedPlaceholder(string $prefix, array $values): string
    {
        $i        = 0;
        $expanded = [];
        foreach ($values as $value) {
            $name                     = "{$prefix}_{$i}";
            $expanded[]               = ":{$name}";
            $this->finalValues[$name] = $value;
            $i++;
        }

        return implode(', ', $expanded);
    }

    /**
     * Given a query string, split it into parts.
     *
     * @param string $statement The query string.
     *
     * @return array
     */
    protected function getParts(string $statement): array
    {
        $split = implode('|', $this->split);
        return preg_split(
            "/($split)/um",
            $statement,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
    }
}
