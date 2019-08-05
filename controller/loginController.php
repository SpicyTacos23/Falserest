<?php
require '../services/connection.php';
require '../services/validations.php';
require '../services/queriesMysql.php';


$errores= [];
if(isset($_REQUEST['username'])){
    $validarNombre = validations::validateName($_REQUEST['username']);
    if($validarNombre){
        $username = $_REQUEST['username'];
    }else{
        $errores['username'] = "usuario no pasa la validacion";
    }
    
}else{
    $errores['username'] = "usuario incorrecto";
}

if(isset($_REQUEST['password'])){
    $validarPassword = validations::validatePasswd($_REQUEST['password']);
    if($validarPassword){
        $password = $_REQUEST['password'];
    }else{
        $errores['password'] = "password no pasa la validacion";
    }
    
}else{
    $errores['password'] = "password incorrecta";
}

if(count($errores) > 0){
    var_dump($errores);
    die("Ha habido errores");
}else{
    $verificarUsuario = queriesMysql::verificarUser($link, $username, $password);
    $getId = queriesMysql::getId($link,$username);
    if($verificarUsuario && $getId){
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $getId;
        header('Location: ../views/home.php');
    }else{
        header('Location: ../views/home.php?error=1');
    }
}