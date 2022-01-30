<div>

    <div class="grid grid-cols-12 w-full min-h-screen" x-data="documentEditor">

        <main class="col-span-9 p-3">
            <div class="dark">
                <x-gc::input wire:model="document.name" class="mx-auto w-full max-w-5xl text-2xl"/>
            </div>

            <div class="p-6 mx-auto mt-6 w-full max-w-lg cursor-move select-none" wire:sortable="updateFieldOrder" x-show="sortFields" x-cloak>
                <x-gc::document-editor.field-sort :document="$document" />
            </div>

            <div class="p-6 mx-auto mt-6 space-y-6 max-w-5xl bg-gray-50 rounded-md" x-show="!sortFields" x-cloak>
                <x-gc::document-editor.field-list :document="$document" />
            </div>
        </main>

        <aside class="col-span-3 bg-gray-900 border-l border-gray-700 dark">
            <div class="sticky top-0">
                <x-gc::document-editor.sidebar :document="$document" />
            </div>
        </aside>

    </div>

    <div class="dark">
        <x-gc::modal id="fieldSettings" x-on:close.window="$wire.$set('configureFieldModelKey', null)" class="max-w-lg">
            <x-slot name="icon"><x-heroicon-o-cog/></x-slot>

            @if($configureFieldModelKey)
                <x-gc::document-editor.field-settings  />
            @endif
        </x-gc::modal>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('documentEditor', () => ({
                sortFields: false
            }))
        })
    </script>
@endpush
