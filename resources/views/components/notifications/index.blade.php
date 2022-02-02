<div class="flex fixed top-0 z-50 flex-col justify-center items-center p-8 space-y-1 w-full pointer-events-none"
     x-data="notifications">
    <template x-for="(notification, index) in stack">
        <x-gc::notifications.message />
    </template>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notifications', () => ({
                stack: [],

                init() {
                    Livewire.on('notify', notification => {
                        this.add(notification);
                    });
                },

                /*
                * @message string|object
                * {
                *   message: "Notification message",
                *   timeout: false,
                *   action: {
                *     event: "someLivewireEvent",
                *     label: "Undo"
                *   }
                * }
                * */

                add: function(message) {
                    if (typeof message === 'string') {
                        message = {message: message}
                    }

                    let notification = _.merge({
                        id: _.uniqueId(),
                        message: null,
                        type: 'success',
                        timeout: 10000,
                        action: false
                    }, message)

                    this.stack.push(notification)

                    if (notification.timeout) {
                        _.delay(id => this.remove(id), notification.timeout, notification.id)
                    }
                },

                remove(id) {
                    let index = _.findKey(this.stack, {id})
                    this.stack.splice(index, 1)
                },

                performAction(action, index) {
                    Livewire.emit(action.event, action.params)
                    this.remove(index)
                }
            }))
        })
    </script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
@endpush
