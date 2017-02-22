<?php

namespace Interop\Http\Message\Strategies\Examples\Minifier;

use JSMin;

class JsMinifier extends Minifier
{
    /**
     * @var string
     */
    protected $mimetype = 'text/javascript';

    /**
     * {@inheritdoc}
     */
    protected function minify($content)
    {
        return JSMin::minify($content);
    }
}
