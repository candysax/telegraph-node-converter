<?php

namespace Candysax\TelegraphNodeConverter;

use Candysax\TelegraphNodeConverter\Exceptions\InvalidHTMLArgumentTypeException;
use DOMDocument;
use DOMElement;
use DOMText;
use Candysax\TelegraphNodeConverter\Types\NodeType;

/**
 * Class HTML
 *
 * This class provides the functionality to convert HTML into a Telegraph Node representation.
 */
class HTML
{
    private const AVAILABLE_ATTRS = ['href', 'src'];


    /**
     * Converts the given HTML to its Telegraph Node representation.
     *
     * @param string|DOMDocument $html HTML to convert to json or array representations (https://telegra.ph/api#NodeElement).
     * @throws InvalidHTMLArgumentTypeException If the passed argument is not a string or a DOMDocument object.
     * @return NodeType A class containing a Node representation in array or json format.
     */
    public static function convertToNode($html)
    {
        if (is_string($html)) {
            $html = "<div>{$html}</div>";

            $dom = new DOMDocument(encoding: 'UTF-8');
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_PARSEHUGE);
            $bodyElement = $dom->getElementsByTagName('body')[0];
            if (isset($bodyElement)) $dom = self::wrapDomDocument($bodyElement);
        } else if ($html instanceof DOMDocument) {
            $bodyElement = $html->getElementsByTagName('body')[0];
            $dom = self::wrapDomDocument(isset($bodyElement) ? $bodyElement : $html);
        } else {
            throw new InvalidHTMLArgumentTypeException('The argument passed to convertToNode must be a string or a DOMDocument object.');
        }

        $root = $dom->documentElement;

        return new NodeType(self::collectElemenets($root));
    }


    /**
     * Traverses the entire DOM tree and forms an array in Telegraph NodeElement form.
     *
     * @param DomElement $parent The element of the DOM tree in which we collect children.
     * @return array An element in NodeElement format.
     */
    private static function collectElemenets(DOMElement $parent)
    {
        $nodes = [];
        $elements = $parent->childNodes;

        foreach ($elements as $element) {
            $elementRepresentation = [];
            if ($element instanceof DOMText) {
                $nodes[] = $element->textContent;
            } elseif ($element instanceof DOMElement) {
                $elementRepresentation['tag'] = strtolower($element->tagName);

                foreach ($element->attributes as $attribute) {
                    if (in_array($attribute->name, self::AVAILABLE_ATTRS)) {
                        $elementRepresentation['attrs'][$attribute->name] = $attribute->value;
                    }
                }

                if (count($element->childNodes) > 0) {
                    $elementRepresentation['children'] = self::collectElemenets($element);
                }

                $nodes[] = $elementRepresentation;
            }
        }

        return $nodes;
    }


    /**
     * Wraps the domdocument in the parent element.
     *
     * @param DOMDocument|DOMElement $dom Source DOMDocument object.
     * @return DOMDocument Converted DOMDocument object.
     */
    private static function wrapDomDocument(DOMDocument|DOMElement $dom)
    {
        $newDom = new DOMDocument();
        $rootElement = $newDom->createElement('div');

        foreach ($dom->childNodes as $node) {
            $rootElement->appendChild($newDom->importNode($node, true));
        }

        $newDom->appendChild($rootElement);

        return $newDom;
    }
}
