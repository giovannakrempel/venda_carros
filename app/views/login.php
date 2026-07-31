<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoAnúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-light bg-light"><div class="container"><a class="navbar-brand" href="/">AutoAnúncios</a></div></nav>
<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Acesse sua conta</h3>
                        <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                        <form method="post">
                            <div class="mb-3"><label class="form-label">E-mail</label><input name="email" type="email" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Senha</label><input name="senha" type="password" class="form-control" required></div>
                            <div class="d-grid"><button class="btn btn-primary" type="submit">Entrar</button></div>
                        </form>
                        <p class="small text-center mt-3"><a href="/register">Não tem conta? Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
