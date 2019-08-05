<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            session_start();
            session_destroy();
            header('Location: ./views/home.php');
        ?>
    </body>
</html>
