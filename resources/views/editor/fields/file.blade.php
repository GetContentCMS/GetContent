<div x-data>
    @if($field->givenLabel)
        <label
               class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">{{$field->givenLabel}}</label>
    @endif

    @if($file = $field->asFile())
        <x-gc::file-card :file="$file">
            <x-slot name="controls">
                <x-gc::button flat title="Remove file"
                              wire:click="clearField('{{$model ?? null ?: $field->getModelPath()}}')">
                    <x-slot name="icon">
                        <x-heroicon-o-x/>
                    </x-slot>
                </x-gc::button>
            </x-slot>
        </x-gc::file-card>
    @else
        <div class="grid gap-3 p-3 w-max rounded border-2 border-dashed">
            <x-gc::button @click="$store.modals['fileBrowserModal-{{$field->getModelPath()}}'] = true">
                <x-slot name="icon"><x-ri-folder-open-line/></x-slot>
                Browse Files
            </x-gc::button>

            <div
                wire:ignore.self
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true; progress = 0"
                x-on:livewire-upload-finish="isUploading = false; @this.saveNewFile('{{$model ?? null ?: $field->getModelPath('value')}}', $refs.fileInput.files[0].name)"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                x-on:livewire-upload-error="isUploading = false"
            >

                <div x-show="isUploading">
                    Uploading...
                    <div class="overflow-hidden h-1 bg-gray-100 rounded-md border border-gray-300 shadow-inner">
                        <div class="h-1 bg-green-400 transition duration-75" :style="{width: progress+'%'}"></div>
                    </div>
                </div>
                <x-gc::upload wire:model="newFile" x-show="!isUploading" :accept="$field->accept"/>
            </div>
        </div>
    @endif

    <div class="dark" @choose="
        $wire.set('{{$model ?? null ?: $field->getModelPath('value')}}', $event.detail);
        $store.modals['fileBrowserModal-{{$field->getModelPath()}}'] = false;
    ">
        <x-gc::modal id="fileBrowserModal-{{$field->getModelPath()}}">
            <x-slot name="icon"><x-ri-folder-open-line/></x-slot>
            <x-slot name="title">
                Browse Files
            </x-slot>
            <livewire:file-browser
                wire:key="fileBrowser-{{$field->getModelPath()}}"
                :accept="$field->accept"
            />
        </x-gc::modal>
    </div>
</div>
