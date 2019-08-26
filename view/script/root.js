// Vue instance of main area (multiple post boxes)
const vmMain = new Vue({
  el: '#main-area',
  data: {
    // post info
    totalCount: 0,
    posts: [],
    // write area
    content: '',
    username: '',
    remember: false,
  },
  computed: {
    restLength: function () {
      return 300 - getWordCount(this.content)
    },
  },
  methods: {
    splitTextToLines: function (text) {
      return text.trim().split(/[\r\n]+/g)
    },
    getDetailUrl: function (post) {
      return post ? `${siteUrl}story/${post.id}/` : '#'
    },
    getDiff: function (date) {
      return getDateDiff(date)
    },
    submitPost: function () {
      createNewStory(this, true)
    },
  },
  created: async function () {
    // initialize scroll detector
    window.onscroll = checkScroll(async () => {
      if (this.posts.length < this.totalCount) {
        getRootListInfo(this)
      }
    }, 100)
    // get username from cookie
    let username = getCookie('300words_username')
    if (username) {
      this.username = username
      this.remember = true
    }
    // get info from server
    await getRootListCount(this)
    getRootListInfo(this)
  },
})
