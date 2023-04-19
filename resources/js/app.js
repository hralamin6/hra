

import Turbolinks from 'turbolinks'
Turbolinks.start()
import Alpine from 'alpinejs'
import Persist from '@alpinejs/persist'
import Collapse from '@alpinejs/collapse'
import Intersect from '@alpinejs/intersect'
import Morph from '@alpinejs/morph'
import Focus from '@alpinejs/focus'

window.Alpine = Alpine
Alpine.plugin(Collapse)
Alpine.plugin(Persist)
Alpine.plugin(Intersect)
Alpine.plugin(Morph)
Alpine.plugin(Focus)

Alpine.start()

