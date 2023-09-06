# Telegraph Node Converter
This library helps with the content field of the Page Telegraph API object. It converts an HTML string or a DOMDocument into the format required by the Telegraph API, and also converts it back to an HTML string or a DOMDocument.
- Telegraph API Docs: https://telegra.ph/api

## Installation
To install this library run the command:
```
composer require candysax/telegraph-node-converter
```

## Usage
### Converting from HTML to an array of Node
As the source data for conversion, the `convertToNode` method accepts a string containing html tags or a DOMDocument object. The result can be obtained as an array of Node or its representation as a JSON string.
```php
$nodes = HTML::convertToNode('<p>Hello <b>world</b></p>');
```
Get as array:
```php
$nodes->array();
```
```
Array
(
    [0] => Array
        (
            [tag] => p
            [children] => Array
                (
                    [0] => Hello
                    [1] => Array
                        (
                            [tag] => b
                            [children] => Array
                                (
                                    [0] => world
                                )

                        )

                )

        )

)
```
Get as JSON:
```php
$nodes->json();
```
```
'[{"tag":"p","children":["Hello ",{"tag":"b","children":["world"]}]}]'
```
Passing the DOMDocument object as a data source for conversion:
```php
$dom = new DOMDocument();
$dom->loadHTML('<p>Hello world <a href="https://example.com/">link</a></p>');

$nodes = HTML::convertToNode($dom)->json();
```

### Converting from an array of Node to HTML
As the source data for the conversion, the `convertToHtml` method accepts an array of Node or a JSON string. The result can be obtained in the form of a string with HTML tags or a DOM object.
```php
$html = Node::convertToHtml([
    [
        'tag' => 'p',
        'children' => [
            'Hello ',
            [
                'tag' => 'b',
                'children' => [
                    'world',
                ],

            ],
        ],
    ],
]);
```
Get as string:
```php
$html->string();
```
```
'<p>Hello <b>world</b></p>'
```
Get as DOMDocument:
```php
$html->dom();
```
```
DOMDocument Object
```

### Multiple conversions
```php
$input = '<p>Hello <b>world</b> <a href="https://example.com/">link</a></p>';

HTML::convertToNode($input)->convertToHtml()->convertToNode()->convertToHtml()->string();
```

### Examples
Creating a Telegraph page:
```php
use GuzzleHttp\Client;
use Candysax\TelegraphNodeConverter\HTML;

function createPage() {
    $client = new Client();
    $client->request('POST', 'https://api.telegra.ph/createPage', [
        'form_params' => [
            'access_token' => 'your_telegraph_token',
            'title' => 'Example',
            'content' => HTML::convertToNode(
                '<p>Hello world <a href="https://example.com/">link</a></p>'
            )->json(),
        ],
    ]);
}
```
Getting the content of the Telegraph page:
```php
use GuzzleHttp\Client;
use Candysax\TelegraphNodeConverter\HTML;

function getPageContent() {
    $client = new Client();
    $response = $client->request('POST', 'https://api.telegra.ph/getPage', [
        'form_params' => [
            'path' => 'path_to_the_telegraph_page',
            'return_content' => true,
        ],
    ])->getBody();
    $data = json_decode($response, true);

    return Node::convertToHtml($data['result']['content'])->string();
}
```

## Testing
Tests can be launched by running the following:
```
composer test
```

## License
The MIT License (MIT). Please see [License File](https://github.com/candysax/telegraph-node-converter/blob/main/LICENSE) for more information.
