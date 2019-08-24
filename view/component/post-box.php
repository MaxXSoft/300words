<div id="main-area" class="post-box">
  <?php $this->need('content.php'); ?>
  <div class="post-subform" v-if="showSubform != 0">
    <div class="post-write" v-if="showSubform == 1" key="subform-1">
      <textarea placeholder="脑洞大开..." v-model="content" @input="contentChanged"></textarea>
      <div class="userbar">
        <div class="user">
          <input type="text" placeholder="署名" class="username" v-model="username">
          <label><input type="checkbox" v-model="remember">记住</label>
        </div>
        <div class="tool">
          <label v-tooltip="'字符剩余 ' + (600-content.length) + '/600'">{{restLength}}/300</label>
          <div class="button" @click="submitPost">发布</div>
        </div>
      </div>
    </div>
    <div class="post-branch" v-else-if="showSubform == 2" key="subform-2">
      <div class="left button fas fa-angle-left fa-lg" @click="branchArrowClicked(true)"></div>
      <div class="panel-container" id="panel-container">
        <?php $this->need('form-branch.php'); ?>
      </div>
      <div class="right button fas fa-angle-right fa-lg" @click="branchArrowClicked(false)"></div>
    </div>
    <div class="post-comment" v-else key="subform-3">
      <?php $this->need('form-comment.php'); ?>
      <div class="reply-box">
        <textarea-autosize placeholder="评论..." class="comment-text" :max-height="150">
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
    </div>
  </div>
</div>
