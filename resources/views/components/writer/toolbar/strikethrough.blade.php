<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleStrike().run()"
                     x-model="isActive('strike', {}, touched)">
    <x-slot name="icon">
        <x-ri-strikethrough/>
    </x-slot>
</x-gc::toggle-button>
