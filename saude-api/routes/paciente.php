<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    //$app = AppFactory::create();
    
    $app->get('/paciente/all', function (Request $request, Response $response) {
        $sql = "SELECT * FROM paciente";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $db->desconectar();
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });


    $app->get('/paciente/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT * FROM paciente WHERE idpaciente = $id";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->query($sql);
            $result = $query->fetch(PDO::FETCH_OBJ);
            $db->desconectar();
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->post('/paciente', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $nome = $obj->nome;
        $cpf = $obj->cpf;
        $telefone = $obj->telefone;
        $email = $obj->email;
        $senha = $obj->senha;
        $particular = $obj->particular;

        $sql = "INSERT INTO paciente(nome, cpf, telefone, email, senha, particular) VALUES (?,?,?,?,?,?)";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$nome, $cpf, $telefone, $email, $senha, $particular]);
            $db->desconectar();
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->put('/paciente', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idpaciente = $obj->idpaciente;
        $nome = $obj->nome;
        $cpf = $obj->cpf;
        $telefone = $obj->telefone;
        $email = $obj->email;
        $senha = $obj->senha;
        $particular = $obj->particular;

        $sql = "UPDATE paciente SET nome=?, cpf=?, telefone=?, email=?, senha=?, 
        particular=? WHERE idpaciente=?";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$nome, $cpf, $telefone, $email, $senha, $particular, $idpaciente]);
            $db->desconectar();
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->delete('/paciente/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM paciente WHERE idpaciente=$id";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute();
            $db->desconectar();
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->post('/paciente/login', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $nome = $obj->nome;
        $senha = $obj->senha;

        $sql = "SELECT count(*) as quantidade, idpaciente, nome FROM paciente WHERE nome = ? AND senha = ? GROUP BY idpaciente";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$nome, $senha]);
            $db->desconectar();
            $response->getBody()->write(json_encode($query->fetch(PDO::FETCH_OBJ)));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        }catch(PDOException $e){
            $error = array("message"=> $e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });