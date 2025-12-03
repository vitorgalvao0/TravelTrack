<?php
class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO avaliacao (id_usuario,id_estab,nota,comentario,data_avaliacao) VALUES (:user_id,:place_id,:rating,:comment,NOW())');
            return $stmt->execute([
                'user_id' => $data['user_id'],
                'place_id' => $data['place_id'],
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? '',
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function forPlace($place_id)
    {
        try {
            $stmt = $this->db->prepare('SELECT r.*, u.nome as user_name FROM avaliacao r JOIN usuario u ON u.id_usuario = r.id_usuario WHERE r.id_estab = :place_id ORDER BY r.data_avaliacao DESC');
            $stmt->execute(['place_id' => $place_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'rating' => $r['nota'] ?? 0,
                    'comment' => $r['comentario'] ?? '',
                    'user_name' => $r['user_name'] ?? '',
                    'created_at' => $r['data_avaliacao'] ?? '',
                ];
            }
            return $out;
        } catch (PDOException $e) {
            return [];
        }
    }
}
