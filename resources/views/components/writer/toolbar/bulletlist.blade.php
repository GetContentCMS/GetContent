<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleBulletList().run()"
                     x-model="isActive('bulletList', {}, touched)">
    <x-slot name="icon">
        <x-ri-list-unordered/>
    </x-slot>
</x-gc::toggle-button>
