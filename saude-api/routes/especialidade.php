<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    //$app = AppFactory::create();
    
    $app->get('/especialidade/all', function (Request $request, Response $response) {
        $sql = "SELECT * FROM especialidade";
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


    $app->get('/especialidade/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT * FROM especialidade WHERE idespecialidade = $id";
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

    $app->post('/especialidade', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $especialidade = $obj->especialidade;

        $sql = "INSERT INTO especialidade(especialidade) VALUES (?)";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$especialidade]);
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

    $app->put('/especialidade', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $especialidade = $obj->especialidade;
        $idespecialidade = $obj->idespecialidade;

        $sql = "UPDATE especialidade SET especialidade=? WHERE idespecialidade=?";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$especialidade, $idespecialidade]);
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

    $app->delete('/especialidade/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM especialidade WHERE idespecialidade=$id";
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