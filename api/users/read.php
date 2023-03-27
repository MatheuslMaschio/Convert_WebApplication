<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json');

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
        // usuario read consulta
        $result = $usuario->read();

        //Verficando o numero de linha 
        $num = $result->rowCount();

        //Verificar se há alguma usuario
        if($num > 0) {
            //usuario Array
            $user_arr = array();
            $user_arr ['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $user_item = array(
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'email' => $row['email'],
                );
                //Enviando para data
                array_push($user_arr['data'], $user_item);
            }
            //Transformando em JSON
            echo json_encode($user_arr);
        } else {
            //Se não há usuários
            echo json_encode(
                array(
                    'Status' => '203',
                    'Mensagem' => 'Não existe usuários'
                )
            );    
        }   
    }


?>