<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json');

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
        //resultados da leitura do tipoAtividade
        $result = $tipoAtividade->read();

        //Verficando o numero de linha 
        $num = $result->rowCount();

        //Verificar se há algum tipo de atividade
        if($num > 0) {
            //tipo de atividade Array
            $tpA_arr = array();
            $tpA_arr ['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $tpA_item = array(
                    'id' => $row['id'],
                    'descricao' => $row['descricao'],
                );
                
                //Enviando para data
                array_push($tpA_arr['data'], $tpA_item);
            }
            //Transformando em JSON
            echo json_encode($tpA_arr);
        }
        else {
            //Se não há categorias
            echo json_encode(
                array(
                    'Status' => '202',
                    'Mensagem' => 'Não existe nenhuma tipo de atividade.'
                )
            );
        }
    }
?>