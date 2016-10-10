<?php

namespace Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Http\Middleware\MiddlewareInterface;
use Interop\Http\Middleware\DelegateInterface;

abstract class Minifier
{
    /**
     * @var string
     */
    protected $mimetype;

    /**
     * Process a server request and return a response.
     *
     * @param RequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);

        if (stripos($response->getHeaderLine('Content-Type'), $this->mimetype) === 0) {
            $stream = Utils\Factory::createStream();
            $stream->write($this->minify((string) $response->getBody()));

            return $response->withBody($stream);
        }

        return $response;
    }

    /**
     * Minify the body content.
     *
     * @param string $content
     *
     * @return string
     */
    abstract protected function minify($content);
}