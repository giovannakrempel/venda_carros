<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/VehicleModel.php';

class PortalController extends Controller
{
    public function index(): void
    {
        session_start();
        $this->requireAuth();
        $model = new VehicleModel($GLOBALS['pdo']);
        $vehicles = $model->list();
        $this->view('portal/index', ['vehicles' => $vehicles]);
    }

    public function create(): void
    {
        session_start();
        $this->requireAuth();
        if (($GLOBALS['_SERVER']['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $uploadDir = __DIR__ . '/../../public/uploads/' . date('Y/m/d');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $paths = [];
            if (!empty($_FILES['fotos']['name'])) {
                foreach ($_FILES['fotos']['tmp_name'] as $index => $tmpName) {
                    if (!is_uploaded_file($tmpName)) {
                        continue;
                    }
                    $extension = pathinfo($_FILES['fotos']['name'][$index], PATHINFO_EXTENSION);
                    $filename = uniqid('photo_', true) . '.' . $extension;
                    $destination = $uploadDir . '/' . $filename;
                    move_uploaded_file($tmpName, $destination);
                    $paths[] = '/uploads/' . date('Y/m/d') . '/' . $filename;
                }
            }

            if (count($paths) < 3) {
                $this->view('portal/create', ['error' => 'Envie ao menos 3 fotos']);
                return;
            }

            $model = new VehicleModel($GLOBALS['pdo']);
            $model->create([
                'user_id' => $_SESSION['user_id'],
                'marca' => trim($_POST['marca'] ?? ''),
                'modelo' => trim($_POST['modelo'] ?? ''),
                'ano' => (int) ($_POST['ano'] ?? 0),
                'cor' => trim($_POST['cor'] ?? ''),
                'quilometragem' => (int) ($_POST['quilometragem'] ?? 0),
                'descricao' => trim($_POST['descricao'] ?? ''),
                'valor' => (float) ($_POST['valor'] ?? 0),
                'estado' => trim($_POST['estado'] ?? ''),
                'cidade' => trim($_POST['cidade'] ?? ''),
            ], $paths);

            $this->redirect('portal');
        }

        $this->view('portal/create');
    }
}
