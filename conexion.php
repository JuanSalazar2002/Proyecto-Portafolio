<?php

class conexion{
    private $servidor= "localhost";
    private $usuario= "juan";
    private $password= "admin123";
    private $conexion;

    public function __construct(){
        try{
            $this->conexion= new PDO("mysql:host=$this->servidor;dbname=album", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            return "falla de conexion ".$e;
        }
    }

    public function ejecutar($sql){ // esta funcion no recupera nada
        $this->conexion->exec($sql);
        return $this->conexion->lastInsertId();
    }

    public function consultar($sql){
        $sentencia= $this->conexion->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(); // fecthAll retorna todos los datos 
    }
}

?>