<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/estilos.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Lobster&family=Open+Sans&family=Quicksand:wght@300&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-flex">
            <main>
                <div></div>
                <div id="login" class="recuadre">
                    <form name="formulario" action="../enviar.php" method="POST">
                        <div class="m3">
                            <span>Introduce tu correo:</span>
                            <input class="reg" type="text" name="correoDestino" value="" required/>
                        </div>                        
                        <div class="borde m4">
                            <input type="submit" name="aceptar" value="Confirmar" class="btn rosa letrainput"/>
                        </div> 
                        <div class="m1">
                            <a href="../index.php"><input type="button" name="Volver" value="Volver" class="btn rosa letrainput"/></a>
                        </div>
                    </form> 
                </div>
                <div></div>
            </main>
        </div>
    </body>
</html>
