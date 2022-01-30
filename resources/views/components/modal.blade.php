@props([
    'id',
    'slideOver' => false,
    'autoFocus' => 'dialog'
    ])

<div
    @class([
       'overflow-y-auto fixed inset-0 z-50' => !$slideOver,
       'fixed inset-0 overflow-hidden' => $slideOver,
   ])
    x-data="thisModal($refs, '{{$id}}', '{{$autoFocus}}')" x-cloak
    x-show="$store.modals['{{$id}}']"
    @keydown.escape="close"
    aria-hidden="true"
    {{$attributes}}
>
    <div @class([
        'flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0' => !$slideOver,
        'absolute inset-0 overflow-hidden' => $slideOver,
    ])>
        {{-- The background overlay --}}
        <div class="fixed inset-0 backdrop-filter backdrop-blur-sm transition-opacity" aria-hidden="true"
             x-show="$store.modals['{{$id}}']"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
        </div>

        @unless($slideOver)
            {{-- This element is to trick the browser into centering the modal contents. --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        @endif

        @if($slideOver)
            <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full">
                <div class="w-screen max-w-2xl">
                    @endif
                    <div
                        {{ $attributes->class([
                            'inline-block w-full max-w-3xl text-left shadow-xl transition transform',
                            'inline-block overflow-hidden align-bottom rounded-lg sm:my-8 sm:align-middle' => !$slideOver,
                            'h-full overflow-y-auto' => $slideOver,

                            'ring-blue-500 ring-opacity-25 outline-none focus:ring focus:border-blue-500',
                            'border bg-gray-50 text-gray-900',

                            'dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100',
                            'dark:ring-opacity-50 dark:focus:border-blue-500'
                            ]) }}
                        tabindex="-1"
                        x-ref="dialog"
                        role="dialog" aria-modal="true" aria-labelledby="modal-title"
                        x-show="$store.modals['{{$id}}']"
                        x-trap.noscroll.inert="$store.modals['{{$id}}']"
                        id="{{$id}}"
                        @unless($slideOver)
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        @else
                        x-transition:enter="ease-in-out duration-300 sm:duration-400"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="ease-in-out duration-300 sm:duration-500"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        @endunless
                    >
                        <div class="flex flex-col justify-between items-start h-full">
                            <header class="flex justify-between items-center px-4 py-5 w-full">
                                @if(!empty($title) || !empty($icon))
                                    <h3 id="modal-title"
                                        class="flex items-center space-x-2 text-lg font-medium text-gray-500">
                                        @if(!empty($icon))
                                            <div
                                                class="flex flex-shrink-0 justify-center items-center p-2 w-10 h-10 text-gray-500 bg-gray-200 rounded-full dark:text-gray-400 dark:bg-gray-800">
                                                {{$icon}}
                                            </div>
                                        @endif
                                        @if(!empty($title))
                                            <span class="truncate">{{$title}}</span>
                                        @endif
                                    </h3>
                                @endif

                                <x-gc::button flat @click="close" class="hidden sm:block">
                                    <x-slot name="icon">
                                        <x-heroicon-s-x/>
                                        <span class="sr-only">Close</span>
                                    </x-slot>
                                </x-gc::button>
                            </header>

                            <div class="overflow-y-auto flex-1 p-4 w-full">
                                {{ $slot }}
                            </div>

                            <x-gc::button @click="close" class="mt-3 sm:hidden">
                                Close
                            </x-gc::button>
                        </div>
                    </div>
                    @if($slideOver)
                </div>
            </div>
        @endif
    </div>
</div>

@once
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.store('modals', {})

                Alpine.data('thisModal', ($refs, id, autoFocus) => ({
                    init() {
                        this.$store.modals[id] = false
                        this.$watch('$store.modals["' + id + '"]', value => {
                            if (value === true) {
                                if (autoFocus && $refs[autoFocus]) {
                                    this.$focus.focus($refs[autoFocus])
                                }
                            }
                        });
                    },
                    close() {
                        this.$dispatch('close')
                        this.$store.modals[id] = false
                    }
                }))
            })
        </script>
    @endpush
@endonce
