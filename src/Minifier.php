<?php

namespace Interop\Http\Message\Strategies\Examples\Minifier;

use Interop\Http\Factory\StreamFactoryInterface;
use Interop\Http\Message\Strategies\ResponseOperatorInterface;
use Middlewares\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

abstract class Minifier implements ResponseOperatorInterface
{
    /**
     * @var string
     */
    protected $mimetype;

    protected $streamFactory;

    public function __construct(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(ResponseInterface $response)
    {
        if (stripos($response->getHeaderLine('Content-Type'), $this->mimetype) === 0) {
            $minified = $this->minify((string) $response->getBody());
            $stream = $this->streamFactory->createStream($minified);

            $response = $response->withBody($stream);

            return Helpers::fixContentLength($response);
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
