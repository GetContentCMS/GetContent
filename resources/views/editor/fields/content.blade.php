@php
    $model = '$wire.entangle(\'' . $field->getModelPath('html') . '\').defer';
@endphp

<x-gc::writer :model="$model" class="w-full"/>
