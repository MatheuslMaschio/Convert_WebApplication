<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: PUT');

    header('Content-Type: application/json; charset=utf-8');

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

        //Setando o ID para Update
        $atividade->id = $data->id;

        $atividade->tipo = $data->tipo;
        $atividade->descricao = $data->descricao;
        $atividade->status = $data->status;
        
        //Atualizando atividade
        if($atividade->update()) {
            //resposta
            echo json_encode(
                array(
                    'Status' => '200',
                    'Mensagem' => 'Atividade Atualizada com sucesso!'
                )
            );
            
        } else {
            echo json_encode(
                array(
                    'Status' => '400',
                    'Mensagem' => 'Atividade Não foi Atualizada!'
                )
            );
        }
    }

    
?>