<div class="w-full">
    <x-gc::date
        wire:model="{{$model ?? null ?: $field->getModelPath('value')}}"
        label="{{$field->label}}"
        :help="$field->instructions"
    />
</div>
