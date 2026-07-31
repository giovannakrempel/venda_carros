<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Anúncio - AutoAnúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/portal">AutoAnúncios - Área Restrita</a>
        <div class="ms-auto">
            <a class="btn btn-outline-light btn-sm" href="/auth/logout">Sair</a>
        </div>
    </div>
</nav>
<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Criar Novo Anúncio</h3>
                        <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Marca</label><input name="marca" type="text" class="form-control" required></div>
                                <div class="col-md-6"><label class="form-label">Modelo</label><input name="modelo" type="text" class="form-control" required></div>
                                <div class="col-md-4"><label class="form-label">Ano</label><input name="ano" type="number" class="form-control" required></div>
                                <div class="col-md-4"><label class="form-label">Cor</label><input name="cor" type="text" class="form-control" required></div>
                                <div class="col-md-4"><label class="form-label">Quilometragem</label><input name="quilometragem" type="number" class="form-control" required></div>
                                <div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control" rows="3" required></textarea></div>
                                <div class="col-md-6"><label class="form-label">Valor</label><input name="valor" type="text" class="form-control" required></div>
                                <div class="col-md-3"><label class="form-label">Estado (UF)</label><input name="estado" type="text" class="form-control" required></div>
                                <div class="col-md-3"><label class="form-label">Cidade</label><input name="cidade" type="text" class="form-control" required></div>
                                <div class="col-12"><label class="form-label">Fotos (mínimo 3)</label><input name="fotos[]" type="file" class="form-control" accept="image/*" multiple required></div>
                            </div>
                            <div class="mt-4 d-grid"><button class="btn btn-primary" type="submit">Criar Anúncio</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
