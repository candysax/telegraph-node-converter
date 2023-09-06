<?php

namespace Candysax\TelegraphNodeConverter\Tests;

use Candysax\TelegraphNodeConverter\HTML;
use PHPUnit\Framework\TestCase;


final class NodeTypeTest extends TestCase
{
    /** @test */
    public function test_multiple_conversion()
    {
        $input = '<p>Hello <b>world</b> <a href="https://example.com/">link</a></p>';

        $this->assertSame(
            $input,
            HTML::convertToNode($input)->convertToHtml()->convertToNode()->convertToHtml()->string()
        );
    }
}
