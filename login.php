<?php

switch ($_POST['accion']) {

//caso login:
    //se recibe por parámetros el usuario y la contraseña que se introdujeron y
    //en el método login() se comparan con los que hay en BDD, si hace login te lleva
    // a la ventana principal.php, sino, aplica el error de la petición ajax.
    case 'login':

        $usuario = $_POST['usuario'];
        $contraseña = $_POST["pass"];

        if (login($usuario, $contraseña)) {
            echo "principal.php";
        } else {
            die(header("HTTP/1.0 404 Not Found"));
        }
        break;

    //caso 'registro' coge los valores que recibe de la petición y se mandan al 
    // método registrar(), donde se mira si ya existe el usuario o no
    case "registro":

        $usuario = $_POST['usuario'];
        $contraseña = $_POST["pass"];

        if (registrar($usuario, $contraseña)) {

            echo "Registrado!";
        } else {
            echo "No se pudo registrar.";
        }
        break;
    default:
        echo "Petición de acción no válida.";
}

//método de conexión a BDD, devuelve la conexión.
function conectarBDD() {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_dbname = "pruebahotelinking";
    $conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_dbname);

    return $conexion;
}

//método login, se le pasa el nombre y el usuario por parámetro, se hace la consulta con
//estos datos y se compara con BDD, si la consulta devuelve una fila significa que está bien
//loggeado y crea la SESSION
function login($name, $pass) {
    try {
        $conexion = conectarBDD();

        $sql = "SELECT nombre FROM usuario WHERE nombre='$name' and password='$pass'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION['login_user'] = $name;
            $_SESSION['login_pass'] = $pass;
            mysqli_close($conexion);
            return true;
        } else {
            mysqli_close($conexion);
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

//método de registro
// se intenta insertar el usuario que el cliente ha introducido, si ya existe, no se introduce,
// si no existe, se registra correctamente.
function registrar($name, $pass) {
    $conexion = conectarBDD();
    $consulta = "INSERT into usuario VALUES('" . $name . "','" . $pass . "')";

    if (mysqli_query($conexion, $consulta)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}
?>

