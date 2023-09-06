<?php

namespace Candysax\TelegraphNodeConverter\Tests;

use Candysax\TelegraphNodeConverter\Exceptions\IncorrectInputFormatException;
use Candysax\TelegraphNodeConverter\Node;
use Candysax\TelegraphNodeConverter\Types\HTMLType;
use DOMDocument;
use PHPUnit\Framework\TestCase;


final class NodeTest extends TestCase
{
    /** @test */
    public function test_is_html()
    {
        $input = ['Hello world'];

        $this->assertInstanceOf(HTMLType::class, Node::convertToHtml($input));
    }


    /** @test */
    public function test_pass_a_string()
    {
        $input = json_encode([[
            'tag' => 'p',
            'children' => [
                'Hello world ',
                [
                    'tag' => 'b',
                    'children' => [
                        'bold text',
                    ],

                ],
            ],
        ]]);

        $this->assertSame('<p>Hello world <b>bold text</b></p>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_without_root()
    {
        $input = ['Hello world'];

        $this->assertSame('Hello world', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_paragraph()
    {
        $input = [[
            'tag' => 'p',
            'children' => ['Hello world'],
        ]];

        $this->assertSame('<p>Hello world</p>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_empty_tag()
    {
        $input = [[
            'tag' => 'p',
        ]];

        $this->assertSame('<p></p>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_without_root_with_bold()
    {
        $input = [
            'Hello world ',
            [
                'tag' => 'b',
                'children' => [
                    'bold text',
                ],

            ],
        ];

        $this->assertSame('Hello world <b>bold text</b>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_paragraph_with_bold()
    {
        $input = [[
            'tag' => 'p',
            'children' => [
                'Hello world ',
                [
                    'tag' => 'b',
                    'children' => [
                        'bold text',
                    ],

                ],
            ],
        ]];

        $this->assertSame('<p>Hello world <b>bold text</b></p>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_paragraph_with_link()
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
            '<p>Hello world <a href="https://example.com/">link</a></p>',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_paragraph_with_multiple_childs()
    {
        $input = [[
            'tag' => 'p',
            'children' => [
                'Hello world ',
                [
                    'tag' => 'b',
                    'children' => [
                        'bold text',
                    ],

                ],
                ' ',
                [
                    'tag' => 'a',
                    'attrs' => [
                        'href' => '#',
                    ],
                    'children' => [
                        'link',
                    ],
                ],
            ],
        ]];

        $this->assertSame(
            '<p>Hello world <b>bold text</b> <a href="#">link</a></p>',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_text_with_new_line()
    {
        $input = [[
            'tag' => 'p',
            'children' => [
                'Hello',
                [
                    'tag' => 'br',

                ],
                'world',
            ],
        ]];

        $this->assertSame('<p>Hello<br />world</p>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_list_and_link()
    {
        $input = [[
            'tag' => 'ol',
            'children' => [
                [
                    'tag' => 'li',
                    'children' => ['Item 1'],
                ],
                [
                    'tag' => 'li',
                    'children' => ['Item 2'],
                ],
                [
                    'tag' => 'li',
                    'children' => [
                        [
                            'tag' => 'a',
                            'attrs' => ['href' => '#'],
                            'children' => ['Item 3']
                        ],
                    ],
                ],
            ],
        ]];

        $this->assertSame(
            '<ol><li>Item 1</li><li>Item 2</li><li><a href="#">Item 3</a></li></ol>',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_images()
    {
        $input = [[
            'tag' => 'img',
            'attrs' => [
                'src' => 'https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg',
            ],
        ],
        [
            'tag' => 'img',
            'attrs' => [
                'src' => 'https://www.php.net/images/logos/php-logo.svg',
                'alt' => 'PHP Logo',
            ],
        ]];

        $this->assertSame(
            '<img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg" /><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo" />',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_images_with_text()
    {
        $input = [[
            'tag' => 'p',
            'children' => ['Intro text'],
        ],
        [
            'tag' => 'img',
            'attrs' => [
                'src' => 'https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg',
            ],
        ],
        [
            'tag' => 'p',
            'children' => ['Main text'],
        ],
        [
            'tag' => 'img',
            'attrs' => [
                'src' => 'https://www.php.net/images/logos/php-logo.svg',
                'alt' => 'PHP Logo',
            ],
        ],
        [
            'tag' => 'p',
            'children' => ['Ending text'],
        ]];

        $this->assertSame(
            '<p>Intro text</p><img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg" /><p>Main text</p><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo" /><p>Ending text</p>',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_iframe()
    {
        $input = [[
            'tag' => 'iframe',
            'attrs' => [
                'src' => 'https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF',
            ],
        ]];

        $this->assertSame(
            '<iframe src="https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF"></iframe>',
            Node::convertToHtml($input)->string()
        );
    }


    /** @test */
    public function test_convert_text_with_non_latin_chars()
    {
        $input = [
            'Привет ',
            [
                'tag' => 'b',
                'children' => ['мир!'],
        ]];

        $this->assertSame('Привет <b>мир!</b>', Node::convertToHtml($input)->string());
    }


    /** @test */
    public function test_convert_to_dom()
    {
        $input = [[
            'tag' => 'p',
            'children' => ['Hello world'],
        ]];

        $this->assertInstanceOf(DOMDocument::class, Node::convertToHtml($input)->dom());

        $html = '<ol><li>Item 1</li><li>Item 2</li><li><a href="#">Item 3</a></li></ol>';
        $input = [[
            'tag' => 'ol',
            'children' => [
                [
                    'tag' => 'li',
                    'children' => ['Item 1'],
                ],
                [
                    'tag' => 'li',
                    'children' => ['Item 2'],
                ],
                [
                    'tag' => 'li',
                    'children' => [
                        [
                            'tag' => 'a',
                            'attrs' => ['href' => '#'],
                            'children' => ['Item 3']
                        ],
                    ],
                ],
            ],
        ]];

        $dom = new DOMDocument(encoding: 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->assertEquals($dom, Node::convertToHtml($input)->dom());
    }


    /** @test */
    public function test_array_of_nodes_contains_not_only_arrays_and_strings()
    {
        $this->expectException(IncorrectInputFormatException::class);
        Node::convertToHtml([
            42,
            [
                'tag' => 'b',
                'children' => [
                    'bold text',
                ],

            ]
        ]);
    }


    /** @test */
    public function test_node_array_does_not_contain_the_tag_name()
    {
        $this->expectException(IncorrectInputFormatException::class);
        Node::convertToHtml([
            'Hello world ',
            [
                'children' => [
                    'bold text',
                ],

            ]
        ]);
    }
}
