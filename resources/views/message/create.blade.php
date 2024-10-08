<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Secret Message
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Prepare an encrypted message") }}
                </div>

                <!-- Success Message with Copy Link Functionality -->
                <div class="space-y-6 px-8">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            @php
                                // Extract the URL from the success message
                                $message = session('success');
                                preg_match('/href="([^"]+)"/', $message, $matches);
                                $url = $matches[1] ?? null;
                            @endphp

                            @if ($url)
                                <div class="mt-4">
                                    <input type="text" value="{{ $url }}" id="copyLink" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                                    <button onclick="copyToClipboard()" id="copyButton" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                        Copy Link
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Form Start -->
                <form action="{{ route('message.store') }}" method="POST" class="space-y-6 px-8">
                    @csrf

                    <!-- Message Textarea -->
                    <div>
                        <label for="text" class="block text-sm font-medium text-gray-700">
                            Enter your message
                        </label>
                        <textarea name="text" id="text" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your message" required></textarea>
                        @error('text')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recipient Dropdown -->
                    <div>
                        <label for="recipient_id" class="block text-sm font-medium text-gray-700">
                            Select Recipient
                        </label>
                        <select name="recipient_id" id="recipient_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('recipient_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry Time Input -->
                    <div>
                        <label for="expires_in" class="block text-sm font-medium text-gray-700">
                            Expiry time (in minutes)
                        </label>
                        <input type="number" name="expires_in" id="expires_in" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Expiry time in minutes">
                        @error('expires_in')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="py-8 flex justify-center">
                        <button type="submit" class="w-1/2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create a secret link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById('copyLink');
        var copyButton = document.getElementById('copyButton');
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value).then(function() {
            copyButton.textContent = 'Copied'; // Change button text on success
            setTimeout(function() {
                copyButton.textContent = 'Copy Link'; // Reset button text after 2 seconds
            }, 2000);
        });
    }
</script>
