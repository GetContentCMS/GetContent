@props([
    'open' => false,
    'disabled' => false,
    'placement' => 'bottom-end',
    'boundary' => null
])
<div {{$attributes->merge(['class' => 'inline-block relative'])}}
     x-data="popover('{{$placement}}', @if($boundary)'{{$boundary}}'@else null @endif)"
     x-init="open = {{$open ? 'true' : 'false'}}"
     @click.away="open = {{$open ? 'true' : 'false'}}"
     @keydown.down="$focus.wrap().next()"
     @keydown.up="$focus.wrap().previous()"
>
    @isset($trigger)
        <div x-ref="trigger" @class(['pointer-events-none' => $disabled]) @click="toggle">{{$trigger}}</div>
    @endisset

    <div class="z-40"
         x-ref="popover"
         wire:ignore.self
    >
        <div x-cloak x-show="open"
             @class([
                'overflow-hidden w-56 origin-top-right',
                'rounded-md border shadow-lg backdrop-filter backdrop-blur-xl ',
                'bg-white bg-opacity-75 border-gray-200',

                'dark:bg-black dark:border-white dark:border-opacity-20 dark:bg-opacity-75',
             ])
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95">

            @if($slot->isEmpty())
                <x-gc::menu.item disabled>Empty menu</x-gc::menu.item>
            @else
                {{$slot}}
            @endif
        </div>
    </div>

</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('popover', (placement, boundary) => ({
                    open: false,
                    popper: null,

                    init() {
                        if (!this.$refs.trigger) {
                            return false;
                        }

                        this.popper = createPopper(this.$refs.trigger, this.$refs.popover, {
                            placement: placement,
                            modifiers: [
                                {
                                    name: 'flip',
                                    enabled: true,
                                    options: {
                                        boundary: document.querySelector(boundary ?? 'body'),
                                    }
                                },
                                {
                                    name: 'offset',
                                    options: {
                                        offset: [0, 5],
                                    },
                                },
                            ],
                        });
                    },

                    toggle() {
                        this.open = !this.open
                    }
                }))
            })
        </script>
    @endpush
@endonce
