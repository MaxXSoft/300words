<div id="main-area">
  <div v-for="post in posts" class="post-box">
    <div class="post-content">
      <p v-for="line in splitTextToLines(post.post)">{{line}}</p>
    </div>
    <div class="infobar">
      <div class="ops">
        <a class="fas fa-external-link-alt" v-tooltip="'详情'" :href="getDetailUrl(post)"></a>
        <label v-tooltip="'子分支'"><span class="fas fa-code-branch fa-flip-vertical"></span>{{post.branchCount}}</label>
        <label v-tooltip="'评论'"><span class="fas fa-comment"></span>{{post.commentCount}}</label>
      </div>
      <div class="username" v-tooltip="post.date">By {{post.user}}, {{getDiff(post.date)}}</div>
    </div>
  </div>
</div>
