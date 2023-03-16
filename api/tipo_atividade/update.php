<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: PUT');

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $tipoAtividade = new tipoAtividade($db);

    //Obtém os dados enviados
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $tipoAtividade->id = $data->id;
    $tipoAtividade->descricao = $data->descricao;

    //Atualizando atividade
    if($tipoAtividade->update()) {
        echo json_encode(
            array('Mensagem' => 'Tipo de atividade Atualizada com sucesso!')
        );
    } else {
        echo json_encode(
            array('Mensagem' => 'Tipo de atividade Não foi Atualizada!')
        );
    }
?>