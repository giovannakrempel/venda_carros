<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/VehicleModel.php';

class HomeController extends Controller
{
    public function index(): void
    {
        session_start();
        $model = new VehicleModel($GLOBALS['pdo']);
        $vehicles = $model->list();
        $this->view('home', ['vehicles' => $vehicles]);
    }

    public function filters(): void
    {
        session_start();
        $model = new VehicleModel($GLOBALS['pdo']);
        $vehicles = $model->list([
            'marca' => $_GET['marca'] ?? null,
            'modelo' => $_GET['modelo'] ?? null,
            'estado' => $_GET['estado'] ?? null,
            'cidade' => $_GET['cidade'] ?? null,
            'valor_max' => $_GET['valor_max'] ?? null,
        ]);
        $this->json(['vehicles' => $vehicles]);
    }
}
