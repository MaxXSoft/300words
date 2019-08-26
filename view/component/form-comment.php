<div v-for="(comment, i) in comments">
  <div class="comment">
    <p v-for="line in splitTextToLines(comment.text)">{{line}}</p>
    <div class="infobar">
      <a class="fas fa-reply" v-tooltip="'回复'" @click="replyComment(i)"></a>
      <div class="username" v-tooltip="comment.date">By {{comment.user}}, {{getDiff(comment.date)}}</div>
    </div>
  </div>
  <div v-show="comment.subCount">
    <div v-for="(sub, j) in comment.subComments" class="comment sub">
      <p v-for="line in splitTextToLines(sub.text)">{{line}}</p>
      <div class="infobar">
        <a class="fas fa-reply" v-tooltip="'回复'" @click="replyComment(j, i)"></a>
        <div class="username" v-tooltip="sub.date">By {{sub.user}}, {{getDiff(sub.date)}}</div>
      </div>
    </div>
    <a v-show="comment.subComments.length != comment.subCount" class="comment more" @click="moreComment(i)">加载更多 (剩余 {{comment.subCount - comment.subComments.length}} 条) ...</a>
  </div>
</div>
<div v-show="totalCommentPage" class="page-selector">
  <div class="page-up" @click="pageSelectorClicked(true)">上一页</div>
  <input type="text" class="page-current" v-model="selectedCommentPage" @keyup.enter="pageSelectorEntered">
  <div class="page-total">/ {{totalCommentPage}}</div>
  <div class="page-down" @click="pageSelectorClicked(false)">下一页</div>
</div>
<div class="reply-box">
  <textarea-autosize id="comment-area" class="comment-text" v-focus :placeholder="commentTip" v-model="commentContent" :max-height="150">
  </textarea-autosize>
  <div class="userbar">
    <div class="user">
      <input type="text" placeholder="署名" class="username" v-model="username">
      <label><input type="checkbox" v-model="remember">记住</label>
    </div>
    <div class="tool">
      <div class="button" @click="submitComment">发布</div>
    </div>
  </div>
</div>
