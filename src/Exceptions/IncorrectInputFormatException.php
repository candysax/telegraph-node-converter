<?php

namespace Candysax\TelegraphNodeConverter\Exceptions;

class IncorrectInputFormatException extends \Exception {
    public static function mustContainTheTagName()
    {
        return new self('The node element must contain the tag name.');
    }

    public static function mustContainOnlyTheArrayOrStringType()
    {
        return new self('Array of nodes must contain only the array or string type.');
    }
}
