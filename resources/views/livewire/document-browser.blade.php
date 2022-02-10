<div x-data="documentBrowser" x-cloak>
    <x-gc::app.header>
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
                                            aria-hidden="true"/>
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
    </x-gc::app.header>

    <x-gc::app.main>
        @foreach($items as $item)
            @if($item->type === 'group')
                <x-gc::app.list.item x-model="selectedGroups" :item-key="$item->uuid"
                                     href="{{route('document:browser', $item->uuid)}}"
                                     title="Browse {{$item->name}}">
                    <x-slot name="icon">
                        <x-heroicon-s-folder class="w-6 text-blue-400"/>
                    </x-slot>
                    {{$item->name}}
                </x-gc::app.list.item>
            @endif

            @if($item->type === 'document')
                <x-gc::app.list.item x-model="selectedDocuments" :item-key="$item->uuid"
                                     href="{{route('document:editor', $item->uuid)}}"
                                     title="Edit {{$item->name}}">
                    <x-slot name="icon">
                        <x-heroicon-o-document class="w-5 text-gray-600"/>
                    </x-slot>
                    <div class="flex-grow truncate">
                        {{$item->name}}
                    </div>
                    <x-gc::app.list.meta-column class="flex-shrink-0" title="Updated {{$item->updated_at}}">
                        {{$item->updated_at->diffForHumans()}}
                    </x-gc::app.list.meta-column>
                </x-gc::app.list.item>
            @endif
        @endforeach
    </x-gc::app.main>

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
