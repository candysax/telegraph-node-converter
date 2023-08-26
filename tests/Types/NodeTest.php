<?php

use HtmlToTelegraphNode\HTML;
use PHPUnit\Framework\TestCase;

/**
 * NodeTest
 * @group group
 */
class NodeTest extends TestCase
{
    /** @test */
    public function test_double_conversion()
    {
        $input = '<p>Hello <b>world</b> <a href="https://example.com/">link</a></p>';

        $this->assertSame($input, HTML::convertToNode($input)->convertToHtml());
    }
}
