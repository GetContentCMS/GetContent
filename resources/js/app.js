import 'lodash'
import moment from 'moment'
import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import collapse from '@alpinejs/collapse'
import 'livewire-sortable'
import pickaday from 'pikaday'
import { createPopper } from '@popperjs/core'
require('./writer')
// require('./bootstrap');

window.moment = moment
window.Pikaday = pickaday
window.createPopper = createPopper

window.Alpine = Alpine
Alpine.plugin(focus)
Alpine.plugin(collapse)
Alpine.start()
