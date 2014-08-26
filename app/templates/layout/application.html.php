<?php
$app = app();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bullet Blog Example</title>
  <link href="<?= $app->url('/assets/styles/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div id="header">
          <h1><a href="/">Bullet Blog Example</a></h1>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="row">
      <div class="col-md-3 col-lg-3">
        <div id="sidebar">
          <ul id="nav_sidebar">
          <li><a href="<?= $app->url('/'); ?>">Dashboard</a></li>
          <li><a href="<?= $app->url('/posts'); ?>">Blog</a></li>
        <ul>
        </div>
      </div>

      <div id="content_container" class="col-md-9 col-lg-9" style="margin-left: 0;">
        <div id="content" class="bBox">
          <?= $yield; ?>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div id="footer">
          <p>Copyright WHO CARES, Inc. &copy; <?= date('Y'); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScripts -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?= $app->url('assets/scripts/bootstrap.min.js'); ?>"></script>
</body>
</html>
