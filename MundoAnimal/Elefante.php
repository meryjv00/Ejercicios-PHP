<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Elefante
 *
 * @author daw209
 */
require_once 'AnimalDomestico.php';

class Elefante extends AnimalDomestico {

    function __construct() {
        $raza = $this->dameRaza();
        parent::__construct($raza);
    }

    private function dameRaza() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $raza = "Africano de Sábana";
                break;
            case 2: $raza = "Africano de bosque";
                break;
            case 3: $raza = "Asiático de Sábana";
                break;
            case 4: $raza = "Asiático de bosque";
                break;
        }
        return $raza;
    }

    public function comer() {
        echo($this->nombre . ' -> Bebiendo agua...' . '<br>');
    }

    public function dormir() {
        echo($this->nombre . ' -> Durmiendo...' . '<br>');
    }

    public function hacerCaso() {
        $az = rand(1, 100);
        if ($az <= 50) {
            $haceCaso = true;
        } else {
            $haceCaso = false;
        }
        return $haceCaso;
    }

    public function hacerRuido() {
        echo($this->nombre . ' -> blurrrr blurrr...' . '<br>');
    }

}
