<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: PUT');

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';
    include_once '../../models/auth.php';


    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $tipoAtividade = new tipoAtividade($db);
    $auth = new Autenticacao($db);

    if($auth->verificaToken()){
        //Obtém os dados enviados
        $data = json_decode(file_get_contents("php://input"));

        //Setando o ID para Update
        $tipoAtividade->id = $data->id;
        $tipoAtividade->descricao = $data->descricao;

        //Atualizando atividade
        if(!empty($tipoAtividade->descricao) && $tipoAtividade->update()) {
            echo json_encode(
                array(
                    'Status' => '200',
                    'Mensagem' => 'Tipo de atividade Atualizada com sucesso!'
                )
            );
        } else {
            echo json_encode(
                array(
                    'Status' => '400',
                    'Mensagem' => 'Tipo de atividade Não foi Atualizada!'
                )
            );
        }
    }
?>