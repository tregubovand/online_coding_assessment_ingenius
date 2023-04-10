<?php

namespace App\Modules\Invoices\Infrastructure\Http;

use GuzzleHttp\Psr7\Response;

class ResponseDataStorage
{
    public function __construct(
        public string $message = '',
        public string $error = '',
        public array $data = [],
        public bool $success = true,
    )
    {
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    public function setError(string $error): void
    {
        $this->error = $error;
    }
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setStatus(bool $status): void
    {
        $this->success = $status;
    }

    public function toArray(): array
    {
        return [
          'message' => $this->message,
          'error' => $this->error,
          'data' => $this->data,
          'success' => $this->success
        ];
    }
}
