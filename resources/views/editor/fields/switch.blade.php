<div class="w-full">
    <x-gc::switch
        wire:model.lazy="{{$model ?? null ?: $field->getModelPath('value')}}"
        label="{{$field->label}}"
        :help="$field->instructions"
    />
</div>
