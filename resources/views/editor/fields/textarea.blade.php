<div class="w-full">
    <x-gc::textarea
        wire:model.lazy="{{$model ?? null ?: $field->getModelPath('value')}}"
        :id="'textarea-'.$field->modelKey"
        label="{{$field->label}}"
        :help="$field->instructions"
    />
</div>
