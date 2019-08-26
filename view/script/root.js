// Vue instance of main area (multiple post boxes)
const vmMain = new Vue({
  el: '#main-area',
  data: {
    totalCount: 0,
    posts: [],
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
  },
  created: async function () {
    window.onscroll = checkScroll(async () => {
      if (this.posts.length < this.totalCount) {
        getRootListInfo(this)
      }
    }, 100)
    await getRootListCount(this)
    getRootListInfo(this)
  },
})
