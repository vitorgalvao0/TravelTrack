<?php

class Database
{
    private $host = "localhost";
    private $port = "3306";
    private $dbName = "traveltrack";
    private $user = "root";
    private $password = "";

    public function conectar()
    {
        $url = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName;charset=utf8mb4";
        try {
            $conn = new PDO($url, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $conn;
        } catch (PDOException $e) {
            // lançar exceção para ser capturada pelos callers
            throw new Exception('Falha ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }
}
?>
