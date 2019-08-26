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
    let url = window.location.href
    let urlArr = url.split('/')
    let page = url.endsWith('/') ? urlArr[urlArr.length - 2] :
                                   urlArr[urlArr.length - 1]
    // initialize scroll detector
    window.onscroll = checkScroll(async () => {
      if (this.posts.length < this.totalCount) {
        switch (page) {
          case 'hot': {
            await getPostListInfo(this, false)
            break
          }
          case 'latest': {
            await getPostListInfo(this, true)
            break
          }
          case 'root': {
            await getRootListInfo(this)
            break
          }
        }
      }
    }, 100)
    // get username from cookie
    let username = getCookie('300words_username')
    if (username) {
      this.username = username
      this.remember = true
    }
    // get info from server
    switch (page) {
      case 'hot': {
        await getPostListCount(this)
        getPostListInfo(this, false)
        break
      }
      case 'latest': {
        await getPostListCount(this)
        getPostListInfo(this, true)
        break
      }
      case 'root': {
        await getRootListCount(this)
        getRootListInfo(this)
        break
      }
    }
  },
})
