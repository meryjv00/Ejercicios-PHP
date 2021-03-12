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
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['numero'])) {
            unset($_SESSION['numero']);
            unset($_SESSION['intentos']);
        }
        ?>
        <h1>Tabla de multiplicar</h1>
        <form name="formulario" action="tabla.php" method="POST">
            <input type="text" name="numero" value="" placeholder="Escribe número"/>
            <input type="submit" name="Aceptar" value="Aceptar"/>
        </form>
    </body>
</html>
