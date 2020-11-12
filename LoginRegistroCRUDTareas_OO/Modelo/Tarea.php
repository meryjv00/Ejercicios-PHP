<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tarea
 *
 * @author daw209
 */
class Tarea {

    private $id;
    private $descripcion;
    private $pdesarrollo;
    private $dificultad;
    private $realizadores;
    
    function __construct($id, $descripcion, $pdesarrollo, $dificultad) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->pdesarrollo = $pdesarrollo;
        $this->dificultad = $dificultad;
        $this->realizadores = Array();
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPdesarrollo() {
        return $this->pdesarrollo;
    }

    function getDificultad() {
        return $this->dificultad;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setPdesarrollo($pdesarrollo): void {
        $this->pdesarrollo = $pdesarrollo;
    }

    function setDificultad($dificultad): void {
        $this->dificultad = $dificultad;
    }

    function getRealizador($i) {
        return $this->realizadores[$i];
    }

    function sizeRealizadores() {
        return count($this->realizadores);
    }

    function asignarRealizador($dni) {
        $this->realizadores[] = $dni;
    }
    function mostrarRealizadores(){
        //return print_r($this->realizadores);
        foreach ($this->realizadores as $i => $realizador) {
            echo $realizador . ', ';
        }
    }
    public function __toString() {
        echo(
        ' Id: ' . $this->id .
        ' Descripcion: ' . $this->descripcion .
        ' Porcentaje de desarrollo ' . $this->pdesarrollo .
        ' Dificultad: ' . $this->dificultad
        );
    }

}
