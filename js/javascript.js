
$(function () {

    var id;
    //Petición ajax POST donde se envían los datos de nombre de Usuario y Contraseña
    //a login.php
    $("#formLogin").submit(function () {
            $.ajax({
                data: {
                    "accion": "login",
                    "usuario": $("#name1").val(),
                    "pass": $("#pass1").val()
                },
                url: 'login.php',
                type: 'post',
                success: function (response) {

                    window.location.replace(response);
                }, error: function () {
                    alert("Campos incorrectos.");
                }

            });
            //el return false sirve para que el form no haga el submit directamente,
            //sino que se haga esta petición
            return false;
    });
    //Petición ajax de registro de usuarios, se cogen los datos y se mandan al
    //login.php, donde se insertarán los datos en la BDD mysql si no existen ya.
    $("#formRegistro").submit(function () {
        var parametros = {
            "accion": "registro",
            "usuario": $("#name2").val(),
            "pass": $("#pass2").val()
        };
        $.ajax({
            data: parametros,
            url: 'login.php',
            type: 'post',
            //Si la petición va bien, el servidor mirará si el usuario existe o no
            //si no existe, este alert dirá que se ha registrado con éxito al usuario,
            //si existe, dirá que no se pudo registrar
            success: function (response) {
                alert(response);
            }
        });
        return false;
    });
    //petición ajax POST para que en gestioncodigos.php se cree un nuevo código y
    // se le adjudique al usuario Logeado
    $("#recibirCodigo").click(function () {
        var parametros = {
            "accion": "recibir"
        };
        $.ajax({
            data: parametros,
            url: 'gestioncodigos.php',
            type: 'post',
            success: function (response) {
                //Si la petición va bien, se añade y se sobreescribe el contenido
                //del div "contenido" por una ventanita con el código
                document.getElementById("contenido").innerHTML = response;
            },
            error: function () {
                //si no puede recibir código, significa que el usuario no existe
                //ya que la COOKIE no ha sido creada al logear, entonces se le devuelve
                //a la página de inicio
                window.location.replace("index.php");
            }
        });
    });
    //petición ajax POST para mostrar los códigos
    $("#misCodigos").click(function () {
        var parametros = {
            "accion": "mostrar"
        };
        $.ajax({

            data: parametros,
            url: 'gestioncodigos.php',
            type: 'post',
            success: function (response) {
                //si la petición va bien, se sobreescribe el contenido de "contenido"
                //y se muestran todos los cupones del usuario registrado
                document.getElementById("contenido").innerHTML = response;
            },
            error: function () {
                //Si no va bien la petición, es porque las cookies no existen y
                // se devuelve al usuario a la página de loggeo
                window.location.replace("index.php");
            }
        });
    });
    //evento de click de los botones de los códigos.
    //cuando clicas "canjear" en un botón, se se le coge su ID y se lanza la
    //ventana modal de confirmación de canjeo.
    $(document).on('click', 'input[type="button"]', function (event) {
        id = this.id;
        ("#myModal").show();
    });
    //evento de click de confirmación de canjeo de código
    //se envía la ID del código al método canjearCodigo(), donde se hace una petición
    $("#confirmar").click(function () {
        canjearCodigo(id);
    });
});
// petición donde se envía la ID del código a gestioncodigos.php, donde se hará
// un update del registro según la ID enviada.
function canjearCodigo(id) {

    var parametros = {
        "accion": "canjear",
        "id": id
    };
    $.ajax({
        data: parametros,
        url: 'gestioncodigos.php',
        type: 'post',
        success: function (response) {
            alert("Código canjeado.");
            location.reload();
        },
        error: function () {
            alert("No se ha podido canjear.");
        }
    });
}


