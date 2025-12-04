<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function findByEmail($email)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM usuario WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;
            return [
                'id' => $row['id_usuario'],
                'name' => $row['nome'],
                'email' => $row['email'],
                'password' => $row['senha'],
                'points' => $row['pontos_totais'] ?? 0,
                'is_admin' => $row['is_admin'] ?? ($row['tipo_acesso'] === 'ADM' ? 1 : 0),
                'logradouro' => $row['logradouro'] ?? '',
                'numero_casa' => $row['numero_casa'] ?? null,
                'city' => $row['cidade'] ?? '',
                'state' => $row['uf'] ?? '',
                'cep' => $row['cep'] ?? '',
                'tipo_acesso' => $row['tipo_acesso'] ?? null,
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO usuario (nome,email,senha,pontos_totais,logradouro,numero_casa,cidade,uf,cep,tipo_acesso) VALUES (:name,:email,:password,:points,:logradouro,:numero_casa,:cidade,:uf,:cep,:tipo_acesso)');
            return $stmt->execute([
                'name' => $data['name'] ?? $data['nome'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? $data['senha'] ?? '',
                'points' => $data['points'] ?? 0,
                'logradouro' => $data['logradouro'] ?? $data['logradouro'] ?? '',
                'numero_casa' => $data['numero_casa'] ?? $data['numero'] ?? null,
                'cidade' => $data['city'] ?? $data['cidade'] ?? '',
                'uf' => $data['state'] ?? $data['uf'] ?? '',
                'cep' => $data['cep'] ?? '',
                'tipo_acesso' => $data['tipo_acesso'] ?? ($data['is_admin'] ? 'ADM' : 'USER'),
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findById($id)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM usuario WHERE id_usuario = :id');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;
            return [
                'id' => $row['id_usuario'],
                'name' => $row['nome'],
                'email' => $row['email'],
                'password' => $row['senha'],
                'points' => $row['pontos_totais'] ?? 0,
                'is_admin' => $row['is_admin'] ?? ($row['tipo_acesso'] === 'ADM' ? 1 : 0),
                'logradouro' => $row['logradouro'] ?? '',
                'numero_casa' => $row['numero_casa'] ?? null,
                'city' => $row['cidade'] ?? '',
                'state' => $row['uf'] ?? '',
                'cep' => $row['cep'] ?? '',
                'tipo_acesso' => $row['tipo_acesso'] ?? null,
            ];
        } catch (PDOException $e) {
            return false;
        }
    }
}
