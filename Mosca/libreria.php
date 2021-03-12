<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Inicializa el tablero con 10 casillas
 * @param type $tablero
 */
function inicializarTablero(&$tablero) {
    for ($i = 0; $i <= 9; $i++) {
        $tablero[$i] = ' ';
    }
}

/**
 * Coloca la mosca en una casilla al azar
 * @param array $tablero
 */
function colocarMosca(&$tablero) {
    $az = rand(0, count($tablero) - 1);
    $tablero[$az] = '*';
}

/**
 * Se comprueba en la casilla elegida si hay mosca o no,
 * en caso de que no, se mira si está en una posición adyacente
 * o no.
 * @param type $tablero
 * @param type $pos
 * @return int 
 *         0 -> no se ha enterado
 *         1 -> ha acertado
 *         2 -> la ha rozado
 *
 */
function golpear($tablero, $pos) {
    $qhp = 0;
    if ($tablero[$pos] == '*') {
        $qhp = 1;
    } else {
        if ($pos - 1 >= 0 && $tablero[$pos - 1] == '*') {
            $qhp = 2;
        }
        if ($pos + 1 < count($tablero) && $tablero[$pos + 1] == '*') {
            $qhp = 2;
        }
    }
    return $qhp;
}

/**
 * La mosca revolotea a otra casilla al azar
 * @param type $tablero
 */
function revolotea(&$tablero){
    inicializarTablero($tablero);
    colocarMosca($tablero);
}