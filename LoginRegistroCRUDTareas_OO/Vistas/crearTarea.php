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
                        <span class="loginreg">¡Crea una tarea!</span>
                    </div>
                    <form name="formulario" action="../valida.php" method="POST">
                        <div class="borde m3">
                            <span>Introduce la descripción:</span>
                            <input class="reg" type="text" name="descripcion" value="" required/>
                        </div>
                        <div class="borde m3">
                            <span>Introduce la dificultad:</span>
                            <input class="reg" type="text" name="dificultad" value="" required/>
                        </div>
                        <?php
                        session_start();
                        if (isset($_SESSION['mensaje2'])) {
                            $msj = $_SESSION['mensaje2'];
                            ?>
                            <p><?= $msj ?></p>
                            <?php
                        }
                        unset($_SESSION['mensaje2']);
                        ?>
                        <div class="m3">
                            <input type="submit" name="RegistrarTarea" value="Crear tarea" class="btn rosa letrainput" />
                        </div>
                    </form>
                    <form name="formulario" action="../valida.php" method="POST">
                        <input type="submit" name="EntrarTareas" value="Volver" class="btn verde letrainput"/>
                    </form>
                </div>
                <div></div>
            </main>
        </div>
    </body>
</html>
