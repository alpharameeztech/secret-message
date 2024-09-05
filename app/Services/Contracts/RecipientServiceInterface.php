<?php

namespace App\Services\Contracts;

interface RecipientServiceInterface
{
    public function getRecipientsExcludingAuthenticated();
}
