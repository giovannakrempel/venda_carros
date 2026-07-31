<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (($GLOBALS['_SERVER']['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $model = new UserModel($GLOBALS['pdo']);
            $user = $model->findByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                $this->redirect('portal');
            }

            $this->view('login', ['error' => 'Credenciais inválidas']);
            return;
        }

        $this->view('login');
    }

    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (($GLOBALS['_SERVER']['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $model = new UserModel($GLOBALS['pdo']);
            $userId = $model->create([
                'nome' => trim($_POST['nome'] ?? ''),
                'cpf' => trim($_POST['cpf'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'senha' => $_POST['senha'] ?? '',
                'telefone' => trim($_POST['telefone'] ?? ''),
            ]);
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = trim($_POST['nome'] ?? '');
            $this->redirect('portal');
        }

        $this->view('register');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('login');
    }
}
