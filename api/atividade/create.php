<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Max-Age: 86400');

    include_once '../../config/Database.php';
    include_once '../../models/atividade.php';
    include_once '../../models/auth.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $atividade = new Atividade($db);
    $auth = new Autenticacao($db);

    if($auth->verificaToken()){
        //Obtém os dados enviados
        $data = json_decode(file_get_contents("php://input"));

        $atividade->tipo = $data->tipo;
        $atividade->descricao = $data->descricao;
        $atividade->status = $data->status;

        if(!empty($atividade->tipo) && !empty($atividade->descricao) && !empty($atividade->status) && $atividade->create()) {
            echo json_encode(
                array(
                    "Status" => "200",
                    "Mensagem" => "Atividade criada com sucesso",
                )
            );
        }
        else{
            echo json_encode(
                array(
                    "Status" => "400",
                    "Mensagem" => "Não foi possível criar atividade"
                )
            );
        }
    }
?>