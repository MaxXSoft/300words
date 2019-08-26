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
