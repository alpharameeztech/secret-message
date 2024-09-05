<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Secret Message</h1>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <!-- Display error message if any -->
                    @if(isset($error))
                        <p class="text-red-500 mb-4">{{ $error }}</p>
                    @endif

                    <!-- Display the decrypted message -->
                    @if(isset($decryptedMessage))
                        <p class="text-gray-700 mb-4">{{ $decryptedMessage }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
