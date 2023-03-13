<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Max-Age: 86400');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $tipoAtividade = new tipoAtividade($db);

    //get raw enviando para data
    $data = json_decode(file_get_contents("php://input"));

    $tipoAtividade->descricao = $data->descricao;
    

    //Criando Tipo de Atividade

    if($tipoAtividade->create()) {
        echo json_encode(
            array('message' => 'Atividade Criado com sucesso!')
        );
    } else {
        echo json_encode(
            array('message' => 'Atividade Não  foi Criada')
        );
    }