<?php

namespace HtmlToTelegraphNode;

use DOMDocument;
use DOMElement;
use DOMText;
use HtmlToTelegraphNode\Types\Node;

class HTML
{
    private const AVAILABLE_ATTRS = ['href', 'src'];

    public static function convertToNode(string $html)
    {
        $html = "<div>{$html}</div>";

        $dom = new DOMDocument();
        $dom->encoding = 'UTF-8';
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $root = $dom->documentElement;

        return new Node(self::collectElemenets($root));
    }


    private static function collectElemenets(DOMElement $parent)
    {
        $nodes = [];
        $elements = $parent->childNodes;

        foreach ($elements as $element) {
            $elementRepresentation = [];
            if ($element instanceof DOMText) {
                $nodes[] = $element->textContent;

            } elseif ($element instanceof DOMElement) {
                $elementRepresentation['tag'] = $element->tagName;

                foreach ($element->attributes as $attribute) {
                    if (in_array($attribute->name, self::AVAILABLE_ATTRS)) {
                        $elementRepresentation['attrs'][$attribute->name] = $attribute->value;
                    }
                }

                if (count($element->childNodes) > 0) {
                    $elementRepresentation['children'] = self::collectElemenets($element) ? self::collectElemenets($element) : [$element->textContent];
                }

                $nodes[] = $elementRepresentation;
            }
        }

        return $nodes;
    }
}
