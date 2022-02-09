@extends('gc::layouts.docs')

@section('title', 'Layout Elements')

@section('content')

    <x-gc::component-preview name="card" noDisabled>
        <x-gc::card>
            <x-slot name="header">This is the card component</x-slot>
            Hello World
            <x-slot name="footer" class="flex justify-end">
                <x-gc::button primary>
                    This is shiney
                </x-gc::button>
            </x-slot>
        </x-gc::card>
    </x-gc::component-preview>

    <x-gc::component-preview name="section-heading" noDisabled>
        <x-gc::section-heading>
            Section Heading
            <x-slot name="description">
                Section description
            </x-slot>
        </x-gc::section-heading>
    </x-gc::component-preview>

@endsection
