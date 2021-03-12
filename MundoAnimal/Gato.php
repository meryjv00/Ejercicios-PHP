<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gato
 *
 * @author Mery
 */
require_once 'AnimalDomestico.php';

class Gato extends AnimalDomestico {

    function __construct() {
        $raza = $this->dameRaza();
        parent::__construct($raza);
    }

    private function dameRaza() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $raza = "Siamés";
                break;
            case 2: $raza = "Persa";
                break;
            case 3: $raza = "Ragdoll";
                break;
            case 4: $raza = "Maine Coon";
                break;
        }
        return $raza;
    }

    public function hacerCaso() {
        $az = rand(1, 100);
        if ($az <= 5) {
            $haceCaso = true;
        } else {
            $haceCaso = false;
        }
        return $haceCaso;
    }

    public function hacerRuido() {
        echo($this->nombre . ' -> miau miauuuu...' . '<br>');
    }

    public function toseBolaPelo() {
        echo($this->nombre . ' -> Tose bola de pelo... ' . '<br>');
    }

    public function comer() {
        echo($this->nombre . ' -> Comiendo lata de sardinas...' . '<br>');
    }

    public function dormir() {
        echo($this->nombre . ' -> Durmiendo...' . '<br>');
    }

}
