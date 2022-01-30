<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleItalic().run()"
                     x-model="isActive('italic', {}, touched)">
    <x-slot name="icon">
        <x-ri-italic/>
    </x-slot>
</x-gc::toggle-button>
