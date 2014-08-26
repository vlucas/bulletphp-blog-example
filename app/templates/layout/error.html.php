<?php
$app = app();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Skeleton Bullet Application</title>
  <link href="<?= $app->url('/assets/styles/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="row">
      <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
        <div id="header">
          <h1><a href="/">Skeleton Application</a></h1>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="row">
      <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
        <div id="content">
          <?= $yield; ?>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="row">
      <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
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
