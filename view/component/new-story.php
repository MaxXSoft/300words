<?php $this->setPrompt(array(
  "起个标题吗？\n<i>{num}</i>月是<i>{somebody}</i>的<i>{something}</i>",
  "起个标题吗？\n<i>{somebody}</i>与<i>{somebody}</i>之间的惨烈修罗场",
  "起个标题吗？\n<i>{somebody}</i>也要{do something}",
  "起个标题吗？\n从零开始的<i>{something}</i>",
  "起个标题吗？\n进击的<i>{somebody}</i>",
  "起个标题吗？\n魔法少女<i>{somebody}</i>",
  "起个标题吗？\n某<i>{adjective}</i>的<i>{something}</i>",
  "起个标题吗？\n我的<i>{somebody}</i>不可能这么<i>{adjective}</i>",
  "起个标题吗？\n只有<i>{somebody}</i>知道的世界",
  "起个标题吗？\n欢迎来到<i>{something}</i>至上主义的<i>{somewhere}</i>",
  "起个标题吗？\n{do something}吧！<i>{somebody}</i>",
  //
  "不被发现就不算犯罪哦",
  "画个圈圈诅咒你 >.<",
  "姐姐姐姐，<i>{blahblah}</i>。\n雷姆雷姆，<i>{blahblah}</i>。",
  "今天的风儿好喧嚣啊",
  "警察叔叔，就是这个人！",
  "绝望了，我对这个<i>{adjective}</i>的世界绝望了",
  "快看，他的画风和我们不一样",
  "如果<i>{something}</i>就是神作了",
  "亚拉那一卡\n<b>やらないか</b>",
  "一旦接受了这种设定……",
  "有一个好消息和一个坏消息",
  "这么可爱一定是男孩子",
  "我得了一种不<i>{do something}</i>就会<i>{do something}</i>的病",
  "生气了吗？\n怒った? ",
  "真有你们的啊<i>{somebody}</i>",
  //
  "NicoNicoNi~",
  "毕竟老夫也不是什么恶魔",
  //
  "<i>{somebody}</i>，快用你那无敌的<i>{something}</i>想想办法啊！",
  "人类的赞歌是勇气的赞歌！",
  "<i>{somebody}</i>，这是我最后的<i>{something}</i>！你收下吧！\n<i>{SOME-}——{-BODY}——</i>！！！",
  "你能记得你吃过多少块面包吗？\n（魔理沙：13 片，我是和食主义者。）",
  "我不做人啦，<i>{somebody}</i>！",
  "但是我拒绝！\nだが断る！",
  "好棒～这清爽的感觉简直就像刚换上新内裤的正月元旦的早晨～",
  "砸挖路多！\nThe World！",
  "这味道……是说谎的味道！",
  "我大德意志的科学技术世界第一！",
  "——🙏✌️👌👋\n——胖·次·看·光·了",
  "你初吻的对象不是<i>{somebody}</i>，是我<i>{somebody}</i>哒！",
  "你的败因只有一个，那就是你激怒我了！",
  "冷静下来……先数质数",
  "オラオラオラオラオラオラオラオラ！！\n無駄無駄無駄無駄無駄無駄無駄無駄！！",
  //
  "原作：石ノ森 章太郎",
)); ?>
<div id="main-area">
  <div class="post-box">
    <div class="post-content even">
    <?php
      $lines = $this->prompt();
      while ($lines->value()) {
    ?>
      <p><?php echo($lines->value()); ?></p>
    <?php
        $lines->next();
      }
    ?>
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
