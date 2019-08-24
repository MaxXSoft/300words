<div id="top-container">
  <div id="header">
    <div id="logo"></div>
    <div id="site-name">300字</div>
    <div id="tab-container">
    <?php
      $tabs = $this->tabs();
      while ($tabs->value()) {
    ?>
      <a href="<?php $this->url($tabs->key()); ?>"<?php if ($tabs->index() == $this->currentTab()): ?> class="tab-sel"<?php endif; ?>><?php echo($tabs->value()); ?></a>
    <?php
        $tabs->next();
      }
    ?>
    </div>
    <div id="control">
      <a href="<?php $this->url('new/'); ?>" id="new-post" class="fas fa-edit" v-tooltip="'写故事'"></a>
    </div>
  </div>
</div>
