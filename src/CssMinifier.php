<?php

namespace Interop\Http\Message\Strategies\Examples\Minifier;

use Minify_CSS;

class CssMinifier extends Minifier
{
    /**
     * @var string
     */
    protected $mimetype = 'text/css';

    /**
     * {@inheritdoc}
     */
    protected function minify($content)
    {
        return Minify_CSS::minify($content, ['preserveComments' => false]);
    }
}
