<div class="w-full">
    <div class="inline-block px-2 py-1 mb-1 text-xs text-yellow-700 bg-yellow-300 rounded">
        Unknown Field Type "{{$field->type}}"
    </div>

    @if(is_array($field->model))
        @foreach($field->model as $key => $value)
            <div class="flex">
                <label for="{{$field->modelKey}}-input" class="w-52 font-mono">{{$key}}</label>
                <x-gc::textarea id="{{$field->modelKey}}-input"
                                class="w-full"
                                wire:model.lazy="model.{{$field->modelKey}}.{{$key}}"/>
            </div>
        @endforeach
    @else
        <x-gc::textarea id="{{$field->modelKey}}-input"
                        class="w-full"
                        wire:model.lazy="model.{{$field->modelKey}}"/>
    @endif

</div>
