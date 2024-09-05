<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Unread Messages
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Your Unread Messages</h3>

                    <table class="min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Link
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sender
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('message.read', ['identifier' => $message->identifier]) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Message
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($message->sender)
                                        {{ $message->sender->name }}
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-red-500">Not Opened</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $messages->links() }}

                    @if($messages->isEmpty())
                        <p class="text-gray-500 mt-4">No unread messages.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
