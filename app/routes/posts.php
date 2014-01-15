<?php
use Entity\Post;

$app->resource('posts', function($request) {

    // Index
    $this->get(function($request) {
        // All posts
        $posts = $this['mapper']->all('Entity\Post')
            ->where(['status' => 'published'])
            ->order(['date_created' => 'DESC']);

        // Pagination
        $page = (int) $request->get('page', 1);
        $posts->page($page, 5);

        $data = [
            'posts' => $posts,
            'page' => $page
        ];

        $this->format('json', function() use($data) {
            return $data;
        });
        $this->format('html', function() use($data) {
            return $this->template('posts/index', $data);
        });
    });

    // Create new record
    $this->post(function($request) {
        if(!$this['user']->isLoggedIn()) {
            return 401;
        }

        $v = new Valdator($request->post());
        $v->rule('required', ['title', 'body']);
        if($v->validate()) {
            // Create new post
            $post = $this['mapper']->create('Entity\Post', array(
                'user_id' => $this['user']->id,
                'title' => $this->helper('format')->format_url($request->title),
                'body' => $request->body
            ));

            $this->format('json', function() use($post) {
                return $this->response(201, $post->toArray());
            });
            $this->format('html', function() use($post) {
                return $this->response()->redirect('/posts/' . $post->id);
            });
        } else {
            $this->format('json', function() use($v) {
                return $this->response(400, ['errors' => $v->errors()]);
            });
            $this->format('html', function() use($v) {
                return $this->template('posts/new', ['errors' => $v->errors()]);
            });
        }
    });

    // Single record
    $this->param('int', function($request, $id) {
        // Load single record
        $post = $this['mapper']->get('Entity\Post', $id);
        if(!$post) {
            return 404;
        }

        // View post
        $this->get(function($request) use($post) {
            $this->format('json', function() use($post) {
                return $post->toArray();
            });
            $this->format('html', function() use($post) {
                return $this->template('posts/view', compact('post'));
            });
        });

        // Edit post
        $this->path('edit', function($request) use($post) {
            if(!$this['user']->isLoggedIn()) {
                return 401;
            }
        });

        // Delete post
        $this->path('edit', function($request) use($post) {
            if(!$this['user']->isLoggedIn()) {
                return 401;
            }
        });

        // Nested paths
        require __DIR__ . '/events.php';
    });
});
