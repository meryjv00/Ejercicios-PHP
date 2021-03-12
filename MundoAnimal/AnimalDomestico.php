<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimalDomestico
 *
 * @author Mery
 */
abstract class AnimalDomestico {

    protected $nombre;
    protected $raza;
    protected $peso;
    protected $color;

    function __construct($raza) {
        $this->nombre = $this->dameNombre();
        $this->raza = $raza;
        $this->peso = $this->damePeso();
        $this->color = $this->dameColor();
    }

    private function dameNombre() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $nombre = "Pepe";
                break;
            case 2: $nombre = "Luisa";
                break;
            case 3: $nombre = "Daniel";
                break;
            case 4: $nombre = "Belen";
                break;
        }
        return $nombre;
    }

    private function damePeso() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $peso = "40 kg";
                break;
            case 2: $peso = "50 kg";
                break;
            case 3: $peso = "30 kg";
                break;
            case 4: $peso = "35 kg";
                break;
        }
        return $peso;
    }
    private function dameColor() {
        $az = rand(1, 4);
        switch ($az) {
            case 1: $color = "Blanco";
                break;
            case 2: $color = "Marrón";
                break;
            case 3: $color = "Negro";
                break;
            case 4: $color = "Grisaceo";
                break;
        }
        return $color;
    }

    public function __toString() {
        return 'Nombre: ' . $this->nombre . ' Raza: ' . $this->raza .
                ' Peso: ' . $this->peso . ' Color: ' . $this->color;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getRaza() {
        return $this->raza;
    }

    function getPeso() {
        return $this->peso;
    }

    function getColor() {
        return $this->color;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setRaza($raza): void {
        $this->raza = $raza;
    }

    function setPeso($peso): void {
        $this->peso = $peso;
    }

    function setColor($color): void {
        $this->color = $color;
    }

    public function vacunar() {
        echo ($this->nombre . ' -> Vacunando...' . '<br>');
    }

    public abstract function comer();

    public abstract function dormir();

    public abstract function hacerRuido();

    public abstract function hacerCaso();
}
