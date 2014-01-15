<h2>Blog Posts</h2>

<p>Page <?= $page ?></p>
<?php foreach($posts as $post): ?>

<h2><?= $post->title ?></h2>
<?= $post->body ?>

<?php endforeach; ?>
