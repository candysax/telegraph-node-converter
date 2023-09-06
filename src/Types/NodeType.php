<?php

namespace Candysax\TelegraphNodeConverter\Types;

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
    private array $nodes;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }


    /**
     * Converts the given Telegraph Node to its HTML representation.
     *
     * @return HTMLType A class containing the HTML representation of the node in string or DOMDocument format.
     */
    public function convertToHtml()
    {
        return Node::convertToHtml($this->nodes);
    }


    /**
     * Gets the conversion result as a json string.
     *
     * @return string Node in json string format.
     */
    public function json()
    {
        return json_encode($this->nodes);
    }


    /**
     * Gets the conversion result as an array.
     *
     * @return array Node in array format.
     */
    public function array()
    {
        return $this->nodes;
    }
}
