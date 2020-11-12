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
                        <p class="crud loginreg">Gestión de usuarios</p>
                    </div>
                    <form name="formulario" action="../valida.php" method="POST">
                        <fieldset>
                            <legend>Opciones</legend>
                            <div class="m2">
                                <input type="submit" name="CrearUsuario" value="Crear nuevo usuario" class="btn rosa letrainput"/>
                            </div>
                            <div class="m2">
                                <input type="submit" name="VolverAdmin" value="Volver" class="btn rosa letrainput"/>
                            </div>
                            <div class="m2">
                                <input type="submit" name="CerrarSesion" value="Cerrar sesión" class="btn verde letrainput"/>
                            </div>
                        </fieldset>

                        <table class="m3" border="1">
                            <tr>
                                <th>¿Admin?</th>
                                <th>Dni</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Editar</th>
                                <th>Hacer admin</th>
                                <th>Quitar admin</th>
                                <th>Eliminar</th>
                            </tr>
                            <?php
                            require_once '../Usuario.php';
                            session_start();
                             
                            $usuarios = $_SESSION['usuarios'];
                            foreach ($usuarios as $i => $usuario) {
                                if ($usuario->sizeRol() == 2) {
                                    $admin = "#96ceb4";
                                } else {
                                    $admin = "#ff6f69";
                                }
                                ?>
                                <tr>
                                    <td style="background-color: <?= $admin ?>"></td>
                                    <td><?= $usuario->getDni() ?></td>
                                    <td>
                                        <input type="text" name="nombre[]" value="<?= $usuario->getNombre() ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" name="tfno[]" value=" <?= $usuario->getTfno() ?>"/>

                                    <td>
                                        <input type="submit" name="<?=$i?>" value="Editar" class="botonCRUD c1"/>
                                    </td>
                                    <td>
                                        <input type="submit" name="<?=$i?>" value="Hacer admin" class="botonCRUD c2"/>
                                    </td>
                                    <td>
                                        <input type="submit" name="<?=$i?>" value="Quitar admin" class="botonCRUD c3"/>
                                    </td>
                                    <td>
                                        <input type="submit" name="<?=$i?>" value="Eliminar" class="botonCRUD c4"/>
                                    </td>
                                </tr>
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
