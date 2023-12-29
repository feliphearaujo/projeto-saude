<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    //$app = AppFactory::create();
    
    $app->get('/medico/all', function (Request $request, Response $response) {
        $sql = "SELECT * FROM medico, especialidade
                WHERE medico.idespecialidade = especialidade.idespecialidade";
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


    $app->get('/medico/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT * FROM medico WHERE idmedico = $id";
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

    $app->post('/medico', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idespecialidade = $obj->idespecialidade;
        $nome = $obj->nome;
        $crm = $obj->crm;
        $email = $obj->email;
        $senha = $obj->senha;

        $sql = "INSERT INTO medico(idespecialidade, nome, crm, email, senha)
         VALUES (?,?,?,?,?)";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$idespecialidade, $nome, $crm, $email, $senha]);
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

    $app->put('/medico', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idmedico = $obj->idmedico;
        $idespecialidade = $obj->idespecialidade;
        $nome = $obj->nome;
        $crm = $obj->crm;
        $email = $obj->email;
        $senha = $obj->senha;

        $sql = "UPDATE medico SET idespecialidade=?, nome=?, crm=?, email=?, senha=?
        WHERE idmedico=?";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$idespecialidade, $nome, $crm, $email, $senha, $idmedico]);
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

    $app->delete('/medico/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM medico WHERE idmedico=$id";
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

    $app->post('/medico/login', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $nome = $obj->nome;
        $senha = $obj->senha;

        $sql = "SELECT count(*) as quantidade, idmedico, nome FROM medico WHERE nome = ? AND senha = ? GROUP BY idmedico, nome";
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