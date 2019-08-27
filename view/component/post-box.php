<div id="main-area">
  <div class="post-box">
    <?php $this->need('content.php'); ?>
    <div class="post-subform" v-if="showSubform != 0">
      <div class="post-write" v-if="showSubform == 1" key="subform-1">
        <textarea placeholder="脑洞大开..." v-focus v-model="content" @keyup.ctrl.enter="submitPost"></textarea>
        <div class="userbar">
          <div class="user">
            <input type="text" placeholder="署名" class="username" v-model="username">
            <label><input type="checkbox" v-model="remember">记住</label>
          </div>
          <div class="tool">
            <label v-tooltip="'字符剩余 ' + (600 - content.length) + '/600'">{{restLength}}/300</label>
            <div class="button" @click="submitPost">发布</div>
          </div>
        </div>
      </div>
      <div class="post-branch" id="post-branch" v-else-if="showSubform == 2 && branchCount" key="subform-2">
        <?php $this->need('form-branch.php'); ?>
      </div>
      <div class="post-branch empty" v-else-if="showSubform == 2 && !branchCount">
        <p>暂无分支，来接龙吧！</p>
      </div>
      <div class="post-comment" v-else key="subform-3">
        <?php $this->need('form-comment.php'); ?>
      </div>
    </div>
  </div>
</div>
