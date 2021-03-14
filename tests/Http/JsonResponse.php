<?php

declare(strict_types=1);

namespace Bag2\Container\Http;

use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @phpstan-template K
 * @phpstan-template V
 */
class JsonResponse implements JsonSerializable, ResponseInterface
{
    use ResponseWrapperTrait;

    /** @phpstan-var array<K,V> */
    private array $data;

    /**
     * @phpstan-param array<K,V> $data
     */
    final public function __construct(
        ?array $data,
        ResponseInterface $inner_response,
        StreamFactoryInterface $stream_factory
    ) {
        if ($data !== null) {
            $this->data = $data;
        }

        $this->inner_response = $inner_response;
        $this->stream_factory = $stream_factory;
    }

    /**
     * @phpstan-return array<K,V>
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @phpstan-param array<K,V> $data
     * @return JsonResponse<K,V>
     */
    public function withJsonData(?array $data)
    {
        return new static(
            $this->data ?? null,
            $this->inner_response,
            $this->stream_factory
        );
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion()
    {
        return $this->inner_response->getProtocolVersion();
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     * @return static
     */
    public function withProtocolVersion($version)
    {
        return new static(
            $this->data ?? null,
            $this->inner_response->withProtocolVersion($version),
            $this->stream_factory
        );
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withHeader($name, $value)
    {
        return new static(
            $this->data ?? null,
            $this->inner_response->withHeader($name, $value),
            $this->stream_factory
        );
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withAddedHeader($name, $value)
    {
        return new static(
            $this->data ?? null,
            $this->inner_response->withAddedHeader($name, $value),
            $this->stream_factory
        );
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return static
     */
    public function withoutHeader($name)
    {
        return new static(
            $this->data ?? null,
            $this->inner_response->withoutHeader($name),
            $this->stream_factory
        );
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody()
    {
        $json = json_encode($this);

        assert($json !== false);

        return $this->stream_factory->createStream($json);
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body Body.
     * @return static
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function withBody(StreamInterface $body)
    {
        throw new \InvalidArgumentException();
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return static
     * @throws \InvalidArgumentException For invalid status code arguments.
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        return new static(
            $this->data ?? null,
            $this->inner_response->withStatus($code, $reasonPhrase),
            $this->stream_factory
        );
    }
}
