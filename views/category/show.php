<?php
    use App\Connexion;
    use App\Model\{Post, Category};
    use App\PaginatedQuery;

    $id = (int)$params['id'];
    $slug = $params['slug'];

    $pdo = Connexion::getPDO();
    $query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
    $query->execute(['id' => $id]);
    $query->setFetchMode(PDO::FETCH_CLASS, Category::class);
    /** @var Category|false */
    $category = $query->fetch();

    if ($category === FALSE) {
        throw new Exception('Aucune catégorie ne correspond à cet ID');
    }

    if ($category->getSlug() !== $slug) {
        $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
        http_response_code(301);
        header('Location: ' . $url);
    }
    
    $title = "Catégorie {$category->getName()}";
    
    $paginatedQuery = new PaginatedQuery(
        "SELECT p.* 
            FROM post p 
            JOIN post_category pc ON pc.post_id = p.id 
            WHERE pc.category_id = {$category->getID()}
            ORDER BY created_at DESC",
        "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$category->getID()}",
        Post::class
    );
    /** @var Post[] */
    $posts = $paginatedQuery->getItems();

    $link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])
?>

<h1>Catégorie <?= e($title) ?></h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>