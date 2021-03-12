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
        <h1>¿Donde está la mosca?</h1>
        <?php
        session_start();
        require_once 'libreria.php';

        //Comprobamos si hemos pulsado una casilla para adivinar en que pos se encuentra la mosca
        $pulsado = false;
        $pos = 0;
        for ($i = 0; $i <= 9; $i++) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $pos = $i;
            }
        }
        if ($pulsado) {
            $tablero = $_SESSION['tab'];
            $tableroj = $_SESSION['tabj'];
            $intentos = $_SESSION['intentos'];

            //Si quedan intentos
            if ($intentos > 0) {
                $qhp = golpear($tablero, $pos);
                if ($qhp == 1) {
                    Header('Location: exito.php');
                } else {
                    ?>
                    <form name="formulario" action="index.php" method="POST">
                        <?php
                        //Tablero jugador
                        foreach ($tableroj as $i => $casilla) {
                            ?>
                            <input type="submit" name="<?= $i ?>" value="<?= $tableroj[$i] ?>"/>
                            <?php
                        }
                        ?>
                    </form>
                    <?php
                    if ($qhp == 0) {
                        $intentos--;
                        $_SESSION['intentos'] = $intentos;
                        echo('Ni se ha inmutado <br>');
                        echo('Te queda(n) ' . $intentos . ' intento(s)');
                    }
                    if ($qhp == 2) {
                        revolotea($tablero);
                        $_SESSION['tab'] = $tablero;
                        $intentos--;
                        $_SESSION['intentos'] = $intentos;
                        echo('Casi!!! La mosca ha revoloteado <br>');
                        echo('Te queda(n) ' . $intentos . ' intento(s)');
                    }
                    //No quedan intentos
                    if ($intentos == 0) {
                        Header('Location: fracaso.php');
                    }
                }
            }
        } else {
            //-------------------------------------1º VEZ QUE ENTRAMOS
            //Preparación tablero mosca
            $tablero = array();
            inicializarTablero($tablero);
            colocarMosca($tablero);
            //Preparación tablero jugador
            $tableroj = array();
            inicializarTablero($tableroj);
            //Guardamos en sesión los tableros y los intentos
            $_SESSION['tab'] = $tablero;
            $_SESSION['tabj'] = $tableroj;
            $_SESSION['intentos'] = 5;

            //Tablero solución
            /*
            foreach ($tablero as $i => $casilla) {
                ?>
                <input type="submit" name="casilla" value="<?= $tablero[$i] ?>"/>
                <?php
            }
             * 
             */
            ?>
            <p></p>
            <form name="formulario" action="index.php" method="POST">
                <?php
                //Tablero jugador
                foreach ($tableroj as $i => $casilla) {
                    ?>
                    <input type="submit" name="<?= $i ?>" value="<?= $tableroj[$i] ?>"/>
                    <?php
                }
                ?>
            </form>
            <?php
        }
        ?>
    </body>
</html>
