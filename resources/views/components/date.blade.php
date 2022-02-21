@props([
    'disabled' => false,
    'time' => true,
    'format' => 'DD/MM/yyyy',
    'firstDay' => 1,
])
<div class="flex items-end space-x-2"
     {{$attributes->wire('model')}}
     x-data="dateInput('{{$format}}', '{{$attributes->wire('model')?->value}}')"
     wire:ignore>
    <x-gc::input
        x-ref="date"
        ::id="$id('dateInput')"
        x-model="date"
        x-init="new window.Pikaday({
            field: $refs.date,
            firstDay: {{$firstDay}},
            format: '{{$format}}',
            blurFieldOnSelect: false,
            theme: document.querySelector('.dark #'+$el.id) ? 'dark' : 'null'
        })"
        @change.stop="date = $el.value; updateDate()"
        class="w-48"
        leading-icon="heroicon-o-calendar"
        :disabled="$disabled"
        {{ $attributes->whereDoesntStartWith('wire') }}
    />
    @if($time)
        <div class="flex items-center space-x-1">
            <x-gc::input value="00" min="0" max="24" class="w-12" x-ref="hour" :disabled="$disabled"
                         x-model="hour"
                         @keyup.up.stop="increment('hour', 24)"
                         @keyup.down.stop="decrement('hour')"
                         @change.stop="updateDate"/>
            <div class="text-gray-500">:</div>
            <x-gc::input value="00" min="0" max="60" class="w-12" x-ref="minute" :disabled="$disabled"
                         x-model="minute"
                         @keyup.up.stop="increment('minute', 60)"
                         @keyup.down.stop="decrement('minute')"
                         @change.stop="updateDate"/>
        </div>
    @endif
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dateInput', (format, initialDate) => ({
                    date: null,
                    hour: '00',
                    minute: '00',
                    value: '',

                    init() {
                        this.date = initialDate && this.$wire[initialDate] ? moment(this.$wire[initialDate]) : moment().hour(0).minute(0)
                        this.hour = this.date.hour().toString().padStart(2, '0')
                        this.minute = this.date.minute().toString().padStart(2, '0')
                        this.date = this.date.format(format)
                    },

                    updateDate() {
                        let newDate = moment(this.date, format).hour(this.hour).minute(this.minute)
                        this.value = newDate.format()
                        this.$dispatch('input', this.value)
                        this.date = newDate.format('{{$format}}')
                        this.hour = newDate.hour().toString().padStart(2, '0')
                        this.minute = newDate.minute().toString().padStart(2, '0')
                    },

                    increment(value, max) {
                        if (this[value] < max) {
                            this[value]++
                            this.updateDate()
                        }
                    },

                    decrement(value) {
                        if (this[value] > 0) {
                            this[value]--
                            this.updateDate()
                        }
                    }
                }))
            })
        </script>
    @endpush
@endonce
