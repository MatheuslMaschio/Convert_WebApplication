<?php 
    class Autenticacao {
        private $conn;

        //Constrututor DB
        public function __construct($db) {
        $this->conn = $db;
        }


        public function verificaToken(){
            $var = getallheaders(); //pegando todos os headers usando uma função original do php

            try{
                if(empty($var['Authorization'])){
                    throw new Exception('token inválido ou inexistente'); //criando exception
                }
                $header = $var["Authorization"]; //pegando o header authorization passado do client para o back end  
                $header = explode(" ", $header); //explode para pegar só o token
                $header = $header[1]; //só o token sem o bearer 
    
                if($header == null){
                    throw new Exception("Token inválido ou inexistente", 401); //criando exception
                }
                else{ //verificando se o token existe no banco de dados
                    $sql = "SELECT token FROM tokens where token = :t";
            
                    $stmt = $this->conn->prepare($sql); 
            
                    $stmt->bindParam(':t',$header);
    
                    $stmt->execute();

                    return true;
                }
            }
            catch (Exception $e){
                echo json_encode(['Mensagem' => $e->getMessage()]);
            } 
        }
    }