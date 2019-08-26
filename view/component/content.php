<div v-for="(post, i) in posts" class="post-content" :class="i % 2 == 0 ? 'even' : 'odd'">
  <p v-for="line in splitTextToLines(post.post)">{{line}}</p>
  <div v-if="post.id == null" class="ellipsis">
    <p>省略 {{post.count}} 篇故事 ...</p>
  </div>
  <div v-else-if="i != posts.length - 1" class="infobar">
    <a class="fas fa-external-link-alt" v-tooltip="'详情'" :href="getDetailUrl(post)"></a>
    <div class="username" v-tooltip="post.date">By {{post.user}}, {{getDiff(post.date)}}</div>
  </div>
</div>
<div class="infobar">
  <div class="ops">
    <a class="fas fa-marker" v-tooltip="'接龙'" @click="toggleTextbox"></a>
    <a class="fab fa-sourcetree" v-tooltip="'从根节点读起'" :href="getFromRootUrl(lastPostNode)"></a>
    <a v-tooltip="'子分支'" @click="toggleBranch"><span
        class="fas fa-code-branch fa-flip-vertical"></span>{{branchCount}}</a>
    <a v-tooltip="'评论'" @click="toggleComment"><span class="fas fa-comment"></span>{{allCommentCount}}</a>
  </div>
  <div class="username" v-tooltip="lastPostNode.date">By {{lastPostNode.user}}, {{getDiff(lastPostNode.date)}}</div>
</div>
