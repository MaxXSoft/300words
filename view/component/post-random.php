<?php $this->setPrompt(array(
  'today'     => '%s',
  'yesterday' => '昨天',
  'days'      => '%s 天前',
  'months'    => '%s 个月前',
  'years'     => '%s 年前',
)); ?>
<div id="main-area" class="post-box">
<?php
  global $contents;
  $contents = $this->contents();
  while ($contents->value()) {
    $this->need('post.php');
    $contents->next();
  }
?>
  <div class="infobar">
    <div class="ops">
      <a class="fas fa-marker" v-tooltip="'接龙'" @click="toggleTextbox"></a>
      <a class="fab fa-sourcetree" v-tooltip="'从根节点读起'" href="<?php $this->url("story/{$contents->last()['id']}/fromroot/"); ?>"></a>
      <a v-tooltip="'子分支'" @click="toggleBranch"><span class="fas fa-code-branch fa-flip-vertical"></span><?php echo($this->info()['child']); ?></a>
      <a v-tooltip="'评论'" @click="toggleComment"><span class="fas fa-comment"></span><?php echo($this->info()['comment']); ?></a>
    </div>
    <div class="username" v-tooltip="'<?php echo($contents->last()['date']); ?>'">
      By <?php echo($contents->last()['user']); ?>, <?php $this->difference($contents->last()['date']) ?>
    </div>
  </div>
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
