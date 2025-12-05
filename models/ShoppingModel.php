<?php
class ShoppingModel
{
    private $db;
    private $CONVERSION_RATE = 10; // 1 real = 10 pontos

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    /**
     * Compra com dinheiro (simula pagamento)
     * Desconta valor real e adiciona pontos ao usuário
     */
    public function buyWithMoney($user_id, $place_id, $valor_real)
    {
        try {
            // Valida
            if ($valor_real <= 0) {
                return ['success' => false, 'message' => 'Valor inválido'];
            }

            // Calcula pontos a receber (1 real = 10 pontos)
            $pontos_recebidos = intval($valor_real * $this->CONVERSION_RATE);

            // Inicia transação
            $this->db->beginTransaction();

            // Adiciona pontos ao usuário
            $stmt = $this->db->prepare('UPDATE usuario SET pontos_totais = COALESCE(pontos_totais, 0) + :points WHERE id_usuario = :user_id');
            $stmt->execute(['points' => $pontos_recebidos, 'user_id' => $user_id]);

            // Registra a compra
            $stmt = $this->db->prepare('INSERT INTO compra_experiencia (id_usuario, id_estab, tipo_compra, valor_gasto, pontos_recebidos, valor_real, data_compra) VALUES (:user_id, :place_id, :tipo, :valor_gasto, :pontos, :valor_real, NOW())');
            $result = $stmt->execute([
                'user_id' => $user_id,
                'place_id' => $place_id,
                'tipo' => 'dinheiro',
                'valor_gasto' => 0,
                'pontos' => $pontos_recebidos,
                'valor_real' => $valor_real
            ]);

            if (!$result) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Erro ao registrar compra'];
            }

            $this->db->commit();

            return [
                'success' => true,
                'message' => "Compra realizada com sucesso! Você recebeu {$pontos_recebidos} pontos 🎉",
                'pontos_recebidos' => $pontos_recebidos,
                'valor_gasto' => $valor_real
            ];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()];
        }
    }

    /**
     * Compra com pontos (troca de pontos)
     * Desconta pontos do usuário para ganhar a experiência
     */
    public function buyWithPoints($user_id, $place_id, $pontos_custo)
    {
        try {
            // Valida
            if ($pontos_custo <= 0) {
                return ['success' => false, 'message' => 'Valor de pontos inválido'];
            }

            // Verifica se usuário tem pontos suficientes
            $stmt = $this->db->prepare('SELECT pontos_totais FROM usuario WHERE id_usuario = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['success' => false, 'message' => 'Usuário não encontrado'];
            }

            if ($user['pontos_totais'] < $pontos_custo) {
                return ['success' => false, 'message' => 'Pontos insuficientes para esta compra'];
            }

            // Inicia transação
            $this->db->beginTransaction();

            // Desconta pontos
            $stmt = $this->db->prepare('UPDATE usuario SET pontos_totais = pontos_totais - :points WHERE id_usuario = :user_id');
            $stmt->execute(['points' => $pontos_custo, 'user_id' => $user_id]);

            // Registra a compra
            $stmt = $this->db->prepare('INSERT INTO compra_experiencia (id_usuario, id_estab, tipo_compra, valor_gasto, pontos_recebidos, valor_real, data_compra) VALUES (:user_id, :place_id, :tipo, :valor_gasto, :pontos, :valor_real, NOW())');
            $result = $stmt->execute([
                'user_id' => $user_id,
                'place_id' => $place_id,
                'tipo' => 'pontos',
                'valor_gasto' => $pontos_custo,
                'pontos' => 0,
                'valor_real' => 0
            ]);

            if (!$result) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Erro ao registrar compra'];
            }

            $this->db->commit();
            $pontos_restantes = $user['pontos_totais'] - $pontos_custo;

            return [
                'success' => true,
                'message' => "Experiência adquirida com sucesso! Pontos restantes: {$pontos_restantes}",
                'pontos_restantes' => $pontos_restantes,
                'pontos_gastos' => $pontos_custo
            ];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()];
        }
    }

    /**
     * Obtém histórico completo de compras
     */
    public function getShoppingHistory($user_id)
    {
        try {
            $stmt = $this->db->prepare('
                SELECT 
                    c.id_compra,
                    c.tipo_compra,
                    c.valor_gasto,
                    c.pontos_recebidos,
                    c.valor_real,
                    c.data_compra,
                    e.nome as place_nome
                FROM compra_experiencia c
                JOIN estabelecimento e ON e.id_estab = c.id_estab
                WHERE c.id_usuario = :user_id
                ORDER BY c.data_compra DESC
            ');
            $stmt->execute(['user_id' => $user_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'id_compra' => $r['id_compra'],
                    'place_name' => $r['place_nome'] ?? '',
                    'tipo_compra' => $r['tipo_compra'],
                    'valor_gasto' => $r['valor_gasto'] ?? 0,
                    'pontos_recebidos' => $r['pontos_recebidos'] ?? 0,
                    'valor_real' => $r['valor_real'] ?? 0,
                    'data_compra' => $r['data_compra'],
                ];
            }
            return $out;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtém apenas compras com dinheiro
     */
    public function getMoneyPurchases($user_id)
    {
        try {
            $stmt = $this->db->prepare('
                SELECT c.*, e.nome as place_nome
                FROM compra_experiencia c
                JOIN estabelecimento e ON e.id_estab = c.id_estab
                WHERE c.id_usuario = :user_id AND c.tipo_compra = "dinheiro"
                ORDER BY c.data_compra DESC
            ');
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtém apenas compras com pontos
     */
    public function getPointPurchases($user_id)
    {
        try {
            $stmt = $this->db->prepare('
                SELECT c.*, e.nome as place_nome
                FROM compra_experiencia c
                JOIN estabelecimento e ON e.id_estab = c.id_estab
                WHERE c.id_usuario = :user_id AND c.tipo_compra = "pontos"
                ORDER BY c.data_compra DESC
            ');
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Calcula estatísticas de compras
     */
    public function getStats($user_id)
    {
        try {
            $stmt = $this->db->prepare('
                SELECT 
                    COUNT(*) as total_compras,
                    SUM(CASE WHEN tipo_compra = "dinheiro" THEN 1 ELSE 0 END) as compras_dinheiro,
                    SUM(CASE WHEN tipo_compra = "pontos" THEN 1 ELSE 0 END) as compras_pontos,
                    SUM(pontos_recebidos) as total_pontos_recebidos,
                    SUM(valor_gasto) as total_pontos_gastos,
                    SUM(valor_real) as total_real_gasto
                FROM compra_experiencia
                WHERE id_usuario = :user_id
            ');
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
