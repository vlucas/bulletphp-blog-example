<?php
if(!isset($app)) {
  throw new \RuntimeException("DB Seeds must be run within application context.");
}

$mapper = $app['mapper'];

echo "Creating Posts...\n";
$posts = array(array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 1',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 2',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 3',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 4',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 5',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 6',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    ), array(
        'status'  => 'published',
        'title'   => 'Some Sample Post 7',
        'body'    => '<p>Some prolific life-changing blog post here that is really profound</p>',
    )
);
foreach($posts as $data) {
  $post = new Entity\Post($data);
  $result = $mapper->save($post);
  if(!$result) { throw new Exception("Unable to create post: " . var_export($post->errors(), true)); }
}
echo "+ Posts Created!\n";

