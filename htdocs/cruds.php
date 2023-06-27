<?php 

require "../vendor/autoload.php";

$router = new \Bramus\Router\Router();
$dotenv = Dotenv\Dotenv::createImmutable("../")->load();
/**
 *  ! GET
 */
// trae todos los datos de la db
$router -> get("/tipo",function(){
    /**
     * * new \App\connect() => se crea una instancia de la clase que se encarga de establecer la conexion a la base de datos
     */
    $cox = new \App\connect();
    /**
     * * preparando una consulta SQL para seleccionar todos los registros de la tabla "tb_camper"
     */
    $res = $cox->con->prepare("SELECT * FROM areas");
    /**
     * *ejecutando la consulta SQL que preparaste en la línea anterior
     */
    $res -> execute();
    /**
     * *La función fetchAll() devuelve un array que contiene todas las filas resultantes de la consulta. Estás utilizando \PDO::FETCH_ASSOC para obtener un array asociativo que utiliza los nombres de las columnas como claves.
     */
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    /**
     * *convirtiendo el array de resultados en formato JSON utilizando la función json_encode() y lo estás mostrando como respuesta de la solicitud
     */
    echo json_encode($res);
});
// MISMO CODIGO DE ARRIBA PERO SIN COMENTARIOS:

// $router -> get("/camper",function(){
//     $cox = new \App\connect();
//     $res = $cox->con->prepare("SELECT * FROM tb_camper");
//     $res -> execute();
//     $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
//     echo json_encode($res);
// });


// TRAE LOS DATOS PERO ESPECIFICO DESDE DONDE CON EL WHERE:

// $router -> get("/camper",function(){
//     $cox = new \App\connect();
//     $res = $cox->con->prepare("SELECT * FROM tb_camper WHERE id > 60");
//     $res -> execute();
//     $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
//     echo json_encode($res);
// });


// trae los datos especificados por id:
// $router->get("/camper/{id}", function($id) {
//     $cox = new \App\connect();
//     $res = $cox->con->prepare("SELECT * FROM tb_camper WHERE id = :ID");
//     $res->bindValue('ID', $id);
//     $res->execute();
//     $result = $res->fetchAll(\PDO::FETCH_ASSOC);
//     echo json_encode($result);
// });


//buscar registros que coincidan con una parte del nombre ingresada en la URL:
// $router->get("/camper/{nombre}", function($nombre) {
//     $nombreLike = $nombre . '%'; // Agregar el carácter comodín '%' al final del nombre
//     $cox = new \App\connect();
//     $res = $cox->con->prepare("SELECT * FROM tb_camper WHERE nombre LIKE :NOMBRE");
//     $res->bindValue('NOMBRE', $nombreLike);
//     $res->execute();
//     $result = $res->fetchAll(\PDO::FETCH_ASSOC);
//     echo json_encode($result);
// });

/**
 *  ! PUT
 */

// $router->put("/camper", function(){
//     $_DATA = json_decode(file_get_contents("php://input"),true);
//     $cox = new \App\connect();
//     $res = $cox->con->prepare("UPDATE tb_camper SET nombre = :NOMBRE, edad =:EDAD WHERE id=:CEDULA");
//     $res -> bindValue('NOMBRE', $_DATA["nom"]);
//     $res -> bindValue('CEDULA', $_DATA["id"]);
//     $res -> bindValue('EDAD', $_DATA["edad"]);
//     $res -> execute();
//     $res = $res->rowCount();
//     echo json_encode($res);
// });


// trae los datos por medio del id del metodo get
$router->put("/tipo/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE areas SET  name_area = :NOMBRE WHERE id = :ID");
    $res -> bindValue('NOMBRE', $_DATA["name_area"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount(); //obtener el número de filas afectadas por la última operación de la consulta
    echo json_encode($res);
});

/**
 *  ! DELETE
 */
