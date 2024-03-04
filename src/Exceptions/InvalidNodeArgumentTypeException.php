<?php

namespace Candysax\TelegraphNodeConverter\Exceptions;

class InvalidNodeArgumentTypeException extends \Exception {
    protected $message = 'The argument passed to convertToHtml must be a json string or an array.';
}
