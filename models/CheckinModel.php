<?php
class CheckinModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO checkin (id_usuario,id_estab,pontos_gerados,data_checkin) VALUES (:user_id,:place_id,:points,NOW())');
            return $stmt->execute([
                'user_id' => $data['user_id'],
                'place_id' => $data['place_id'],
                'points' => $data['points'] ?? 0,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function historyByUser($user_id)
    {
        try {
            $stmt = $this->db->prepare('SELECT c.*, p.nome as place_nome, c.data_checkin as created_at FROM checkin c JOIN estabelecimento p ON p.id_estab = c.id_estab WHERE c.id_usuario = :user_id ORDER BY c.data_checkin DESC');
            $stmt->execute(['user_id' => $user_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'place_name' => $r['place_nome'] ?? $r['nome'] ?? '',
                    'created_at' => $r['created_at'] ?? $r['data_checkin'] ?? '',
                    'points' => $r['pontos_gerados'] ?? $r['pontos'] ?? 0,
                ];
            }
            return $out;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function weeklyRanking($limit = 3)
    {
        try {
            $stmt = $this->db->prepare('SELECT u.nome, SUM(c.pontos_gerados) as total FROM checkin c JOIN usuario u ON u.id_usuario = c.id_usuario WHERE c.data_checkin >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY u.id_usuario ORDER BY total DESC LIMIT :limit');
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            return [];
        }
    }
}
