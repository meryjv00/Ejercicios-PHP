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
                <div id="CRUD" class="recuadre">
                    <div class="m1">
                        <p class="crud loginreg">Tareas disponibles</p>
                    </div>
                    <form name="formulario" action="../valida.php" method="POST">
                        <fieldset>
                            <legend>Opciones</legend>
                            <div class="m2">
                                <input type="submit" name="Bienvenido" value="Volver" class="btn rosa letrainput"/>
                            </div>
                            <div class="m2">
                                <input type="submit" name="CerrarSesion" value="Cerrar sesión" class="btn verde letrainput"/>
                            </div>
                        </fieldset>
                        <table class="m3" border="1">
                            <tr>
                                <th>Id</th>
                                <th>Descripcion</th>
                                <th>% desarrollo</th>
                                <th>Dificultad</th>
                                <th>Elegir</th>
                            </tr>
                            <?php
                            require_once '../Modelo/Tarea.php';
                            session_start();
                            $tareasDispo = $_SESSION['tareasDispo'];
                            if (count($tareasDispo) > 0) {
                                foreach ($tareasDispo as $i => $tarea) {
                                    ?>
                                    <tr>
                                        <td><?= $tarea->getId() ?></td>
                                        <td><?= $tarea->getDescripcion() ?></td>
                                        <td><?= $tarea->getPdesarrollo() ?></td>
                                        <td><?= $tarea->getDificultad() ?></td>
                                        <td>
                                            <input type="submit" name="<?= $i ?>" value="Elegir tarea" class="botonCRUD c4"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <p class="loginreg">No hay tareas disponibles en este momento! </p>
                                <?php
                            }
                            ?>

                        </table>

                    </form> 
                </div>
                <div></div>
            </main>
        </div>
    </body>
</html>
