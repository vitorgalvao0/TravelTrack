<?php
class AdminController extends BaseController
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

    public function panel()
    {
        $this->ensureAdmin();
        $this->view('admin/panel.php');
    }

    public function places()
    {
        $this->ensureAdmin();
        $places = (new PlaceModel())->all();
        $this->view('admin/places.php', ['places' => $places]);
    }

    // exibe formulário para novo local
    public function newPlace()
    {
        $this->ensureAdmin();
        $this->view('admin/place_form.php', ['place' => null, 'action' => 'create']);
    }

    // cria novo local (POST)
    public function createPlace()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_places');
            exit;
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'logradouro' => $_POST['logradouro'] ?? '',
            'numero_casa' => $_POST['numero_casa'] ?? null,
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'cep' => $_POST['cep'] ?? '',
            'description' => $_POST['description'] ?? '',
            'tipo' => $_POST['tipo'] ?? 'turistico',
            'points' => isset($_POST['pontos_base']) ? (int)$_POST['pontos_base'] : 0,
            'sustentabilidade' => isset($_POST['sustentabilidade']) ? (int)$_POST['sustentabilidade'] : 3,
        ];
        $result = (new PlaceModel())->create($data);
        if ($result === false) {
            $_SESSION['flash'] = 'Erro ao criar local.';
            header('Location: index.php?page=admin_places');
            exit;
        }
        // se houver upload de imagem no form, processa e salva
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['imagem'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $safe = preg_replace('/[^a-z0-9\-_\.]/i', '_', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = $safe . '_' . time() . '.' . $ext;
            $dst = __DIR__ . '/../upload/' . $filename;
            if (move_uploaded_file($file['tmp_name'], $dst)) {
                (new PlaceModel())->setImage($result, $filename);
            }
        }
        $_SESSION['flash'] = 'Local criado com sucesso.';
        header('Location: index.php?page=admin_places');
        exit;
    }

    // exibe formulário de edição
    public function editPlace()
    {
        $this->ensureAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=admin_places');
            exit;
        }
        $place = (new PlaceModel())->find($id);
        if (!$place) {
            $_SESSION['flash'] = 'Local não encontrado.';
            header('Location: index.php?page=admin_places');
            exit;
        }
        $this->view('admin/place_form.php', ['place' => $place, 'action' => 'update']);
    }

    // atualiza local (POST)
    public function updatePlace()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_places');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = 'ID inválido.';
            header('Location: index.php?page=admin_places');
            exit;
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'logradouro' => $_POST['logradouro'] ?? '',
            'numero_casa' => $_POST['numero_casa'] ?? null,
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'cep' => $_POST['cep'] ?? '',
            'description' => $_POST['description'] ?? '',
            'tipo' => $_POST['tipo'] ?? 'turistico',
            'points' => isset($_POST['pontos_base']) ? (int)$_POST['pontos_base'] : 0,
            'sustentabilidade' => isset($_POST['sustentabilidade']) ? (int)$_POST['sustentabilidade'] : 3,
        ];
        $ok = (new PlaceModel())->update($id, $data);
        // se houver upload de imagem no form, processa e salva
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['imagem'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $safe = preg_replace('/[^a-z0-9\-_\.]/i', '_', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = $safe . '_' . time() . '.' . $ext;
            $dst = __DIR__ . '/../upload/' . $filename;
            if (move_uploaded_file($file['tmp_name'], $dst)) {
                (new PlaceModel())->setImage($id, $filename);
            }
        }
        $_SESSION['flash'] = $ok ? 'Local atualizado.' : 'Erro ao atualizar local.';
        header('Location: index.php?page=admin_places');
        exit;
    }

    // exclui local (POST)
    public function deletePlace()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_places');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = 'ID inválido.';
            header('Location: index.php?page=admin_places');
            exit;
        }
        $ok = (new PlaceModel())->delete($id);
        $_SESSION['flash'] = $ok ? 'Local excluído.' : 'Erro ao excluir local.';
        header('Location: index.php?page=admin_places');
        exit;
    }

    public function rewards()
    {
        $this->ensureAdmin();
        $rewards = (new RewardModel())->all();
        $this->view('admin/rewards.php', ['rewards' => $rewards]);
    }

    // exibe formulário para nova recompensa
    public function newReward()
    {
        $this->ensureAdmin();
        $this->view('admin/reward_form.php', ['reward' => null, 'action' => 'create']);
    }

    // cria nova recompensa (POST)
    public function createReward()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'points_required' => isset($_POST['points_required']) ? (int)$_POST['points_required'] : 0,
        ];
        $ok = (new RewardModel())->create($data);
        $_SESSION['flash'] = $ok ? 'Recompensa criada com sucesso.' : 'Erro ao criar recompensa.';
        header('Location: index.php?page=admin_rewards');
        exit;
    }

    // exibe formulário de edição
    public function editReward()
    {
        $this->ensureAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $reward = (new RewardModel())->find($id);
        if (!$reward) {
            $_SESSION['flash'] = 'Recompensa não encontrada.';
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $this->view('admin/reward_form.php', ['reward' => $reward, 'action' => 'update']);
    }

    // atualiza recompensa (POST)
    public function updateReward()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = 'ID inválido.';
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'points_required' => isset($_POST['points_required']) ? (int)$_POST['points_required'] : 0,
        ];
        $ok = (new RewardModel())->update($id, $data);
        $_SESSION['flash'] = $ok ? 'Recompensa atualizada.' : 'Erro ao atualizar recompensa.';
        header('Location: index.php?page=admin_rewards');
        exit;
    }

    // exclui recompensa (POST)
    public function deleteReward()
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = 'ID inválido.';
            header('Location: index.php?page=admin_rewards');
            exit;
        }
        $ok = (new RewardModel())->delete($id);
        $_SESSION['flash'] = $ok ? 'Recompensa excluída.' : 'Erro ao excluir recompensa.';
        header('Location: index.php?page=admin_rewards');
        exit;
    }

    public function reviews()
    {
        $this->ensureAdmin();
        $this->view('admin/reviews.php');
    }
}
