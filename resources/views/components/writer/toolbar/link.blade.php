<x-gc::toggle-button flat @click="openLinkEditor"
              x-model="isActive('link', {}, touched)">
    <x-slot name="icon">
        <x-ri-link/>
    </x-slot>
</x-gc::toggle-button>
