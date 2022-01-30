@foreach($document->fields as $field)
    <x-gc::document-editor.field :field="$field" :configurable="!$document->usingGroupSchema" />
@endforeach
