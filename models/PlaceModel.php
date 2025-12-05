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
                    'logradouro' => $r['logradouro'] ?? $r['endereco'] ?? '',
                    'numero_casa' => $r['numero_casa'] ?? $r['numero'] ?? null,
                    'city' => $r['cidade'] ?? $r['endereco'] ?? '',
                    'state' => $r['uf'] ?? $r['estado'] ?? '',
                    'description' => $r['descricao'] ?? $r['description'] ?? '',
                    'sustentabilidade' => $r['sustentabilidade'] ?? $r['nivel_sustentabilidade'] ?? 3,
                    'points' => $r['pontos_base'] ?? $r['points'] ?? $r['pontos'] ?? 0,
                    'imagem' => $r['imagem'] ?? $r['image'] ?? null,
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
                'logradouro' => $r['logradouro'] ?? $r['endereco'] ?? '',
                'numero_casa' => $r['numero_casa'] ?? $r['numero'] ?? null,
                'city' => $r['cidade'] ?? $r['endereco'] ?? '',
                'state' => $r['uf'] ?? $r['estado'] ?? '',
                'description' => $r['descricao'] ?? $r['description'] ?? '',
                'sustentabilidade' => $r['sustentabilidade'] ?? 3,
                'points' => $r['pontos_base'] ?? $r['points'] ?? $r['pontos'] ?? 0,
                'imagem' => $r['imagem'] ?? $r['image'] ?? null,
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO estabelecimento (nome,logradouro,numero_casa,cidade,uf,cep,descricao,tipo,pontos_base,sustentabilidade) VALUES (:nome,:logradouro,:numero_casa,:cidade,:uf,:cep,:descricao,:tipo,:pontos_base,:sustentabilidade)');
            $ok = $stmt->execute([
                'nome' => $data['name'] ?? $data['nome'] ?? '',
                'logradouro' => $data['logradouro'] ?? $data['endereco'] ?? '',
                'numero_casa' => $data['numero_casa'] ?? $data['numero'] ?? null,
                'cidade' => $data['city'] ?? $data['cidade'] ?? '',
                'uf' => $data['state'] ?? $data['uf'] ?? '',
                'cep' => $data['cep'] ?? '',
                'descricao' => $data['description'] ?? $data['descricao'] ?? '',
                'tipo' => $data['tipo'] ?? 'turistico',
                'pontos_base' => $data['points'] ?? $data['pontos_base'] ?? $data['pontos'] ?? 0,
                'sustentabilidade' => isset($data['sustentabilidade']) ? (int)$data['sustentabilidade'] : 3,
            ]);
            if ($ok) return $this->db->lastInsertId();
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        try {
            $stmt = $this->db->prepare('UPDATE estabelecimento SET nome=:nome,logradouro=:logradouro,numero_casa=:numero_casa,cidade=:cidade,uf=:uf,cep=:cep,descricao=:descricao,pontos_base=:pontos_base,sustentabilidade=:sustentabilidade WHERE id_estab=:id');
            return $stmt->execute([
                'id' => $id,
                'nome' => $data['name'] ?? $data['nome'] ?? '',
                'logradouro' => $data['logradouro'] ?? $data['endereco'] ?? '',
                'numero_casa' => $data['numero_casa'] ?? $data['numero'] ?? null,
                'cidade' => $data['city'] ?? $data['cidade'] ?? '',
                'uf' => $data['state'] ?? $data['uf'] ?? '',
                'cep' => $data['cep'] ?? '',
                'descricao' => $data['description'] ?? $data['descricao'] ?? '',
                'pontos_base' => $data['points'] ?? $data['pontos_base'] ?? 0,
                'sustentabilidade' => isset($data['sustentabilidade']) ? (int)$data['sustentabilidade'] : 3,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setImage($id, $filename)
    {
        try {
            $stmt = $this->db->prepare('UPDATE estabelecimento SET imagem = :imagem WHERE id_estab = :id');
            return $stmt->execute(['imagem' => $filename, 'id' => $id]);
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
