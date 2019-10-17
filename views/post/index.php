<?php
    use App\Helpers\Text;
    use App\Model\Post;
    use App\Connexion;
    use App\URL;

    $title = 'Mon Blog';
    $pdo = Connexion::getPDO();
    
    $currentPage = URL::getPositiveInt('page', 1);
    
    $count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
    $perPage = 12;
    $pages = ceil($count / $perPage);

    if ($currentPage > $pages) throw new Exception('Cette page n\'existe pas');

    $offset = $perPage * ($currentPage -1);
    $posts  = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll(PDO::FETCH_CLASS, Post::class);
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
        <?php
            $link = $router->url('home');
            if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">&#8592; Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante &#8594;</a>
    <?php endif ?>
</div>