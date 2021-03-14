<?php

declare(strict_types=1);

namespace Bag2\Container\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class JsonResponseFactory implements ResponseFactoryInterface
{
    private ResponseFactoryInterface $response_factory;
    private StreamFactoryInterface $stream_factory;

    public function __construct(
        ResponseFactoryInterface $response_factory,
        StreamFactoryInterface $stream_factory
    ) {
        $this->response_factory = $response_factory;
        $this->stream_factory = $stream_factory;
    }

    /**
     * @return JsonResponse<array-key,null>
     */
    public function createResponse(
        int $code = 200,
        string $reasonPhrase = ''
    ): ResponseInterface
    {
        return new JsonResponse(
            null,
            $this->response_factory->createResponse($code, $reasonPhrase),
            $this->stream_factory
        );
    }
}
