{{-- Livewire Chat Component --}}
<div>
    <div class="bg-white py-3">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __($user->name ?? null) }}
                </h2>

                Search Input
                <div class="relative w-1/3">
                    <input type="text" wire:model.live="search" placeholder="Search Messages..."
                        class="pl-10 pr-16 py-2 border rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-400">

                    {{-- Search Icon (Left) --}}
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>

                    {{-- Clear Button --}}
                    @if (!empty($search))
                        <button type="button" wire:click="resetSearch"
                            class="absolute right-20 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="red" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>

                        <!-- Navigation Icons (Right) -->
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex space-x-2">

                            {{-- Arrow up --}}
                            <button type="button" wire:click="prevMatch" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                </svg>
                            </button>

                            {{-- Arrow down --}}
                            <button type="button" wire:click="nextMatch" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
        </div>
    </div>
</div>

{{-- @script
    <script type="module">
        let typingTimeout;
        const chatContainer = document.getElementById('chat-container');

        window.Echo.private(`chat-channel.{{ $senderId }}`)
            .listen('UserTyping', (event) => {
                const messageInputField = document.getElementById('message-input');
                if (messageInputField) {
                    messageInputField.placeholder = 'Typing...';
                }

                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    if (messageInputField) {
                        messageInputField.placeholder = 'Type here...';
                    }
                }, 2000);
            })

            .listen('MessageSentEvent', (event) => {
                const isInputFocused = document.activeElement === messageInputField;
                const isScrolledToBottom = chatContainer.scrollTop + chatContainer.clientHeight >= chatContainer
                    .scrollHeight - 10;

                if (!isInputFocused || !isScrolledToBottom) {
                    const audio = new Audio('{{ asset('sounds/notification.mp3') }}');
                    audio.play();
                }
            });

        // Listen for Livewire events
        Livewire.on('messages-updated', () => {
            setTimeout(() => {
                scrollToBottom();
            }, 50);
        });

        // Scroll to Message
        Livewire.on('scroll-to-message', (event) => {
            const messageElement = document.getElementById(`message-${event.index}`);
            if (messageElement) {
                messageElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });

        // Scroll on initial load
        window.onload = () => {
            scrollToBottom();
        };

        function scrollToBottom() {
            if (chatContainer) {
                chatContainer.scrollTo(0, chatContainer.scrollHeight);
            }
        }
    </script>
@endscript --}}