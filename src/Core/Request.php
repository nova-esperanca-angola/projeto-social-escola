<?php
declare(strict_types=1);

namespace NovaEsperanca\Core;

class Request
{
    private string $method;
    private string $uri;
    private array $params;
    private array $headers;

    public function __construct(
        string $method = 'GET',
        string $uri = '/',
        array $params = [],
        array $headers = []
    ) {
        $this->method = strtoupper($method);
        $this->uri = '/' . trim(parse_url($uri, PHP_URL_PATH) ?? '/', '/');
        if ($this->uri !== '/') {
            $this->uri = rtrim($this->uri, '/');
        }
        $this->params = $params;
        $this->headers = $headers;
    }

    public static function createFromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        $params = [];
        if ($method === 'POST') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (str_contains($contentType, 'application/json')) {
                $raw = file_get_contents('php://input');
                $decoded = is_string($raw) ? json_decode($raw, true) : null;
                $params = is_array($decoded) ? $decoded : [];
            } else {
                $params = $_POST;
            }
        } else {
            $params = $_GET;
        }

        return new self($method, $uri, $params);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }
}
