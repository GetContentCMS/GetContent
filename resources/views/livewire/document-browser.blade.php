<div x-data="documentBrowser" x-cloak>
    <header class="flex justify-between items-center px-6 py-3 text-gray-400 dark">
        <nav class="flex items-center space-x-2 text-lg">
            <a href="{{route('document:browser')}}" title="Go to top group">
                <x-heroicon-o-collection class="inline-block w-5 h-5"/>
                Documents
            </a>
            @isset($this->group)
                @foreach($this->group->ancestors()->defaultOrder()->get() as $ancestor)
                    <div class="@if(!$loop->last) hidden sm:contents @else contents @endif">
                        <x-heroicon-o-chevron-right class="flex-shrink-0 mx-2 w-5 h-5 text-gray-600"
                                                    aria-hidden="true"/>
                        <a href="{{route('document:browser', ['group' => $ancestor->uuid])}}"
                           title="Go back to {{$ancestor->name}}">
                            @if ($loop->last) <span class="sm:hidden">&hellip;</span> @endif
                            <span class="hidden truncate sm:flex">{{$ancestor->name}}</span>
                        </a>
                    </div>
                @endforeach
                <x-heroicon-o-chevron-right class="flex-shrink-0 -mx-1 w-5 h-5 text-gray-600"
                                            aria-hidden="true" />
                <div class="text-gray-200">
                    {{$this->group->name}}
                </div>
                <x-gc::button flat title="Edit {{$this->group->name}}">
                    <x-slot name="icon">
                        <x-heroicon-o-pencil class="text-gray-400"/>
                    </x-slot>
                </x-gc::button>

            @endif
        </nav>

        <nav class="flex items-center space-x-2" x-show="!selectedItems">
            <x-gc::button @click="newDocument" flat>
                <x-slot name="icon">
                    <x-heroicon-o-document-add/>
                </x-slot>
                New Document
            </x-gc::button>
            <x-gc::button @click="newGroup" flat>
                <x-slot name="icon">
                    <x-heroicon-o-folder-add/>
                </x-slot>
                New Group
            </x-gc::button>
        </nav>
        <nav class="flex items-center space-x-2" x-show="selectedItems">
            <div class="flex items-center space-x-2 font-semibold text-blue-400">
                <span x-text="selectedItems"></span>
                <span x-text="selectedItems > 1 ? 'items selected' : 'item selected'"></span>
                <x-gc::button flat title="Clear Selection" @click="clearSelection">
                    <x-slot name="icon">
                        <x-heroicon-s-x-circle class="text-blue-400"/>
                    </x-slot>
                </x-gc::button>
            </div>
            <x-gc::menu.divider vertical/>
            <x-gc::button @click="deleteSelectedItems" flat>
                <x-slot name="icon">
                    <x-heroicon-o-trash/>
                </x-slot>
                Delete
            </x-gc::button>
        </nav>
    </header>

    <main class="p-4 mr-4 space-y-px bg-white rounded">
        @foreach($items as $item)
            <div class="flex items-center px-2 rounded group"
                 :class="{
                    'bg-blue-500 hover:bg-blue-400 text-white': inSelection('{{$item->uuid}}'),
                    'hover:bg-gray-100': !inSelection('{{$item->uuid}}'),
                 }">
                @if($item->type === 'group')
                    <label class="h-full">
                        <input type="checkbox" value="{{$item->uuid}}" x-model="selectedGroups"
                               :class="{'opacity-0 group-hover:opacity-100': !selectedItems}">
                    </label>
                    <a href="{{route('document:browser', $item->uuid)}}" class="flex flex-grow items-center py-3"
                       title="Open {{$item->name}}">
                        <div class="flex justify-center items-center mx-1 w-8 h-8 bg-white rounded-md">
                            <x-heroicon-s-folder class="w-6 text-blue-400"/>
                        </div>
                        {{$item->name}}
                    </a>
                @else
                    <label class="h-full">
                        <input type="checkbox" value="{{$item->uuid}}" x-model="selectedDocuments"
                               :class="{'opacity-0 group-hover:opacity-100': !selectedItems}">
                    </label>
                    <a href="{{route('document:editor', $item->uuid)}}" class="flex flex-grow items-center py-3"
                       title="Open {{$item->name}}">
                        <div class="flex justify-center items-center mx-1 w-8 h-8 bg-white rounded-md">
                            <x-heroicon-o-document class="w-5 text-gray-600"/>
                        </div>
                        <div class="flex-grow">
                            {{$item->name}}
                        </div>
                        <div title="Updated {{$item->updated_at}}" class="text-sm"
                             :class="{
                                'text-blue-200': inSelection('{{$item->uuid}}'),
                                'text-gray-500': !inSelection('{{$item->uuid}}')
                             }">
                            {{$item->updated_at->diffForHumans()}}
                        </div>
                    </a>
                @endif
            </div>
        @endforeach
    </main>

    <div class="p-8">
        {{$items->links()}}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('documentBrowser', () => ({
                selectedDocuments: [],
                selectedGroups: [],

                init() {
                    this.$wire.on('document:created', document => {
                        this.$wire.openDocument(document.uuid)
                    })
                },

                get selectedItems() {
                    return this.selectedDocuments.length + this.selectedGroups.length
                },

                newDocument() {
                    let newDocumentName = window.prompt('Name your new Document …')

                    if (newDocumentName) {
                        this.$wire.createDocument(newDocumentName)
                    }
                },

                newGroup() {
                    let newGroupName = window.prompt('Name your new Group …')

                    if (newGroupName) {
                        this.$wire.createGroup(newGroupName)
                    }
                },

                deleteSelectedItems() {
                    this.$wire.deleteItems(this.selectedGroups, this.selectedDocuments)
                    this.clearSelection()
                },

                clearSelection() {
                    this.selectedGroups = []
                    this.selectedDocuments = []
                },

                inSelection(uuid) {
                    return this.selectedGroups.includes(uuid) || this.selectedDocuments.includes(uuid)
                }
            }))
        })
    </script>
@endpush
