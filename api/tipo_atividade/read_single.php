<?php
    //Headers
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/tipoAtividade.php';

    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando tipoAtividade Object
    $tipoAtividade = new TipoAtividade($db);

    //Pegando o id
    $tipoAtividade->id = isset($_GET['id']) ? $_GET['id'] : die();

    //executando método
    $tipoAtividade->read_single();

    //Criando array
    $tpA_arr = array(
        'id' => $tipoAtividade->id,
        'descricao' => $tipoAtividade->descricao,
    );

    //JSON
    print_r(json_encode($tpA_arr));
?>