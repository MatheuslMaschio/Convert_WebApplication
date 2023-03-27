<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/atividade.php';
    include_once '../../models/auth.php';


    //Instaciando Banco de Dados & Conexão
    $database = new Database();
    $db = $database->connect();

    //Instanciando atividade object
    $atividade= new Atividade($db);
    $auth = new Autenticacao($db);

    if($auth->verificaToken()){
        // atividade read consulta
        $result = $atividade->read();

        //Verficando o numero de linha 
        $num = $result->rowCount();
        
        //Verificar se há alguma atividade
        if($num > 0) {
            //atividade Array
            $at_arr = array();
            $at_arr ['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $at_item = array(
                    'id' => $row['id'],
                    'datahora' => $row['datahora'],
                    'tipo' => $row['tipo'],
                    'descricao' => $row['descricao'],
                    'status' => $row['status'],
                );
                //Enviando para data
                array_push($at_arr['data'], $at_item);
            }
            //Transformando em JSON
            echo json_encode($at_arr);
        }
        else {
            //Se não há atividade
            echo json_encode(array(
                'Status' => '202',
                'Mensagem' => 'Não existe nenhuma atividade.'
                )
            );
        }
    }
?>