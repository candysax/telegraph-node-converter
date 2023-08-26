<?php

namespace HtmlToTelegraphNode\Types;

use HtmlToTelegraphNode\Node as HtmlToTelegraphNodeNode;

class Node
{
    private array $nodes;


    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }


    public function convertToHtml()
    {
        HtmlToTelegraphNodeNode::convertToHtml($this->nodes);
    }


    public function json()
    {
        return json_encode($this->nodes);
    }


    public function nodes()
    {
        return $this->nodes;
    }
}
