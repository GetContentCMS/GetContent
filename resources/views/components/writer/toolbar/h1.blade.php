<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleHeading({ level: 1 }).run()"
                     x-model="isActive('heading', { level: 1 }, touched)">
    <x-slot name="icon"><x-ri-h-1/></x-slot>
</x-gc::toggle-button>
