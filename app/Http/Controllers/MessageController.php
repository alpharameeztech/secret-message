<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\User;
use App\Services\Contracts\MessageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected MessageServiceInterface $messageService;
    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index()
    {
        $messages = $this->messageService->getUserMessages(Auth::id());
        return view('message.index', compact('messages'));
    }

    public function create()
    {
        return view('message.create', [
            'users' => User::get()
        ]);
    }

    public function store(MessageRequest $request): \Illuminate\Http\RedirectResponse
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
