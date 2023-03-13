<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: PUT');

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/atividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $atividade = new Atividade($db);

    //get raw atividadeed data
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $atividade->id = $data->id;

    $atividade->tipo = $data->tipo;
    $atividade->descricao = $data->descricao;
    $atividade->status = $data->status;

    

    //Atualizando atividade
    if($atividade->update()) {
        echo json_encode(
            array('message' => 'atividade Atualizado com sucesso!')
        );
    } else {
        echo json_encode(
            array('message' => 'atividade Não foi Atualizado!')
        );
    }
?>