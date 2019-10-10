<?php
    use App\Helpers\Text;
    use App\Model\Post;

    $title = 'Mon Blog';
    
    $pdo = new PDO('mysql:dbname=blog;host=127.0.0.1', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $currentPage = (int)($_GET['page'] ?? 1);
    if ($currentPage <= 0) {
        throw new Exception('Numéro de page invalide');
    }

    $count = $pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
    $perPage = 12;
    $pages = ceil($count / $perPage);
    if ($currentPage > $pages) {
        throw new Exception('Cette page n\'existe pas');
    }

    $offset = $perPage * ($currentPage -1);
    $query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    $posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<h1>Mon Blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage - 1 ?>" class="btn btn-primary">&#8592; Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante &#8594;</a>
    <?php endif ?>
</div>