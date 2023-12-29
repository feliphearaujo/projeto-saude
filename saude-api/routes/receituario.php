<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    //$app = AppFactory::create();
    
    $app->get('/receituario/all', function (Request $request, Response $response) {
        $sql = "SELECT * FROM receituario";
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


    $app->get('/receituario/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT * FROM receituario WHERE idreceituario = $id";
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

    $app->post('/receituario', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $descricao = $obj->descricao;
        $idconsulta = $obj->idconsulta;
       
        $sql = "INSERT INTO receituario(descricao, idconsulta) VALUES (?, ?)";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$descricao, $idconsulta]);
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

    $app->put('/receituario', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idreceituario = $obj->idreceituario;
        $descricao = $obj->descricao;
        $idconsulta = $obj->idconsulta;

        $sql = "UPDATE receituario SET descricao=?, idconsulta=? WHERE idreceituario=?";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$descricao, $idconsulta, $idreceituario]);
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

    $app->delete('/receituario/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM receituario WHERE idreceituario=$id";
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