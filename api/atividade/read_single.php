<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    header('Content-Type: application/json; charset=utf-8');

    include_once '../../config/Database.php';
    include_once '../../models/atividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $atividade = new Atividade($db);

    //GET ID
    $atividade->id = isset($_GET['id']) ? $_GET['id'] : die();

    //GET post
    $atividade->read_single();

    //Create array
    $at_arr = array();
    $at_arr ['data'] = array();
    
    $at_arr = array(
        'id' => $atividade->id,
        'datahora' => $atividade->datahora,
        'tipo' => $atividade->tipo,
        'descricao' => $atividade->descricao,
        'status' => $atividade->status
    );

    //JSON
    print_r(json_encode($at_arr));
?>