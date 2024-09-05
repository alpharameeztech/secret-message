<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\Contracts\MessageServiceInterface;
use App\Services\Contracts\RecipientServiceInterface;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected MessageServiceInterface $messageService;
    protected RecipientServiceInterface $recipientService;

    public function __construct(MessageServiceInterface $messageService, RecipientServiceInterface $recipientService)
    {
        $this->messageService = $messageService;
        $this->recipientService = $recipientService;
    }

    public function index()
    {
        $messages = $this->messageService->getUserMessages(Auth::id());
        return view('message.index', compact('messages'));
    }

    public function create()
    {
        $users = $this->recipientService->getRecipientsExcludingAuthenticated();
        return view('message.create', compact('users'));
    }

    public function store(MessageRequest $request)
    {
        $message = $this->messageService->createMessage($request->all());

        $messageUrl = route('message.read', ['identifier' => $message->identifier]);

        return redirect()->back()->with('success', 'Message created successfully! Share this link: <a href="' . $messageUrl . '">' . $messageUrl . '</a>');
    }

    public function readMessage($identifier)
    {
        $result = $this->messageService->readMessage($identifier);
        return view('message.read', $result);
    }

    public function unreadMessages()
    {
        $messages = $this->messageService->getUnreadMessages(Auth::id());
        return view('message.unread', compact('messages'));
    }
}
