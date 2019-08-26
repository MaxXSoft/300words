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
  let result = username.match(re)
  if (result === null) return false
  return result[0].length > 0 && result[0].length <= 16
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

// post JSON data asynchronously
const postJsonAsync = async (url, data) => {
  let resp = await fetch(url, {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      'Content-Type': 'application/json',
    },
  })
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

// set cookie
const setCookie = (name, value, days) => {
  let expires = ''
  if (days) {
    let date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    expires = `expires=${date.toUTCString()}`
  }
  document.cookie = `${name}=${value || ''}; ${expires}; path=/`
}

// get cookie
const getCookie = (name) => {
  let nameEq = `${name}=`
  let cookies = document.cookie.split(/;\s?/g)
  for (const c of cookies) {
    if (c.indexOf(nameEq) == 0) return c.substring(nameEq.length, c.length)
  }
  return null
}
