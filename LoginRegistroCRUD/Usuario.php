<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author daw209
 */
class Usuario {

    private $dni;
    private $nombre;
    private $tfno;
    private $roles;

    function __construct($dni, $nombre, $tfno) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->tfno = $tfno;
        $this->roles = Array();
    }

    function getDni() {
        return $this->dni;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTfno() {
        return $this->tfno;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTfno($tfno) {
        $this->tfno = $tfno;
    }

    function getRol($i) {
        return $this->roles[$i];
    }

    function sizeRol() {
        return count($this->roles);
    }

    function asignarRol($rol) {
        $this->roles[] = $rol;
    }

    public function __toString() {
        echo(
        ' Dni: ' . $this->dni .
        ' Nombre: ' . $this->nombre .
        ' Tfno: ' . $this->tfno
        );
    }

}
