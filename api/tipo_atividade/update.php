<?php
    //Headers
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Acces-Control-Allow-Headers: *');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $tipoAtividade = new tipoAtividade($db);

    //get raw atividadeed data
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $tipoAtividade->id = $data->id;
    $tipoAtividade->descricao = $data->descricao;

    //Atualizando atividade
    if($tipoAtividade->update()) {
        echo json_encode(
            array('message' => 'Tipo de atividade Atualizada com sucesso!')
        );
    } else {
        echo json_encode(
            array('message' => 'Tipo de atividade Não foi Atualizada!')
        );
    }