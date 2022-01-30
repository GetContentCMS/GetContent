<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleBold().run()"
                     x-model="isActive('bold', {}, touched)">
    <x-slot name="icon"><x-ri-bold/></x-slot>
</x-gc::toggle-button>
