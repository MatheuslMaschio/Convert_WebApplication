<?php 
    //Headers 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $user = new Usuario($db);

    //get raw enviando para data
    $data = json_decode(file_get_contents("php://input"));

    $user->nome = $data->nome;
    $user->email = $data->email;
    $user->senha = $data->senha;

    if(
        !empty($user->nome) &&
        !empty($user->email) &&
        !empty($user->senha) &&
        $user->create()
    ){
        //resposta 
        http_response_code(200);
        echo json_encode(
            array(
            "status" => "Sucesso",
            "mensagem" => "Usuário criado com sucesso."
        ));
    }
    else{
        //http_response_code(400);
        //resposta
        echo json_encode(
            array(
                "Status" => "400",
                "mensagem" => "Não foi possível criar usuário"
            )
        );
    }
?>