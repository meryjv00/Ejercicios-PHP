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
        <link rel="stylesheet" href="css/estilos.css">
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
                <div id="login" class="recuadre">
                    <div class="m3">
                        <span class="loginreg">Login</span>
                    </div>
                    <form name="formulario" action="valida.php" method="POST">
                        <div class="borde m3">
                            <i class="fas fa-user iconologin"></i>
                            <input type="text" name="usuario" class="login letrainput " placeholder="Username" />
                        </div>
                        <div class="borde m3">
                            <i class="fas fa-lock iconologin"></i>
                            <input type="password" name="contra" class="login letrainput" placeholder="Password" />
                        </div>
                        <?php
                        session_start();
                        if (isset($_SESSION['mensaje'])) {
                            $msj = $_SESSION['mensaje'];
                            ?>
                            <p><?= $msj ?></p>
                            <?php
                        }
                        unset($_SESSION['mensaje']);
                        ?>
                        <div class="m3">
                            <input type="submit" name="Entrar" value="Entrar" class="letrainput btn rosa" />
                        </div>
                    </form>
                    <a href="Vistas/registro.php"><input type="button" name="irregistrate" value="Registrate" class="letrainput btn rosa"/></a>
                   
                </div>
                <div></div>
            </main>
        </div>      
    </body>
</html>
