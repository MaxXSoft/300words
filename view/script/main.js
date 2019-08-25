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
    branches: [],
    // comment info
    allCommentCount: 0,
    commentCount: 0,
    currentPage: 1,
    comments: [],
    subComments: [],
    // subform control
    showSubform: 0,
    // write area
    content: '',
    username: '',
    remember: false,
    restLength: 300,
    replyParent: 0,
    replyUser: '',
  },
  computed: {
    lastPostNode: function () {
      if (this.posts.length) {
        return this.posts[this.posts.length - 1]
      }
      else {
        return {
          id: null,
          parent: null,
          user: 'N/A',
          date: 'N/A',
          post: 'N/A',
        }
      }
    },
    totalCommentPage: function () {
      let page = Math.ceil(this.commentCount / commentsPerPage)
      return page ? page : 1
    },
  },
  methods: {
    getDetailUrl: function (post) {
      return post ? `${siteUrl}story/${post.id}/` : '#'
    },
    getFromRootUrl: function (post) {
      return post ? `${siteUrl}story/${post.id}/fromroot/` : '#'
    },
    getDiff: function (date) {
      return getDateDiff(date)
    },
    toggleTextbox: function () {
      this.showSubform = this.showSubform != 1 ? 1 : 0
    },
    toggleBranch: function () {
      this.showSubform = this.showSubform != 2 ? 2 : 0
    },
    toggleComment: function () {
      this.showSubform = this.showSubform != 3 ? 3 : 0
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
      if (moveBranchPanel(isLeft)) {
        // load more branch info
        getMoreBranchInfo(this)
      }
    },
    branchPanelClicked: function (index) {
      window.location.href = this.getDetailUrl(this.branches[index])
    },
    pageSelectorClicked: function (isUp) {
      // set new value of current page
      let offset = isUp ? -1 : 1
      changeCurrentCommentPage(this, this.currentPage + offset)
    },
    pageSelectorEntered: function (event) {
      let page = parseInt(event.target.value)
      changeCurrentCommentPage(this, page)
    },
    replyComment: function (index) {
      //
    },
    submitComment: function () {
      // TODO
    },
  },
  created: async function () {
    // initialize scroll detector
    if (fromRoot) {
      window.onscroll = checkScroll(() => getPostInfo(this), 100)
    }
    // get info from server
    await getPathInfo(this)
    getPostInfo(this)
    getBranchInfo(this)
    getCommentInfo(this)
  },
})
