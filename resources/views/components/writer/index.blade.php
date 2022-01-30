@props([
    'id' => Str::uuid(),
    'model' => null,
    'toolbar' => 'h1 h2 h3 | bold italic strikethrough highlight | bulletlist orderedlist blockquote | alignLeft alignCenter alignRight | horizontalRule'
])
@php
    $toolbarItems = collect(explode(' ', $toolbar))->transform(fn($item) => str_replace('|', 'divider', $item));
@endphp
<x-gc::input-surround :attributes="$attributes" :id="$id" wire:ignore>
    <div x-data="writer({{$model}}, '{{$id}}')"
         x-cloak
         wire:ignore
         id="writer-{{$id}}"
         class="w-full bg-white rounded border shadow-sm dark:bg-gray-700 dark:border-gray-600 focus-outline"
         tabindex="-1"
    >
        <template x-if="editor">
            <div
                class="flex overflow-x-auto sticky -top-px z-10 p-1 space-x-px w-full bg-white bg-opacity-75 rounded filter backdrop-blur dark:bg-gray-700"
                @click.self="theEditor().chain().focus()"
                x-ref="toolbar">
                @foreach($toolbarItems as $item)
                    <x-dynamic-component :component="'gc::writer.toolbar.'.$item"/>
                @endforeach
            </div>
        </template>

        <div x-ref="tiptap" class="px-3 py-2"
             @click.self="theEditor().chain().focus()"></div>

        <x-gc::card tight class="px-2 bg-opacity-75 shadow-xl backdrop-blur" x-ref="bubbleMenu">
            <template x-if="typeof editor !== 'undefined'">
                <div class="flex">
                    <div class="flex items-center space-x-1">
                        <x-gc::writer.toolbar.bold/>
                        <x-gc::writer.toolbar.italic/>
                        <x-gc::writer.toolbar.strikethrough/>
                        <x-gc::writer.toolbar.highlight/>

                        <x-gc::writer.toolbar.divider/>

                        <x-gc::writer.toolbar.link/>
                    </div>
                </div>
            </template>
        </x-gc::card>

        <x-gc::modal :id="'linkEditor-'.$id" class="max-w-sm" auto-focus="linkHrefInput" wire:ignore>
            <x-slot name="title">Link</x-slot>
            <x-slot name="icon">
                <x-ri-link />
            </x-slot>
            <div class="space-y-2">
                <x-gc::input placeholder="https://example.com"
                             trailing-icon="ri-link" x-ref="linkHrefInput" x-model="linkHref"
                             @focus="$el.select()"
                />
                <x-gc::switch label="Open in a new tab" x-model="linkTarget" true-value="_blank" false-value="_self" />
            </div>
            <footer class="flex justify-between mt-2">
                <x-gc::button flat @click="removeLink">
                    <x-slot name="icon"><x-ri-delete-bin-line /></x-slot>
                    Remove Link
                </x-gc::button>
                <x-gc::button primary @click="setLink">Set Link</x-gc::button>
            </footer>
        </x-gc::modal>
    </div>
</x-gc::input-surround>


@push('styles')
    <style>
        .ProseMirror p.is-editor-empty:first-child::before {
            content: attr(data-placeholder);
            float: left;
            color: #a8aeb9;
            pointer-events: none;
            height: 0;
        }
    </style>
@endpush
