<?php
class UploadController extends BaseController
{
    private function ensureAdmin()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $user = (new UserModel())->findById($_SESSION['user_id']);
        if (!$user || !$user['is_admin']) {
            echo 'Access denied';
            exit;
        }
    }

    public function form()
    {
        $this->ensureAdmin();
        $this->view('admin/upload_image.php');
    }

    public function handle()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_places');
            exit;
        }
        $place_id = $_POST['place_id'] ?? null;
        if (!$place_id || empty($_FILES['imagem'])) {
            $_SESSION['flash'] = 'Dados inválidos para upload';
            header('Location: index.php?page=admin_places');
            exit;
        }
        $file = $_FILES['imagem'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash'] = 'Erro no upload';
            header('Location: index.php?page=admin_places');
            exit;
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safe = preg_replace('/[^a-z0-9\-_\.]/i', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $filename = $safe . '_' . time() . '.' . $ext;
        $dst = __DIR__ . '/../upload/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dst)) {
            $_SESSION['flash'] = 'Falha ao salvar arquivo';
            header('Location: index.php?page=admin_places');
            exit;
        }
        (new PlaceModel())->setImage($place_id, $filename);
        $_SESSION['flash'] = 'Imagem enviada com sucesso!';
        header('Location: index.php?page=admin_places');
        exit;
    }
}
