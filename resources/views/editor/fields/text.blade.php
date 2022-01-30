<div class="w-full">
    <x-gc::input
        wire:model.lazy="{{$model ?? null ?: $field->getModelPath('value')}}"
        label="{{$field->label}}"
        :help="$field->instructions"
    />
</div>
