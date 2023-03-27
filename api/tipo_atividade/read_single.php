<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';
    include_once '../../models/auth.php';


    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando tipoAtividade Object
    $tipoAtividade = new TipoAtividade($db);
    $auth = new Autenticacao($db);

    if($auth->verificaToken()){
        //Pegando o id
        $tipoAtividade->id = isset($_GET['id']) ? $_GET['id'] : die();

        //executando método
        $tipoAtividade->read_single();
        
        //Resposta
        echo json_encode(
            array(
                'id' => $tipoAtividade->id,
                'descricao' => $tipoAtividade->descricao,
            )
        );
    }
?>