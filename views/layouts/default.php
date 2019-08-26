<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Mon site'?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand">Mon site</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py-3 footer mt-auto">
        <div class="container">
            <?php if (defined('DEBUG_TIME')): ?>
                Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
            <?php endif ?>
        </div>
    </footer>
</body>
</html>