<?php

namespace Candysax\TelegraphNodeConverter\Types;

use Candysax\TelegraphNodeConverter\Exceptions\InvalidHTMLArgumentTypeException;
use DOMDocument;
use Candysax\TelegraphNodeConverter\HTML;


/**
 * Class HTMLType
 *
 * This class containing the HTML representation of the node in string or DOMDocument format.
 *
 * @property string $html HTML string.
 */
class HTMLType
{
    private $html;

    public function __construct(string $html)
    {
        $this->html = $html;
    }


    /**
     * Converts the given HTML to its Telegraph Node representation.
     *
     * @throws InvalidHTMLArgumentTypeException If the passed argument is not a string or a DOMDocument object.
     * @return NodeType A class containing a Node representation in array or json format.
     */
    public function convertToNode(): NodeType
    {
        return HTML::convertToNode($this->html);
    }


    /**
     * Gets the conversion result as a string.
     *
     * @return string HTML string.
     */
    public function string(): string
    {
        return $this->html;
    }


    /**
     * Gets the conversion result as a DOMDocument object.
     *
     * @return DOMDocument DOMDocument object.
     */
    public function dom(): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        return $dom;
    }
}
