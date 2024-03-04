<?php

namespace Candysax\TelegraphNodeConverter\Types;

use Candysax\TelegraphNodeConverter\Exceptions\IncorrectInputFormatException;
use Candysax\TelegraphNodeConverter\Exceptions\InvalidNodeArgumentTypeException;
use Candysax\TelegraphNodeConverter\Node;


/**
 * Class NodeType
 *
 * A class containing a Node representation in array or json format.
 *
 * @property @nodes Array of Telegraph Nodes.
 */
class NodeType
{
    private $nodes;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }


    /**
     * Converts the given Telegraph Node to its HTML representation.
     *
     * @throws IncorrectInputFormatException If an incorrect node array format is passed.
     * @throws InvalidNodeArgumentTypeException If the passed argument is not a json string or an array.
     * @return HTMLType A class containing the HTML representation of the node in string or DOMDocument format.
     */
    public function convertToHtml(): HTMLType
    {
        return Node::convertToHtml($this->nodes);
    }


    /**
     * Gets the conversion result as a json string.
     *
     * @return string Node in json string format.
     */
    public function json(): string
    {
        return json_encode($this->nodes);
    }


    /**
     * Gets the conversion result as an array.
     *
     * @return array Node in array format.
     */
    public function array(): array
    {
        return $this->nodes;
    }
}
