<x-gc::toggle-button flat @click="theEditor().chain().focus().toggleBlockquote().run()"
                     x-model="isActive('blockquote', {}, touched)">
    <x-slot name="icon">
        <x-ri-double-quotes-l/>
    </x-slot>
</x-gc::toggle-button>
