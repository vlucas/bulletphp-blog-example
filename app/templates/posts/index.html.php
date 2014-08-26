<h2>Blog Posts</h2>

<p>Page <?= $page ?></p>
<?php foreach($posts as $post): ?>

  <h2><a href="<?= app()->url('/posts/' . $post->id); ?>"><?= $post->title ?></a></h2>
  <?= $post->body ?>

<?php endforeach; ?>

