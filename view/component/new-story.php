<div id="main-area">
  <div class="post-box">
    <div class="post-content even">
      <p>line</p>
    </div>
    <div class="post-subform">
      <div class="post-write">
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
    </div>
  </div>
</div>
