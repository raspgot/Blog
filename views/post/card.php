<div class="card mb-3">
    <div class="card-body">
        <h5 class=card-title><?= htmlentities($post->getName()) ?></h5>
        <p class='text-muted'><?= $post->getCreated_at()->format('d F Y') ?></p>
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>