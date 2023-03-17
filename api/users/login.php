<?php 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: *');
    
    //Arquivos necessários para conectar com o banco de dados
    include_once '../../config/Database.php';
    include_once '../../models/usuario.php';

    //obtem conexao com o banco de dados
    $database = new Database();

    $db = $database->connect();

    //Instanciando objeto Usuario
    $usuario = new Usuario($db);

    //Obtém os dados enviados
    $data = json_decode(file_get_contents(("php://input")));

    //Definindo os valores
    $usuario->email = $data->email;
    $usuario->senha = $data->senha;

    $result = $usuario->login();
    
    if($result->rowCount() > 0){
        
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        //JWT é divido em três partes separadas por ponto "." um header, um payload e um signature

        //Header indica o tipo do token "JWT", e o algoritmo utilizado "HS256"
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = json_encode($header);

        /**codficando em base64 -> alg de codificação que permite transformar qlqr caracter em um alfabeto 
         * constituido por 64 caracteres [A-Z a-z 0-9 "/" e "+"]  
        */
        $header = base64_encode($header);

        /**payload é o corpo do jwt.
            iss - o dominio da aplicação que gera o token
            aud - define o dominio que pode usar o token
            exp - data de vencimento do token 
        */
        $duracao =  (time() -10800) + (60 * 30);

        $payload = [
            'exp' => $duracao,
            'id' => $row['id'],
            'nome' => $row['nome'],
            'email' => $row['email']
        ];

        //Converter o array em objeto
        $payload = json_encode($payload);

        //codificando em base64
        $payload = base64_encode($payload);

        //O signature é a assinatura. 
        //chave secreta unica
        $chave = "DGBU85S46H9M5W4X60D7";

        //Pegar o header e o payload e codificar com o algoritmo sha256, junto com a chave */
        /**Gera um valor de HASH com chave usando o método HMAC -> combina uma chave secreta com os dados da mensagem,
        faz hashes do resultado com a função de hash, mistura esse valor de hash com a chave secreta novamente e aplica a função de hash uma segunda vez */
        $signature = hash_hmac('sha256', "$header.$payload", $chave, true);

        //Codificar dados em base64
        $signature = base64_encode($signature);

        $salt = 'dCUrtqi@YwLK8tw';

        $token = "$header.$payload.$signature.$salt";

        setcookie ('token', $token, ((time() -10800) + (60 * 30)));

        http_response_code(200);

        $usuario_arr = array(
            "status" => '200',
            "mensagem" => "Login feito com sucesso",
            'id' => $row['id'],
            'nome' => $row['nome'],
            'email' => $row['email'],
            'token' => $token
        );

        //Salvando o token
        $userId = $row['id'];

        $usuario->create_token($token, $userId);
        
    }
    else{   
        //http_response_code(403); -> tive problema de cors ver com o bruno 
        $usuario_arr = array(
            "Status" => '403',
            "Mensagem" => "Inválido usuário ou senha!",
        );
        
    }

    print_r(json_encode($usuario_arr));
?>