<?php

namespace App\Notifications\Messages;

class SmsMessage
{
    public function __construct(
        public string $body = '',
        public ?string $from = null,
    ) {}

    public static function make(string $body, ?string $from = null): static
    {
        return new static($body, $from);
    }

    public function body(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }
}
