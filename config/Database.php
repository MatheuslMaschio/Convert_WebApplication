<?php 

    //Classe do Banco de dados
    class Database {
    // Parametros do Banco de Dados
    private $host = 'localhost'; //servidor
    private $db_name = 'convert_api'; //nome do banco de dados
    private $username = 'root'; //usuario do phpmyadmin
    private $password = ''; //senha do usuario
    private $conn;

    // Conexão com o Banco
    public function connect() {
        $this->conn = null; 
    
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name",
            $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERRO DE CONEXAO: '. $e->getMessage();
        }

        return $this->conn;
    }
}
?>