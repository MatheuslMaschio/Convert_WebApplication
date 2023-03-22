<?php
    //Headers
    header('Access-Control-Allow-Origin: * ');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: *');
    
    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';

    //Instanciando Banco de dados e conexão 
    $database = new Database();
    $db = $database->connect();

    //Instanciando objeto do usuario
    $usuario = new Usuario($db);


    if(isset($_SESSION["token"])){ //Se session TOKEN existir permite executar a consulta
        //Enviando atividade para data 
        $data = json_decode(file_get_contents("php://input"));

        //Setando o ID para delete
        $usuario->id = $data->id;

        //Deletando atividade
        if($usuario->delete()){
            echo json_encode(
                array(
                    "Status" => "200",
                    "Mensagem" => "Usuário deletado com sucesso!"
                )
            );
        } else {
            echo json_encode(
                array(
                    "Status" => "400",
                    "Mensagem" => "Usuário não foi deletado"
                )
            );
        }
    }
    else{
        echo json_encode(
            array(
                'Token' => 'Inválido ou não existente!'
            )
        );
    }
?>  

