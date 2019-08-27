  <div id="bottom-container">
    <div id="footer">
      <div id="footer-left">
        <a href="<?php $this->url('about/'); ?>">关于</a>
        <a href="<?php $this->url('about/#coop'); ?>">合作</a>
      </div>
      <div id="footer-right">Copyright <?php $this->year(); ?> <?php $this->org(); ?></div>
    </div>
  </div>
  <script>
    // constant definitions
    const siteUrl = '<?php $this->url(''); ?>'
    const apiUrl = `${siteUrl}api/`
    const diffPrompt = {
      today:      '%s',
      yesterday:  '昨天',
      days:       '%s 天前',
      months:     '%s 个月前',
      years:      '%s 年前',
    }
    const commentPrompt = {
      comment:    '评论...',
      reply:      '正在回复 @%s...',
      replyText:  '回复 @%s: ',
    }
    const postPrompt = {
      username:   '用户名无效\n只能包含字母、数字、下划线、中文字符和 Emoji',
      content:    '输入内容不能为空\n且不能超过 300 字或 600 字符',
      server:     '服务器拒绝了此次请求',
    }

    const maxPostCount = <?php $this->maxPostCount(); ?>

    const commentsPerPage = <?php $this->commentsPerPage(); ?>

    const postId = <?php $this->postId(); ?>

    const fromRoot = <?php $this->fromRoot(); ?>

  </script>
  <script src="<?php $this->script('util.js'); ?>"></script>
  <script src="<?php $this->script('control.js'); ?>"></script>
  <script src="<?php $this->script('textarea-autosize.js'); ?>"></script>
  <script src="<?php $this->script('header.js'); ?>"></script>
  <script src="<?php $this->scriptMain(); ?>"></script>
</body>

</html>
