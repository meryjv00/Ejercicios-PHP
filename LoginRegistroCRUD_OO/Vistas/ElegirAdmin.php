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
        <?php
        require '../Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        ?>
        <div class="container-flex">
            <main>
                <div></div>
                <div id="login" class="recuadre">
                    <div class="m1">
                        <span class="loginreg">¡Hola <?= $usuario->getNombre(); ?>!</span>
                        <p>¿Cómo quieres entrar?</p>
                    </div>
                    <form name="formulario" action="../valida.php" method="POST">
                        <div class="m1">
                            <input type="submit" name="EntrarAdmin" value="Entrar como administrador" class="btn rosa letrainput"/>
                        </div>
                        <div class="m1">
                            <input type="submit" name="EntrarUsu" value="Entrar como usuario" class="btn rosa letrainput"/>
                        </div>
                        <hr>
                        <div class="m1">
                            <input type="submit" name="CerrarSesion" value="Cerrar sesión" class="btn verde letrainput"/>
                        </div>
                    </form> 
                </div>
                <div></div>
            </main>
        </div>
    </body>
</html>
