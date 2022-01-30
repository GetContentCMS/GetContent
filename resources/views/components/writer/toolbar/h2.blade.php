<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleHeading({ level: 2 }).run()"
                     x-model="isActive('heading', { level: 2 }, touched)">
    <x-slot name="icon"><x-ri-h-2/></x-slot>
</x-gc::toggle-button>
