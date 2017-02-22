<?php

namespace Interop\Http\Message\Strategies\Examples\Minifier\Tests;

use Interop\Http\Message\Strategies\Examples\Minifier\Tests\Helpers\StreamFactory;
use Psr\Http\Message\ResponseInterface;
use Interop\Http\Message\Strategies\Examples\Minifier\HtmlMinifier;
use Interop\Http\Message\Strategies\Examples\Minifier\CssMinifier;
use Interop\Http\Message\Strategies\Examples\Minifier\JsMinifier;
use Zend\Diactoros\Response;

class MinifierTest extends \PHPUnit_Framework_TestCase
{
    public function minifierProvider()
    {
        $data = [
            [
                'text/html',
                file_get_contents(__DIR__.'/assets/test.html'),
                trim(file_get_contents(__DIR__.'/assets/test.min.html')),
            ],
            [
                'text/css',
                file_get_contents(__DIR__.'/assets/test.css'),
                trim(file_get_contents(__DIR__.'/assets/test.min.css')),
            ],
            [
                'text/javascript',
                file_get_contents(__DIR__.'/assets/test.js'),
                trim(file_get_contents(__DIR__.'/assets/test.min.js')),
            ],
        ];

        return $data;
    }

    /**
     * @dataProvider minifierProvider
     */
    public function testMinifier($mime, $content, $expected)
    {
        $streamFactory = new StreamFactory();
        $response = (new Response())->withHeader('Content-Type', $mime);
        $response->getBody()->write($content);

        foreach ([
            new CssMinifier($streamFactory),
            new JsMinifier($streamFactory),
            new HtmlMinifier($streamFactory),
        ] as $minifier) {
            $response = $minifier($response);
        }

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals($expected, (string) $response->getBody());
        $this->assertEquals($response->getBody()->getSize(), $response->getHeaderLine('Content-Length'));
    }
}
