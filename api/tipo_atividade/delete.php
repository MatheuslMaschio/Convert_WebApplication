<?php
    //Headers
    header('Access-Control-Allow-Origin: * ');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: *');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando Atividade object
    $tipoAtividade = new tipoAtividade($db);

    //Obtém os dados enviados
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $tipoAtividade->id = $data->id;

    //Deletando Atividade
    if($tipoAtividade->delete()) {
        echo json_encode(
            array(
                "Status" => "200",
                'Mensagem' => 'Atividade Deletada com sucesso!'
            )
        );
    } else {
        echo json_encode(
            array(
                "Status" => "400",
                'Mensagem' => 'Atividade Não foi Deletada!'
            )
        );
    }
?>
