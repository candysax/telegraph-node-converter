<?php

use Candysax\TelegraphNodeConverter\Node;
use PHPUnit\Framework\TestCase;


final class HTMLTypeTest extends TestCase
{
    /** @test */
    public function test_multiple_conversion()
    {
        $input = [[
            'tag' => 'p',
            'children' => [
                'Hello world ',
                [
                    'tag' => 'a',
                    'attrs' => [
                        'href' => 'https://example.com/',
                    ],
                    'children' => [
                        'link',
                    ],
                ],
            ],
        ]];

        $this->assertSame(
            $input,
            Node::convertToHtml($input)->convertToNode()->convertToHtml()->convertToNode()->array()
        );
    }
}
