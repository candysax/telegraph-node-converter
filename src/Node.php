<?php

namespace Candysax\TelegraphNodeConverter;

use Candysax\TelegraphNodeConverter\Exceptions\IncorrectInputFormatException;
use Candysax\TelegraphNodeConverter\Exceptions\InvalidNodeArgumentTypeException;
use Candysax\TelegraphNodeConverter\Types\HTMLType;

/**
 * Class Node
 *
 * This class provides the functionality to convert a Telegraph Node into HTML representation.
 */
class Node
{
    private const EMPTY_TAGS = ['br', 'img'];


    /**
     * Converts the given Telegraph Node to its HTML representation.
     *
     * @param string|array $nodes The node to convert to HTML representations.
     * @throws IncorrectInputFormatException If an incorrect node array format is passed.
     * @throws InvalidNodeArgumentTypeException If the passed argument is not a json string or an array.
     * @return HTMLType A class containing the HTML representation of the node in string or DOMDocument format.
     */
    public static function convertToHtml($nodes)
    {
        if (!is_string($nodes) && !is_array($nodes)) {
            throw new InvalidNodeArgumentTypeException('The argument passed to convertToHtml must be a json string or an array.');
        }

        $nodes = is_string($nodes) ? json_decode($nodes, true) : $nodes;
        $nodes = [[
            'tag' => 'div',
            'children' => $nodes,
        ]];

        $html = self::collectElemenets($nodes[0]);

        return new HTMLType($html);
    }


    /**
     * Traverses the array hierarchy and generates HTML code.
     *
     * @param array $parent The element of the array in which we collect children.
     * @throws IncorrectInputFormatException If an incorrect node array format is passed.
     * @return string An element in HTML format.
     */
    private static function collectElemenets(array $parent)
    {
        $html = '';
        $nodes = $parent['children'];

        foreach ($nodes as $node) {
            if (is_array($node)) {
                if (!isset($node['tag'])) throw new IncorrectInputFormatException('The node element must contain the tag name.');

                $tag = strtolower($node['tag']);

                $attrs = '';
                if (isset($node['attrs']))
                foreach ($node['attrs'] as $attr => $value) {
                    $attrs .= ' ' . $attr . '="' . $value . '"';
                }

                if (in_array($tag, self::EMPTY_TAGS)) {
                    $html .= "<{$tag}{$attrs} />";
                } else {
                    $html .= "<{$tag}{$attrs}>" . self::collectElemenets($node) . "</{$tag}>";
                }
            } elseif (is_string($node)) {
                $html .= $node;
            } else {
                throw new IncorrectInputFormatException('Array of nodes must contain only the array or string type.');
            }
        }

        return $html;
    }
}
