<?php
class ProfileController extends BaseController
{
    public function show()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $user = (new UserModel())->findById($_SESSION['user_id']);
        $this->view('user/profile.php', ['user' => $user]);
    }

    public function update()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id = $_SESSION['user_id'];
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'logradouro' => $_POST['logradouro'] ?? '',
            'numero_casa' => $_POST['numero_casa'] ?? '',
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'cep' => $_POST['cep'] ?? '',
        ];
        (new UserModel())->update($id, $data);
        $_SESSION['flash'] = 'Perfil atualizado com sucesso!';
        header('Location: index.php?page=profile');
        exit;
    }
}
