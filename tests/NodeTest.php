<?php

use HtmlToTelegraphNode\Node;
use PHPUnit\Framework\TestCase;

/**
 * NodeTest
 * @group group
 */
class NodeTest extends TestCase
{
    /** @test */
    public function test_convert_without_root()
    {
        $input = ['Hello world'];

        $this->assertSame('Hello world', Node::convertToHtml($input));
    }


    // /** @test */
    // public function test_convert_paragraph()
    // {
    //     $input = '<p>Hello world</p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => ['Hello world'],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_without_root_with_bold()
    // {
    //     $input = 'Hello world <b>bold text</b>';

    //     $this->assertSame([
    //         'Hello world ',
    //         [
    //             'tag' => 'b',
    //             'children' => [
    //                 'bold text',
    //             ],

    //         ],
    //     ], Node::convertToHtml($input));
    // }



    // /** @test */
    // public function test_convert_paragraph_with_bold()
    // {
    //     $input = '<p>Hello world <b>bold text</b></p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => [
    //             'Hello world ',
    //             [
    //                 'tag' => 'b',
    //                 'children' => [
    //                     'bold text',
    //                 ],

    //             ],
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_paragraph_with_link()
    // {
    //     $input = '<p>Hello world <a href="https://example.com/">link</a></p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => [
    //             'Hello world ',
    //             [
    //                 'tag' => 'a',
    //                 'attrs' => [
    //                     'href' => 'https://example.com/',
    //                 ],
    //                 'children' => [
    //                     'link',
    //                 ],
    //             ],
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_paragraph_with_multiple_childs()
    // {
    //     $input = '<p>Hello world <b>bold text</b> <a href="#">link</a></p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => [
    //             'Hello world ',
    //             [
    //                 'tag' => 'b',
    //                 'children' => [
    //                     'bold text',
    //                 ],

    //             ],
    //             ' ',
    //             [
    //                 'tag' => 'a',
    //                 'attrs' => [
    //                     'href' => '#',
    //                 ],
    //                 'children' => [
    //                     'link',
    //                 ],
    //             ],
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_text_with_new_line()
    // {
    //     $input = '<p>Hello<br>world</p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => [
    //             'Hello',
    //             [
    //                 'tag' => 'br',

    //             ],
    //             'world',
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_list_and_link()
    // {
    //     $input = '<ol><li>Item 1</li><li>Item 2</li><li><a href="#">Item 3</a></li></ol>';

    //     $this->assertSame([[
    //         'tag' => 'ol',
    //         'children' => [
    //             [
    //                 'tag' => 'li',
    //                 'children' => ['Item 1'],
    //             ],
    //             [
    //                 'tag' => 'li',
    //                 'children' => ['Item 2'],
    //             ],
    //             [
    //                 'tag' => 'li',
    //                 'children' => [
    //                     [
    //                         'tag' => 'a',
    //                         'attrs' => ['href' => '#'],
    //                         'children' => ['Item 3']
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_images()
    // {
    //     $input = '<img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg"><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo">';

    //     $this->assertSame([[
    //         'tag' => 'img',
    //         'attrs' => [
    //             'src' => 'https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg',
    //         ],
    //     ],
    //     [
    //         'tag' => 'img',
    //         'attrs' => [
    //             'src' => 'https://www.php.net/images/logos/php-logo.svg',
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_images_with_text()
    // {
    //     $input = '<p>Intro text</p><img src="https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg"><p>Main text</p><img src="https://www.php.net/images/logos/php-logo.svg" alt="PHP Logo"><p>Ending text</p>';

    //     $this->assertSame([[
    //         'tag' => 'p',
    //         'children' => ['Intro text'],
    //     ],
    //     [
    //         'tag' => 'img',
    //         'attrs' => [
    //             'src' => 'https://telegra.ph/file/6a5b15e7eb4d7329ca7af.jpg',
    //         ],
    //     ],
    //     [
    //         'tag' => 'p',
    //         'children' => ['Main text'],
    //     ],
    //     [
    //         'tag' => 'img',
    //         'attrs' => [
    //             'src' => 'https://www.php.net/images/logos/php-logo.svg',
    //         ],
    //     ],
    //     [
    //         'tag' => 'p',
    //         'children' => ['Ending text'],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_iframe()
    // {
    //     $input = '<iframe width="560" height="315" src="https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

    //     $this->assertSame([[
    //         'tag' => 'iframe',
    //         'attrs' => [
    //             'src' => 'https://www.youtube.com/embed/jNQXAC9IVRw?si=QGJ2nPkJdJc53rsF',
    //         ],
    //     ]], Node::convertToHtml($input));
    // }


    // /** @test */
    // public function test_convert_text_with_non_latin_chars()
    // {
    //     $input = 'Привет <b>мир!</b>';

    //     $this->assertSame([
    //     'Привет ',
    //     [
    //         'tag' => 'b',
    //         'children' => ['мир!'],
    //     ]], Node::convertToHtml($input));
    // }
}
