<?php

namespace App\Services;

use App\Models\Message;
use App\Services\Contracts\MessageServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class MessageService implements MessageServiceInterface
{
    public function getUserMessages(int $userId)
    {
        return Message::where('sender_id', $userId)->get();
    }

    public function createMessage(array $data)
    {
        $encryptedMessage = Crypt::encryptString($data['text']);
        $expiry = isset($data['expires_in']) ? Carbon::now()->addMinutes((int) $data['expires_in']) : null;

        return Message::create([
            'identifier' => uniqid(),
            'sender_id' => Auth::id(),
            'recipient_id' => $data['recipient_id'],
            'encrypted_message' => $encryptedMessage,
            'expires_at' => $expiry,
        ]);
    }

    public function readMessage(string $identifier)
    {
        $message = Message::where('identifier', $identifier)->first();

        if (!$message) {
            return ['error' => 'Message not found'];
        }

        if ($message->expires_at && Carbon::now()->greaterThan($message->expires_at)) {
            $message->delete();
            return ['error' => 'Message has expired'];
        }

        if ($message->opened_at) {
            return ['error' => 'Message has already been opened and is no longer available.'];
        }

        $decryptedMessage = Crypt::decryptString($message->encrypted_message);

        $message->opened_at = Carbon::now();
        $message->save();
        $message->delete();

        return ['decryptedMessage' => $decryptedMessage];
    }

    public function getUnreadMessages(int $userId)
    {
        return Message::where('recipient_id', $userId)
            ->whereNull('opened_at')
            ->with('sender')
            ->paginate(10);
    }
}
