<div x-data="tabGroup()">
    {{$slot}}
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('tabGroup', () => ({
                    selectedTab: null,

                    _select(id) {
                        this.selectedTab = id
                    },

                    _selected(id) {
                        return this.selectedTab === id
                    },
                }));
            });
        </script>
    @endpush
@endonce
