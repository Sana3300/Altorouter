    <?php
   require_once dirname(__DIR__) . '/../vendor/autoload.php';
    use App\PostManager;
    $postsmanager = new PostManager();
     $posts = $postsmanager->getPosts();
   // require 'header.php';
   ?>



    <h1>Books Page</h1>
    <?php if (!empty($posts)): ?>
    <h1>Articles</h1>
    <?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post->name); ?></h2>
        <p><?php echo htmlspecialchars($post->slug); ?></p>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun article trouvé.</p>
<?php endif; ?>

