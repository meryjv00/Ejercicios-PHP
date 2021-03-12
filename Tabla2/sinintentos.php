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
        $n = $_SESSION['numero'];
        ?>
        <h1>¡Has perdido todos los intentos!</h1>
        <p>La tabla de multiplicar era:</p>
        <form name="formulario" action="tabla.php" method="POST">
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo $n . ' * ' . $i . ' = ';
                ?>
                <input type="text" name="tabla[]" value="<?=$n*$i?>" style="background-color: green"/>
                <?php
                echo '<br>';
            }
            ?>
            <p>
                <input type="submit" name="comprobar" value="Comprobar"/>
                <input type="submit" name="meRindo" value="Me rindo"/>
            </p>
        </form>
        <a href="index.php">Volver</a>

    </body>
</html>
