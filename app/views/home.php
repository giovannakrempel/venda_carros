<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoAnúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="/">AutoAnúncios</a>
        <div class="ms-auto">
            <a class="btn btn-outline-primary btn-sm" href="/login">Login</a>
            <a class="btn btn-primary btn-sm" href="/register">Cadastro</a>
        </div>
    </div>
</nav>
<main class="py-4">
    <div class="container">
        <div class="card p-3 mb-4">
            <h2 class="h5">Filtros dinâmicos</h2>
            <form id="filterForm" class="row g-2">
                <div class="col-md-3"><input class="form-control" name="marca" placeholder="Marca"></div>
                <div class="col-md-3"><input class="form-control" name="modelo" placeholder="Modelo"></div>
                <div class="col-md-2"><input class="form-control" name="estado" placeholder="UF"></div>
                <div class="col-md-2"><input class="form-control" name="cidade" placeholder="Cidade"></div>
                <div class="col-md-2"><input class="form-control" name="valor_max" type="number" placeholder="Valor até"></div>
                <div class="col-12"><button class="btn btn-primary" type="submit">Aplicar</button></div>
            </form>
        </div>

        <div id="vehicleList" class="row g-4">
            <?php foreach ($vehicles as $vehicle): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <?php $photos = array_filter(explode(',', $vehicle['photos'] ?? '')); ?>
                        <?php $firstPhoto = $photos[0] ?? '/img/placeholder.png'; ?>
                        <img src="<?= $firstPhoto ?>" class="card-img-top" alt="<?= htmlspecialchars($vehicle['modelo']) ?>" style="height: 200px; object-fit: cover;">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const form = document.getElementById('filterForm');
const list = document.getElementById('vehicleList');
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const params = new URLSearchParams(new FormData(form));
  const response = await fetch('/home/filters?' + params.toString());
  const data = await response.json();
  list.innerHTML = '';
  data.vehicles.forEach(vehicle => {
    const photos = (vehicle.photos || '').split(',').filter(Boolean);
    const firstPhoto = photos[0] || '/img/placeholder.png';
    list.innerHTML += `
      <div class="col-md-4">
        <div class="card h-100">
          <img src="${firstPhoto}" class="card-img-top" alt="${vehicle.modelo}" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h3 class="h6 mb-1">${vehicle.marca} ${vehicle.modelo}</h3>
            <p class="text-muted mb-2">${vehicle.cidade}/${vehicle.estado}</p>
            <p class="fw-bold">R$ ${Number(vehicle.valor).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</p>
            <p class="small mb-0">${vehicle.descricao}</p>
          </div>
        </div>
      </div>`;
  });
});
</script>
</body>
</html>
