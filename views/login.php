<?php 
    require'../lib/librerias.php';
?>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        esto es el login
        <div class="formularioLogin col-xs-4 col-xs-offset-4">
            <form action="../controller/loginController.php" method="POST">
                
                <input type="text" id="userNameForm" name="userName" class="form-control" placeholder="Usuario">
                
                <input type="password" id="passwordForm" name="passwordForm" class="form-control" placeholder="contraseña">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </body>
</html>