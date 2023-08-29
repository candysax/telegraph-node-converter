<?php

namespace HtmlToTelegraphNode;

use HtmlToTelegraphNode\Types\HTMLType;

/**
 *
 */
class Node
{
    private const EMPTY_TAGS = ['br', 'img'];

    public static function convertToHtml(string|array $nodes)
    {
        $nodes = is_string($nodes) ? json_decode($nodes, true) : $nodes;
        $nodes = [[
            'tag' => 'div',
            'children' => $nodes,
        ]];

        $html = self::collectElemenets($nodes[0]);

        return new HTMLType($html);
    }


    private static function collectElemenets(array $parent)
    {
        $html = '';
        $nodes = $parent['children'];

        foreach ($nodes as $node) {
            if (is_array($node)) {
                $tag = $node['tag'];

                $attrs = '';
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
            }
        }

        return $html;
    }
}
