# http-message-strategies-interop/example-minifier

> A [middlewares/minifier](https://github.com/middlewares/minifier) fork, but using [HTTP Message Strategies PSR (pre-Draft)](https://github.com/http-message-strategies-interop/fig-standards/tree/http-message-strategies/proposed/http-message-strategies)


HTTP Message Strategies to minify the `Html`, `CSS` and `Javascript` content using [mrclay/minify](https://github.com/mrclay/minify). This package is splited into the following components:

* [HtmlMinifier](#htmlminifier)
* [CssMinifier](#cssminifier)
* [JsMinifier](#jsminifier)

## Example

```php
$streamFactory = new StreamFactory(); // A PSR-17 StreamFactory

foreach ([
    new CssMinifier($streamFactory),
    new JsMinifier($streamFactory),
    new HtmlMinifier($streamFactory),
] as $minifier) {
    $response = $minifier($response);
}
```

## HtmlMinifier

Minifies the code of html responses. Make sure the response contains the header `Content-Type: text/html` (you can use [middlewares/negotiation](https://github.com/middlewares/negotiation)).

#### `inlineCss($inlineCss = true)`

Set `false` to do not minify inline css. (`true` by default)

#### `inlineJs($inlineJs = true)`

Set `false` to do not minify inline js. (`true` by default)

## CssMinifier

Minifies the code of css responses. Make sure the response contains the header `Content-Type: text/css`.

## JsMinifier

Minifies the code of javascript responses. Make sure the response contains the header `Content-Type: text/javascript`.


## Related

* [HTTP Message Strategies PSR (pre-Draft)](https://github.com/http-message-strategies-interop/fig-standards/tree/http-message-strategies/proposed/http-message-strategies)
* [HTTP Factories](https://github.com/http-interop/http-factory)

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
