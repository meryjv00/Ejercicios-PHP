<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parque
 *
 * @author daw209
 */
class Parque {
    private $parque;
    function __construct() {
        $this->parque = Array();
    }
    public function aniadirAnimal($animal){
        $this->parque[] = $animal;
    }
    
    public function size(){
        return count($this->parque);
    }
    public function get($i){
        return $this->parque[$i];
    }
    public function animalesCambianPos(){
        $az1 = rand(0,count($this->parque));
        $az2 = rand(0,count($this->parque));
        
        while($az1 == $az2){
            $az2 = rand(0,count($this->parque));
        }
         
        $pos1 = $this->parque[$az1];
        $this->parque[$az1] = $this->parque[$az2];
        $this->parque[$az2] = $pos1;
        
    }
    
    public function animalAbandonaParque(){
        array_pop($this->parque);
    }
}
