<?php

namespace TelegraphNodesConverter\Types;

use DOMDocument;
use TelegraphNodesConverter\HTML;


/**
 * Class HTMLType
 *
 * This class containing the HTML representation of the node in string or DOMDocument format.
 *
 * @property string $html HTML string.
 */
class HTMLType
{
    private string $html;

    public function __construct(string $html)
    {
        $this->html = $html;
    }


    /**
     * Converts the given HTML to its Telegraph Node representation.
     *
     * @return NodeType A class containing a Node representation in array or json format.
     */
    public function convertToNode()
    {
        return HTML::convertToNode($this->html);
    }


    /**
     * Gets the conversion result as a string.
     *
     * @return string HTML string.
     */
    public function string()
    {
        return $this->html;
    }


    /**
     * Gets the conversion result as a DOMDocument object.
     *
     * @return DOMDocument DOMDocument object.
     */
    public function dom()
    {
        $dom = new DOMDocument(encoding: 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        return $dom;
    }
}
