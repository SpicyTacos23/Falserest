<?php
session_start();
require '../services/connection.php';
require '../lib/librerias.php';
require '../services/queriesMysql.php';
if(isset($_GET['error'])){
    if($_GET['error'] === '1'){
        $mensaje = "<p style='color: red'> El usuario o la contraseña no coinciden</p>";
    }
}
if(isset($_SESSION['username'])){
    $userLogged = $_SESSION['username'];
    $userLogedId = $_SESSION['id'];
}
$rowsToShow = 6;
$fotos = queriesMysql::getAll($link, $rowsToShow);


if(isset($mensaje)){
    if($mensaje !== 0){
        echo "<script>alert('El usuario o la contraseña no coinciden');</script>";
        session_destroy();
    }
}
?>

<html>
    <head>
        <title>Homepage</title>
    </head>
    <body>
        <?php require'header.php'; ?>
        <!-- MODAL LOGIN *************************************************************************************** -->
        <div id="id01" class="modal">

            <form class="modal-content animate" action="../controller/loginController.php">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="../web/img/fondo/logout.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <?php 
                        if(isset($userLogged)){
                            echo'<input type="text" placeholder="'.$userLogged.'" name="username" readonly>';
                            echo'<button type="button" id="logOut">Logout</button>';
                        } else{ 
                            echo '<input type="text" placeholder="Username" name="username" required>';
                            echo'<input type="password" placeholder="Password" name="password" required>';
                            echo'<button type="submit">Login</button>';
                            echo '<label><input type="checkbox" checked="checked" name="remember"> Remember me</label>';
                        }
                    ?>
                </div>

                <div class="container footerLogin">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="https://youtu.be/y6120QOlsfU?t=31">password?</a></span>
                </div>
            </form>
        </div>
        <!-- END MODAL *********************************************************************************************************-->
        <div class="container">  
            <input type="hidden" name="controlRowsToShow" id="controlRowsToShow" value="<?php echo $rowsToShow ?>">
            <div class="blqSubirImagen">
                <form enctype="multipart/form-data" action="../controller/subirImagen.php" 
                      method="POST" class="form-inline subirImagenes" id="imgForm">
                    <input type="file" class="custom-file-input" id="subirFoto" name="subirFoto" required>
                    <input type="submit"  class="btn btn-primary" name="enviarFoto" id="enviarFoto" value="E̱̠̙̰̖͎͆ͥͥN̰̻͕̫͋̈V̱͒̊̄I̠̫̖͖͓̞ͫ̈́͌ͅA̫͎͇̭̣͗ͮ̄͗̌R̻̄͒ͥ̆͆ͫ̔"/>
                    <p id="errorFile" value=""></p>  
                </form>
            </div>
            <div class="container" id="homeContainer">
                <div class='cajaFotos'>
                <?php 
                if(!$fotos){
                    echo "<h1 style='color: white;'>Sin Resultados<h1>";
                }else{
                   foreach ($fotos as $key => $foto){
                        $rutaFoto = "../web/img/".$fotos[$key]['nombre']."_varid".$fotos[$key]["id"].$fotos[$key]["extension"];
                        //arreglar query paramostrar el nombre de la persona que lo ha subido
                        echo "<div class='col-xs-4'>";
                        echo "<span><div class='infoUser marcofoto'>";
                        //echo "<p class='mensajeFoto' style='display:none'>Subida por:</p>";
                        echo "<p>".$fotos[$key]['fecha']."</p>";
                        echo "<figure><img src='$rutaFoto' class='img-fluid'></figure><br>";
                        echo "</div></span></div>";
                    } 
                }
                
                ?>
                </div>
            </div>
            <button type="button" class="btn btn-primary col-xs-12" id="showMoreBtn">Show more</button>
        </div>
    </body>
</html>

<script>
    
 $( document ).ready(function() {
     //posicionar al top 0 de Y al cargar
     goToTop();
     function goToTop(){
        $(window).scrollTop(0);
     }
     
     
     //Control del numero de foto para pasar a la variable
     var rowsToShow = $('#controlRowsToShow').val();
     //console.log(rowsToShow);
     var control = false;
     $('#logOut').click(function(){
         logOut();
     })
    function logOut(){
        window.location.href = '../controller/logOutController.php';
    }
    function showMore(){
        rowsToShow = parseInt(rowsToShow)+6; 
        console.log(rowsToShow);
        $.ajax({
            data:{rowsToShow : rowsToShow},
            url:'../controller/getPicsController.php',
            type: 'POST',
            dataType:'JSON',
            beforeSend: function(){
              //console.log(rowsToShow);
            },
            success: function(response){
                //console.log(response);
                for(i=0; i < 6; i++){
                   var rutaFoto = "../web/img/"+response[i]['nombre']+"_varid"+response[i]['id']+response[i]['extension']; 
                   //console.log (rutaFoto);
                   console.log(response[i]['fecha']);
                   var popImages = "<div class='col-xs-4'><span><div class='infoUser marcofoto'><p>"+response[i]['fecha']+"</p><figure><img src='"+rutaFoto+"' class='img-fluid'></figure><br></div></span></div>";
                   $('#homeContainer').append(popImages);
                   if(response[i]['id'] === '1'){
                      $('#showMoreBtn').attr("disabled", true);
                      control = true;
                      return false;
                   }
                }
            }
         });
        //console.log("click click"); 
     }
     
 //Valida que el formato que se sube es el correcto
//     $('#enviarFoto').submit(function(){
//        //$('#imgForm').preventDefault();
//        console.log($('#subirFoto').val());
//        var fotoName = $('#subirFoto').val();
//        var extension = fotoName.split('.');
//        var extension = extension[1];
//        console.log(extension);
//        
//        if(extension !== "jpg" && extension !== 'jpeg' && extension !== 'gif' && extension !== 'png'){
//            $('.blqSubirImagen').css('border','solid 3px #ff0101');
//            $('#errorFile').html("Por favor introduce un formato correcto.");
//            console.log("formato incorrecto");
//        }else{
//            $('#imgForm').submit();
//        }
//     });
     
     
    $('.abrirLogin').click(function(){
        document.getElementById('id01').style.display='block';
    });


    $(window).on("scroll", function() {
        if ((window.innerHeight + window.scrollY) >= ((document.body.offsetHeight)-50 ) && control === false) {

            showMore();
        }
    });


    // Mirar por que no muestra la fecha en los que estan metidos por ajax
    $('.marcofoto').mouseenter(function(){
       //console.log("entra");
        $('.marcofoto p').css('display', 'inline-block');
    });
    $('.marcofoto').mouseleave(function(){
        $('.marcofoto p').css('display', 'none');
    });
});
     /* hacer on mouse enter que lea de un input hidden dentro del foreach con la fecha.
      * y que lo muestre en un comentario dentro de la foto y al salir lo borre.
      *  $('.prueba div').mouseenter(function(){
                $( this ).fadeOut( 100 );
                $( this ).fadeIn( 100 );
            });
      */

</script>