$router->delete("/tipo/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM areas WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});

/**
 *  ! POST
 */
$router->post("/tipo",function(){
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO areas (name_area) VALUES (:NOMBRE)");
    $res->bindValue('NOMBRE', $_DATA["name_area"]);
    $res->execute();
    $res = $res->rowCount();
    echo json_encode($res);
});

/**
 * ? TABLA CITIES:
 */
/**
 *  ! GET
 */
$router -> get("/city",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM cities");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/city", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO cities (name_city, id_region) VALUES (:NOMBRE, :ID_REGION)");
    $res->bindValue('NOMBRE', $_DATA["name_city"]);
    $res->bindValue('ID_REGION', $_DATA["id_region"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/city/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE cities SET  name_city = :NOMBRE WHERE id = :ID");
    $res -> bindValue('NOMBRE', $_DATA["name_city"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/city/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM cities WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});


/**
 * ? TABLA CONTACT_INFO:
 */
// No funciona el post
/**
 *  ! GET
 */
$router -> get("/contacto",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM contact_info");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/contacto", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO contact_info (id_staff, whatsapp, instagram, linkedin, email, addresss, cel_number) VALUES (:id_staff, :whatsapp, :instagram, :linkedin, :email, :addresss, :cel_number)");
    $res->bindValue('id_staff', $_DATA["id_staff"]);
    $res->bindValue('whatsapp', $_DATA["whatsapp"]);
    $res->bindValue('instagram', $_DATA["instagram"]);
    $res->bindValue('linkedin', $_DATA["linkedin"]);
    $res->bindValue('email', $_DATA["email"]);
    $res->bindValue('addresss', $_DATA["addresss"]);
    $res->bindValue('cel_number', $_DATA["cel_number"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});
/**
 *  ! PUT
 */
$router->put("/contacto/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE contact_info SET  whatsapp = :whatsapp, instagram = :instagram,  linkedin = : linkedin,  email = : email,  addresss = : addresss,  cel_number = : cel_number WHERE id = :ID");
    $res -> bindValue('whatsapp', $_DATA["whatsapp"]);
    $res -> bindValue('instagram', $_DATA["instagram"]);
    $res -> bindValue('linkedin', $_DATA["linkedin"]);
    $res -> bindValue('email', $_DATA["email"]);
    $res -> bindValue('addresss', $_DATA["addresss"]);
    $res -> bindValue('cel_number', $_DATA["cel_number"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/contacto/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM contact_info WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA COUNTRIES:
 */
/**
 *  ! GET
 */
$router -> get("/pais",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM countries");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/pais",function(){
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO countries (name_country) VALUES (:name_country)");
    $res->bindValue('name_country', $_DATA["name_country"]);
    $res->execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! PUT
 */
$router->put("/pais/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE countries SET   name_country = :NOMBRE WHERE id = :ID");
    $res -> bindValue('NOMBRE', $_DATA[" name_country"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/pais/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM countries WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA EMERGENCY:
 */
// no funciona el post ni put
/**
 *  ! GET
 */
$router -> get("/eme",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM emergency_contact");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/eme", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO emergency_contact (id_staff,cel_number,relationship,full_name,email) VALUES (:id_staff,:cel_number,:relationship,:full_name,:email)");
    $res->bindValue('id_staff',$_DATA["id_staff"]);
    $res->bindValue('cel_number',$_DATA["cel_number"]);
    $res->bindValue('relationship',$_DATA["relationship"]);
    $res->bindValue('full_name',$_DATA["full_name"]);
    $res->bindValue('email',$_DATA["email"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/eme/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE emergency_contact SET id_staff = :id_staff,cel_number = :cel_number,relationship = :relationship, full_name = :full_name, email = :email WHERE id = :ID");
    $res->bindValue('id_staff',$_DATA["id_staff"]);
    $res->bindValue('cel_number',$_DATA["cel_number"]);
    $res->bindValue('relationship',$_DATA["relationship"]);
    $res->bindValue('full_name',$_DATA["full_name"]);
    $res->bindValue('email',$_DATA["email"]);
    $res->bindValue('ID',$id);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! DELETE
 */
$router->delete("/eme/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM emergency_contact WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA JOURNEY:
 */
/**
 *  ! GET
 */
$router -> get("/journey",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM journey");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/journey", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO journey (name_journey,check_in,check_out) VALUES (:name_journey, :check_in, :check_out)");
    $res->bindValue('name_journey',$_DATA["name_journey"]);
    $res->bindValue('check_in',$_DATA["check_in"]);
    $res->bindValue('check_out',$_DATA["check_out"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/journey/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE journey SET name_journey = :name_journey,check_in = :check_in,check_out = :check_out WHERE id = :ID");
    $res -> bindValue('name_journey', $_DATA["name_journey"]);
    $res -> bindValue('check_in', $_DATA["check_in"]);
    $res -> bindValue('check_out', $_DATA["check_out"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/journey/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM journey WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA PERSONAL_REF:
 */
/**
 *  ! GET
 */
$router -> get("/ocu",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM personal_ref");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/ocu", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO personal_ref (full_name, cel_number, relationship, occupation) VALUES (:full_name, :cel_number, :relationship, :occupation)");
    $res->bindValue('full_name',$_DATA["full_name"]);
    $res->bindValue('cel_number',$_DATA["cel_number"]);
    $res->bindValue('relationship',$_DATA["relationship"]);
    $res->bindValue('occupation',$_DATA["occupation"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/ocu/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE personal_ref SET full_name = :full_name,cel_number = :cel_number,relationship = :relationship, occupation = :occupation WHERE id = :ID");
    $res -> bindValue('full_name', $_DATA["full_name"]);
    $res -> bindValue('cel_number', $_DATA["cel_number"]);
    $res -> bindValue('relationship', $_DATA["relationship"]);
    $res -> bindValue('occupation', $_DATA["occupation"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/ocu/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM personal_ref WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA POSITION:
 */
/**
 *  ! GET
 */
$router -> get("/pos",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM position");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/pos", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO position (name_position,arl) VALUES (:name_position,:arl)");
    $res->bindValue('name_position',$_DATA["name_position"]);
    $res->bindValue('arl',$_DATA["arl"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/pos/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE position SET name_position = :name_position,arl = :arl WHERE id = :ID");
    $res -> bindValue('name_position', $_DATA["name_position"]);
    $res -> bindValue('arl', $_DATA["arl"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/pos/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM position WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA REGIONS:
 */
/**
 *  ! GET
 */
$router -> get("/region",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM regions");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/region", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO regions (name_region,id_country) VALUES (:name_region,:id_country)");
    $res->bindValue('name_region',$_DATA["name_region"]);
    $res->bindValue('id_country',$_DATA["id_country"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/region/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE regions SET name_region = :name_region,id_country = :id_country WHERE id = :ID");
    $res -> bindValue('name_region', $_DATA["name_region"]);
    $res -> bindValue('id_country', $_DATA["id_country"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/region/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM regions WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 * ? TABLA THEMES:
 */
/**
 *  ! GET
 */
$router -> get("/tema",function(){

    $cox = new \App\connect();
    $res = $cox->con->prepare("SELECT * FROM themes");
    $res -> execute();
    $res = $res -> fetchAll(\PDO::FETCH_ASSOC);
    echo json_encode($res);
});
/**
 *  ! POST
 */
$router->post("/tema", function() {
    $_DATA = json_decode(file_get_contents("php://input"), true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("INSERT INTO themes (id_chapter, name_theme, start_date, end_date, description, duration_days) VALUES (:id_chapter,:name_theme,:start_date,:end_date,:description,:duration_days)");
    $res->bindValue('id_chapter',$_DATA["id_chapter"]);
    $res->bindValue('name_theme',$_DATA["name_theme"]);
    $res->bindValue('start_date',$_DATA["start_date"]);
    $res->bindValue('end_date',$_DATA["end_date"]);
    $res->bindValue('description',$_DATA["description"]);
    $res->bindValue('duration_days',$_DATA["duration_days"]);
    $res->execute();
    $rowCount = $res->rowCount();
    echo json_encode($rowCount);
});

/**
 *  ! PUT
 */
$router->put("/tema/{id}", function($id) {
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("UPDATE themes SET id_chapter = :id_chapter,name_theme = :name_theme,start_date = :start_date,end_date = :end_date,description = :description,duration_days = :duration_days WHERE id = :ID");
    $res -> bindValue('id_chapter', $_DATA["id_chapter"]);
    $res -> bindValue('name_theme', $_DATA["name_theme"]);
    $res -> bindValue('start_date', $_DATA["start_date"]);
    $res -> bindValue('end_date', $_DATA["end_date"]);
    $res -> bindValue('description', $_DATA["description"]);
    $res -> bindValue('duration_days', $_DATA["duration_days"]);
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
/**
 *  ! DELETE
 */
$router->delete("/tema/{id}", function($id){
    $_DATA = json_decode(file_get_contents("php://input"),true);
    $cox = new \App\connect();
    $res = $cox->con->prepare("DELETE FROM themes WHERE id=:ID");
    $res -> bindValue('ID', $id);
    $res -> execute();
    $res = $res->rowCount();
    echo json_encode($res);
});
$router->run();