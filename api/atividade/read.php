<?php 
//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/atividade.php';

//Instaciando Banco de Dados & Conexão
$database = new Database();
$db = $database->connect();

//Instanciando atividade object
$atividade= new Atividade($db);

// atividade read consulta
$result = $atividade->read();

$var = getallheaders();
    
$header = $var["Authorization"];
$header = explode(" ", $header);
$header = $header[1];

if($header == null){
    throw new Exception("Token inválido ou inexistente", 401);
}

else if (!empty($header)) {

    $sql = "SELECT token FROM tokens where token = :t";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':t',$header);

    if($stmt->execute()){
        //Verficando o numero de linhas
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
    } else {
        //Se não há atividade
        echo json_encode(array(
            'Status' => '202',
            'Mensagem' => 'Não existe nenhuma atividade.'
            )
        );
        
    }
}
    
?>