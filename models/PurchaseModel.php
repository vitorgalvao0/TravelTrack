<?php
class PurchaseModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    /**
     * Cria uma compra/troca de experiência
     * Desconta pontos do usuário e registra a compra
     */
    public function purchase($user_id, $place_id, $points)
    {
        try {
            // Verifica se usuário tem pontos suficientes
            $stmt = $this->db->prepare('SELECT pontos_totais FROM usuario WHERE id_usuario = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return ['success' => false, 'message' => 'Usuário não encontrado'];
            }

            if ($user['pontos_totais'] < $points) {
                return ['success' => false, 'message' => 'Pontos insuficientes para esta compra'];
            }

            // Desconta pontos
            $stmt = $this->db->prepare('UPDATE usuario SET pontos_totais = pontos_totais - :points WHERE id_usuario = :user_id');
            $result = $stmt->execute(['points' => $points, 'user_id' => $user_id]);

            if ($result) {
                // Registra a compra no histórico (pode usar tabela checkin ou criar nova)
                $stmt = $this->db->prepare('INSERT INTO checkin (id_usuario, id_estab, pontos_gerados, data_checkin) VALUES (:user_id, :place_id, :points, NOW())');
                $stmt->execute([
                    'user_id' => $user_id,
                    'place_id' => $place_id,
                    'points' => -abs($points) // Valores negativos indicam gasto
                ]);

                return ['success' => true, 'message' => 'Experiência adquirida com sucesso!', 'new_points' => $user['pontos_totais'] - $points];
            }

            return ['success' => false, 'message' => 'Erro ao processar compra'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()];
        }
    }

    /**
     * Obtém histórico de compras de um usuário
     */
    public function purchaseHistory($user_id)
    {
        try {
            // Busca apenas as linhas com pontos negativos (compras)
            $stmt = $this->db->prepare('SELECT c.*, p.nome as place_nome FROM checkin c JOIN estabelecimento p ON p.id_estab = c.id_estab WHERE c.id_usuario = :user_id AND c.pontos_gerados < 0 ORDER BY c.data_checkin DESC');
            $stmt->execute(['user_id' => $user_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'place_name' => $r['place_nome'] ?? $r['nome'] ?? '',
                    'created_at' => $r['data_checkin'] ?? '',
                    'points_spent' => abs($r['pontos_gerados'] ?? 0),
                ];
            }
            return $out;
        } catch (PDOException $e) {
            return [];
        }
    }
}
