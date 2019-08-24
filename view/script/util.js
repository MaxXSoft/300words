// get word count by counting Chinese & English words
const getWordCount = (text) => {
  let chinese = text.match(/[\u4e00-\u9fa5]/g)
  let english = text.match(/\b\w+\b/g)
  let chineseLen = chinese != null ? chinese.length : 0;
  let englishLen = english != null ? english.length : 0;
  return chineseLen + englishLen
}

// check if window is already scrolled to bottom
const checkScroll = (callback, limit = 0) => {
  return () => {
    // calculate offset
    let d = document.documentElement
    let offset = d.scrollTop + window.innerHeight
    let height = d.offsetHeight
    if (offset >= height - limit) callback()
  }
}

// get path info from server
const getPathInfo = async (vm) => {
  // send request
  let resp = await fetch(`${apiUrl}path/${postId}`)
  let json = await resp.json()
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
    // get post info after breakpoint
    //
  }
  else {
    // get post info just by path
    //
  }
}

// load more posts when scroll to bottom
const loadMorePosts = async () => {
  //
}

// get branch info from server
const getBranchInfo = async (vm) => {
  //
}

// get comment info from server
const getCommentInfo = async (vm) => {
  //
}
