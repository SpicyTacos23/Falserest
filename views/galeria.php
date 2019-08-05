<?php
session_start();
require '../services/connection.php';
require '../services/queriesMysql.php';
require '../lib/librerias.php';

if(!isset($_SESSION['id'])){
    header('Location: ../views/home.php');
}
$id = $_SESSION['id'];

$fotos = queriesMysql::getLoggedUserPics($link,$id);

require 'header.php';
if(!$fotos){
    echo "<h1 style='color: white;'>Sin Resultados<h1>";
}else{
   foreach ($fotos as $key => $foto){
        $rutaFoto = "../web/img/".$fotos[$key]['nombre']."_varid".$fotos[$key]["id"].$fotos[$key]["extension"];

        echo "<div class='col-xs-4'>";
        echo "<span><div class='infoUser marcofoto'>";
        echo "<figure><img src='$rutaFoto' class='img-fluid'></figure><br>";
        echo "</div></span></div>";
    } 
}


