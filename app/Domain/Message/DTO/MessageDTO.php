<?php

namespace App\Domain\Message\DTO;

readonly class MessageDTO
{
    public function __construct(
        private ?int   $id,
        private int    $sender,
        private int    $receiver,
        private string $body,
        private string $sent_at,
        private bool   $read,
    )
    {
    }
}
