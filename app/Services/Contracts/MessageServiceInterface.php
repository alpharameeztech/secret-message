<?php

namespace App\Services\Contracts;

interface MessageServiceInterface
{
    public function getUserMessages(int $userId);
    public function createMessage(array $data);
    public function readMessage(string $identifier);
    public function getUnreadMessages(int $userId);
}
