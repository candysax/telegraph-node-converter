<?php

namespace Candysax\TelegraphNodeConverter\Exceptions;

class InvalidHTMLArgumentTypeException extends \Exception {
    protected $message = 'The argument passed to convertToNode must be a string or a DOMDocument object.';
}
