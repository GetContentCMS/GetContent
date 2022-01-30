@props([
    'id' => Str::uuid(),
    'allowMultiple' => false
])
<div x-data="thisAccordion($refs, '{{$id}}', {{$allowMultiple ? 'true' : 'false'}})" {{$attributes}}>
    {{$slot}}
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('thisAccordion', ($refs, id, allowMultiple) => ({
                    id: null,
                    allowMultiple: false,
                    open: [],

                    init() {
                        this.id = id
                        this.allowMultiple = allowMultiple
                    },

                    openPanel(id) {
                        if(this.isOpen(id)) {
                            return
                        }

                        if(this.allowMultiple) {
                            return this.open.push(id)
                        }

                        this.open = [id]
                    },

                    closePanel(id) {
                        if ((index = this.open.indexOf(id)) > -1) {
                            this.open.splice(index, 1)
                        }
                    },

                    isOpen(id) {
                        return this.open.includes(id)
                    },

                    togglePanel(id) {
                        this.isOpen(id) ? this.closePanel(id) : this.openPanel(id)
                    }
                }));
            });
        </script>
    @endpush
@endonce
