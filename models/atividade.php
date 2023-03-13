<?php
    class Atividade {
        //Banco de dados Stuff 
        private $conn;
        private $table = "atividade";

        //colunas
        public $id;
        public $datahora;
        public $tipo;
        public $descricao;
        public $status;

        //Constrututor DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Atividades
        public function read() {
            //Criando consulta
            $query = 'SELECT
            atividade.id,
            atividade.datahora,
            tipoatividade.descricao as tipo,
            atividade.descricao,
            atividade.status
            FROM atividade INNER JOIN tipoatividade ON atividade.tipo=tipoatividade.id';

            //Prepara envio
            $stmt = $this->conn->prepare($query);

            //Executando
            $stmt->execute();

            return $stmt;
        }

        public function read_single(){
            // Criando consulta
            $query = 'SELECT
            atividade.id,
            atividade.datahora,
            tipoatividade.descricao as tipo,
            atividade.descricao,
            atividade.status
            FROM
            atividade INNER JOIN tipoatividade ON atividade.tipo=tipoatividade.id
            WHERE atividade.id = ?
            LIMIT 0,1';
        
            //fazendo conexão com o banco 
            $stmt = $this->conn->prepare($query);
    
            // Bindando o ID
            $stmt->bindParam(1, $this->id);
    
            // Execute query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // setando propriedades
            $this->id = $row['id'];
            $this->datahora = $row['datahora'];
            $this->tipo = $row['tipo'];
            $this->descricao = $row['descricao'];
            $this->status = $row['status'];
        }

        // Criando Atividade
        public function create(){
            // Criando Consulta
            $query = 'INSERT INTO ' . $this->table . ' SET tipo = :tipo, descricao = :descricao, status = :status';

            // prepara
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->tipo = htmlspecialchars(strip_tags($this->tipo));
            $this->descricao = htmlspecialchars(strip_tags($this->descricao));
            $this->status = htmlspecialchars(strip_tags($this->status));
            
            //Ligando dados
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':status', $this->status);

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
            $query = 'UPDATE ' . $this->table . ' SET tipo = :tipo, descricao = :descricao, status = :status WHERE id = :id';

            // prepara conexão com o banco
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->tipo = htmlspecialchars(strip_tags($this->tipo));
            $this->descricao = htmlspecialchars(strip_tags($this->descricao));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->id = htmlspecialchars(strip_tags($this->id));

        

            //Conectando dados
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':status', $this->status);
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

        public function getTipos(){
            $query = "SELECT * FROM tipoatividade"; //preparando consulta
            $stmt = $this->conn->query($query); //Método
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

        public function enviandoForm($descricao, $tipo, $status){
            //criando consulta
            $query = 'INSERT INTO ' . $this->table . ' SET  descricao = :descricao, tipo = :tipo, status = :status';

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->bindValue(':status', $status);
            
            if($stmt->execute()){
                return true;
            }
        }
    }
?>

