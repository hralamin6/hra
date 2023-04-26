

import Turbolinks from 'turbolinks'
Turbolinks.start()
import Alpine from 'alpinejs'
import Persist from '@alpinejs/persist'
import Collapse from '@alpinejs/collapse'
// import Intersect from '@alpinejs/intersect'
// import Morph from '@alpinejs/morph'
// import Focus from '@alpinejs/focus'

// window.Push = Push
window.Alpine = Alpine
Alpine.plugin(Collapse)
Alpine.plugin(Persist)

Alpine.start()

