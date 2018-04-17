
<html>
    
    <?php
    if (!(isset($_COOKIE['login_user']) and isset($_COOKIE['login_pass']))) {
        header('Location: index.php');
    }
    ?>
    <head>
        <title>Principal</title>
        <link rel="stylesheet" type="text/css" href="css/css.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/js.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <button id="recibirCodigo" class="boton">Recibir código.</button>

        <button id="misCodigos" class="boton">Mis códigos.</button>

        <div id="contenido"></div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">


                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmación.</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro/a de que quieres canjear el código?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="confirmar" class="btn btn-primary" data-dismiss="modal">Canjear</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
    </body>

</html>

