

import Turbolinks from 'turbolinks'
Turbolinks.start()
import Alpine from 'alpinejs'
import Persist from '@alpinejs/persist'
import Collapse from '@alpinejs/collapse'
import Intersect from '@alpinejs/intersect'
import Morph from '@alpinejs/morph'
import Focus from '@alpinejs/focus'
import Push from 'push.js'

// window.Push = Push
Push.create('Hello World!')
window.Alpine = Alpine
Alpine.plugin(Collapse)
Alpine.plugin(Persist)
Alpine.plugin(Intersect)
Alpine.plugin(Morph)
Alpine.plugin(Focus)

Alpine.start()

// Push.create("Hello world!", {
//     body: "How's it hangin'?",
//     icon: '/icon.png',
//     timeout: 4000,
//     onClick: function () {
//         window.focus();
//         this.close();
//     }
// });
