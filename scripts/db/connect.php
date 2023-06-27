<?php 

namespace App;

class connect {
    //almacenar la conexión a la base de datos
    public $con;
    function __construct(){
        try {
            //  se crea una nueva instancia de la clase PDO, que se utiliza para conectarse a la base de datos
            $this->con=new \PDO( $_ENV["DSN"].":host=".$_ENV["HOST"].";dbname=".$_ENV["DBNAME"].";user=". $_ENV["USERNAME"].";password=".$_ENV["PASSWORD"].";port=". $_ENV["PORT"]);
            //  Aquí se establece un atributo en la conexión PDO para habilitar el modo de excepción. Esto significa que PDO lanzará excepciones en caso de errores en las consultas SQL.
            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // print_r("conexion exitosa");
        // se muestra el mensaje de la excepción utilizando el método getMessage() del objeto $e. Esto imprimirá el mensaje de error en caso de que se produzca una excepción durante la conexión a la base de datos.
        } catch (\PDOException $e) {
            print_r($e->getMessage());
        }
    }
}

/**
 * ? la clase connect se utiliza para establecer una conexión PDO con una base de datos MySQL. Recibe la configuración de conexión (como el tipo de base de datos, el host, el nombre de la base de datos, etc.) a través de propiedades heredadas de la clase credentials. Si se produce un error durante la conexión, se captura la excepción y se muestra el mensaje de error correspondiente.
 */