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
        //Si hemos recargado
        if (isset($_SESSION['numero'])) {
            $n = $_SESSION['numero'];
            $miSolucion = $_REQUEST['tabla']; //Vector
            $intentos = $_SESSION['intentos'];

            if ($intentos > 0) {
                if (isset($_REQUEST['comprobar'])) {
                    echo('Has pulsado comprobar');
                    ?>
                    <h1>Rellena la tabla de multiplicar!</h1>
                    <form name="formulario" action="tabla.php" method="POST">
                        <?php
                        $fallo = false;
                        for ($i = 0; $i < count($miSolucion); $i++) {               
                            $j = $i + 1;
                            echo $n . ' * ' . $j . ' = ';
                            if ($n * $j != $miSolucion[$i]) {
                                $fallo = true;
                                ?>
                                <input type="text" name="tabla[]" value="<?= $miSolucion[$i] ?>" style="background-color: red"/>
                                <?php
                            } else {
                                ?>
                                <input type="text" name="tabla[]" value="<?= $miSolucion[$i] ?>" style="background-color: green"/>
                                <?php
                            }
                            echo '<br>';
                        }
                        if($fallo){
                            $intentos--;
                            $_SESSION['intentos'] = $intentos;
                        }
                        ?>
                        <p>
                            <span>Te queda(n) <?= $_SESSION['intentos']?> intento(s) </span><br>
                            <input type="submit" name="comprobar" value="Comprobar"/>
                            <input type="submit" name="meRindo" value="Me rindo"/>
                        </p>
                    </form>
                    <a href="index.php">Volver</a>
                    <?php
                }
                if (isset($_REQUEST['meRindo'])) {
                    echo('Has pulsado me rindo');
                    ?>
                    <h1>Rellena la tabla de multiplicar!</h1>
                    <form name="formulario" action="tabla.php" method="POST">
                        <?php
                        for ($i = 0; $i < count($miSolucion); $i++) {
                            $j = $i + 1;
                            echo $n . ' * ' . $j . ' = ';
                            if ($n * $j != $miSolucion[$i]) {
                                ?>
                                <input type="text" name="tabla[]" value="<?= $n * $j ?>" style="background-color: red"/>
                                <?php
                            } else {
                                ?>
                                <input type="text" name="tabla[]" value="<?= $miSolucion[$i] ?>" style="background-color: green"/>
                                <?php
                            }
                            echo '<br>';
                        }
                        ?>
                        <p>
                            <input type="submit" name="comprobar" value="Comprobar"/>
                            <input type="submit" name="meRindo" value="Me rindo"/>
                        </p>
                    </form>
                    <a href="index.php">Volver</a>
                    <?php
                }
            }else{
                header('Location: sinintentos.php');
            }

            //Si es la primera vez que entramos
        } else {
            $n = $_REQUEST['numero'];
            $_SESSION['numero'] = $n;
            $_SESSION['intentos'] = 5;
            ?>
            <h1>Rellena la tabla de multiplicar!</h1>
            <p>Tienes 5 intentos!</p>
            <form name="formulario" action="tabla.php" method="POST">
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    echo $n . ' * ' . $i . ' = ';
                    ?>
                    <input type="text" name="tabla[]" value=""/>
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
            <?php
        }
        ?>

    </body>
</html>
