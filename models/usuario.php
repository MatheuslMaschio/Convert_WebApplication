<?php 
    //Objeto USUARIO
    class Usuario {
        //Conexao com o banco e nome
        private $conn;
        private $table_name = "usuarios";

        //Propriedades do Usuario//colunas do banco
        public $id;
        public $nome;
        public $email;
        public $senha;

        //constructor
        public function __construct($db){
            $this->conn = $db;
        }

        //lendo todos os usuários
        function read(){
            //Criando consulta
            $query = 'SELECT
            id,
            nome,
            email
            FROM usuarios';

            //Prepara envio
            $stmt = $this->conn->prepare($query);

            //Executando
            $stmt->execute();

            return $stmt;
        }

        //lendo apenas um usuário
        public function read_single(){
            // Create query
            $query = 'SELECT
            id,
            nome,
            email
            FROM
            ' . $this->table_name . '
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
            $this->nome = $row['nome'];
            $this->email = $row['email'];

        }

        //criar um novo usuario
        function create(){
            //inserindo consulta 
            $query = 'INSERT INTO ' . $this->table_name . ' SET nome = :nome, email = :email, senha = :senha';

            //preaprando consulta
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->senha=htmlspecialchars(strip_tags($this->senha));

            //Ligando valores
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            
            //Criando salt para a senha do usuario
            $salt = 'dCUrtqi@YwLK8tw';

            //Passando sha1 para a senha do usuario 
            $sha1 = sha1($this->senha);

            //juntando salt com a senha do usuario 
            $sha1_and_salt = "$sha1$salt";

            $sha1_and_salt = sha1($sha1_and_salt);

            $stmt->bindParam(':senha', $sha1_and_salt);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        //logando usuario 
        function login(){
            //fazendo a consulta 
            $query = 'SELECT id, nome, email, senha
            FROM
            ' . $this->table_name . '
            WHERE 
                email = :email AND senha = :senha';   

            //prepara consulta
            $stmt= $this->conn->prepare($query);

            //limpando dados
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->senha=htmlspecialchars(strip_tags($this->senha));

            //Ligando valores
            $stmt->bindParam(':email', $this->email);

            //Passando sha1 para a senha do usuario 
            $sha1 = sha1($this->senha);
            //Criando salt para a senha do usuario
            $salt = 'dCUrtqi@YwLK8tw';
            //juntando salt com a senha do usuario 
            $sha1_and_salt = "$sha1$salt";

            $sha1_and_salt = sha1($sha1_and_salt);

            $stmt->bindParam(':senha',  $sha1_and_salt);

            //executando a query
            $stmt->execute();        
            return $stmt;
        }

        //Atualizando o usuário
        function update(){
            // Criando Consulta
            $query = 'UPDATE ' . $this->table_name . ' SET nome = :nome, email = :email WHERE id = :id';

            // prepara conexão com o banco
            $stmt = $this->conn->prepare($query);

            //Limpando dados
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Conectando dados
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':id', $this->id);

            //Excutando
            if($stmt->execute()) {
                return true;
            }

            //Print erro se algo ruim acontecer
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Criando token
        function create_token($token, $userId){ //ajuda do rodolfo 
            //Implementamos uma consulta para procurar o id do usuario na tabela
            $sql = "SELECT id_usuario FROM tokens WHERE id_usuario = :id";
            
            $user_existe = $this->conn->prepare($sql);

            $user_existe->bindValue(':id', $userId);
            $user_existe->execute();

            //Se o usuario EXISTE na tabela ele vai executar um update do token na tabela
            if ($user_existe->fetch(PDO::FETCH_ASSOC)){
                $sql = "UPDATE tokens SET token = :t WHERE id_usuario = :id";
                $userExiste = $this->conn->prepare($sql);

                $userExiste->bindValue(':t', $token);
                $userExiste->bindValue(':id', $userId);

                $userExiste->execute();
            }else{ //Se o usuario O EXISTE ele vai inserir um token novo 
                $sql = "INSERT INTO tokens(token, id_usuario) VALUES (:t , :id)";
                $query = $this->conn->prepare($sql);

                $query->bindParam(':t', $token);
                $query->bindParam(':id', $userId);

                $query->execute();  
            }
        }

        //deletando usuario
        public function delete(){
            //criando consulta
            $query = 'DELETE FROM '. $this->table_name . ' WHERE id = :id';

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
    }
?>