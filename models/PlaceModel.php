<?php
class PlaceModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function all()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM estabelecimento ORDER BY nome');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $out = [];
            foreach ($rows as $r) {
                $out[] = [
                    'id' => $r['id_estab'] ?? $r['id'] ?? null,
                    'name' => $r['nome'] ?? $r['name'] ?? '',
                    'city' => $r['endereco'] ?? $r['city'] ?? '',
                    'state' => $r['estado'] ?? $r['state'] ?? '',
                    'description' => $r['descricao'] ?? $r['description'] ?? '',
                    'sustainability_level' => $r['sustainability_level'] ?? $r['nivel_sustentabilidade'] ?? 3,
                    'points' => $r['points'] ?? $r['pontos'] ?? $r['pontos_gerados'] ?? 0,
                    'image' => $r['image'] ?? null,
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
            $stmt = $this->db->prepare('SELECT * FROM estabelecimento WHERE id_estab = :id');
            $stmt->execute(['id' => $id]);
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$r) return false;
            return [
                'id' => $r['id_estab'],
                'name' => $r['nome'],
                'city' => $r['endereco'] ?? '',
                'state' => $r['estado'] ?? '',
                'description' => $r['descricao'] ?? '',
                'sustainability_level' => $r['sustainability_level'] ?? 3,
                'points' => $r['points'] ?? $r['pontos'] ?? 0,
                'image' => $r['image'] ?? null,
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO estabelecimento (nome,endereco,descricao,tipo) VALUES (:nome,:endereco,:descricao,:tipo)');
            return $stmt->execute([
                'nome' => $data['name'] ?? $data['nome'] ?? '',
                'endereco' => $data['city'] ?? $data['endereco'] ?? '',
                'descricao' => $data['description'] ?? $data['descricao'] ?? '',
                'tipo' => $data['tipo'] ?? 'turistico',
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        try {
            $stmt = $this->db->prepare('UPDATE estabelecimento SET nome=:nome,endereco=:endereco,descricao=:descricao WHERE id_estab=:id');
            return $stmt->execute([
                'id' => $id,
                'nome' => $data['name'] ?? $data['nome'] ?? '',
                'endereco' => $data['city'] ?? $data['endereco'] ?? '',
                'descricao' => $data['description'] ?? $data['descricao'] ?? '',
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM estabelecimento WHERE id_estab = :id');
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
