@extends('gc::layouts.docs')

@section('title', 'Other Inputs')

@section('content')
    <x-gc::component-preview name="switch"></x-gc::component-preview>
    <x-gc::component-preview name="upload"></x-gc::component-preview>

    <x-gc::component-preview name="select">
        <x-slot name="code">
            @php echo e('<x-gc::select>
    <x-gc::select.option value="option1">Option 1</x-gc::select.option>
    <x-gc::select.option value="option2">Option 2</x-gc::select.option>
    <x-gc::select.option value="option3">Option 3</x-gc::select.option>
</x-gc::select>
') @endphp
        </x-slot>
        <x-gc::select id="select1">
            <x-gc::select.option value="option1">Option 1</x-gc::select.option>
            <x-gc::select.option value="option2">Option 2</x-gc::select.option>
            <x-gc::select.option value="option3">Option 3</x-gc::select.option>
        </x-gc::select>
        <x-slot name="disabled">
            <x-gc::select id="select1" disabled>
                <x-gc::select.option value="option1">Option 1</x-gc::select.option>
                <x-gc::select.option value="option2">Option 2</x-gc::select.option>
                <x-gc::select.option value="option3">Option 3</x-gc::select.option>
            </x-gc::select>
        </x-slot>
    </x-gc::component-preview>
@endsection
