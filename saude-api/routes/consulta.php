<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    //$app = AppFactory::create();
    
    $app->get('/consulta/all', function (Request $request, Response $response) {
        $sql = "SELECT * FROM consulta";
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


    $app->get('/consulta/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT * FROM consulta WHERE idconsulta = $id";
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

    $app->get('/consulta/medico/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT c.*, p.nome 
                FROM consulta as c 
                JOIN paciente as p ON c.idpaciente = p.idpaciente
                WHERE c.idmedico = $id";
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

    $app->get('/consulta/paciente/{id}', function (Request $request, Response $response, array $args) {
        $id = $args["id"];
        $sql = "SELECT c.*, m.nome 
            FROM consulta as c 
            JOIN medico as m ON c.idmedico = m.idmedico
            WHERE c.idpaciente = $id";
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

    $app->post('/consulta', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idpaciente = $obj->idpaciente;
        $idmedico = $obj->idmedico;
        $data = $obj->data;
        $hora = $obj->hora;
        $finalizada = $obj->finalizada;
        $observacao = $obj->observacao;

        $sql = "INSERT INTO consulta(idpaciente, idmedico, data, hora, finalizada, observacao) VALUES (?,?,?,?,?,?)";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$idpaciente, $idmedico, $data, $hora, $finalizada, $observacao]);
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

    $app->put('/consulta', function (Request $request, Response $response, array $args) {
        $data = $request->getBody();
        $obj = json_decode($data);
        $idpaciente = $obj->idpaciente;
        $idmedico = $obj->idmedico;
        $data = $obj->data;
        $hora = $obj->hora;
        $finalizada = $obj->finalizada;
        $observacao = $obj->observacao;
        $idconsulta = $obj->idconsulta;

        $sql = "UPDATE consulta SET idpaciente=?, idmedico=?, data=?, hora=?, finalizada=?, observacao=?
        WHERE idconsulta=?";
        try {
            $db = new Conexao();
            $conn = $db->conectar();
            $query = $conn->prepare($sql);
            $result = $query->execute([$idpaciente, $idmedico, $data, $hora, $finalizada, $observacao, $idconsulta]);
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

    $app->delete('/consulta/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $sql = "DELETE FROM consulta WHERE idconsulta=$id";
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