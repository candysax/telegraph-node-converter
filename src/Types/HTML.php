<?php

namespace HtmlToTelegraphNode\Types;

use HtmlToTelegraphNode\HTML as HtmlToTelegraphNodeHTML;

class HTML
{
    private string $html;


    public function __construct(string $html)
    {
        $this->html = $html;
    }


    public function convertToNode()
    {
        HtmlToTelegraphNodeHTML::convertToNode($this->html);
    }
}
