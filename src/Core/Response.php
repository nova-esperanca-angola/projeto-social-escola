<?php
declare(strict_types=1);

namespace NovaEsperanca\Core;

class Response
{
    private const DEFAULT_SECURITY_HEADERS = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'SAMEORIGIN',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        'X-XSS-Protection' => '1; mode=block'
    ];

    private readonly array $headers;

    public function __construct(
        private readonly string $body,
        private readonly int $statusCode = 200,
        array $headers = []
    ) {
        $this->headers = array_merge(self::DEFAULT_SECURITY_HEADERS, $headers);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public static function json(array $data, int $statusCode = 200): self
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return new self((string)$json, $statusCode, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    public static function html(string $html, int $statusCode = 200): self
    {
        return new self($html, $statusCode, ['Content-Type' => 'text/html; charset=utf-8']);
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $val) {
            header("{$name}: {$val}");
        }
        echo $this->body;
    }
}
