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
                'is_admin' => $row['is_admin'] ?? 0,
            ];
        } catch (PDOException $e) {
            // table might not exist yet
            return false;
        }
    }

    public function create($data)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO usuario (nome,email,senha,pontos_totais) VALUES (:name,:email,:password,:points)');
            return $stmt->execute([
                'name' => $data['name'] ?? $data['nome'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? $data['senha'] ?? '',
                'points' => $data['points'] ?? 0,
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
                'is_admin' => $row['is_admin'] ?? 0,
            ];
        } catch (PDOException $e) {
            return false;
        }
    }
}
