<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleHeading({ level: 3 }).run()"
                     x-model="isActive('heading', { level: 3 }, touched)">
    <x-slot name="icon"><x-ri-h-3/></x-slot>
</x-gc::toggle-button>
