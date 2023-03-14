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

    //Obtém os dados enviados
    $data = json_decode(file_get_contents("php://input"));

    //definindo os valores 
    $tipoAtividade->descricao = $data->descricao;
    

    //Criando Tipo de Atividade
    if(!empty($tipoAtividade->descricao)){
        if($tipoAtividade->create()) {
            //resposta
            echo json_encode(
                array(
                    "Status" => "200",
                    'Mensagem' => 'Tipo de Atividade Criada com sucesso!'
                )
            );
        }
        else{
            echo json_encode(
                array(
                    "Status" => "400",
                    "Mensagem" => "Não foi possível criar Tipo de Atividade"
                )
            );
        }
    }
?>