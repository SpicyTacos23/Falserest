<?php


/**
 * Queries
 *
 * @author msi
 */
class queriesMysql {
    // Pilla todas las fotos de la bd
    public function getAll(&$link, $rowsToShow){
        $fotos = [];
        $queryGetAll="
            SELECT * FROM (SELECT * FROM (SELECT * FROM foto ORDER BY id DESC LIMIT $rowsToShow) as fotos "
                . "ORDER BY id LIMIT 6)as otraFoto ORDER BY id DESC LIMIT 6"
                . "            ";
        $getAll = mysqli_query($link, $queryGetAll);
        if($getAll){
            while ($row = mysqli_fetch_array($getAll)) {
                array_push($fotos, $row);
            }
        }else{
            echo "no se ha podido hacer la query";die;
        }
        return $fotos;
    }
    
    //Saca el ultimo Id para ponerlo de nombre en la foto
    public function getLastId(&$link){
        $queryGetLastId="
            SELECT id FROM foto ORDER BY id DESC LIMIT 1
        ";
        $getLastId = mysqli_query($link, $queryGetLastId);
        if($getLastId){
            $lastId = mysqli_fetch_row($getLastId);
            $id = $lastId[0];
        }else{
            die("errores en GetLastId");
        }
        return $id;         
    }
    
    //Guarda la info de la foto en la base de datos
    public function guardarFoto($link, $id, $nombreFoto, $ext, $subidoX){
        $queryGuardarFoto="
            INSERT INTO foto(id, nombre, extension, fecha, subidaX) 
            VALUES(
                '$id','$nombreFoto','$ext',NOW(),'$subidoX'
            )
        ";
        $guardarFoto = mysqli_query($link, $queryGuardarFoto);
        if($guardarFoto){
            return true;
        }
        return false;
        //var_dump($queryGuardarFoto);die;
    } 
    
    // comprueba el usuario introducido en la base de datos
    public function verificarUser(&$link, $user, $password){
        
        $queryVerficarUser ="
            SELECT
                username,
                password
            FROM
                usuario
            WHERE
                username = '$user' AND password = '$password'";
        $validateLogin = mysqli_query($link, $queryVerficarUser);
        $userBD = mysqli_fetch_array($validateLogin);
        //echo$user[0],$user[1];die;  
        if($userBD[0] === $user && $userBD[1] === $password){
            return true;
        }else{
            return false;
        }
    }
    
    //Saca el id del usuario introducido
    public function getId(&$link, $username){
        $queryGetId="
            SELECT id FROM usuario WHERE username = '$username'
        ";
        $getId = mysqli_query($link, $queryGetId);
        if($getId){
            $id = mysqli_fetch_row($getId);
            $id = $id[0];
        }else{
            return false;
        }
        return $id;
    }
    
    //Saca las fotos del usuario logueado
    public function getLoggedUserPics(&$link, $id){
        $fotos = [];
        $queryGetLoggedUserPics="
            SELECT * FROM foto WHERE subidaX = '$id';
            ";
        $getLoggedUserPics = mysqli_query($link, $queryGetLoggedUserPics);
        if($getLoggedUserPics){
            while ($row = mysqli_fetch_array($getLoggedUserPics)) {
                array_push($fotos, $row);
            }
        }else{
            echo "no se ha podido hacer la query";die;
        }
        return $fotos;
    }
}

