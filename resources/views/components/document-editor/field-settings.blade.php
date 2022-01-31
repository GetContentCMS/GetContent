<div class="px-6">
    <x-slot name="title">
        {{Str::title($this->configureField->label)}} Settings
    </x-slot>

    <div class="space-y-3">
        <x-gc::input id="labelField" label="Label" help="Give the field a specific label" wire:model="configureFieldSchema.label" class="w-full"/>
        <x-gc::textarea id="instructionsField" label="Instructions" help="Give some instructions for using this field" wire:model="configureFieldSchema.instructions" />

        <x-gc::input id="cssClasses" label="CSS Classes" help="CSS classes available when rendering the field" wire:model="configureFieldModel.options.cssClasses" />

        {{$this->configureField->editorSettingsView}}

        <x-gc::accordion>
            <x-gc::accordion.panel>
                <x-slot name="button" class="flex items-center space-x-2 text-yellow-500 cursor-pointer">
                    <x-heroicon-s-exclamation class="w-6"/>
                    <div>Advanced</div>
                    <x-gc::menu.divider />
                </x-slot>

                <x-gc::input id="modelKeyField" label="Model Key"
                             help="Changing the Model Key may have unintended effects on where your document is used."
                             wire:model="configureFieldSchema.modelKey" class="w-full"/>

            </x-gc::accordion.panel>
        </x-gc::accordion>
    </div>

    <footer class="flex justify-end mt-3 space-x-2">
        <x-gc::button flat @click="close">Cancel</x-gc::button>
        <x-gc::button primary wire:click="applyFieldSettings" @click="close">Apply</x-gc::button>
    </footer>
</div>
