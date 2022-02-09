@extends('gc::layouts.docs')

@section('title', 'Buttons')

@section('content')

    <x-gc::component-preview name="button"/>

    <x-gc::component-preview name="button" label="Button with icon">
        <x-slot name="code">
            @php echo e('<x-gc::button>
    <x-slot name="icon"><x-heroicon-o-zoom-in/></x-slot>
    Icon Button
</x-gc::button>')
            @endphp
        </x-slot>
        <x-gc::button>
            <x-slot name="icon">
                <x-heroicon-o-zoom-in/>
            </x-slot>
            Icon Button
        </x-gc::button>
        <x-slot name="disabled">
            <x-gc::button disabled>
                <x-slot name="icon">
                    <x-heroicon-o-zoom-in/>
                </x-slot>
                Icon Button
            </x-gc::button>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="button" label="Primary Button">
        <x-slot name="code">
            @php echo e('<x-gc::button primary>
    Do the main thing
</x-gc::button>')
            @endphp
        </x-slot>
        <x-gc::button primary>
            Do the main thing
        </x-gc::button>
        <x-slot name="disabled">
            <x-gc::button primary disabled>
                Do the main thing
            </x-gc::button>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="button" label="Flat Button">
        <x-slot name="code">
            @php
                echo e('<x-gc::button flat>Flat Button</x-gc::button>')
            @endphp
        </x-slot>
        <x-gc::button flat>Flat Button</x-gc::button>
        <x-slot name="disabled">
            <x-gc::button flat disabled>Flat Button</x-gc::button>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="button" label="Flat Button icon only">
        <x-slot name="code">
            @php
                echo e('<x-gc::button flat>
    <x-slot name="icon"><x-heroicon-o-dots-horizontal/></x-slot>
</x-gc::button>')
            @endphp
        </x-slot>
        <x-gc::button flat>
            <x-slot name="icon">
                <x-heroicon-o-dots-horizontal/>
            </x-slot>
        </x-gc::button>
        <x-slot name="disabled">
            <x-gc::button flat disabled>
                <x-slot name="icon">
                    <x-heroicon-o-dots-horizontal/>
                </x-slot>
            </x-gc::button>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="toggle-button" x-data="{toggleButton: false}">
        <x-slot name="code">
            @php
                echo e('<div x-data="{toggleButton: false}">
    <x-gc::toggle-button x-model="toggleButton">Toggle Button</x-gc.toggle-button>
</div>')
            @endphp
        </x-slot>
        <x-gc::toggle-button x-model="toggleButton">Toggle Button</x-gc::toggle-button>
        <x-slot name="disabled">
            <x-gc::toggle-button x-model="toggleButton" disabled>Toggle Button</x-gc::toggle-button>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="toggle-button" label="Flat Toggle Button" x-data="{toggleButton: false}">
        <x-slot name="code">
            @php
                echo e('<div x-data="{toggleButton: false}">
    <x-gc::toggle-button flat x-model="toggleButton">Toggle Button</x-gc.toggle-button>
</div>')
            @endphp
        </x-slot>
        <x-gc::toggle-button flat x-model="toggleButton">Toggle Button</x-gc::toggle-button>
        <x-slot name="disabled">
            <x-gc::toggle-button flat x-model="toggleButton" disabled>Toggle Button</x-gc::toggle-button>
        </x-slot>
    </x-gc::component-preview>

@endsection
