<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleHighlight().run()"
                     x-model="isActive('highlight', {}, touched)">
    <x-slot name="icon">
        <x-ri-mark-pen-fill/>
    </x-slot>
</x-gc::toggle-button>
