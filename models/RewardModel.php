<?php
class RewardModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function all()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM recompensa ORDER BY custo_pontos');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'id' => $r['id_recompensa'] ?? null,
                    'name' => $r['titulo'] ?? $r['name'] ?? '',
                    'description' => $r['descricao'] ?? '',
                    'points_required' => $r['custo_pontos'] ?? 0,
                ];
            }
            return $out;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function find($id)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM recompensa WHERE id_recompensa = :id');
            $stmt->execute(['id' => $id]);
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$r) return false;
            return [
                'id' => $r['id_recompensa'],
                'name' => $r['titulo'],
                'description' => $r['descricao'],
                'points_required' => $r['custo_pontos'],
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO recompensa (titulo,descricao,custo_pontos) VALUES (:name,:description,:points_required)');
            return $stmt->execute([
                'name' => $data['name'] ?? $data['titulo'] ?? '',
                'description' => $data['description'] ?? $data['descricao'] ?? '',
                'points_required' => $data['points_required'] ?? $data['custo_pontos'] ?? 0,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        try {
            $stmt = $this->db->prepare('UPDATE recompensa SET titulo=:name,descricao=:description,custo_pontos=:points_required WHERE id_recompensa=:id');
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'] ?? $data['titulo'] ?? '',
                'description' => $data['description'] ?? $data['descricao'] ?? '',
                'points_required' => $data['points_required'] ?? $data['custo_pontos'] ?? 0,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM recompensa WHERE id_recompensa = :id');
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
