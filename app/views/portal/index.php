<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - AutoAnúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/portal">Área Restrita</a>
        <div class="ms-auto">
            <a class="btn btn-outline-light btn-sm" href="/portal/create">Criar anúncio</a>
            <a class="btn btn-outline-light btn-sm" href="/auth/logout">Sair</a>
        </div>
    </div>
</nav>
<main class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Meus anúncios</h2>
            <a class="btn btn-primary" href="/portal/create">Novo anúncio</a>
        </div>
        <div class="row g-4">
            <?php foreach ($vehicles as $vehicle): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <?php $photos = array_filter(explode(',', $vehicle['photos'] ?? '')); ?>
                        <?php $firstPhoto = $photos[0] ?? '/img/placeholder.png'; ?>
                        <img src="<?= $firstPhoto ?>" class="card-img-top" alt="<?= htmlspecialchars($vehicle['modelo']) ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h3 class="h6 mb-1"><?= htmlspecialchars($vehicle['marca']) ?> <?= htmlspecialchars($vehicle['modelo']) ?></h3>
                            <p class="text-muted mb-2"><?= htmlspecialchars($vehicle['cidade']) ?>/<?= htmlspecialchars($vehicle['estado']) ?></p>
                            <p class="fw-bold">R$ <?= number_format($vehicle['valor'], 2, ',', '.') ?></p>
                            <p class="small mb-0"><?= htmlspecialchars($vehicle['descricao']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
</body>
</html>
