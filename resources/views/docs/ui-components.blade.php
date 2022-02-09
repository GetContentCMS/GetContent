@extends('gc::layouts.docs')

@section('content')

    <div class="grid grid-cols-3 gap-6 p-6 mx-auto max-w-6xl">
        <a href="{{route('docs.components', ['section' => 'text-inputs'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div
                    class="flex overflow-hidden absolute inset-0 justify-center items-center w-full h-full rounded-t-lg pointer-events-none">
                    <x-gc::input/>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Text Inputs
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'buttons'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div
                    class="flex overflow-hidden absolute inset-0 justify-center items-center w-full h-full rounded-t-lg pointer-events-none">
                    <x-gc::button/>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Buttons
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'reveals'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div
                    class="flex overflow-hidden absolute inset-0 justify-center items-center w-full h-full rounded-t-lg pointer-events-none">
                    <x-gc::tab.group>
                        <x-gc::tab.list>
                            <x-gc::tab for="notab" label="Tabs" active/>
                            <x-gc::tab for="notab2" label="Tabs"/>
                        </x-gc::tab.list>
                    </x-gc::tab.group>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Reveals
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'popovers'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div
                    class="flex overflow-hidden absolute inset-0 justify-center items-center w-full h-full rounded-t-lg pointer-events-none">
                    <x-gc::popover open>
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
                </div>
                <div class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-gray-100"></div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Popovers
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'modals'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-800">
                <div
                    class="flex overflow-hidden absolute inset-0 justify-center items-center w-full h-full rounded-t-lg pointer-events-none">
                    <div class="relative p-6 w-5/6 h-5/6 bg-gray-100 rounded-md">
                        <x-heroicon-s-x class="absolute top-2 right-2 w-4 text-gray-500" />
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Modals
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'other-inputs'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div class="flex absolute inset-0 justify-center items-center">
                    <x-heroicon-o-dots-horizontal class="w-8"/>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Other Inputs
                </p>
            </div>
        </a>
        <a href="{{route('docs.components', ['section' => 'layouts'])}}"
           class="overflow-hidden text-gray-800 rounded-md border shadow">
            <div class="relative pt-[50%] bg-gray-100">
                <div class="flex absolute inset-0 justify-center items-center">
                    <x-gc::card>
                        <x-gc::section-heading>
                            Cards & Headings
                            <x-slot name="description">
                                And anything else
                            </x-slot>
                        </x-gc::section-heading>
                    </x-gc::card>
                </div>
            </div>
            <div class="px-4 py-3 bg-white">
                <p class="mb-1 text-sm font-medium text-gray-900">
                    Layout Components
                </p>
            </div>
        </a>
    </div>

@endsection
