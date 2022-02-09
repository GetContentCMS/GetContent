@extends('gc::layouts.docs')

@section('title', 'Popovers')

@section('content')
    <x-gc::component-preview name="popover" no-disabled>
        <x-gc::popover open/>
    </x-gc::component-preview>

    <x-gc::component-preview name="menu.item" label="Menu Item" no-disabled>
        <x-slot name="code">
            @php echo e('<x-gc::menu.item>Menu Item</x-gc::menu.item>

<x-gc::menu.item disabled>Disabled Item</x-gc::menu.item>

<x-gc::menu.divider/>

<x-gc::menu.item>
    <x-slot name="icon">
        <x-heroicon-o-clipboard-copy/>
    </x-slot>
    Item with icon
</x-gc::menu.item>

<x-gc::menu.item selected>
    <x-slot name="icon">
        <x-heroicon-o-arrow-up/>
    </x-slot>
    Selected Item
</x-gc::menu.item>')
            @endphp
        </x-slot>
        <x-gc::menu.item>Menu Item</x-gc::menu.item>
        <x-gc::menu.item disabled>Disabled Item</x-gc::menu.item>
        <x-gc::menu.divider/>
        <x-gc::menu.item>
            <x-slot name="icon">
                <x-heroicon-o-clipboard-copy/>
            </x-slot>
            Item with icon
        </x-gc::menu.item>
        <x-gc::menu.item selected>
            <x-slot name="icon">
                <x-heroicon-o-arrow-up/>
            </x-slot>
            Selected Item
        </x-gc::menu.item>
    </x-gc::component-preview>

    <x-gc::component-preview name="popover" label="Menu">

        <x-slot name="code">
            @php echo e('<x-gc::popover>
    <x-slot name="trigger">
        <x-gc::button flat>
            <x-slot name="icon">
                <x-heroicon-o-dots-horizontal/>
            </x-slot>
        </x-gc::button>
    </x-slot>
    <x-gc::menu.item>Menu Item</x-gc::menu.item>
</x-gc::popover>')
            @endphp
        </x-slot>

        <x-gc::popover>
            <x-slot name="trigger">
                <x-gc::button flat>
                    <x-slot name="icon">
                        <x-heroicon-o-dots-horizontal/>
                    </x-slot>
                </x-gc::button>
            </x-slot>
            <x-gc::menu.item>Menu Item</x-gc::menu.item>
            <x-gc::menu.item disabled>Disabled Item</x-gc::menu.item>
            <x-gc::menu.divider/>
            <x-gc::menu.item>
                <x-slot name="icon">
                    <x-heroicon-o-clipboard-copy/>
                </x-slot>
                Item with icon
            </x-gc::menu.item>
            <x-gc::menu.item selected>
                <x-slot name="icon">
                    <x-heroicon-o-arrow-up/>
                </x-slot>
                Selected Item
            </x-gc::menu.item>
        </x-gc::popover>

        <x-slot name="disabled">
            <x-gc::popover disabled>
                <x-slot name="trigger">
                    <x-gc::button flat disabled>
                        <x-slot name="icon">
                            <x-heroicon-o-dots-horizontal/>
                        </x-slot>
                    </x-gc::button>
                </x-slot>
                <x-gc::menu.item>Menu Item</x-gc::menu.item>
                <x-gc::menu.item disabled>Disabled Item</x-gc::menu.item>
                <x-gc::menu.divider/>
                <x-gc::menu.item>
                    <x-slot name="icon">
                        <x-heroicon-o-clipboard-copy/>
                    </x-slot>
                    Item with icon
                </x-gc::menu.item>
                <x-gc::menu.item selected>
                    <x-slot name="icon">
                        <x-heroicon-o-arrow-up/>
                    </x-slot>
                    Selected Item
                </x-gc::menu.item>
            </x-gc::popover>
        </x-slot>
    </x-gc::component-preview>
@endsection
