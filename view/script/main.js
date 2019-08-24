// Vue instance of navigation bar
const vmHeader = new Vue({
  el: '#top-container'
})

// Vue instance of main area (post box)
const vmMain = new Vue({
  el: '#main-area',
  data: {
    // post info
    path: [],
    posts: [],
    // branch info
    branchCount: 0,
    branchs: [],
    // comment info
    allCommentCount: 0,
    commentCount: 0,
    comments: [],
    subComments: [],
    // subform control
    showSubform: 0,
    // write area
    content: '',
    username: '',
    remember: false,
    restLength: 300,
  },
  methods: {
    toggleTextbox: function () {
      this.showSubform = this.showSubform != 1 ? 1 : 0
      //
    },
    toggleBranch: function () {
      this.showSubform = this.showSubform != 2 ? 2 : 0
      //
    },
    toggleComment: function () {
      this.showSubform = this.showSubform != 3 ? 3 : 0
      //
    },
    contentChanged: function () {
      this.restLength = 300 - getWordCount(this.content)
    },
    submitPost: function () {
      // TODO
      console.log(this.content)
      console.log(this.username)
      console.log(this.remember)
    },
    branchArrowClicked: function (isLeft) {
      let container = document.getElementById('panel-container')
      let panel = document.querySelectorAll('.post-branch .panel')
      if (!panel.length) return
      let left = container.offsetLeft
      let offset = container.offsetWidth / panel.length
      left += offset * (isLeft ? 1 : -1)
      if (left > 0) {
        left = 0
      }
      else if (left < -offset * (panel.length - 1)) {
        left = -offset * (panel.length - 1)
      }
      container.style.left = left + 'px'
    },
    branchPanelClicked: function (index) {
      //
    },
    replyComment: function (index) {
      //
    },
    submitComment: function () {
      //
    },
  },
  created: async function () {
    // initializer
    window.onscroll = checkScroll(() => console.log('bottom'), 100)
    await getPathInfo(this)
    await getPostInfo(this)
  },
})
