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
                        <p class="crud loginreg">Mis tareas</p>
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
                                <th>Editar</th>
                                <th>Terminada</th>
                                <th>Dejar tarea</th>
                            </tr>
                            <?php
                            require_once '../Modelo/Tarea.php';
                            session_start();
                            $misTareas = $_SESSION['misTareas'];
                            if (count($misTareas) > 0) {
                                foreach ($misTareas as $i => $tarea) {
                                    ?>
                                    <tr>
                                        <td><?= $tarea->getId() ?></td>
                                        <td>
                                            <input type="text" name="descripcion[]" value="<?= $tarea->getDescripcion() ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="pdesarrollo[]" value="<?= $tarea->getPdesarrollo() ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="dificultad[]" value="<?= $tarea->getDificultad() ?>" />
                                        <td>
                                            <input type="submit" name="<?= $i ?>" value="Editar" class="botonCRUD c4"/>
                                        </td>
                                        <td>
                                            <input type="submit" name="<?= $i ?>" value="Terminada" class="botonCRUD c2"/>
                                        </td>
                                        <td>
                                            <input type="submit" name="<?= $i ?>" value="Dejar tarea" class="botonCRUD c3"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                    <p class="loginreg">No tienes tareas asignadas en este momento!! </p>
                                    <p class="centrado">Añade una tarea <a href="verTareas.php">aquí</a></p>
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
