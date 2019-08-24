<?php global $contents; ?>
<div class="post-content <?php if ($contents->index() % 2 == 0): ?>even<?php else: ?>odd<?php endif; ?>">
<?php if ($contents->value()['id'] === null): ?>
  <div class="ellipsis">
    <p>省略 <?php echo($contents->value()['count']); ?> 篇故事 ...</p>
  </div>
<?php else: ?>
  <?php $post = preg_split('/[\r\n]+/', trim($contents->value()['post'])); ?>
  <?php foreach ($post as $i): ?>
  <p><?php echo($i); ?></p>
  <?php endforeach; ?>
  <?php if (!$contents->isLast()): ?>
  <div class="infobar">
    <a class="fas fa-external-link-alt" v-tooltip="'详情'" href="<?php $this->url("story/{$contents->value()['id']}/"); ?>"></a>
    <div class="username" v-tooltip="'<?php echo($contents->value()['date']); ?>'">
      By <?php echo($contents->value()['user']); ?>, <?php $this->difference($contents->value()['date']) ?>
    </div>
  </div>
  <?php endif; ?>
<?php endif; ?>
</div>
