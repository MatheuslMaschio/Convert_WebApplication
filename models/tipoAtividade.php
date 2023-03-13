<?php
    class TipoAtividade{
        //banco de dados Stuff
        private $conn;
        private $table = "tipoatividade";

        //Propriedades
        public $id;
        public $descricao;
        
        //Constrututor DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get tipo de atividade
        public function read(){
            //criando consulta
            $query = 'SELECT
            id,
            descricao
            FROM '. $this->table;

            //prepara o envio
            $stmt = $this->conn->prepare($query);

            //Executando
            $stmt->execute();

            return $stmt;
        }
        
        public function read_single(){
            // Create query
            $query = 'SELECT
            id,
            descricao
            FROM
            ' . $this->table . '
            WHERE id = ?
            LIMIT 0,1';
        
            //Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind ID
            $stmt->bindParam(1, $this->id);
    
            // Execute query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // set properties
            $this->id = $row['id'];
            $this->descricao = $row['descricao'];
        }

        // Criando Atividade
        public function create(){
            // Criando Consulta
            $query = 'INSERT INTO ' . $this->table . ' SET  descricao = :descricao';

            // prepara
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->descricao = htmlspecialchars(strip_tags($this->descricao));
            
            //Ligando dados
            $stmt->bindParam(':descricao', $this->descricao);

            //Excutando
            if($stmt->execute()) {
                return true;
            }

            //Print erro se algo ruim acontecer
            var_dump("Error: %s.\n", $stmt->error);

            return false;
        }

        // Atualizando Post
        public function update(){
            // Criando Consulta
            $query = 'UPDATE ' . $this->table . ' SET descricao = :descricao WHERE id = :id';

            // prepara
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->descricao = htmlspecialchars(strip_tags($this->descricao));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Conectando dados
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':id', $this->id);

            //Excutando
            if($stmt->execute()) {
                return true;
            }

            //Print erro se algo ruim acontecer
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //deletando atividade
        public function delete(){
            //criando consulta
            $query = 'DELETE FROM '. $this->table . ' WHERE id = :id';

            //Prepara envio
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Conectando dados
            $stmt->bindParam(':id', $this->id);

            //Excutando
            if($stmt->execute()) {
                return true;
            }

            //Print erro se algo ruim acontecer
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function enviandoForm($descricao){
            //criando consulta
            $query = 'INSERT INTO ' . $this->table . ' SET  descricao = :descricao';
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':descricao', $descricao);
            
            if($stmt->execute()){
                return true;
            }
        }
    }
?>