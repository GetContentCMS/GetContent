<x-gc::toggle-button flat @click="theEditor().chain().focus().setTextAlign('center').run()"
                     x-model="isActive({textAlign: 'center'}, {}, touched)">
    <x-slot name="icon">
        <x-ri-align-center/>
    </x-slot>
</x-gc::toggle-button>
