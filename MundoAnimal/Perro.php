<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perro
 *
 * @author Mery
 */
require_once 'AnimalDomestico.php';

class Perro extends AnimalDomestico {

    function __construct() {
        $raza = $this->dameRaza();
        parent::__construct($raza);
    }

    private function dameRaza() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $raza = "Pastor alemán";
                break;
            case 2: $raza = "Bulldog";
                break;
            case 3: $raza = "Caniche";
                break;
            case 4: $raza = "Labrador";
                break;
        }
        return $raza;
    }

    public function hacerCaso() {
        $az = rand(1, 100);
        if ($az <= 90) {
            $haceCaso = true;
        } else {
            $haceCaso = false;
        }
        return $haceCaso;
    }

    public function hacerRuido() {
        echo($this->nombre . ' -> GUAU GUAU...' . '<br>');
    }

    public function sacarPaseo() {
        echo($this->nombre . ' -> De paseo...' . '<br>');
    }

    public function comer() {
        echo($this->nombre . ' -> Comiendo comida para perros...' . '<br>');
    }

    public function dormir() {
        echo($this->nombre . ' -> Durmiendo...' . '<br>');
    }

}
