<?php
class AuthController extends BaseController
{
    public function showLogin()
    {
        $this->view('auth/login.php');
    }

    public function showRegister()
    {
        $this->view('auth/register.php');
    }

    public function handle($action)
    {
        $model = new UserModel();
        if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $model->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php?page=dashboard');
                exit;
            }
            $_SESSION['flash'] = 'Credenciais inválidas';
            header('Location: index.php?page=login');
            exit;
        }

        if ($action === 'logout') {
            session_unset();
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        }

        if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            if ($password !== $confirm) {
                $_SESSION['flash'] = 'Senha e confirmação não batem';
                header('Location: index.php?page=register');
                exit;
            }
            $exists = $model->findByEmail($email);
            if ($exists) {
                $_SESSION['flash'] = 'Email já cadastrado';
                header('Location: index.php?page=register');
                exit;
            }
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $model->create(['name'=>$name,'email'=>$email,'password'=>$hash,'points'=>0,'is_admin'=>0]);
            $_SESSION['flash'] = 'Conta criada. Faça login.';
            header('Location: index.php?page=login');
            exit;
        }
    }
}
