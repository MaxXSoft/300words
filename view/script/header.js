// register 'v-focus' directive
Vue.directive('focus', {
  inserted: function (el) {
    el.focus()
  }
})

// Vue instance of navigation bar
const vmHeader = new Vue({
  el: '#top-container'
})
