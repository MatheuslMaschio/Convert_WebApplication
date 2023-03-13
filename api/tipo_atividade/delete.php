<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Acces-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando Atividade object
    $tipoAtividade = new tipoAtividade($db);

    //Enviando atividade para data 
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $tipoAtividade->id = $data->id;

    //Deletando Atividade
    if($tipoAtividade->delete()) {
        echo json_encode(
            array('message' => 'Atividade Deletada com sucesso!')
        );
    } else {
        echo json_encode(
            array('message' => 'Atividade Não foi Deletada!')
        );
    }
?>
