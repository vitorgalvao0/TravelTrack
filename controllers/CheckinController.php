<?php
class CheckinController extends BaseController
{
    public function handle($action)
    {
        if ($action === 'do' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? null;
            $place_id = $_POST['place_id'] ?? null;
            if (!$user_id || !$place_id) {
                $_SESSION['flash'] = 'Ação inválida';
                header('Location: index.php?page=dashboard');
                exit;
            }
            $place = (new PlaceModel())->find($place_id);
            if (!$place) {
                $_SESSION['flash'] = 'Local não encontrado';
                header('Location: index.php?page=places');
                exit;
            }
            $points = $place['points'] ?? 0;
            (new CheckinModel())->create(['user_id'=>$user_id,'place_id'=>$place_id,'points'=>$points]);
            $db = (new Database())->conectar();
            $stmt = $db->prepare('UPDATE usuario SET pontos_totais = COALESCE(pontos_totais,0) + :p WHERE id_usuario = :id');
            $stmt->execute(['p'=>$points,'id'=>$user_id]);
            $_SESSION['flash'] = "Check-in realizado: +{$points} pts";
            header('Location: index.php?page=place&id=' . $place_id);
            exit;
        }
    }

    public function history()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?page=login');
            exit;
        }
    $history = (new CheckinModel())->historyByUser($user_id);
    $this->view('user/history.php', ['history' => $history]);
    }
}
