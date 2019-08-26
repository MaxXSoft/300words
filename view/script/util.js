// get word count by counting Chinese & English words
const getWordCount = (text) => {
  let chinese = text.match(/[\u4e00-\u9fa5]/g)
  let english = text.match(/\b\w+\b/g)
  let chineseLen = chinese != null ? chinese.length : 0
  let englishLen = english != null ? english.length : 0
  return chineseLen + englishLen
}

// check user name
const checkUsername = (username) => {
  // regex of username
  // allowed characters: numbers, letters, underline, chinese characters
  let re = /^(?:[0-9a-zA-Z_\u4e00-\u9fa5]|(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|[\ud83c\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|[\ud83c\ude32-\ude3a]|[\ud83c\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff]))+$/
  // check input
  return username.match(re)
}

// get difference between dates as a string
const getDateDiff = (date) => {
  // get target date (which time is set to zero)
  let target = new Date(date)
  target.setHours(0, 0, 0, 0)
  // calculate difference
  let now = new Date()
  now.setHours(0, 0, 0, 0)
  let diff = now - target
  let diffDay = Math.floor(diff / (1000 * 60 * 60 * 24))
  // get result
  if (diffDay == 0) {
    let d = new Date(date)
    let h = String(d.getHours()).padStart(2, '0')
    let m = String(d.getMinutes()).padStart(2, '0')
    return diffPrompt.today.replace('%s', `${h}:${m}`)
  }
  else if (diffDay == 1) {
    return diffPrompt.yesterday.replace('%s', diffDay)
  }
  else if (diffDay < 31) {
    return diffPrompt.days.replace('%s', diffDay)
  }
  else if (diffDay < 366) {
    let months = (now.getFullYear() - target.getFullYear()) * 12
    months += now.getMonth() - target.getMonth()
    return diffPrompt.months.replace('%s', months)
  }
  else {
    let years = now.getFullYear() - target.getFullYear()
    return diffPrompt.years.replace('%s', years)
  }
}

// fetch JSON from URL asynchronously
const fetchJsonAsync = async (url) => {
  let resp = await fetch(url)
  return await resp.json()
}

// check if window is already scrolled to bottom
const checkScroll = (callback, limit = 0) => {
  let isCalled = false
  return () => {
    // calculate offset
    let d = document.documentElement
    let offset = d.scrollTop + window.innerHeight
    let height = d.offsetHeight
    if (!isCalled && offset >= height - limit) {
      callback()
      isCalled = true
    }
    else if (isCalled && offset < height - limit) {
      isCalled = false
    }
  }
}

// move branch panels in panel container
// returns true if need to load more branch info
const moveBranchPanel = (isLeft) => {
  // get target element
  let container = document.getElementById('panel-container')
  let panel = document.querySelectorAll('.post-branch .panel')
  if (!panel.length) return false
  // calculate new left position
  let left = container.offsetLeft
  let offset = container.offsetWidth / panel.length
  left += offset * (isLeft ? 1 : -1)
  // check if the boundary is reached
  let ret = false
  if (left > 0) {
    left = 0
  }
  else if (left <= -offset * (panel.length - 1)) {
    left = -offset * (panel.length - 1)
    ret = true
  }
  // set left position
  container.style.left = left + 'px'
  return ret
}

// get path info from server
const getPathInfo = async (vm) => {
  // send request
  let json = await fetchJsonAsync(`${apiUrl}path/${postId}`)
  // get path info from json
  if (!json.error) vm.path = json.response
  // check if need to reduce
  if (!fromRoot && vm.path.length > maxPostCount) {
    let root = vm.path[0]
    let orgLen = vm.path.length
    vm.path = vm.path.slice(orgLen - (maxPostCount - 1))
    vm.path.unshift(root, -(orgLen - maxPostCount))
  }
}

// get post info from server
const getPostInfo = async (vm) => {
  if (fromRoot) {
    const numberOfStories = 10
    // get post info after breakpoint
    for (const i of vm.path.slice(vm.posts.length, numberOfStories)) {
      let json = await fetchJsonAsync(`${apiUrl}info/${i}`)
      vm.posts.push(!json.error ? json.response : null)
    }
  }
  else {
    vm.posts = []
    // get post info just by path
    for (const i of vm.path) {
      if (i < 0) {
        // generate an ellipsis node
        vm.posts.push({id: null, count: -i, post: ''})
      }
      else {
        // fetch post info
        let json = await fetchJsonAsync(`${apiUrl}info/${i}`)
        vm.posts.push(!json.error ? json.response : null)
      }
    }
  }
}

// get branch info from server
const getBranchInfo = async (vm) => {
  // get branch count
  let json = await fetchJsonAsync(`${apiUrl}childcount/${postId}`)
  vm.branchCount = !json.error ? json.response : 0
  // get initial branch info
  getMoreBranchInfo(vm)
}

// load more branch info
const getMoreBranchInfo = async (vm) => {
  const numberOfBranches = 10
  // get branch info after breakpoint
  let start = vm.branches.length
  if (start < vm.branchCount) {
    // fetch branch info
    let url = `${apiUrl}child/${postId}/${start}/${numberOfBranches}`
    let json = await fetchJsonAsync(url)
    if (!json.error) {
      vm.branches = vm.branches.concat(json.response)
    }
  }
}

// get comment info from server
const getCommentInfo = async (vm) => {
  // get comment count
  let json = await fetchJsonAsync(`${apiUrl}commentcount/${postId}/1`)
  vm.allCommentCount = !json.error ? json.response : 0
  json = await fetchJsonAsync(`${apiUrl}commentcount/${postId}/0`)
  vm.commentCount = !json.error ? json.response : 0
  // get comment content
  refreshCommentInfo(vm)
}

// just get content of comments and sub comments
const refreshCommentInfo = async (vm) => {
  const subCommentInitCount = 3
  // get comment content
  const commentUrl = `${apiUrl}comment/${postId}/${vm.currentPage - 1}/${commentsPerPage}`
  let json = await fetchJsonAsync(commentUrl)
  let comments = !json.error ? json.response : []
  // get sub comment content
  for (const i of comments) {
    if (i.subCount > 0) {
      const subUrl = `${apiUrl}sub/${i.id}/0/${subCommentInitCount}`
      let json = await fetchJsonAsync(subUrl)
      i.subComments = !json.error ? json.response : []
    }
    else {
      i.subComments = []
    }
  }
  // update comment info
  vm.comments = comments
}

const moreSubComments = async (vm, parentIndex) => {
  const subCommentIncreaseCount = 5
  // get sub comment info after breakpoint
  const comment = vm.comments[parentIndex]
  const subUrl = `${apiUrl}sub/${comment.id}/${comment.subComments.length}/${subCommentIncreaseCount}`
  let json = await fetchJsonAsync(subUrl)
  if (!json.error) {
    comment.subComments = comment.subComments.concat(json.response)
  }
}

// change current page of comment area
const changeCurrentCommentPage = (vm, page) => {
  // set new value of current page
  if (page <= 1) {
    page = 1
  }
  else if (page >= vm.totalCommentPage) {
    page = vm.totalCommentPage
  }
  vm.currentPage = page
  // reload current page
  refreshCommentInfo(vm)
}

// change reply status
const changeReplyStatus = (vm, index, parentIndex = null) => {
  // get username
  let user = null
  if (parentIndex === null) {
    user = vm.comments[index].user
    vm.replyParent = vm.comments[index].id
  }
  else {
    user = vm.comments[parentIndex].subComments[index].user
    vm.replyParent = vm.comments[parentIndex].id
  }
  // change the rest status
  vm.commentTip = commentPrompt.reply.replace('%s', user)
  vm.commentContent = commentPrompt.replyText.replace('%s', user)
  // set focus
  document.getElementById('comment-area').focus()
}
