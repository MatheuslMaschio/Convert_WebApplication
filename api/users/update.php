<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Methods: *');

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $usuario = new Usuario($db);

    //Obtém os dados enviados
    $data = json_decode(file_get_contents("php://input"));

    //Setando o ID para Update
    $usuario->id = $data->id;

    $usuario->nome = $data->nome;
    $usuario->email = $data->email;

    //Atualizando usuario
    if($usuario->update()) {
        echo json_encode(
            array(
                'Status' => '200',
                'Mensagem' => 'Usuário Atualizado com sucesso!'
            )
        );
    } 
    else{
        echo json_encode(
            array(
                'Status' => '400',
                'Mensagem' => 'Usuário Não foi Atualizado!'
            )
        );
    }
?>