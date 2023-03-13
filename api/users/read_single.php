<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando usuario object
    $usuario = new Usuario($db);

    //GET ID
    $usuario->id = isset($_GET['id']) ? $_GET['id'] : die();

    //GET post
    $usuario->read_single();

    //Create array
    $at_arr = array();
    $at_arr ['data'] = array();
    
    $at_arr = array(
        'id' => $usuario->id,
        'nome' => $usuario->nome,
        'email' => $usuario->email,
    );

    //JSON
    print_r(json_encode($at_arr));
?>