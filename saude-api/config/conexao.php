<?php
header("Access-Control-Allow-Origin: *"); // Permite solicitações de qualquer origem
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Cabeçalhos permitidos

class Conexao{
    private static $dbName = "banco_saude";
    private static $dbHost = "localhost";
    private static $dbUser = "root";
    private static $dbPass = "root";
    private static $con = null;

    public static function conectar(){
        if(self::$con == null){
            try{
                self::$con = new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbName, 
self::$dbUser, self::$dbPass);
                self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $exception){
                die($exception->getMessage());
            }
        }
        return self::$con;
    }//fim do conectar

    public static function desconectar(){
        self::$con = null;
    }//fim do desconectar
}//fim da classe