<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\RecipientServiceInterface;
use Illuminate\Support\Facades\Auth;

class RecipientService implements RecipientServiceInterface
{
    public function getRecipientsExcludingAuthenticated()
    {
        return User::where('id', '!=', Auth::id())->get();
    }
}
