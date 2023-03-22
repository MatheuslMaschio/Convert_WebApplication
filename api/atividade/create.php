<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Max-Age: 86400');

    include_once '../../config/Database.php';
    include_once '../../models/atividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $atividade = new Atividade($db);

    //Obtém os dados enviados
    $data = json_decode(file_get_contents("php://input"));

    $atividade->tipo = $data->tipo;
    $atividade->descricao = $data->descricao;
    $atividade->status = $data->status;

    if(
        !empty($atividade->tipo) &&
        !empty($atividade->descricao) &&
        !empty($atividade->status) &&
        $atividade->create()
    ){
        $header = $var["Authorization"];
        $header = explode(" ", $header);
        $header = $header[1];

        if($header == null){
            throw new Exception("Token inválido ou inexistente", 401);
        }
        else if(!empty($header)){

            $sql = "SELECT token FROM tokens where token = :t";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':t',$header);

            if($stmt->execute()){
                
            }

        }




        
    }
    else{
        echo json_encode(
            array(
                "Status" => "400",
                "Mensagem" => "Não foi possível criar atividade"
            )
        );
    }
?>