<div class="flex fixed top-0 z-50 flex-col justify-center items-center p-8 space-y-1 w-full pointer-events-none"
     x-data="notifications">
    <template x-for="(notification, index) in stack">
        <x-gc::notifications.message/>
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
                add: function (message) {
                    if (typeof message === 'string') {
                        message = {message: message}
                    }

                    let notification = _.merge({
                        id: _.uniqueId(),
                        message: null,
                        type: 'success',
                        timeout: 8000,
                        action: false
                    }, message)

                    this.stack.push(notification)
                    this.stack.sort((el1, el2) => el1.id < el2.id)
                },

                remove(notification) {
                    this.stack = this.stack.filter(i => i.id !== notification.id)
                }
            }))

            Alpine.data('notificationMessage', () => ({
                show: false,

                init() {
                    this.$nextTick(() => this.show = true)

                    if (this.notification.timeout) {
                        setTimeout(() => this.transitionOut(), this.notification.timeout)
                    }
                },

                transitionOut() {
                    this.show = false
                    setTimeout(() => this.remove(this.notification), 500)
                },

                performAction(action) {
                    Livewire.emit(action.event, action.params)
                    this.remove(this.notification)
                },
            }))
        })
    </script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
@endpush
