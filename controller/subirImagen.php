<?php
session_start();
require '../services/connection.php';
require '../services/queriesMysql.php';

if(isset($_REQUEST['enviarFoto'])){
    $foto = $_FILES['subirFoto'];
    var_dump($foto["tmp_name"]);
    if($foto["error"] === 0){
        //hacer query para ver el ultimo insert
        $lastId = queriesMysql::getLastId($link);
        if($lastId === NULL){
            $lastId = 0;
        }
        //var_dump($lastId);die;
        $id = $lastId+1;
        
        $fullNombreFoto = strtolower($foto["tmp_name"]);
        $nombre = explode("php", $fullNombreFoto);
        $nombre = explode(".", $nombre[1]);
        $nombreFoto = $nombre[0];
        $ext = ".jpg";
        $destino = "../web/img/".$nombreFoto."_varid".$id.$ext;
        $tmpName = $foto["tmp_name"];
        echo $destino;
        //die;
        $subirFoto = move_uploaded_file($tmpName, $destino);
        //guardar nombre de la foto en la bd
        if($subirFoto){
            //Subir el nombre de la foto a la base de datos con la fecha.
            if(isset($_SESSION['id'])){
                $subidoX = $_SESSION['id'];
            }else{
                $subidoX = '0';
            }
            $guardarFoto = queriesMysql::guardarFoto($link, $id, $nombreFoto, $ext, $subidoX);
            header("Location: ../views/home.php");
        }else{
            die("error al subir");
        }
    }else{
        echo $foto["error"];
        die("hay errores");
    }
}else{
    die("nada");
}

//https://www.creativosonline.org/blog/30-paginas-web-increiblemente-simples.html