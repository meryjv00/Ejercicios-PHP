<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido</title>
        <link rel="stylesheet" href="../css/estilos.css">
        <link
            href="https://fonts.googleapis.com/css2?family=Lobster&family=Open+Sans&family=Quicksand:wght@300&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>
        <?php
        require '../Modelo/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        ?>
        <div class="container-flex">
            <main>
                <div></div>
                <div id="login" class="recuadre">
                    <div class="m3">
                        <span class="loginreg">¡Bienvenido <?= $usuario->getNombre(); ?>!</span>
                    </div>
                    <form class="m3" name="formulario" action="../valida.php" method="POST">
                        <div class="m1">
                            <input type="submit" name="VerMisTareass" value="Ver mis tareas" 
                                   class="btn rosa letrainput"/>
                        </div>
                        <div class="m1">
                            <input type="submit" name="VerTareasDisp" value="Ver tareas disponibles" 
                                   class="btn rosa letrainput"/>
                        </div>

                        <?php
                        if ($usuario->sizeRol() == 2) {
                            ?>
                            <hr>
                            <!--Solo si es admin tiene este botón -->
                            <input type="submit" name="VolverAdmin" value="Volver" class="btn verde letrainput"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="CerrarSesion" value="Cerrar sesión" class="m1 btn verde letrainput"/>
                    </form> 
                </div>
                <div></div>
            </main>
        </div>


    </body>
</html>
