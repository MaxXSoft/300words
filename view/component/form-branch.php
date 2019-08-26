<div class="left button fas fa-angle-left fa-lg" @click="branchArrowClicked(true)"></div>
<div class="panel-container" id="panel-container">
  <div v-for="(branch, i) in branches" class="panel" @click="branchPanelClicked(i)">
    <div class="abstract">
      <p>{{branch.post}}</p>
    </div>
    <div class="status">
      <label><span class="fas fa-code-branch fa-flip-vertical"></span>{{branch.branchCount}}</label>
      <label><span class="fas fa-comment"></span>{{branch.commentCount}}</label>
    </div>
  </div>
</div>
<div class="right button fas fa-angle-right fa-lg" @click="branchArrowClicked(false)"></div>
