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
                <div id="registro" class="recuadre">
                    <div class="m3">
                        <span class="loginreg">¡Registra un usuario!</span>
                    </div>
                    <form name="formulario" action="../valida.php" method="POST">
                        <div class="borde m3">
                            <span>Introduce el dni:</span>
                            <input class="reg" type="text" name="dni" value="" required/>
                        </div>
                        <div class="borde m3">
                            <span>Introduce el nombre:</span>
                            <input class="reg" type="text" name="nombre" value="" required/>
                        </div>

                        <div class="borde m3">
                            <span>Introduce el teléfono:</span>
                            <input class="reg" type="text" name="tfno" value="" required/>
                        </div>
                        <div class="borde m3">
                            <span>Introduce la contraseña:</span>
                            <input class="reg" type="password" name="contra" value="" required/>
                        </div>
                        <div class="m3 borde">
                            <span>¿Administrador?</span>
                            <input type="checkbox" name="admin" value="" />
                        </div>
                        <div class="m3">
                            <input type="submit" name="RegistrarUsuario" value="Registrar" class="btn rosa letrainput" required/>
                        </div>
                    </form>
                    <a href="CRUD.php"><input type="button" name="VolverCRUD" value="Volver" class="btn verde letrainput"/></a>
                </div>
                <div></div>
            </main>
        </div>
    </body>
</html>
