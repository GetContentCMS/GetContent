@extends('gc::layouts.docs')

@section('title', 'Reveals')

@section('content')

    <x-gc::component-preview name="accordion">
        <x-slot name="code">
            @php
                echo e('<x-gc::accordion>
<x-gc::accordion.panel label="This is a panel" open>
    Some content in this panel
</x-gc::accordion.panel>
<x-gc::accordion.panel label="This is a panel">
    Only showing one panel at a time
</x-gc::accordion.panel>
</x-gc::accordion')
            @endphp
        </x-slot>
        <x-gc::accordion>
            <x-gc::accordion.panel label="This is a panel" open>
                Some content in this panel
            </x-gc::accordion.panel>
            <x-gc::accordion.panel label="Another panel here">
                Only showing one panel at a time
            </x-gc::accordion.panel>
        </x-gc::accordion>
    </x-gc::component-preview>

    <x-gc::component-preview name="accordion" label="Accordion with multiple open panels">
        <x-slot name="code">
            @php
                echo e('<x-gc::accordion allow-multiple>
<x-gc::accordion.panel label="This is a panel">
    Some content in this panel
</x-gc::accordion.panel>
</x-gc::accordion')
            @endphp
        </x-slot>
        <x-gc::accordion allow-multiple>
            <x-gc::accordion.panel label="This is a panel">
                Some content in this panel
            </x-gc::accordion.panel>
            <x-gc::accordion.panel label="Another panel here">
                All panels can be open at once
            </x-gc::accordion.panel>
        </x-gc::accordion>
    </x-gc::component-preview>

    <x-gc::component-preview name="tab.group" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::tab.group>
    <x-gc::tab.list>
        <x-gc::tab for="first" label="Tab #1"/>
        <x-gc::tab for="second" label="Tab #2"/>
        <x-gc::tab for="third">
            <button class="px-2 px-3 font-semibold text-blue-200 bg-blue-500 rounded-full" :class="{\'bg-blue-900\': selected()}" @click="select">
                Custom
            </button>
        </x-gc::tab>
        <x-gc::tab for="fourth" label="Disabled" disabled />
    </x-gc::tab.list>

    <x-gc::tab.panel id="first" active>
        This is the First Panel.
    </x-gc::tab.panel>
    <x-gc::tab.panel id="second">
        Second Panel here
    </x-gc::tab.panel>
    <x-gc::tab.panel id="third">
        Lovely tab style!
    </x-gc::tab.panel>
</x-gc::tab.group>');
            @endphp
        </x-slot>
        <x-gc::tab.group>
            <x-gc::tab.list>
                <x-gc::tab for="first" label="Tab #1"/>
                <x-gc::tab for="second" label="Tab #2"/>
                <x-gc::tab for="third">
                    <button class="px-2 px-3 font-semibold text-blue-200 bg-blue-500 rounded-full"
                            :class="{'bg-blue-900': selected()}" @click="select">
                        Custom
                    </button>
                </x-gc::tab>
                <x-gc::tab for="fourth" label="Disabled" disabled/>
            </x-gc::tab.list>

            <x-gc::tab.panel id="first" active>
                This is the First Panel.
            </x-gc::tab.panel>
            <x-gc::tab.panel id="second">
                Second Panel here
            </x-gc::tab.panel>
            <x-gc::tab.panel id="third">
                Lovely tab style!
            </x-gc::tab.panel>
        </x-gc::tab.group>
    </x-gc::component-preview>

@endsection
