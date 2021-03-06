<?php
use Entity\Post;

$app->resource('posts', function($request) {

    // Index
    $this->get(function($request) {
        // All posts
        $mapper = $this['spot']->mapper('Entity\Post');
        $posts = $mapper
            ->where(['status' => 'published'])
            ->order(['date_created' => 'DESC']);

        // Pagination
        $page = (int) $request->get('page', 1);
        $posts->page($page, 5);

        $this->format('json', function() use($posts) {
            return $posts->toArray();
        });
        $this->format('html', function() use($posts, $page) {
            return $this->template('posts/index', compact('posts', 'page'));
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
            $mapper = $this['spot']->mapper('Entity\Post');
            $post = $mapper->create([
                'user_id' => $this['user']->id,
                'title' => $this->helper('format')->format_url($request->title),
                'body' => $request->body
            ]);

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
        $mapper = $this['spot']->mapper('Entity\Post');
        $post = $mapper->get($id);
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

        // Edit post form
        $this->path('edit', function($request) use($post) {
            if(!$this['user']->isLoggedIn()) {
                return 401;
            }
            $this->format('html', function() use($post) {
                return $this->template('posts/new', compact('post'));
            });
        });

        // Edit post
        $this->put(function($request) use($post) {
            if(!$this['user']->isLoggedIn()) {
                return 401;
            }
            $post->data([
                'status' => $request->get('status', $post->status),
                'title' => $request->get('title', $post->title),
                'body' => $request->get('body', $post->body),
            ]);
            $this['mapper']->save($post);

            $this->format('json', function($request) use($post) {
                return $post->toArray();
            });
            return $this->response(200)->header('Location', $this->url('/posts/' . $post->id));
        });

        // Delete post
        $this->delete(function($request) use($post) {
            if(!$this['user']->isLoggedIn()) {
                return 401;
            }
            $mapper = $this['spot']-mapper('Entity\Post')->delete($post);
            return 204;
        });

        // Nested paths
        require __DIR__ . '/comments.php';
    });
});
