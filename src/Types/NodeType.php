<?php

namespace HtmlToTelegraphNode\Types;

use HtmlToTelegraphNode\Node;

class NodeType
{
    private array $nodes;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }


    public function convertToHtml()
    {
        return Node::convertToHtml($this->nodes);
    }


    public function json()
    {
        return json_encode($this->nodes);
    }


    public function array()
    {
        return $this->nodes;
    }
}
