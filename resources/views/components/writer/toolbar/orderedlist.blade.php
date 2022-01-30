<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleOrderedList().run()"
                     x-model="isActive('orderedList', {}, touched)">
    <x-slot name="icon">
        <x-ri-list-ordered/>
    </x-slot>
</x-gc::toggle-button>
