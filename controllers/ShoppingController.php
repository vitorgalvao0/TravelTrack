<?php
class ShoppingController extends BaseController
{
    /**
     * Processa compra com dinheiro (simula pagamento)
     */
    public function buyWithMoney()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash'] = 'Método inválido';
            header('Location: index.php?page=places');
            exit;
        }

        $user_id = $_SESSION['user_id'] ?? null;
        $place_id = $_POST['place_id'] ?? null;
        $valor_real = floatval($_POST['valor_real'] ?? 0);

        if (!$user_id) {
            $_SESSION['flash'] = 'Você precisa estar logado para comprar';
            header('Location: index.php?page=login');
            exit;
        }

        if (!$place_id || $valor_real <= 0) {
            $_SESSION['flash'] = 'Dados inválidos';
            header('Location: index.php?page=places');
            exit;
        }

        // Valida lugar
        $place = (new PlaceModel())->find($place_id);
        if (!$place) {
            $_SESSION['flash'] = 'Local não encontrado';
            header('Location: index.php?page=places');
            exit;
        }

        // Processa compra
        $result = (new ShoppingModel())->buyWithMoney($user_id, $place_id, $valor_real);

        if ($result['success']) {
            $_SESSION['flash'] = $result['message'];
        } else {
            $_SESSION['flash'] = 'Erro: ' . $result['message'];
        }

        header('Location: index.php?page=places');
        exit;
    }

    /**
     * Processa compra com pontos (troca)
     */
    public function buyWithPoints()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash'] = 'Método inválido';
            header('Location: index.php?page=places');
            exit;
        }

        $user_id = $_SESSION['user_id'] ?? null;
        $place_id = $_POST['place_id'] ?? null;

        if (!$user_id) {
            $_SESSION['flash'] = 'Você precisa estar logado para comprar';
            header('Location: index.php?page=login');
            exit;
        }

        if (!$place_id) {
            $_SESSION['flash'] = 'Local inválido';
            header('Location: index.php?page=places');
            exit;
        }

        // Valida lugar
        $place = (new PlaceModel())->find($place_id);
        if (!$place) {
            $_SESSION['flash'] = 'Local não encontrado';
            header('Location: index.php?page=places');
            exit;
        }

        $pontos_custo = $place['points'] ?? 0;

        // Processa compra
        $result = (new ShoppingModel())->buyWithPoints($user_id, $place_id, $pontos_custo);

        if ($result['success']) {
            $_SESSION['flash'] = $result['message'];
        } else {
            $_SESSION['flash'] = 'Erro: ' . $result['message'];
        }

        header('Location: index.php?page=places');
        exit;
    }

    /**
     * Exibe histórico de compras
     */
    public function history()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?page=login');
            exit;
        }

        $user = (new UserModel())->findById($user_id);
        $shopping = new ShoppingModel();
        $history = $shopping->getShoppingHistory($user_id);
        $stats = $shopping->getStats($user_id);

        $this->view('user/shopping_history.php', [
            'user' => $user,
            'history' => $history,
            'stats' => $stats
        ]);
    }
}
