@extends('gc::layouts.docs')

@section('title', 'Text Inputs')

@section('content')

    <x-gc::component-preview name="input"/>

    <x-gc::component-preview name="input" label="Input with placeholder">
        <x-slot name="code">
            @php
                echo e('<x-gc::input placeholder="Enter something here"/>')
            @endphp
        </x-slot>
        <x-gc::input placeholder="Enter something here"/>
        <x-slot name="disabled">
            <x-gc::input placeholder="Enter something here" disabled/>
        </x-slot>
    </x-gc::component-preview>

    <x-gc::component-preview name="input" label="Input with label & help" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::input label="Email address" help="We will only use this for spam" type="email" />')
            @endphp
        </x-slot>

        <x-gc::input label="Email address" help="We will only use this for spam" type="email" name="email"/>
    </x-gc::component-preview>

    <x-gc::component-preview name="input" label="Input with leading icon" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::input label="Email address" type="email" leading-icon="heroicon-o-mail" />')
            @endphp
        </x-slot>

        <x-gc::input label="Email address" type="email" leading-icon="heroicon-o-mail"/>
    </x-gc::component-preview>

    <x-gc::component-preview name="input" label="Input with trailing icon" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::input label="Username" trailing-icon="heroicon-o-user" />')
            @endphp
        </x-slot>

        <x-gc::input label="Username" trailing-icon="heroicon-o-user"/>
    </x-gc::component-preview>

    <x-gc::component-preview name="input" label="Input validation error" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::input label="Password" error="Your password must be less than 4 characters" />')
            @endphp
        </x-slot>

        <x-gc::input label="Password" placeholder="New Password" error="Your password must be less than 4 characters"/>
    </x-gc::component-preview>

    <x-gc::component-preview name="textarea"/>

    <x-gc::component-preview name="date" label="Date Picker"/>

    <x-gc::component-preview name="writer" label="Writer" no-disabled>
        <x-gc::writer model="null"/>
        <x-slot name="dark">
            <x-gc::writer model="null"/>
        </x-slot>
    </x-gc::component-preview>

@endsection
