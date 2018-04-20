<html>
    <head>
        <title>Prueba</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/javascript.js"></script>
    </head>
    <body>
        <form id="formLogin">
            <div class="container center-block ">
                <h3>Login</h3>
                <label for="uname"><b>Usuario:</b></label><br>
                <input type="text" id="name1" required>
                <br><br>
                <label for="psw"><b>Contraseña:</b></label><br>
                <input type="password" id="pass1" required><br><br>
                <input type="submit" id="login" value="Loggear">
            </div>
        </form>
        
        <form id="formRegistro"> 
            <div class="container center-block ">
                <h3>Registro</h3>
                <label for="uname"><b>Usuario:</b></label><br>
                <input type="text" placeholder="Usuario" id="name2" required>
                <br><br>
                <label for="psw"><b>Contraseña:</b></label><br>
                <input type="password" placeholder="Contraseña" id="pass2" required><br><br>
                <input type="submit" id="registro" value="Registrarse">
            </div>
            
        </form>
        
    </body>

</html>
