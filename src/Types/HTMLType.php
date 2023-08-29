<?php

namespace HtmlToTelegraphNode\Types;

use DOMDocument;
use HtmlToTelegraphNode\HTML;

class HTMLType
{
    private string $html;


    public function __construct(string $html)
    {
        $this->html = $html;
    }


    public function convertToNode()
    {
        return HTML::convertToNode($this->html);
    }


    public function string()
    {
        return $this->html;
    }


    public function dom()
    {
        $dom = new DOMDocument(encoding: 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        return $dom;
    }
}
