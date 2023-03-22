<?php 
//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/usuario.php';

//Instaciando Banco de Dados & Conexão
$database = new Database();
$db = $database->connect();

//Instanciando usuario object
$usuario = new Usuario($db);

// usuario read consulta
$result = $usuario->read();

$var = getallheaders();
    
$header = $var["Authorization"];
$header = explode(" ", $header);
$header = $header[1];

if($header == null ){
    throw new Exception("Token inválido ou inexistente", 401);
}

else if (!empty($header)) {
    $sql = "SELECT token FROM tokens where token = :t";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':t',$header);

    if($stmt->execute()){
        //Verficando o numero de linhas
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
}

?>