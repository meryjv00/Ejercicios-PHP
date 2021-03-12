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
        <h1>Mundo animal</h1>
        <?php
        require_once 'Perro.php';
        require_once 'Gato.php';
        require_once 'Elefante.php';
        require_once 'Parque.php';

        /**
          $gato = new Gato();
          $perro = new Perro();
          $elefante = new Elefante();

          $v = [$gato, $perro, $elefante];
          //Mostrar info
          foreach ($v as $i => $animal) {
          echo($animal . '<br>');
          $animal->vacunar();
          if ($animal instanceof Gato) {
          $animal->comer();
          $animal->dormir();
          $animal->hacerCaso();
          $animal->hacerRuido();
          $animal->toseBolaPelo();
          }
          if ($animal instanceof Perro) {
          $animal->comer();
          $animal->dormir();
          $animal->hacerCaso();
          $animal->hacerRuido();
          $animal->sacarPaseo();
          }
          if ($animal instanceof Elefante) {
          $animal->comer();
          $animal->dormir();
          $animal->hacerCaso();
          $animal->hacerRuido();
          }
          echo('<hr>');
          }
         * */
        //Simulación
        $parque = new Parque();
        $t = 0;
        while ($t < 300) {
            //Muestro el zoo 
            if ($t % 4 == 0) {
                if ($parque->size() > 0) {
                    for ($i = 0; $i < $parque->size(); $i++) {
                        $animal = $parque->get($i);
                        if (isset($animal) != null) {
                            echo($animal->getNombre() . ' | ');
                        }
                    }
                    echo('<br>');
                } else {
                    echo('No hay animales en el zoo en este momento' . '<br>');
                }
            }

            //Cada 2s -> los animales comen o duermen o hacen ruido
            if ($t % 2 == 0) {
                if ($parque->size() > 0) {
                    for ($i = 0; $i < $parque->size(); $i++) {
                        $animal = $parque->get($i);
                        if (isset($animal) != null) {
                            $az = rand(1, 3);
                            if ($animal instanceof Gato) {
                                if ($az == 1) {
                                    $animal->comer();
                                }
                                if ($az == 2) {
                                    $animal->dormir();
                                }
                                if ($az == 3) {
                                    $animal->hacerRuido();
                                }
                            }
                            if ($animal instanceof Perro) {
                                if ($az == 1) {
                                    $animal->comer();
                                }
                                if ($az == 2) {
                                    $animal->dormir();
                                }
                                if ($az == 3) {
                                    $animal->hacerRuido();
                                }
                            }
                            if ($animal instanceof Elefante) {
                                if ($az == 1) {
                                    $animal->comer();
                                }
                                if ($az == 2) {
                                    $animal->dormir();
                                }
                                if ($az == 3) {
                                    $animal->hacerRuido();
                                }
                            }
                        }
                    }
                }
            }
            //Cada 10s -> se añade un nuevo animal al parque
            if ($t % 10 == 0) {
                $az = rand(1, 3);
                switch ($az) {
                    case 1: $gato = new Gato();
                        $parque->aniadirAnimal($gato);
                        break;
                    case 2: $perro = new Perro();
                        $parque->aniadirAnimal($perro);
                        break;
                    case 3;
                        $elef = new Elefante();
                        $parque->aniadirAnimal($elef);
                        break;
                }
            }

            //Cada 15s -> 2 animales al azar intercambian pos
            if ($t % 15 == 0) {
                if ($parque->size() > 2) {
                    $parque->animalesCambianPos();
                }
            }

            //Cada 20s -> animal abandona el parque
            if ($t % 20 == 0) {
                $az = rand(1, 100);
                if ($az >= 50) {
                    $parque->animalAbandonaParque();
                }
            }

            $t++;
            sleep(1);
            ob_flush();
            flush();
        }
        echo('Fin de la simulación');
        ?>
    </body>
</html>
