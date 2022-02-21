@php
    $model = '$wire.entangle(\'' . $field->getModelPath('html') . '\').defer';
@endphp

@if($field->givenLabel)
    <label
        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">{{$field->givenLabel}}</label>
@endif

<x-gc::writer :model="$model" class="w-full"/>
