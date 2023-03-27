<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';
    include_once '../../models/auth.php';


    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando usuario object
    $usuario = new Usuario($db);
    $auth = new Autenticacao($db);

    if($auth->verificaToken()){
        //pegando o id 
        $usuario->id = isset($_GET['id']) ? $_GET['id'] : die();

        //executando método 
        $usuario->read_single();

        //Criando array
        $user_arr = array();
        $user_arr ['data'] = array();
        
        $user_arr = array(
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'email' => $usuario->email,
        );

        //JSON
        print_r(json_encode($user_arr));
    }
?>