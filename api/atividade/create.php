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

    //get raw enviando para data
    $data = json_decode(file_get_contents("php://input"));

    $atividade->tipo = $data->tipo;
    $atividade->descricao = $data->descricao;
    $atividade->status = $data->status;

    //Criando Atividade
    if($atividade->create()) {
        

        echo json_encode(
            array('message' => 'Atividade Criado com sucesso!')
        );
    } else {
        echo json_encode(
            array('message' => 'Atividade Não  foi Criada')
        );
    }
?>