<?php

use HtmlToTelegraphNode\HTML;
use HtmlToTelegraphNode\Types\NodeType;
use PHPUnit\Framework\TestCase;


final class HTMLTest extends TestCase
{
    /** @test */
    public function test_is_node()
    {
        $input = 'Hello world';

        $this->assertInstanceOf(NodeType::class, HTML::convertToNode($input));
    }


    /** @test */
    public function test_convert_without_root()
    {
        $input = 'Hello world';

        $this->assertSame(
            json_encode(['Hello world']),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_paragraph()
    {
        $input = '<p>Hello world</p>';

        $this->assertSame(
            json_encode([[
                'tag' => 'p',
                'children' => ['Hello world'],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_empty_tag()
    {
        $input = '<p></p>';

        $this->assertSame(
            json_encode([[
                'tag' => 'p',
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_without_root_with_bold()
    {
        $input = 'Hello world <b>bold text</b>';

        $this->assertSame(
            json_encode([
                'Hello world ',
                [
                    'tag' => 'b',
                    'children' => [
                        'bold text',
                    ],

                ],
            ]),
            HTML::convertToNode($input)->json()
        );
    }



    /** @test */
    public function test_convert_paragraph_with_bold()
    {
        $input = '<p>Hello world <b>bold text</b></p>';

        $this->assertSame(
            json_encode([[
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
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_paragraph_with_link()
    {
        $input = '<p>Hello world <a href="https://example.com/">link</a></p>';

        $this->assertSame(
            json_encode([[
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
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_paragraph_with_multiple_childs()
    {
        $input = '<p>Hello world <b>bold text</b> <a href="#">link</a></p>';

        $this->assertSame(
            json_encode([[
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
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_text_with_new_line()
    {
        $input = '<p>Hello<br>world</p>';

        $this->assertSame(
            json_encode([[
                'tag' => 'p',
                'children' => [
                    'Hello',
                    [
                        'tag' => 'br',

                    ],
                    'world',
                ],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_list_and_link()
    {
        $input = '<ol><li>Item 1</li><li>Item 2</li><li><a href="#">Item 3</a></li></ol><p>test text</p>';

        $this->assertSame(
            json_encode([
                [
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
                ],
                [
                    'tag' => 'p',
                    'children' => ['test text'],
                ],
            ]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_images()
    {
        $input = '<img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg"><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo">';

        $this->assertSame(
            json_encode([[
                'tag' => 'img',
                'attrs' => [
                    'src' => 'https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg',
                ],
            ],
            [
                'tag' => 'img',
                'attrs' => [
                    'src' => 'https://www.php.net/images/logos/php-logo.svg',
                ],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_images_with_text()
    {
        $input = '<p>Intro text</p><img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg"><p>Main text</p><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo"><p>Ending text</p>';

        $this->assertSame(
            json_encode([[
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
                ],
            ],
            [
                'tag' => 'p',
                'children' => ['Ending text'],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_iframe()
    {
        $input = '<iframe width="560" height="315" src="https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

        $this->assertSame(
            json_encode([[
                'tag' => 'iframe',
                'attrs' => [
                    'src' => 'https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF',
                ],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_text_with_non_latin_chars()
    {
        $input = 'Привет <b>мир!</b>';

        $this->assertSame(
            json_encode([
            'Привет ',
            [
                'tag' => 'b',
                'children' => ['мир!'],
            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_pass_a_full_html_page()
    {
        $input = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Document</title></head><body><p>Hello world</p></body></html>';

        $this->assertSame(
            json_encode([[
                'tag' => 'p',
                'children' => ['Hello world'],

            ]]),
            HTML::convertToNode($input)->json()
        );
    }


    /** @test */
    public function test_convert_dom_document()
    {
        $input = new DOMDocument();
        $input->loadHTML(
            mb_convert_encoding(
                '<p>Hello world <a href="https://example.com/">link</a></p>',
                'HTML-ENTITIES',
                'UTF-8'
            ),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $this->assertEquals(
            json_encode([[
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
            ]]),
            HTML::convertToNode($input)->json()
        );

        $input->loadHTML(
            mb_convert_encoding(
                '<p></p>',
                'HTML-ENTITIES',
                'UTF-8'
            ),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $this->assertEquals(
            json_encode([[
                'tag' => 'p',
            ]]),
            HTML::convertToNode($input)->json()
        );
    }
}
