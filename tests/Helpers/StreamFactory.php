<?php

namespace Interop\Http\Message\Strategies\Examples\Minifier\Tests\Helpers;

use Interop\Http\Factory\StreamFactoryInterface;
use Zend\Diactoros\Stream;

class StreamFactory implements StreamFactoryInterface
{
    public function createStream($content = '')
    {
        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $content);
        rewind($resource);

        return $this->createStreamFromResource($resource);
    }

    public function createStreamFromFile($path, $mode = 'r')
    {
        $error = null;
        set_error_handler(function ($severity, $message, $filename, $lineno) use (&$error) {
            $error = new \ErrorException($message, 0, $severity, $filename, $lineno);
        }, E_WARNING);
        $stream = fopen($path, $mode);
        restore_error_handler();

        if ($error) {
            throw new \Exception(
                "The file \"$path\" could not be opened ($mode).",
                $error
            );
        }

        return $this->createStreamFromResource($resource);
    }

    public function createStreamFromResource($resource)
    {
        return new Stream($resource);
    }
}
