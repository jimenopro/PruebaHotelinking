<?php

//Archivo de gestión de los códigos
//SWITCH en el cual se mira qué acción se ha de tomar con la petición recibida

switch ($_POST['accion']) {

    //caso recibir código:
    //si la SESSION está creada, se manda el nombre de usuario al método crearNuevoCodigo()
    //el metodo devuelve el resultado de la consulta SQL, justo después se envía el código de la
    //ventana que mostrará el número de código
    case 'recibir':
        session_start();
        if (isset($_SESSION['login_user'])) {
            $fila = crearNuevoCodigo($_SESSION['login_user']);
            echo "<div class='modal-dialog modal-sm'>
      <div class='modal-content'>
        <div class='modal-header'>
          
          <h4 class='modal-title'>" . $fila[1] . ", has recibido:</h4>
        </div>
        <div class='modal-body'>
          <p>Código nº #" . $fila[0] . "</p>
        </div>
      </div>
    </div>";
        } else {
            die(header("HTTP/1.0 404 Not Found"));
        }

        break;

    //caso mostrar códigos:
    // si la SESSION del nombre de usuario está creada, se mandará al método mostrarMisCódigos(),
    // devuelve el resultado de la consulta, el cual se recorre y se va añadiendo al div "contenido"
    // se van añadiendo los códigos con un botón para canjearlos
    case 'mostrar':
        session_start();
        if (isset($_SESSION['login_user'])) {
            $filas = mostrarMisCódigos($_SESSION['login_user']);
            while ($fila = $filas->fetch_assoc()) {
                if ($fila['canjeado'] == 0) {
                    echo "<div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4 class='modal-title'> Código nº #" . $fila['id'] . "</h4>
                        </div>
                        <div class='modal-body'>
                        <input type='button' data-toggle='modal' data-target='#myModal' value = 'Canjear' id=" . $fila['id'] . ">
                        </div>
                    </div>
                </div>";
                } else {
                    echo "<div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4 class='modal-title'> Código nº #" . $fila['id'] . "</h4>
                        </div>
                        <div class='modal-body'>
                        <p>Canjeado.</p>
                        </div>
                    </div>
                </div>";
                }
            }
        } else {
            die(header("HTTP/1.0 404 Not Found"));
        }

        break;
    //caso 'canjear', se canjea el código según su ID en el método canjear()
    //se recibe por petición ajax la ID
    case 'canjear':
        $id = $_POST['id'];
        if (canjear($id)) {
            echo 'Código canjeado';
        } else {
            die(header("HTTP/1.0 404 Not Found"));
        }
        
    default:
        echo "Petición de acción no válida.";
}

//se conecta a BDD, y se Crea un nuevo código según el nombre de usuario, 
//acto seguido se hace una consulta para obtener el código y se devuelve con return.
function crearNuevoCodigo($name) {
    $conexion = conectarBDD();
    $consulta = "INSERT INTO tickets(`canjeado`,`nombre_usuario`) VALUES(0,'$name')";

    if (mysqli_query($conexion, $consulta)) {

        $sql = "SELECT id, nombre_usuario FROM tickets WHERE nombre_usuario='$name' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_row($result);

        mysqli_close($conexion);
        return $row;
    } else {
        mysqli_close($conexion);
        return null;
    }
}

//método para conectar a base de datos, devuelve la conexión.
function conectarBDD() {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_dbname = "pruebaHotelinking";
    $conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_dbname);

    return $conexion;
}

//método para consultar a base de datos que devuelve los códigos del usuario introducido
//por parámetro
function mostrarMisCódigos($name) {
    $conexion = conectarBDD();
    $sql = "SELECT * FROM tickets WHERE nombre_usuario='$name' ORDER BY id DESC";
    $result = mysqli_query($conexion, $sql);

    mysqli_close($conexion);
    return $result;
}

//método para canjear el código, se hace un update del campo BOOLEAN "canjeado"
function canjear($id) {
    $conexion = conectarBDD();
    $consulta = "UPDATE tickets SET canjeado=1 WHERE ID='$id'";
    if ($result = mysqli_query($conexion, $consulta) === TRUE) {
        return true;
    } else {
        return false;
    }
}

?>