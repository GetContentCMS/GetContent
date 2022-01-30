<x-gc::button flat @click="theEditor().chain().focus().setTextAlign('left').run()"
              x-model="isActive({textAlign: 'left'}, {}, touched)">
    <x-slot name="icon">
        <x-ri-align-left/>
    </x-slot>
</x-gc::button>
