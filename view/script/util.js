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
  // no space, include only num, letter, underline, chinese
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
  //
}
