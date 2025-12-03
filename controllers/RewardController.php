<?php
class RewardController extends BaseController
{
    public function index()
    {
        $rewards = (new RewardModel())->all();
        $user = null;
        if (!empty($_SESSION['user_id'])) {
            $user = (new UserModel())->findById($_SESSION['user_id']);
        }
        $this->view('user/rewards.php', ['rewards' => $rewards, 'user' => $user]);
    }

    public function handle($action)
    {
        if ($action === 'redeem' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? null;
            $reward_id = $_POST['reward_id'] ?? null;
            if (!$user_id || !$reward_id) {
                $_SESSION['flash'] = 'Ação inválida';
                header('Location: index.php?page=rewards');
                exit;
            }
            $user = (new UserModel())->findById($user_id);
            $reward = (new RewardModel())->find($reward_id);
            if (!$user || !$reward) {
                $_SESSION['flash'] = 'Dados inválidos';
                header('Location: index.php?page=rewards');
                exit;
            }
            if (($user['points'] ?? 0) < ($reward['points_required'] ?? 0)) {
                $_SESSION['flash'] = 'Pontos insuficientes';
                header('Location: index.php?page=rewards');
                exit;
            }
            $db = (new Database())->conectar();
            $stmt = $db->prepare('UPDATE usuario SET pontos_totais = COALESCE(pontos_totais,0) - :p WHERE id_usuario = :id');
            $stmt->execute(['p' => $reward['points_required'], 'id' => $user_id]);
            $_SESSION['flash'] = 'Recompensa resgatada!';
            header('Location: index.php?page=rewards');
            exit;
        }
    }
}
