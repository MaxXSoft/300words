<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="description" content="300字 - 分支式故事接龙">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php $this->setTabs(array(
    'random/' => '随机',
    'hot/'    => '热门',
    'latest/' => '最新',
    'root/'   => '根列表',
  ));?><?php $this->title(); ?> - 300字</title>
  <link rel="icon" type="image/png" sizes="16x16" href="<?php $this->image('icon-16.png'); ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php $this->image('icon-32.png'); ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php $this->image('icon-96.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php $this->image('icon-76.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php $this->image('icon-114.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php $this->image('icon-120.png'); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php $this->image('icon-152.png'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->css('main.css'); ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->css('font.css'); ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->css('toolbar.css'); ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->css('tooltip.css'); ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->css('dark.css'); ?>">
  <link href="https://cdn.bootcss.com/font-awesome/5.10.2/css/all.css" rel="stylesheet">
  <script src="https://cn.vuejs.org/js/vue.min.js"></script>
</head>

<body>