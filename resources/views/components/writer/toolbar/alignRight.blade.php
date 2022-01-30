<x-gc::toggle-button flat @click="theEditor().chain().focus().setTextAlign('right').run()"
                     x-model="isActive({textAlign: 'right'}, {}, touched)">
    <x-slot name="icon">
        <x-ri-align-right/>
    </x-slot>
</x-gc::toggle-button>
