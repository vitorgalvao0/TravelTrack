<?php
class PurchaseController extends BaseController
{
    /**
     * Processa a compra/troca de pontos por uma experiência
     */
    public function buy()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash'] = 'Método inválido';
            header('Location: index.php?page=places');
            exit;
        }

        $user_id = $_SESSION['user_id'] ?? null;
        $place_id = $_POST['place_id'] ?? null;

        if (!$user_id) {
            $_SESSION['flash'] = 'Você precisa estar logado para comprar uma experiência';
            header('Location: index.php?page=login');
            exit;
        }

        if (!$place_id) {
            $_SESSION['flash'] = 'Local inválido';
            header('Location: index.php?page=places');
            exit;
        }

        // Obtém informações do local
        $place = (new PlaceModel())->find($place_id);
        if (!$place) {
            $_SESSION['flash'] = 'Local não encontrado';
            header('Location: index.php?page=places');
            exit;
        }

        $points = $place['points'] ?? 0;

        // Processa a compra
        $result = (new PurchaseModel())->purchase($user_id, $place_id, $points);

        if ($result['success']) {
            $_SESSION['flash'] = $result['message'] . ' Pontos restantes: ' . $result['new_points'];
        } else {
            $_SESSION['flash'] = $result['message'];
        }

        header('Location: index.php?page=places');
        exit;
    }

    /**
     * Exibe histórico de compras (experiências adquiridas)
     */
    public function purchaseHistory()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?page=login');
            exit;
        }

        $user = (new UserModel())->findById($user_id);
        $history = (new PurchaseModel())->purchaseHistory($user_id);
        $this->view('user/purchases.php', ['user' => $user, 'history' => $history]);
    }
}
